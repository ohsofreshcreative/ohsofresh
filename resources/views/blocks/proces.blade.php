<!--- proces --->

<section
  data-gsap-anim="section"
  @if (!empty($section_id)) id="{{ $section_id }}" @endif
  @class([ 'b-proces relative -smt',
  $sectionClass => filled($sectionClass),
  $section_class => filled($section_class),
  $background => filled($background) && $background !== 'none',
  ])>

  <div class="__wrapper c-main grid grid-cols-1 gap-12 lg:grid-cols-[1.5fr_2fr] lg:gap-20">
    @if (!empty($g_proces['header']) || !empty($g_proces['text']))
      <div class="__intro order1 lg:self-start relative lg:sticky top-0 lg:top-16 h-max">
        <div class="__inside lg:sticky lg:top-32">
          @if (!empty($g_proces['header']))
            <h2 data-gsap-element="header" class="text-h3">{{ $g_proces['header'] }}</h2>
          @endif

          @if (!empty($g_proces['text']))
            <div data-gsap-element="txt" class="__txt m-header space-y-4">
              {!! $g_proces['text'] !!}
            </div>
          @endif
        </div>
      </div>
    @endif

    @if (!empty($r_proces))
      <div class="__cards order2 flex flex-col gap-10">
        @foreach ($r_proces as $item)
          <article
            data-process-card
            data-gsap-element="stagger"
            @class([
              '__card relative isolate overflow-hidden border border-white/25 bg-background-dark radius',
              'is-active' => $loop->first,
              'is-' . ($item['color'] ?? 'yellow'),
            ])>
            @if (!empty($item['image']))
              <img
                class="__background absolute inset-0 z-0 h-full w-full object-cover"
                src="{{ $item['image']['url'] }}"
                alt=""
                loading="lazy"
                decoding="async"
                aria-hidden="true">
            @endif

            <span class="__background-overlay absolute inset-0 z-0" aria-hidden="true"></span>

            <button
              type="button"
              data-process-trigger
              class="__summary relative z-10 flex min-h-40 w-full cursor-pointer flex-col items-start justify-between gap-6 bg-transparent p-4 text-left text-white md:p-5"
              aria-expanded="{{ $loop->first ? 'true' : 'false' }}">
              <span class="__number text-h6 font-header" aria-hidden="true">{{ $loop->iteration }}</span>
              <span class="text-lg font-semibold leading-tight font-header">{{ $item['header'] ?? 'Krok ' . $loop->iteration }}</span>
            </button>

            <div
              data-process-panel
              class="__panel relative z-10"
              aria-hidden="{{ $loop->first ? 'false' : 'true' }}"
              @if (!$loop->first) inert @endif>
              <div class="__panel-inside min-h-0 overflow-hidden">
                @if (!empty($item['text']))
                  <div class="__txt space-y-2 px-4 pb-5 text-sm md:px-5 md:pb-6">
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
