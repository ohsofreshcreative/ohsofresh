<?php

namespace App\Blocks;

use App\Support\SectionClasses;
use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Jobs extends Block
{
	public $name = 'Jobs';
	public $description = 'Sekcja z ofertami pracy i formularzem aplikacyjnym';
	public $slug = 'jobs';
	public $category = 'formatting';
	public $icon = 'businessperson';
	public $keywords = ['jobs', 'kariera', 'praca', 'oferty pracy'];
	public $mode = 'edit';
	public $supports = [
		'align' => false,
		'mode' => true,
		'jsx' => true,
	];

	public function fields()
	{
		$jobs = new FieldsBuilder('jobs');

		$jobs
			->setLocation('block', '==', 'acf/jobs')

			/*--- TREŚCI ---*/

			->addTab('Treści', ['placement' => 'top'])
			->addGroup('g_jobs', ['label' => ''])
			->addText('subheader', [
				'label' => 'Nadtytuł',
			])
			->addText('header', [
				'label' => 'Nagłówek',
			])
			->addText('button_label', [
				'label' => 'Tekst przycisku',
				'default_value' => 'Aplikuj',
			])
			->addText('form_title', [
				'label' => 'Tytuł formularza',
				'default_value' => 'Dołącz do nas',
			])
			->addText('shortcode', [
				'label' => 'Kod formularza',
				'instructions' => 'Wklej shortcode Contact Form 7. Aby automatycznie przekazać stanowisko, dodaj w formularzu pole [hidden job-title].',
				'default_value' => '[contact-form-7 id="cefbba1" title="Wyślij CV"]',
			])
			->endGroup()

			/*--- OFERTY PRACY ---*/

			->addTab('Oferty pracy', ['placement' => 'top'])
			->addRepeater('r_jobs', [
				'label' => 'Oferty pracy',
				'layout' => 'table',
				'min' => 1,
				'button_label' => 'Dodaj ofertę',
			])
			->addText('header', [
				'label' => 'Stanowisko',
			])
			->addWysiwyg('text', [
				'label' => 'Treść',
				'tabs' => 'all',
				'toolbar' => 'full',
				'media_upload' => true,
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

		return $jobs;
	}

	public function with(): array
	{
		$fields = [
			'g_jobs' => get_field('g_jobs'),
			'r_jobs' => get_field('r_jobs'),
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
