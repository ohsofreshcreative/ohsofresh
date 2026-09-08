@extends('layouts.app')

@section('content')
  @php
    global $wp_query;

    $term = get_queried_object();
    $category_header = get_field('category_header', $term) ?: single_cat_title('', false);
    $category_description = get_field('category_description', $term) ?: term_description($term);
    $cta = get_field('g_octa', 'option') ?: [];
    $pagination = paginate_links([
      'total' => $wp_query->max_num_pages,
      'current' => max(1, (int) get_query_var('paged')),
      'type' => 'array',
      'prev_text' => '<span aria-hidden="true">‹</span><span class="sr-only">Poprzednia strona</span>',
      'next_text' => '<span aria-hidden="true">›</span><span class="sr-only">Następna strona</span>',
    ]);
  @endphp

  <section data-gsap-anim="section" class="category-archive -menu-pt">
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

      <header class="__header w-full lg:w-3/5 mt-12">
        <h1 data-gsap-element="header" class="text-h2 text-white">{{ $category_header }}</h1>

        @if (!empty($category_description))
          <div data-gsap-element="txt" class="__description text-lg leading-relaxed mt-6">
            {!! $category_description !!}
          </div>
        @endif
      </header>

      @if (have_posts())
        <div class="__grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-12 mt-12">
          @while (have_posts())
            @php
              the_post();
              $post_categories = get_the_category();
              $post_category = !empty($post_categories) ? $post_categories[0] : null;
            @endphp

            <article @php(post_class('__card group')) data-gsap-element="card">
              <a href="{{ get_permalink() }}" class="block">
                @if (has_post_thumbnail())
                  <figure class="__img img-m radius overflow-hidden m-0">
                    {!! get_the_post_thumbnail(null, 'large', [
                      'class' => 'w-full h-full object-cover',
                      'loading' => 'lazy',
                    ]) !!}
                  </figure>
                @endif

                <div class="__content pt-5">
                  @if ($post_category)
                    <span class="block text-primary text-sm font-semibold mb-2">
                      {{ $post_category->name }}
                    </span>
                  @endif

                  <h2 class="text-h7 text-white transition-colors group-hover:text-primary">
                    {{ get_the_title() }}
                  </h2>
                </div>
              </a>
            </article>
          @endwhile
        </div>

        @if (!empty($pagination))
          <nav class="__pagination" aria-label="Paginacja wpisów">
            @foreach ($pagination as $link)
              {!! $link !!}
            @endforeach
          </nav>
        @endif
      @else
        <div class="__empty py-20">
          <h2 class="text-h5 text-white">Brak wpisów w tej kategorii.</h2>
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
