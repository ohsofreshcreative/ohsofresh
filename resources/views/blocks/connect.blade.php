<!--- connect --->

<section
  data-gsap-anim="section"
  @if (!empty($section_id)) id="{{ $section_id }}" @endif
  @class([
    'b-connect relative -smt block!',
    $sectionClass => filled($sectionClass),
    $section_class => filled($section_class),
    $background => filled($background) && $background !== 'none',
  ])>
  <div class="__wrapper c-main">
    <div @class([
      '__inside grid grid-cols-1 items-center border border-dotted border-gray-500 p-6',
      'lg:grid-cols-2' => !empty($g_connect['image']),
      'gap-8 lg:gap-12' => !$gap,
      'gap-12 lg:gap-20' => $gap,
    ])>
      @if (!empty($g_connect['image']['ID']))
        <figure data-gsap-element="img" @class([
          '__img m-0 min-w-0',
          'lg:order-2' => $flip,
        ])>
          {!! wp_get_attachment_image($g_connect['image']['ID'], 'large', false, [
            'class' => 'block h-auto w-full',
            'loading' => 'lazy',
            'decoding' => 'async',
          ]) !!}
        </figure>
      @endif

      <div data-gsap-element="txt" class="__content min-w-0">
        @if (!empty($g_connect['subheader']))
          <p class="text-brand-yellow mb-2">{{ $g_connect['subheader'] }}</p>
        @endif

        @if (!empty($g_connect['header']))
          <h2 class="text-h5 leading-normal!">{{ $g_connect['header'] }}</h2>
        @endif

        @if (!empty($g_connect['button']['url']) && !empty($g_connect['button']['title']))
          <div class="inline-buttons m-btn">
            <x-button
              :href="$g_connect['button']['url']"
              :target="$g_connect['button']['target'] ?? '_self'"
              :rel="($g_connect['button']['target'] ?? '') === '_blank' ? 'noopener noreferrer' : null"
              variant="primary">
              {{ $g_connect['button']['title'] }}
            </x-button>
          </div>
        @endif
      </div>
    </div>
  </div>
</section>
