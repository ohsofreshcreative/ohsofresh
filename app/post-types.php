<?php

/*--- CPT - Produkty ---*/

add_action('init', function () {
	register_post_type('works', [
		'label'         => 'Realizacje',
		'labels'        => [
			'name'               => 'Realizacje',
			'singular_name'      => 'Realizacja',
			'menu_name'          => 'Realizacje',
			'all_items'          => 'Wszystkie realizacje',
			'add_new'            => 'Dodaj nową',
			'add_new_item'       => 'Dodaj nową realizację',
			'edit_item'          => 'Edytuj realizację',
			'new_item'           => 'Nowa realizacja',
			'view_item'          => 'Zobacz realizację',
			'view_items'         => 'Zobacz realizacje',
			'search_items'       => 'Szukaj realizacji',
			'not_found'          => 'Nie znaleziono realizacji',
			'not_found_in_trash' => 'Brak realizacji w koszu',
			'parent_item_colon'  => 'Realizacja nadrzędna:',
		],
		'public'        => true,
		'hierarchical'  => true,
		'has_archive'   => true,
		'menu_icon'     => 'dashicons-cart',
		'menu_position' => 20,
		'supports'      => ['title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'],
		'show_in_rest'  => true,
		'rewrite'       => ['slug' => 'realizacje', 'with_front' => false],
	]);
});

add_action('init', function () {
	register_taxonomy('offer_category', ['works'], [
		'label'        => 'Kategorie realizacji',
		'labels'       => [
			'name'              => 'Kategorie realizacji',
			'singular_name'     => 'Kategoria realizacji',
			'search_items'      => 'Szukaj kategorii',
			'all_items'         => 'Wszystkie kategorie',
			'parent_item'       => 'Kategoria nadrzędna',
			'parent_item_colon' => 'Kategoria nadrzędna:',
			'edit_item'         => 'Edytuj kategorię',
			'update_item'       => 'Aktualizuj kategorię',
			'add_new_item'      => 'Dodaj nową kategorię',
			'new_item_name'     => 'Nazwa nowej kategorii',
			'menu_name'         => 'Kategorie',
		],
		'hierarchical' => true,
		'public'       => true,
		'show_in_rest' => true,
		'rewrite'      => ['slug' => 'kategoria-oferty', 'with_front' => false],
	]);
});
