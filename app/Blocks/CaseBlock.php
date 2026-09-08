<?php

namespace App\Blocks;

use App\Support\SectionClasses;
use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;

class CaseBlock extends Block
{
	public $name = 'Case';
	public $description = 'Opis realizacji z dużymi zdjęciami';
	public $slug = 'case';
	public $category = 'formatting';
	public $icon = 'media-text';
	public $keywords = ['case', 'projekt', 'realizacja', 'zdjęcie'];
	public $mode = 'edit';
	public $supports = [
		'align' => false,
		'mode' => true,
		'jsx' => true,
		'anchor' => true,
		'customClassName' => true,
	];

	public function fields()
	{
		$case = new FieldsBuilder('case');

		$case
			->setLocation('block', '==', 'acf/case')

			/*--- ELEMENTY ---*/

			->addTab('Elementy', ['placement' => 'top'])
			->addGroup('g_case', ['label' => ''])
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
			->addImage('image', [
				'label' => 'Obraz',
				'return_format' => 'array',
				'preview_size' => 'thumbnail',
			])
			->addImage('image2', [
				'label' => 'Obraz dodatkowy',
				'return_format' => 'array',
				'preview_size' => 'thumbnail',
			])
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

		return $case;
	}

	public function with(): array
	{
		$case = get_field('g_case') ?: [];
		$header_classes = [
			'yellow' => 'yellow-stroke',
			'orange' => 'orange-stroke',
			'jasmine' => 'jasmine-stroke',
			'purple' => 'purple-stroke',
			'dark-purple' => 'darkpurple-stroke',
			'blue' => 'blue-stroke',
		];

		$fields = [
			'g_case' => $case,
			'header_class' => $header_classes[$case['color'] ?? 'yellow'] ?? 'yellow-stroke',
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
