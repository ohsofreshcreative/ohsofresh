<!--- attributes --->

<section
  data-gsap-anim="section"
  @if (!empty($section_id)) id="{{ $section_id }}" @endif
  @class([ 'b-attributes relative -smt -smb',
  $sectionClass => filled($sectionClass),
  $section_class => filled($section_class),
  $background => filled($background) && $background !== 'none',
  ])>

  <div class="__wrapper c-main">
    @if (!empty($r_attributes))
      <div class="__items">
        @foreach ($r_attributes as $item)
          <article
            @class([
              '__item relative flex flex-col items-start gap-8 lg:flex-row lg:items-end lg:gap-0',
              'lg:justify-start' => $loop->first || $loop->iteration === 3,
              'pt-20 lg:justify-end lg:pt-0 lg:pr-14' => $loop->iteration === 2,
              'pt-20 lg:pt-34' => $loop->iteration === 3,
            ])>
            @if (!empty($item['image']))
              <figure
                data-gsap-element="img"
                @class([
                  '__img relative z-0 m-0 w-full sm:w-1/2 lg:w-[407px] shrink-0',
                  'lg:order-2 lg:-ml-[70px]' => !$loop->first,
                ])>
                <picture>
                  <img
                    class="w-full h-[300px] lg:h-[413px] object-cover radius-img b-shadow"
                    src="{{ $item['image']['url'] }}"
                    alt="{{ $item['image']['alt'] ?? '' }}"
                    loading="lazy"
                    decoding="async">
                </picture>
              </figure>
            @endif

            <div
              @class([
                '__content relative z-10 w-full lg:w-[35%]',
                'lg:-ml-[70px] lg:pb-10' => $loop->first,
                'lg:order-1 lg:left-[50px] lg:top-[70px]' => $loop->iteration === 2,
                'lg:order-1 lg:top-[70px]' => $loop->iteration === 3,
              ])>
              @if (!empty($item['header']))
                <h2 data-gsap-element="header" class="text-h3">{{ $item['header'] }}</h2>
              @endif

              @if (!empty($item['text']))
                <div data-gsap-element="txt" class="__txt m-header space-y-3">
                  {!! $item['text'] !!}
                </div>
              @endif
            </div>
          </article>
        @endforeach
      </div>
    @endif
  </div>
</section>
