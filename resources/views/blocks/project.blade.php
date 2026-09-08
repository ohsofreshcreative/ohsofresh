<!--- project --->

<section
  data-gsap-anim="section"
  @if(!empty($section_id)) id="{{ $section_id }}" @endif
  @class([ 'b-project relative -smt' ,
  $sectionClass=> filled($sectionClass),
  $section_class => filled($section_class),
  $background => filled($background) && $background !== 'none',
  ])>

  <div @class([
    '__wrapper grid w-full grid-cols-1 items-start gap-10 px-6 md:px-0',
    'lg:grid-cols-2 lg:gap-20' => !empty($g_project['image']),
  ])>
    @if (!empty($g_project['image']))
      <figure data-gsap-element="img" class="__img order1 m-0 self-start lg:sticky lg:top-24">
        <picture>
          <img
            class="h-auto w-full object-cover radius-img b-shadow"
            src="{{ $g_project['image']['url'] }}"
            alt="{{ $g_project['image']['alt'] ?? '' }}"
            loading="lazy"
            decoding="async">
        </picture>
      </figure>
    @endif

    <div @class([
      '__content order2 w-full',
      'lg:w-4/5 lg:justify-self-center' => !empty($g_project['image']),
    ])>
      @if (!empty($g_project['header']))
        <h3 data-gsap-element="header">{{ $g_project['header'] }}</h3>
      @endif

      @if (!empty($g_project['text']))
        <div data-gsap-element="txt" class="__txt m-header space-y-4">
          {!! $g_project['text'] !!}
        </div>
      @endif

      @if (!empty($g_project['goals']))
        <div data-gsap-element="txt" class="__goals mt-8">
          <h4>Cele</h4>
          <div class="__txt m-header space-y-4">
            {!! $g_project['goals'] !!}
          </div>
        </div>
      @endif

      @if (!empty($g_project['challenges']))
        <div data-gsap-element="txt" class="__challenges mt-8 border-t border-primary pt-8">
          <h4>Wyzwania</h4>
          <div class="__txt m-header space-y-4">
            {!! $g_project['challenges'] !!}
          </div>
        </div>
      @endif

      @if (!empty($r_project))
        <div class="__results mt-8 border-t border-primary pt-8">
          <h4 data-gsap-element="header">Rezultat</h4>

          <div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-2">
            @foreach ($r_project as $item)
              <div data-gsap-element="card" class="__box">
                @if (!empty($item['header']) || !empty($item['icon']))
                  <div class="flex items-end gap-3">
                    @if (!empty($item['header']))
                      <p class="text-h2 font-semibold leading-none">{{ $item['header'] }}</p>
                    @endif

                    @if (!empty($item['icon']))
                      <img
                        class="size-12 shrink-0 object-contain"
                        src="{{ $item['icon']['url'] }}"
                        alt="{{ $item['icon']['alt'] ?? '' }}"
                        loading="lazy"
                        decoding="async">
                    @endif
                  </div>
                @endif

                @if (!empty($item['text']))
                  <div class="__txt mt-3 space-y-3 text-sm">
                    {!! $item['text'] !!}
                  </div>
                @endif
              </div>
            @endforeach
          </div>
        </div>
      @endif
    </div>
  </div>
</section>
