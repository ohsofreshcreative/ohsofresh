<!--- tabs --->

<section
  data-gsap-anim="section"
  @if (!empty($section_id)) id="{{ $section_id }}" @endif
  @class([ 'b-tabs relative -smt',
  $sectionClass => filled($sectionClass),
  $section_class => filled($section_class),
  $background => filled($background) && $background !== 'none',
  ])>

  @if (!empty($r_tabs))
    @php($tabs_uid = wp_unique_id('tabs-'))

    <div class="__wrapper c-main">
      <div class="js-tabs">
        <div class="__nav-scroll overflow-x-auto">
          <div
            class="__nav relative"
            role="tablist"
            aria-label="Etapy procesu">

            <div class="__line" aria-hidden="true"></div>
            <div class="__active-bg" aria-hidden="true"></div>

            @foreach ($r_tabs as $item)
              @php($icon_index = $loop->index % 5)
              <button
                type="button"
                id="{{ $tabs_uid }}-tab-{{ $loop->index }}"
                class="__tab __tab--tone-{{ $icon_index + 1 }} {{ $loop->first ? 'is-active' : '' }}"
                role="tab"
                aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                aria-controls="{{ $tabs_uid }}-panel-{{ $loop->index }}"
                tabindex="{{ $loop->first ? '0' : '-1' }}"
                data-tab-index="{{ $loop->index }}">

                <span class="__icon-stage" aria-hidden="true">
                  <span class="__icon-shell">
                    @switch($icon_index)
                      @case(0)
                        <svg class="__icon" viewBox="0 0 24 24" fill="none">
                          <path pathLength="1" d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                          <circle pathLength="1" cx="12" cy="12" r="3" />
                        </svg>
                        @break

                      @case(1)
                        <svg class="__icon" viewBox="0 0 24 24" fill="none">
                          <path pathLength="1" d="M14 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6z" />
                          <path pathLength="1" d="M14 3v5h5M16 13H8M16 17H8M10 9H8" />
                        </svg>
                        @break

                      @case(2)
                        <svg class="__icon" viewBox="0 0 24 24" fill="none">
                          <rect pathLength="1" x="3.9" y="3.9" width="16.2" height="16.2" rx="1.2" />
                          <path pathLength="1" d="M4.2 9.3h15.6M9.1 9.5v10.3" />
                        </svg>
                        @break

                      @case(3)
                        <svg class="__icon" viewBox="0 0 24 24" fill="none">
                          <path pathLength="1" d="M4 21v-7M4 10V3M12 21v-9M12 8V3M20 21v-5M20 12V3M1 14h6M9 8h6M17 16h6" />
                        </svg>
                        @break

                      @default
                        <svg class="__icon" viewBox="0 0 24 24" fill="none">
                          <rect pathLength="1" x="2" y="3" width="20" height="14" rx="2" />
                          <path pathLength="1" d="M8 21h8M12 17v4" />
                        </svg>
                    @endswitch
                  </span>
                </span>

                <span class="__label">{{ $item['tab'] }}</span>
              </button>
            @endforeach
          </div>
        </div>

        <div class="__panels">
          @foreach ($r_tabs as $item)
            <article
              id="{{ $tabs_uid }}-panel-{{ $loop->index }}"
              class="__panel __panel--tone-{{ ($loop->index % 5) + 1 }}"
              role="tabpanel"
              aria-labelledby="{{ $tabs_uid }}-tab-{{ $loop->index }}"
              tabindex="0"
              @if (!$loop->first) hidden @endif>

              <div @class([
                '__panel-grid grid grid-cols-1 items-center gap-8 lg:gap-16 p-6 sm:p-10 lg:p-16',
                'lg:grid-cols-2' => !empty($item['image']),
              ])>
                @if (!empty($item['image']))
                  <figure class="__img m-0 overflow-hidden radius-img">
                    <picture>
                      <img
                        class="w-full aspect-[4/3] object-cover"
                        src="{{ $item['image']['url'] }}"
                        alt="{{ $item['image']['alt'] ?? '' }}"
                        loading="lazy"
                        decoding="async">
                    </picture>
                  </figure>
                @endif

                <div class="__content">
                  @if (!empty($item['tab']))
                    <p class="__eyebrow text-lg font-semibold">{{ $item['tab'] }}</p>
                  @endif

                  @if (!empty($item['header']))
                    <h3 class="text-h4 m-header">{{ $item['header'] }}</h3>
                  @endif

                  @if (!empty($item['text']))
                    <div class="__txt m-header space-y-3">{!! $item['text'] !!}</div>
                  @endif
                </div>
              </div>
            </article>
          @endforeach
        </div>
      </div>
    </div>
  @endif
</section>
