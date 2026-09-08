@php
$sectionClass = '';
$sectionClass .= $flip ? ' order-flip' : '';
$sectionClass .= $nolist ? ' no-list' : '';
$sectionClass .= $wide ? ' wide' : '';
$sectionClass .= $nomt ? ' !mt-0' : '';
$sectionClass .= $gap ? ' wider-gap' : '';

if (!empty($background) && $background !== 'none') {
$sectionClass .= ' ' . $background;
}
@endphp

<!-- gallery --->

<section data-gsap-anim="section" @if(!empty($section_id)) id="{{ $section_id }}" @endif class="b-gallery relative -smt {{ $sectionClass }} {{ $section_class }}">
	<div class="__wrapper c-main">
		<h4 data-gsap-element="header" class="text-center">{{ $g_gallery['header'] }}</h4>

		@if (!empty($g_gallery['gallery']))
		<div data-gsap-element="images" class="flex md:flex-row gap-y-5 gap-x-10 lg:gap-20 items-center justify-center max-w-screen-lg flex-wrap mx-auto mt-10">
			@foreach ($g_gallery['gallery'] as $image)

			<img class="opacity-50 hover:opacity-100 transition-opacity duration-300" src="{{ $image['sizes']['large'] ?? $image['url'] }}" alt="{{ $image['alt'] ?? '' }}">
			@endforeach
		</div>
		@endif

	</div>
</section>