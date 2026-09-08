<!--- case --->

<section
  data-gsap-anim="section"
  @if(!empty($section_id)) id="{{ $section_id }}" @endif
  @class([ 'b-case relative -smt' ,
  $sectionClass=> filled($sectionClass),
  $section_class => filled($section_class),
  $background => filled($background) && $background !== 'none',
  ])>

  <div class="__wrapper c-main">
    @if (!empty($g_case['header']) || !empty($g_case['text']))
      <div @class([
        '__content grid grid-cols-1 gap-8',
        'lg:grid-cols-2 lg:gap-20' => !empty($g_case['header']) && !empty($g_case['text']),
      ])>
        @if (!empty($g_case['header']))
          <h2
            data-gsap-element="header"
            class="__header order1 {{ $header_class }} darktxt">
            {{ $g_case['header'] }}
          </h2>
        @endif

        @if (!empty($g_case['text']))
          <div data-gsap-element="txt" class="__txt order2 space-y-4">
            {!! $g_case['text'] !!}
          </div>
        @endif
      </div>
    @endif

    @if (!empty($g_case['image']))
      <figure data-gsap-element="img" class="__img m-0 mt-14 overflow-hidden radius-img">
        <picture>
          <img
            class="h-auto w-full object-cover"
            src="{{ $g_case['image']['url'] }}"
            alt="{{ $g_case['image']['alt'] ?? '' }}"
            loading="lazy"
            decoding="async">
        </picture>
      </figure>
    @endif

    @if (!empty($g_case['image2']))
      <figure data-gsap-element="img" class="__img m-0 mt-14 overflow-hidden radius-img">
        <picture>
          <img
            class="h-auto w-full object-cover"
            src="{{ $g_case['image2']['url'] }}"
            alt="{{ $g_case['image2']['alt'] ?? '' }}"
            loading="lazy"
            decoding="async">
        </picture>
      </figure>
    @endif
  </div>
</section>
