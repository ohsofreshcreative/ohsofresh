<!--- reach --->

<section
  data-gsap-anim="section"
  @if(!empty($section_id)) id="{{ $section_id }}" @endif
  @class([ 'b-reach relative -smt' ,
  $sectionClass=> filled($sectionClass),
  $section_class => filled($section_class),
  $background => filled($background) && $background !== 'none',
  ])>

  <div class="__wrapper c-main">
    <div class="__inside relative overflow-hidden border border-brand-second bg-background-dark px-6 py-24 md:px-10 md:py-32 lg:py-36">
      @if (!empty($g_reach['image']))
        <figure class="__img absolute inset-0 z-0 m-0 h-full w-full" aria-hidden="true">
          <picture class="block h-full w-full">
            <img
              class="h-full w-full object-cover"
              src="{{ $g_reach['image']['url'] }}"
              alt=""
              loading="lazy"
              decoding="async">
          </picture>
        </figure>
      @endif

      <div class="__overlay pointer-events-none absolute inset-0 z-10" aria-hidden="true"></div>

      <div class="__content relative z-20 mx-auto flex w-full flex-col items-center text-center">
        @if (!empty($g_reach['header']))
          <h2 data-gsap-element="header" class="w-full text-h3 text-white lg:w-5/12">
            {{ $g_reach['header'] }}
          </h2>
        @endif

        @if (!empty($g_reach['text']))
          <div data-gsap-element="txt" class="m-header w-full text-xl leading-7 text-white md:text-2xl lg:w-7/12">
            {!! $g_reach['text'] !!}
          </div>
        @endif

        @if (!empty($g_reach['button']))
          <div class="inline-buttons m-btn">
            <x-button
              :href="$g_reach['button']['url']"
              variant="primary"
              data-gsap-element="btn">
              {{ $g_reach['button']['title'] }}
            </x-button>
          </div>
        @endif
      </div>
    </div>
  </div>
</section>
