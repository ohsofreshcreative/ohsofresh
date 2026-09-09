<?php

namespace App\Blocks;

use App\Support\SectionClasses;
use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Works extends Block
{
	public $name = 'Works';
	public $description = 'Lista realizacji';
	public $slug = 'works';
	public $category = 'formatting';
	public $icon = 'portfolio';
	public $keywords = ['works', 'realizacje', 'case studies'];
	public $mode = 'edit';
	public $supports = [
		'align' => false,
		'mode' => true,
		'jsx' => true,
	];

	public function fields()
	{
		$works = new FieldsBuilder('works');

		$works
			->setLocation('block', '==', 'acf/works')
			/*--- TAB #1 ---*/
			->addTab('Elementy', ['placement' => 'top'])
			->addGroup('g_works', ['label' => ''])
			->addMessage(
				'Informacja',
				'Blok automatycznie wyświetla opublikowane wpisy z sekcji „Realizacje”. Kolejność ustawisz przez przeciąganie w Realizacje → Kolejność. Po zmianach kliknij „Zapisz kolejność”.'
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

		return $works;
	}

	public function with(): array
	{
		$paged = max(1, (int) get_query_var('paged'), (int) get_query_var('page'));
		$query = new \WP_Query([
			'post_type' => 'works',
			'posts_per_page' => (int) get_option('posts_per_page'),
			'paged' => $paged,
			'post_status' => 'publish',
			'orderby' => ['menu_order' => 'ASC', 'date' => 'DESC', 'ID' => 'DESC'],
		]);

		$items = [];

		foreach ($query->posts as $post) {
			$thumb_id = get_post_thumbnail_id($post->ID);
			$terms = get_the_terms($post->ID, 'offer_category');
			$categories = !is_wp_error($terms) && !empty($terms)
				? array_filter($terms, fn ($term) => $term->slug !== 'wszystkie')
				: [];

			$items[] = [
				'title' => get_the_title($post->ID),
				'url' => get_permalink($post->ID),
				'image_url' => $thumb_id ? wp_get_attachment_image_url($thumb_id, 'large') : null,
				'image_alt' => $thumb_id ? get_post_meta($thumb_id, '_wp_attachment_image_alt', true) : '',
				'categories' => wp_list_pluck($categories, 'name'),
			];
		}

		$pagination = $query->max_num_pages > 1
			? paginate_links([
				'current' => $paged,
				'total' => $query->max_num_pages,
				'type' => 'array',
				'prev_text' => '‹',
				'next_text' => '›',
			])
			: [];

		$fields = [
			'g_works' => get_field('g_works'),
			'items' => $items,
			'pagination' => $pagination ?: [],
			'section_id' => get_field('section_id'),
			'section_class' => get_field('section_class'),
			'flip' => (bool) get_field('flip'),
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
}
