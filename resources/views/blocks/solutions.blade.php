<!--- solutions --->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-solutions relative -smt' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<div class="__wrapper c-main">
		<div class="__top w-full md:w-1/2">
			<h3 data-gsap-element="header" class="m-header">{{ strip_tags($g_solutions['header']) }}</h3>
			<p data-gsap-element="text">{{ $g_solutions['text'] }}</p>
		</div>

		@if (!empty($r_solutions))
		@php
		$itemCount = count($r_solutions);
		$gridCols = 1;
		if ($itemCount == 2) $gridCols = 2;
		if ($itemCount == 3) $gridCols = 3;
		if ($itemCount >= 4) $gridCols = 4; // Twój dotychczasowy warunek
		$gridClass = $gridCols > 1 ? 'grid-cols-1 lg:grid-cols-' . $gridCols : 'grid-cols-1';
		@endphp

		<div class="grid {{ $gridClass }} gap-8 mt-10">
			@foreach ($r_solutions as $item)
			<div data-gsap-element="card" class="__card relative radius border border-white/20 px-8 py-12">
				@if (!empty($item['image']['url']) || !empty($item['image2']['url']) || !empty($item['image3']['url']))
				<div class="flex gap-3 opacity-50">
					@if (!empty($item['image']['url']))
					<img class="w-10 h-10 mb-6" src="{{ $item['image']['url'] }}" alt="{{ $item['image']['alt'] ?? '' }}" />
					@endif
					@if (!empty($item['image2']['url']))
					<img class="w-10 h-10 mb-6" src="{{ $item['image2']['url'] }}" alt="{{ $item['image2']['alt'] ?? '' }}" />
					@endif
					@if (!empty($item['image3']['url']))
					<img class="w-10 h-10 mb-6" src="{{ $item['image3']['url'] }}" alt="{{ $item['image3']['alt'] ?? '' }}" />
					@endif
				</div>
				@endif
				@if (!empty($item['title']))
				<p class="text-h6">{{ $item['title'] }}</p>
				@endif
				@if (!empty($item['text']))
				<p class="!text-[13px] mt-2">{{ $item['text'] }}</p>
				@endif
			</div>
			@endforeach
		</div>
		@endif

	</div>

</section>
