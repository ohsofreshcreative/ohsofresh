<!--- how -->

<section
  data-gsap-anim="section"
  @if (!empty($section_id)) id="{{ $section_id }}" @endif
  @class([ 'b-how relative -smt',
  $sectionClass => filled($sectionClass),
  $section_class => filled($section_class),
  $background => filled($background) && $background !== 'none',
  ])>

  <div class="__wrapper c-main">
    @if (!empty($g_how['header']) || !empty($g_how['text']))
      <div class="__top mx-auto text-center">
        @if (!empty($g_how['header']))
          <h2 data-gsap-element="header">{{ $g_how['header'] }}</h2>
        @endif

        @if (!empty($g_how['text']))
          <div data-gsap-element="txt" class="__intro m-header">
            {!! $g_how['text'] !!}
          </div>
        @endif
      </div>
    @endif

    @if (!empty($r_how))
      <div class="__items">
        @foreach ($r_how as $item)
          <article class="__item relative">
            @if (!empty($item['pattern']))
              <div
                class="__pattern absolute"
                style="--how-pattern: url('{{ esc_url($item['pattern']['url']) }}')"
                aria-hidden="true"></div>
            @endif

            <div class="__row relative z-10 grid grid-cols-1 lg:grid-cols-2 items-center gap-8 lg:gap-16">
              @if (!empty($item['image']))
                <figure data-gsap-element="img" class="__img m-0">
                  <img
                    class="w-full object-cover radius-img b-shadow"
                    src="{{ $item['image']['url'] }}"
                    alt="{{ $item['image']['alt'] ?? '' }}"
                    loading="lazy">
                </figure>
              @endif

              <div class="__content">
                @if (!empty($item['icon']))
                  <img
                    data-gsap-element="img"
                    class="__icon"
                    src="{{ $item['icon']['url'] }}"
                    alt="{{ $item['icon']['alt'] ?? '' }}"
                    loading="lazy">
                @endif

                @if (!empty($item['header']))
                  <h4 data-gsap-element="header" class="__header m-header">{{ $item['header'] }}</h4>
                @endif

                @if (!empty($item['text']))
                  <div data-gsap-element="txt" class="__text m-header">
                    {!! $item['text'] !!}
                  </div>
                @endif
              </div>
            </div>
          </article>
        @endforeach
      </div>
    @endif
  </div>
</section>
