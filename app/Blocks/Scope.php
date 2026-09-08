<?php

namespace App\Blocks;

use App\Support\SectionClasses;
use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Scope extends Block
{
	public $name = 'SCOPE';
	public $description = 'Zakładki z usługami pobieranymi z megamenu';
	public $slug = 'scope';
	public $category = 'formatting';
	public $icon = 'screenoptions';
	public $keywords = ['scope', 'usługi', 'oferta', 'zakładki'];
	public $mode = 'edit';
	public $supports = [
		'align' => false,
		'mode' => true,
		'jsx' => true,
	];

	public function fields()
	{
		$scope = new FieldsBuilder('scope');

		$scope
			->setLocation('block', '==', 'acf/scope')

			/*--- TREŚCI ---*/

			->addTab('Elementy', ['placement' => 'top'])
			->addGroup('g_scope', ['label' => ''])
			->addText('header', [
				'label' => 'Nagłówek',
				'default_value' => 'Poznaj więcej naszych usług',
			])
			->addWysiwyg('text', [
				'label' => 'Treść',
				'tabs' => 'all',
				'toolbar' => 'full',
				'media_upload' => true,
			])
			->addMessage(
				'Źródło usług',
				'Zakładki i kafelki są pobierane automatycznie z elementu „Oferta” w menu głównym. Bezpośrednie podpozycje tworzą zakładki, a pozycje trzeciego poziomu — kafelki usług.'
			)
			->endGroup()

			/*--- USTAWIENIA BLOKU ---*/

			->addTab('Ustawienia bloku', ['placement' => 'top'])
			->addText('section_id', [
				'label' => 'ID',
			])
			->addText('section_class', [
				'label' => 'Dodatkowe klasy CSS',
			])
			->addTrueFalse('flip', [
				'label' => 'Odwrotna kolejność',
				'ui' => 1,
				'ui_on_text' => 'Tak',
				'ui_off_text' => 'Nie',
			])
			->addTrueFalse('wide', [
				'label' => 'Szeroka kolumna',
				'ui' => 1,
				'ui_on_text' => 'Tak',
				'ui_off_text' => 'Nie',
			])
			->addTrueFalse('nomt', [
				'label' => 'Usunięcie marginesu górnego',
				'ui' => 1,
				'ui_on_text' => 'Tak',
				'ui_off_text' => 'Nie',
			])
			->addTrueFalse('gap', [
				'label' => 'Większy odstęp',
				'ui' => 1,
				'ui_on_text' => 'Tak',
				'ui_off_text' => 'Nie',
			])
			->addSelect('background', [
				'label' => 'Kolor tła',
				'choices' => SectionClasses::backgroundChoices(),
				'default_value' => 'none',
				'ui' => 0,
				'allow_null' => 0,
			]);

		return $scope;
	}

	public function with(): array
	{
		$flip = (bool) get_field('flip');
		$tabs = $this->serviceTabs();

		if ($flip) {
			$tabs = array_reverse($tabs);
		}

		$fields = [
			'g_scope' => get_field('g_scope'),
			'tabs' => $tabs,
			'section_id' => get_field('section_id'),
			'section_class' => get_field('section_class'),
			'flip' => $flip,
			'wide' => (bool) get_field('wide'),
			'nomt' => (bool) get_field('nomt'),
			'gap' => (bool) get_field('gap'),
			'background' => get_field('background') ?: get_field('default_block_background', 'option') ?: 'none',
		];

		$fields['sectionClass'] = SectionClasses::fromMap($fields, [
			'flip' => 'order-flip',
			'wide' => 'wide',
			'nomt' => '!mt-0',
			'gap' => 'wider-gap',
		]);

		return $fields;
	}

	/**
	 * Buduje zakładki z tej samej hierarchii menu, z której korzysta megamenu „Oferta”.
	 *
	 * @return array<int, array<string, mixed>>
	 */
	private function serviceTabs(): array
	{
		$locations = get_nav_menu_locations();
		$menu_id = $locations['primary_navigation'] ?? 0;

		if (!$menu_id) {
			return [];
		}

		$items = wp_get_nav_menu_items($menu_id, ['post_status' => 'publish']);

		if (!$items || is_wp_error($items)) {
			return [];
		}

		usort($items, static fn ($first, $second) => (int) $first->menu_order <=> (int) $second->menu_order);

		$children = [];

		foreach ($items as $item) {
			$children[(int) $item->menu_item_parent][] = $item;
		}

		$menu_root = $this->offerMenuRoot($children);

		if (!$menu_root) {
			return [];
		}

		$tabs = [];

		foreach ($children[(int) $menu_root->ID] ?? [] as $category) {
			$services = [];

			foreach ($children[(int) $category->ID] ?? [] as $service) {
				$post_id = (int) $service->object_id;
				$icon = $post_id ? get_field('offer_icon', $post_id) : null;
				$menu_description = trim((string) ($service->description ?? ''));
				$excerpt = $menu_description ?: ($post_id ? get_the_excerpt($post_id) : '');

				$services[] = [
					'title' => wp_strip_all_tags($service->title),
					'url' => $service->url,
					'target' => $service->target,
					'icon' => is_array($icon) ? $icon : null,
					'excerpt' => wp_strip_all_tags($excerpt),
				];
			}

			if ($services) {
				$tabs[] = [
					'title' => wp_strip_all_tags($category->title),
					'services' => $services,
				];
			}
		}

		return $tabs;
	}

	/**
	 * Znajduje gałąź „Oferta”; awaryjnie wybiera pierwsze menu o trzech poziomach.
	 */
	private function offerMenuRoot(array $children): ?\WP_Post
	{
		$fallback = null;

		foreach ($children[0] ?? [] as $root) {
			$categories = $children[(int) $root->ID] ?? [];
			$has_services = false;

			foreach ($categories as $category) {
				if (!empty($children[(int) $category->ID])) {
					$has_services = true;
					break;
				}
			}

			if (!$has_services) {
				continue;
			}

			$fallback ??= $root;

			$path = (string) wp_parse_url($root->url, PHP_URL_PATH);

			if (sanitize_title($root->title) === 'oferta' || preg_match('#(^|/)oferta/?$#', $path)) {
				return $root;
			}
		}

		return $fallback;
	}
}
