<?php

namespace App\Fields;

use Log1x\AcfComposer\Field;
use StoutLogic\AcfBuilder\FieldsBuilder;

class OfferFields extends Field
{
	public function fields(): array
	{
		$offer = new FieldsBuilder('offer_fields', [
			'title'    => 'Ustawienia oferty',
			'style'    => 'seamless',
			'position' => 'side',
		]);

		$offer
			->setLocation('post_type', '==', 'offer')
			->addText('whatwedid', [
				'label'        => 'Co zrobiliśmy',
				'instructions' => 'Krótki label wyświetlany nad tytułem w sliderze, np. "Projekt graficzny"',
				'allow_null'   => 1,
			])
			->addImage('offer_icon', [
				'label'         => 'Ikona',
				'instructions'  => 'Dodaj ikonę (SVG, PNG) wyświetlaną nad tytułem oferty.',
				'return_format' => 'array',
				'preview_size'  => 'thumbnail',
				'allow_null'    => 1,
			]);

		return [$offer];
	}
}
