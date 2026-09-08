<!--- top --->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-top relative flex -spt overflow-hidden' ,
	$sectionClass => filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	@if (!empty($g_top['image']))
	<figure class="__img absolute inset-0 z-0 m-0">
		<picture class="block w-full h-full">
			<img class="w-full h-full object-cover" src="{{ $g_top['image']['url'] }}" alt="{{ $g_top['image']['alt'] ?? '' }}">
		</picture>
	</figure>
	@endif

	<div class="__overlay absolute inset-0 z-1 pointer-events-none" aria-hidden="true"></div>

	<div class="__wrapper c-main relative z-10 flex items-center">
		<div class="__content w-full md:w-1/2">
			@if (!empty($g_top['header']))
			<h1 data-gsap-element="header" class="text-h1 text-white">{{ $g_top['header'] }}</h1>
			@endif

			@if (!empty($g_top['text']))
			<div data-gsap-element="txt" class="__txt text-white m-header">{!! $g_top['text'] !!}</div>
			@endif
		</div>
	</div>
</section>
