<!--- offers --->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-offers relative -smt' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<div class="__wrapper c-main">
		<div class="__top grid grid-cols-1 md:grid-cols-[1fr_2fr_1fr] items-end gap-8">
			<h3 data-gsap-element="header" class="text-white">{{ strip_tags($g_offers['header']) }}</h3>
			<p data-gsap-element="text">{{ $g_offers['text'] }}</p>
			@if (!empty($g_offers['button']))
			<x-button
				:href="$g_offers['button']['url']"
				variant="outline"
				class="justify-self-start md:justify-self-end"
				data-gsap-element="btn">
				{{ $g_offers['button']['title'] }}
			</x-button>
			@endif
		</div>

		@if (!empty($r_offers))
		<div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-10">
			@foreach ($r_offers as $item)
			<div data-gsap-element="card" class="__card group relative overflow-hidden min-h-80 flex flex-col justify-center radius p-8">
				@if (!empty($item['image']['url']))
				<figure class="absolute inset-0 m-0">
					<picture>
						<source srcset="{{ $item['image']['url'] }}" type="image/jpeg" />
						<img class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 ease-out group-hover:scale-110" src="{{ $item['image']['url'] }}" alt="{{ $item['image']['alt'] ?? '' }}" />
					</picture>
				</figure>
				<div class="absolute inset-0 bg-gradient-to-r from-black/70 to-black/20"></div>
				@endif
				@if (!empty($item['button1']))
				<a href="{{ $item['button1']['url'] }}" class="absolute inset-0 z-20" aria-label="{{ $item['button1']['title'] }}"></a>
				@endif
				<div class="relative z-10">
					@if (!empty($item['title']))
					<p class="text-h5 text-white">{{ $item['title'] }}</p>
					@endif
					@if (!empty($item['text']))
					<p class="m-header">{{ $item['text'] }}</p>
					@endif
					@if (!empty($item['button1']))
					<x-button variant="underline" class="group-hover:!underline transition-all m-btn">
						{{ $item['button1']['title'] }}
					</x-button>
					@endif
				</div>
			</div>
			@endforeach
		</div>
		@endif
	</div>
</section>
