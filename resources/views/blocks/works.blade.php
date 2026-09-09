<!--- works --->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-works relative -smt -spb' ,
	$sectionClass => filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<div class="__wrapper c-main">
		@if (!empty($items))
		<div class="__grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
			@foreach ($items as $item)
			<article data-gsap-element="stagger" class="__card">
				<a href="{{ $item['url'] }}" class="__link group relative block overflow-hidden aspect-[6/5] radius">
					@if (!empty($item['image_url']))
					<figure class="__img absolute inset-0 m-0">
						<img
							src="{{ $item['image_url'] }}"
							alt="{{ $item['image_alt'] ?: $item['title'] }}"
							class="w-full h-full object-cover transition-transform duration-500 ease-out group-hover:scale-110">
					</figure>
					@endif

					<div class="absolute inset-0 bg-gradient-to-b from-transparent to-[#0f1219] pointer-events-none"></div>

					@if (!empty($item['categories']))
					<div class="__categories absolute inset-x-0 top-0 z-10 flex flex-wrap gap-2 p-6 md:p-8">
						@foreach ($item['categories'] as $category)
						<span class="inline-flex items-center rounded-full border border-white bg-black/40 px-3 py-1 text-xs font-medium leading-none text-white">
							{{ $category }}
						</span>
						@endforeach
					</div>
					@endif

					<div class="__content absolute inset-x-0 bottom-0 z-10 flex items-end justify-between gap-6 p-6 md:p-8 text-white">
						<h2 class="__title text-h5">{!! $item['title'] !!}</h2>
						<span class="grid size-14 shrink-0 place-items-center rounded-full border border-white" aria-hidden="true">
							<x-icon.arrow-up class="h-4 w-4 rotate-[225deg] group-hover:rotate-[270deg] transition-transform text-white" />
						</span>
					</div>
				</a>
			</article>
			@endforeach
		</div>
		@else
		<p class="__empty text-center">Brak realizacji do wyświetlenia.</p>
		@endif

		@if (!empty($pagination))
		<nav class="__pagination" aria-label="Paginacja realizacji">
			@foreach ($pagination as $link)
			{!! $link !!}
			@endforeach
		</nav>
		@endif
	</div>
</section>
