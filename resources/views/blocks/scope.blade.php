<!--- scope --->

<section
  data-gsap-anim="section"
  @if (!empty($section_id)) id="{{ $section_id }}" @endif
  @class([ 'b-scope relative -smt',
  $sectionClass => filled($sectionClass),
  $section_class => filled($section_class),
  $background => filled($background) && $background !== 'none',
  ])>

  <div class="__wrapper c-main">
    @if (!empty($g_scope['header']) || !empty($g_scope['text']))
      <div class="__top c-narrow text-center">
        @if (!empty($g_scope['header']))
          <h2 class="text-h2" data-gsap-element="header">{{ $g_scope['header'] }}</h2>
        @endif

        @if (!empty($g_scope['text']))
          <div class="__intro m-header" data-gsap-element="txt">{!! $g_scope['text'] !!}</div>
        @endif
      </div>
    @endif

    @if (!empty($tabs))
      @php($scope_uid = wp_unique_id('scope-'))

      <div class="js-scope m-header">
        <div class="__nav-scroll overflow-x-auto">
          <div
            class="__nav flex min-w-max items-center justify-center gap-3 mt-10"
            role="tablist"
            aria-label="Kategorie usług">
            @foreach ($tabs as $tab)
              <button
                type="button"
                id="{{ $scope_uid }}-tab-{{ $loop->index }}"
                class="__tab rounded-full border border-white/20 px-5 py-3 text-sm font-semibold text-white/60 {{ $loop->first ? 'is-active' : '' }}"
                role="tab"
                aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                aria-controls="{{ $scope_uid }}-panel-{{ $loop->index }}"
                tabindex="{{ $loop->first ? '0' : '-1' }}">
                {{ $tab['title'] }}
              </button>
            @endforeach
          </div>
        </div>

        <div class="__panels mt-6">
          @foreach ($tabs as $tab)
            <div
              id="{{ $scope_uid }}-panel-{{ $loop->index }}"
              class="__panel"
              role="tabpanel"
              aria-labelledby="{{ $scope_uid }}-tab-{{ $loop->index }}"
              tabindex="0"
              @if (!$loop->first) hidden @endif>
              <div @class([
                '__grid grid grid-cols-1 gap-5 sm:grid-cols-2',
                'lg:grid-cols-2' => count($tab['services']) === 2,
                'lg:grid-cols-3' => count($tab['services']) === 3,
                'lg:grid-cols-4' => count($tab['services']) >= 4,
              ])>
                @foreach ($tab['services'] as $service)
                  <a
                    href="{{ $service['url'] }}"
                    @if (!empty($service['target'])) target="{{ $service['target'] }}" @endif
                    @if (($service['target'] ?? '') === '_blank') rel="noopener" @endif
                    class="__card group flex min-h-64 flex-col justify-between overflow-hidden radius border border-white/20 p-6 text-white sm:p-8">
                    <span class="__card-top flex min-h-14 items-start justify-between gap-4">
                      @if (!empty($service['icon']['url']))
                        <img
                          class="__icon size-14 object-contain object-left-top opacity-50 grayscale"
                          src="{{ $service['icon']['url'] }}"
                          alt=""
                          loading="lazy"
                          decoding="async">
                      @endif
                    </span>

                    <span class="__card-bottom flex items-end justify-between gap-5">
                      <span>
                        <span class="block text-h5">{{ $service['title'] }}</span>
                        @if (!empty($service['excerpt']))
                          <span class="__excerpt mt-3 block text-sm leading-relaxed text-white/60">{{ $service['excerpt'] }}</span>
                        @endif
                      </span>
                      <span class="__arrow grid size-11 shrink-0 place-items-center rounded-full border border-white/50" aria-hidden="true">
                        <x-icon.arrow-up class="size-4" />
                      </span>
                    </span>
                  </a>
                @endforeach
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @elseif (is_admin())
      <p class="m-header text-center">Dodaj trzy poziomy pozycji pod elementem „Oferta” w menu głównym, aby wyświetlić zakładki i usługi.</p>
    @endif
  </div>
</section>
