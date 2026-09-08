<?php

namespace App\Blocks;

use App\Support\SectionClasses;
use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Proces extends Block
{
	public $name = 'Proces';
	public $description = 'Sekcja prezentująca kolejne etapy procesu';
	public $slug = 'proces';
	public $category = 'formatting';
	public $icon = 'media-text';
	public $keywords = ['proces', 'kroki', 'etapy'];
	public $mode = 'edit';
	public $supports = [
		'align' => false,
		'mode' => true,
		'jsx' => true,
	];

	public function fields()
	{
		$proces = new FieldsBuilder('proces');

		$proces
			->setLocation('block', '==', 'acf/proces')

			/*--- TREŚCI ---*/

			->addTab('Treść', ['placement' => 'top'])
			->addGroup('g_proces', ['label' => ''])
			->addText('header', [
				'label' => 'Nagłówek',
			])
			->addWysiwyg('text', [
				'label' => 'Opis',
				'tabs' => 'all',
				'toolbar' => 'full',
				'media_upload' => true,
			])
			->endGroup()

			/*--- KROKI ---*/

			->addTab('Kroki', ['placement' => 'top'])
			->addRepeater('r_proces', [
				'label' => 'Etapy procesu',
				'layout' => 'table',
				'min' => 1,
				'button_label' => 'Dodaj krok',
			])
			->addImage('image', [
				'label' => 'Obraz w tle',
				'instructions' => 'Opcjonalny obraz wyświetlany w tle kafelka.',
				'return_format' => 'array',
				'preview_size' => 'medium',
			])
			->addText('header', [
				'label' => 'Nagłówek',
			])
			->addWysiwyg('text', [
				'label' => 'Treść',
				'tabs' => 'all',
				'toolbar' => 'full',
				'media_upload' => true,
			])
			->addSelect('color', [
				'label' => 'Kolor nagłówka',
				'choices' => [
					'yellow' => 'Żółty',
					'orange' => 'Pomarańczowy',
					'jasmine' => 'Jaśminowy',
					'purple' => 'Fioletowy',
					'dark-purple' => 'Ciemnofioletowy',
					'blue' => 'Niebieski',
				],
				'default_value' => 'yellow',
				'ui' => 0,
				'allow_null' => 0,
			])
			->endRepeater()

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

		return $proces;
	}

	public function with(): array
	{
		$fields = [
			'g_proces' => get_field('g_proces') ?: [],
			'r_proces' => get_field('r_proces') ?: [],
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
