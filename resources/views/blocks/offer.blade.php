<!--- offer --->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-offer relative -smt   relative z-30' ,
	$sectionClass => filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<div class="__wrapper c-main relative">
		@if (!empty($r_offer))
		<div class="offer">
			@foreach ($r_offer as $item)
			<div id="offerlist-{{ $loop->iteration }}" class="__col offer-list relative grid grid-cols-1 md:grid-cols-2 items-center gap-8 md:gap-20">
				@if (!empty($item['image']['url']))
				<div data-gsap-element="img" class="__img img relative z-10">
					<img class="b-shadow w-full object-cover" src="{{ $item['image']['url'] }}" alt="{{ $item['image']['alt'] ?? '' }}">
				</div>
				@endif

				<div class="__content content relative z-10">
					@if (!empty($item['header']))
					<h3 data-gsap-element="header">{{ $item['header'] }}</h3>
					@endif

					@if (!empty($item['text']))
					<div data-gsap-element="txt" class="__txt">{!! $item['text'] !!}</div>
					@endif

					@if (!empty($item['button']))
					<div class="stroke-btn inline-buttons">
						<x-button :href="$item['button']['url']" variant="outline-primary" data-gsap-element="btn">
							{{ $item['button']['title'] }}
						</x-button>
					</div>
					@endif
				</div>

				@if (!empty($item['background_image']['url']))
				<div data-gsap-element="img" aria-hidden="true" class="__decoration bg-sign absolute z-0 pointer-events-none">
					<img src="{{ $item['background_image']['url'] }}" alt="">
				</div>
				@endif
			</div>
			@endforeach
		</div>
		@endif
	</div>
</section>
