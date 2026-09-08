@extends('layouts.app')

@section('content')
  @php
    $term = get_queried_object();
    $category_header = get_field('category_header', $term) ?: single_cat_title('', false);
    $category_description = get_field('category_description', $term) ?: term_description($term);
    $cta = get_field('g_octa', 'option') ?: [];
    $grouped_posts = [];

    while (have_posts()) {
      the_post();

      $title = trim(wp_strip_all_tags(get_the_title()));
      $first_letter = function_exists('mb_substr')
        ? mb_strtoupper(mb_substr($title, 0, 1, 'UTF-8'), 'UTF-8')
        : strtoupper(substr($title, 0, 1));

      if (!preg_match('/^\p{L}$/u', $first_letter)) {
        $first_letter = '#';
      }

      $grouped_posts[$first_letter][] = [
        'title' => $title,
        'url' => get_permalink(),
      ];
    }

    $alphabet = array_flip([
      'A', 'Ą', 'B', 'C', 'Ć', 'D', 'E', 'Ę', 'F', 'G', 'H', 'I', 'J',
      'K', 'L', 'Ł', 'M', 'N', 'Ń', 'O', 'Ó', 'P', 'R', 'S', 'Ś', 'T',
      'U', 'W', 'Y', 'Z', 'Ź', 'Ż', '#',
    ]);
    $letter_slugs = [
      'Ą' => 'a-ogonek',
      'Ć' => 'c-kreska',
      'Ę' => 'e-ogonek',
      'Ł' => 'l-kreska',
      'Ń' => 'n-kreska',
      'Ó' => 'o-kreska',
      'Ś' => 's-kreska',
      'Ź' => 'z-kreska',
      'Ż' => 'z-kropka',
      '#' => 'inne',
    ];

    uksort($grouped_posts, function ($first, $second) use ($alphabet) {
      return ($alphabet[$first] ?? 999) <=> ($alphabet[$second] ?? 999);
    });
  @endphp

  <section data-gsap-anim="section" class="concepts-archive -menu-pt">
    <div class="c-main pt-6 md:pt-10 -spb">
      <nav data-gsap-element="bread" class="__breadcrumbs" aria-label="Okruszki">
        @if (function_exists('yoast_breadcrumb'))
          {!! yoast_breadcrumb('', '', false) !!}
        @else
          <a href="{{ home_url('/') }}">{{ get_bloginfo('name') }}</a>
          <span aria-hidden="true">/</span>
          <span>{{ $category_header }}</span>
        @endif
      </nav>

      <header class="__top w-full lg:w-3/5 mt-12">
        <h1 data-gsap-element="header" class="text-h2 text-white">{{ $category_header }}</h1>

        @if (!empty($category_description))
          <div data-gsap-element="txt" class="__description text-lg leading-relaxed mt-6">
            {!! $category_description !!}
          </div>
        @endif
      </header>

      @if (!empty($grouped_posts))
        <div class="__index grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-12 gap-y-16 mt-12">
          @foreach ($grouped_posts as $letter => $letter_posts)
            <section data-gsap-element="stagger" class="__letter-group">
              <h2 id="litera-{{ $letter_slugs[$letter] ?? sanitize_title($letter) }}" class="__letter text-h4 text-white pb-3">
                {{ $letter }}
              </h2>

              <ul class="__list mt-5">
                @foreach ($letter_posts as $post)
                  <li>
                    <a href="{{ $post['url'] }}">{{ $post['title'] }}</a>
                  </li>
                @endforeach
              </ul>
            </section>
          @endforeach
        </div>
      @else
        <div class="__empty py-20">
          <h2 class="text-h5 text-white">Brak pojęć do wyświetlenia.</h2>
        </div>
      @endif
    </div>
  </section>

  @if (!empty(array_filter($cta)))
    @include('blocks.cta', [
      'g_octa' => $cta,
      'form' => !empty($cta['shortcode']),
      'section_id' => '',
      'section_class' => '',
      'sectionClass' => '',
      'background' => 'none',
    ])
  @endif
@endsection
