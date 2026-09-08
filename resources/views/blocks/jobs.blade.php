<!--- jobs --->

<section
  data-gsap-anim="section"
  @if (!empty($section_id)) id="{{ $section_id }}" @endif
  @class([ 'b-jobs relative -smt -smb',
  $sectionClass => filled($sectionClass),
  $section_class => filled($section_class),
  $background => filled($background) && $background !== 'none',
  ])>

  <div class="__wrapper c-main">
    <div class="__grid grid grid-cols-1 lg:grid-cols-[3fr_1fr]">
      <div class="__main">
        @if (!empty($g_jobs['subheader']))
          <p data-gsap-element="header" class="text-h6 text-primary mb-4">{{ $g_jobs['subheader'] }}</p>
        @endif

        @if (!empty($g_jobs['header']))
          <h2 data-gsap-element="header" class="mb-10">{{ $g_jobs['header'] }}</h2>
        @endif

        @if (!empty($r_jobs))
          <div class="__items">
            @foreach ($r_jobs as $item)
              <div data-gsap-element="stagger" class="__job">
                <button
                  type="button"
                  class="__summary btn btn-outline !flex !w-full items-center justify-between gap-5 text-left !text-lg !font-bold"
                  aria-expanded="false">
                  <span>{{ $item['header'] ?? '' }}</span>
                  <span class="__toggle-icon relative flex h-7 w-7 shrink-0 items-center justify-center rounded-full border border-white bg-transparent" aria-hidden="true">
                    <span class="__toggle-horizontal absolute h-px w-3 bg-white"></span>
                    <span class="__toggle-vertical absolute h-3 w-px bg-white"></span>
                  </span>
                </button>

                <div class="__panel max-h-0 overflow-hidden transition-[max-height] duration-300 ease-out" aria-hidden="true" inert>
                  <div class="__inside my-2.5 rounded-2xl border border-white/35 bg-page p-6 md:p-10">
                    @if (!empty($item['text']))
                      <div class="__txt space-y-3 [&_p]:mb-2.5 [&_ul]:mb-5 [&_ul]:list-disc [&_ul]:pl-9">
                        {!! $item['text'] !!}
                      </div>
                    @endif

                    @if (!empty($g_jobs['shortcode']))
                      <x-button
                        tag="button"
                        type="button"
                        variant="primary"
                        class="js-jobs-open mt-8"
                        data-job-title="{{ $item['header'] ?? '' }}">
                        {{ $g_jobs['button_label'] ?: 'Aplikuj' }}
                      </x-button>
                    @endif
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @endif
      </div>
    </div>
  </div>

  @if (!empty($g_jobs['shortcode']))
    <dialog
      data-jobs-dialog
      class="__dialog fixed inset-0 m-auto max-h-[85vh] w-[calc(100%_-_48px)] max-w-[900px] overflow-hidden border-0 bg-background-dark p-0 text-left text-white radius">
      <button
        type="button"
        data-jobs-close
        class="__close absolute top-2 right-4 z-10 bg-transparent p-2 text-4xl leading-none text-primary transition-colors hover:text-secondary"
        aria-label="Zamknij formularz">
        &times;
      </button>

      <div class="__dialog-content max-h-[85vh] overflow-y-auto p-6 md:p-10">
        @if (!empty($g_jobs['form_title']))
          <h5 class="mb-6">{{ $g_jobs['form_title'] }}</h5>
        @endif

        {!! do_shortcode($g_jobs['shortcode']) !!}
      </div>
    </dialog>
  @endif
</section>
