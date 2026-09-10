@php
  $current_id = get_the_ID();
  $categories = get_the_category($current_id);
  $category = !empty($categories) ? $categories[0] : null;
  $raw_content = get_the_content();
  $content = apply_filters('the_content', $raw_content);
  $toc_items = [];
  $used_ids = [];

  $content = preg_replace_callback(
    '/<h([23])([^>]*)>(.*?)<\/h\1>/is',
    function ($heading) use (&$toc_items, &$used_ids) {
      $level = (int) $heading[1];
      $attributes = $heading[2];
      $inner_html = $heading[3];
      $title = trim(wp_strip_all_tags($inner_html));

      if ($title === '') {
        return $heading[0];
      }

      $id = '';

      if (preg_match('/\sid=(["\'])(.*?)\1/i', $attributes, $id_match)) {
        $id = sanitize_title($id_match[2]);
        $attributes = preg_replace('/\s+id=(["\']).*?\1/i', '', $attributes, 1);
      }

      $base_id = $id ?: sanitize_title($title);
      $base_id = $base_id ?: 'sekcja';
      $id = $base_id;
      $suffix = 2;

      while (in_array($id, $used_ids, true)) {
        $id = $base_id . '-' . $suffix;
        $suffix++;
      }

      $used_ids[] = $id;
      $toc_items[] = sprintf(
        '<li class="toc-h%d"><a href="#%s">%s</a></li>',
        $level,
        esc_attr($id),
        esc_html($title)
      );

      return sprintf(
        '<h%d%s id="%s">%s</h%d>',
        $level,
        $attributes,
        esc_attr($id),
        $inner_html,
        $level
      );
    },
    $content
  );

  $category_ids = wp_get_post_categories($current_id);
  $related_args = [
    'post_type' => 'post',
    'post_status' => 'publish',
    'post__not_in' => [$current_id],
    'posts_per_page' => 6,
    'ignore_sticky_posts' => true,
    'orderby' => 'date',
    'order' => 'DESC',
  ];

  if (!empty($category_ids)) {
    $related_args['category__in'] = $category_ids;
  }

  $related_query = new WP_Query($related_args);
  $cta = get_field('g_octa', 'option') ?: [];
  $show_global_cta = !empty(array_filter($cta)) && !has_block('acf/cta', $raw_content);
@endphp

<article class="single-post-content">
  <header data-gsap-anim="section" class="__hero relative -menu-pt">
    <div class="c-main py-20 md:py-26">
      <div class="w-full lg:w-3/5">
        <nav data-gsap-element="bread" class="__breadcrumbs mb-8" aria-label="Okruszki">
          @if (function_exists('yoast_breadcrumb'))
            {!! yoast_breadcrumb('', '', false) !!}
          @else
            <a href="{{ home_url('/') }}">{{ get_bloginfo('name') }}</a>
            @if ($category)
              <span aria-hidden="true">/</span>
              <a href="{{ get_category_link($category->term_id) }}">{{ $category->name }}</a>
            @endif
          @endif
        </nav>

        <h1 data-gsap-element="header" class="text-h2 text-white">{{ get_the_title() }}</h1>

        @if (has_excerpt())
          <div data-gsap-element="txt" class="__lead text-lg leading-relaxed mt-6">
            {{ get_the_excerpt() }}
          </div>
        @endif
      </div>
    </div>
  </header>

  @if (has_post_thumbnail())
    <div data-gsap-anim="section">
      <figure data-gsap-element="img" class="__featured img-3xl w-full overflow-hidden m-0">
        {!! get_the_post_thumbnail($current_id, 'full', [
          'class' => 'w-full h-full object-cover',
          'loading' => 'eager',
          'fetchpriority' => 'high',
        ]) !!}
      </figure>
    </div>
  @endif

  <section id="tresc" class="__article c-main -spt -spb">
    <div class="w-full lg:w-3/5 mx-auto">
      @if (!empty($toc_items))
        <nav data-gsap-anim="section" class="toc" aria-label="Spis treści">
          <p data-gsap-element="header" class="text-h6 text-white block pb-4">Spis treści</p>
          <ol data-gsap-element="txt">
            {!! implode('', $toc_items) !!}
          </ol>
        </nav>
      @endif

      <div data-gsap-anim="section">
        <div data-gsap-element="txt" class="__entry">
          {!! $content !!}
        </div>
      </div>
    </div>
  </section>
</article>

@if ($related_query->have_posts())
  <section data-gsap-anim="section" class="single-related c-main -spt -spb">
    <h2 data-gsap-element="header" class="text-h4 text-white mb-8">Zobacz więcej</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-12">
      @while ($related_query->have_posts())
        @php
          $related_query->the_post();
          $related_categories = get_the_category();
          $related_category = !empty($related_categories) ? $related_categories[0] : null;
        @endphp

        <article @php(post_class('__card group')) data-gsap-element="card">
          <a href="{{ get_permalink() }}" class="block">
            @if (has_post_thumbnail())
              <figure class="img-s radius overflow-hidden m-0">
                {!! get_the_post_thumbnail(null, 'large', [
                  'class' => 'w-full h-full object-cover',
                  'loading' => 'lazy',
                ]) !!}
              </figure>
            @endif

            <div class="pt-5">
              @if ($related_category)
                <span class="block text-primary text-sm font-semibold mb-2">
                  {{ $related_category->name }}
                </span>
              @endif
              <h3 class="text-h7 text-white transition-colors group-hover:text-primary">
                {{ get_the_title() }}
              </h3>
            </div>
          </a>
        </article>
      @endwhile
    </div>

    @if ($category)
      <p data-gsap-element="txt" class="__more text-center mt-16 p-6">
        Chcesz zobaczyć więcej?
        <a href="{{ get_category_link($category->term_id) }}">
          Sprawdź wszystkie wpisy z kategorii {{ $category->name }}
        </a>
      </p>
    @endif
  </section>
@endif

@php(wp_reset_postdata())

@if ($show_global_cta)
  @include('blocks.cta', [
    'g_octa' => $cta,
    'form' => !empty($cta['shortcode']),
    'section_id' => '',
    'section_class' => '',
    'sectionClass' => '',
    'background' => 'none',
  ])
@endif

@if (!empty($toc_items))
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const article = document.querySelector('.single-post-content');

      if (!article) return;

      const headings = article.querySelectorAll('.__entry h2[id], .__entry h3[id]');
      const links = article.querySelectorAll('.toc a');

      const updateActiveLink = () => {
        let activeId = '';

        headings.forEach((heading) => {
          if (heading.getBoundingClientRect().top <= 180) activeId = heading.id;
        });

        links.forEach((link) => {
          link.parentElement.classList.toggle('active', link.hash === `#${activeId}`);
        });
      };

      updateActiveLink();
      window.addEventListener('scroll', updateActiveLink, { passive: true });
    });
  </script>
@endif
