<!--- carrer --->

<section
  data-gsap-anim="section"
  @if (!empty($section_id)) id="{{ $section_id }}" @endif
  @class([ 'b-carrer relative z-[99999] -smt -smb',
  $sectionClass => filled($sectionClass),
  $section_class => filled($section_class),
  $background => filled($background) && $background !== 'none',
  ])>

  <div class="__wrapper c-main relative">
    <img
      data-gsap-element="img"
      class="__decoration absolute z-0 -top-20 right-2.5 max-w-full pointer-events-none"
      src="{{ get_template_directory_uri() }}/resources/images/career-decoration.svg"
      alt=""
      aria-hidden="true">

    @if (!empty($r_carrer))
      <div class="__items relative z-10">
        @foreach ($r_carrer as $item)
          <article
            @class([
              '__item relative z-10 flex max-[992px]:grid max-[992px]:grid-cols-1',
              'justify-end pr-10 max-[992px]:pr-0' => $loop->first,
              'justify-start pt-26 max-[992px]:pt-20' => $loop->iteration === 2,
              'justify-center pt-16' => $loop->iteration === 3,
            ])>
            @if (!empty($item['image']))
              <figure
                data-gsap-element="img"
                @class([
                  '__img m-0 mb-[30px] w-full min-[577px]:w-1/2 min-[993px]:mb-0 min-[993px]:w-[395px] shrink-0',
                  'min-[993px]:order-2 min-[993px]:-ml-[70px]' => $loop->odd,
                ])>
                <img
                  class="h-[300px] w-full object-cover rounded-2xl b-shadow min-[993px]:h-auto"
                  src="{{ $item['image']['url'] }}"
                  alt="{{ $item['image']['alt'] ?? '' }}"
                  loading="lazy"
                  decoding="async">
              </figure>
            @endif

            @if (!empty($item['header']) || !empty($item['text']))
              <div
                @class([
                  '__content relative z-10 w-full min-[993px]:w-[35%] min-[993px]:self-end',
                  'min-[993px]:order-1 min-[993px]:top-[70px] min-[993px]:left-[50px]' => $loop->first,
                  'min-[993px]:-ml-[70px]' => $loop->iteration === 2,
                  'min-[993px]:order-1 min-[993px]:top-[70px]' => $loop->iteration === 3,
                ])>
                @if (!empty($item['header']))
                  <h2 data-gsap-element="header" class="mb-4">{{ $item['header'] }}</h2>
                @endif

                @if (!empty($item['text']))
                  <div data-gsap-element="txt" class="__txt space-y-3">
                    {!! $item['text'] !!}
                  </div>
                @endif
              </div>
            @endif
          </article>
        @endforeach
      </div>
    @endif
  </div>
</section>
