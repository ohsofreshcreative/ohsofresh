<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Support\SectionClasses;

class Slider extends Block
{
    public $name = 'Slider - Realizacje';
    public $description = 'slider';
    public $slug = 'slider';
    public $category = 'formatting';
    public $icon = 'image-flip-horizontal';
    public $keywords = ['slider', 'oferta'];
    public $mode = 'edit';
    public $supports = [
        'align' => false,
        'mode' => true,
        'jsx' => true,
    ];

    public function fields()
    {
        $slider = new FieldsBuilder('slider');

        $slider
            ->setLocation('block', '==', 'acf/slider')
            ->addTab('Treści', ['placement' => 'top'])
            ->addText('slider_title', ['label' => 'Tytuł sekcji'])
            ->addText('slider_txt', ['label' => 'Opis sekcji'])
            ->addLink('slider_btn', [
                'label'         => 'Przycisk nagłówka',
                'return_format' => 'array',
            ])
            ->addRelationship('slider_offers', [
                'label'         => 'Realizacje w sliderze',
                'post_type'     => ['works'],
                'filters'       => ['search'],
                'return_format' => 'object',
                'instructions'  => 'Wybierz realizacje do wyświetlenia. Jeśli pole jest puste, wyświetlą się automatycznie realizacje nadrzędne. Kolejność jest zgodna z ustawieniem w Realizacje → Kolejność, tak jak w bloku Works.',
            ])

            ->addTab('Ustawienia bloku', ['placement' => 'top'])
            ->addText('section_id', ['label' => 'ID'])
            ->addText('section_class', ['label' => 'Dodatkowe klasy CSS'])
            ->addTrueFalse('nomt', [
                'label' => 'Usunięcie marginesu górnego',
                'ui' => 1,
                'ui_on_text' => 'Tak',
                'ui_off_text' => 'Nie',
            ])
            ->addSelect('background', [
                'label' => 'Kolor tła',
                'choices' => [
                    'none'              => 'Brak (domyślne - ciemne)',
                    'section-bgdark'    => 'Bardzo ciemne (jak Works)',
                    'section-white'     => 'Białe',
                    'section-light'     => 'Jasne',
                    'section-gray'      => 'Szare',
                    'section-brand'     => 'Marki',
                    'section-gradient'  => 'Gradient',
                    'section-dark'      => 'Ciemne (czerwone)',
                ],
                'default_value' => 'none',
                'ui' => 0,
                'allow_null' => 0,
            ]);

        return $slider;
    }

    public function with(): array
    {
        $selected = get_field('slider_offers') ?: [];

        $query_args = [
            'post_type'      => 'works',
            'posts_per_page' => -1,
            'orderby'       => ['menu_order' => 'ASC', 'date' => 'DESC', 'ID' => 'DESC'],
            'post_status'   => 'publish',
        ];

        if (empty($selected)) {
            $query_args['post_parent'] = 0;
        } else {
            $query_args['post__in'] = wp_list_pluck($selected, 'ID');
        }

        $offers_query = new \WP_Query($query_args);
        $selected = $offers_query->posts;

        $slides = [];
        foreach ($selected as $post) {
            $thumb_id  = get_post_thumbnail_id($post->ID);
            $terms     = get_the_terms($post->ID, 'offer_category');
            $categories = !is_wp_error($terms) && !empty($terms)
                ? array_filter($terms, fn ($term) => $term->slug !== 'wszystkie')
                : [];

            $slides[] = [
                'title'      => $post->post_title,
                'url'        => get_permalink($post->ID),
                'image_url'  => $thumb_id ? wp_get_attachment_image_url($thumb_id, 'large') : null,
                'image_alt'  => $thumb_id ? get_post_meta($thumb_id, '_wp_attachment_image_alt', true) : '',
                'categories' => wp_list_pluck($categories, 'name'),
            ];
        }

        $fields = [
            'slides'        => $slides,
            'slider_title'  => get_field('slider_title'),
            'slider_txt'    => get_field('slider_txt'),
            'slider_btn'    => get_field('slider_btn') ?: [],
            'section_id'    => get_field('section_id'),
            'section_class' => get_field('section_class'),
            'nomt'          => (bool) get_field('nomt'),
            'background'    => get_field('background') ?: 'none',
        ];

        $fields['sectionClass'] = SectionClasses::fromMap($fields, [
            'nomt' => '!mt-0',
        ]);

        return $fields;
    }
}
