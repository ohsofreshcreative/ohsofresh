<!--- case --->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-case relative -smt' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<div class="__wrapper c-main">
		<div class="__content grid grid-cols-1 gap-8 lg:grid-cols-2 lg:gap-20">
			@if (!empty($g_case['header']))
			<h2
				data-gsap-element="header"
				class="__header order1 {{ $header_class }} darktxt">
				{{ $g_case['header'] }}
			</h2>
			@endif

			<div class="order2 space-y-4">
				@if (!empty($g_case['header1']))
				<h3
					data-gsap-element="header"
					class=" order1 {{ $header_class }} ">
					{{ $g_case['header1'] }}
				</h3>
				@endif
				@if (!empty($g_case['text1']))
				<div data-gsap-element="txt" class="__txt">
					{!! $g_case['text1'] !!}
				</div>
				@endif

				@if (!empty($g_case['header2']))
				<h3
					data-gsap-element="header"
					class=" order1 {{ $header_class }} ">
					{{ $g_case['header2'] }}
				</h3>
				@endif
				@if (!empty($g_case['text2']))
				<div data-gsap-element="txt" class="__txt order2 space-y-4">
					{!! $g_case['text2'] !!}
				</div>
				@endif
				@if (!empty($g_case['text']))
				<div data-gsap-element="txt" class="__txt order2 space-y-4">
					{!! $g_case['text'] !!}
				</div>
				@endif
			</div>
		</div>

		@if (!empty($g_case['image']))
		<x-picture :image="$g_case['image']" data-gsap-element="img" figureClass="__img m-0 mt-14 overflow-hidden radius-img" class="h-auto w-full object-cover" />
		@endif

		@if (!empty($g_case['image2']))
		<x-picture :image="$g_case['image2']" data-gsap-element="img" figureClass="__img m-0 mt-14 overflow-hidden radius-img" class="h-auto w-full object-cover" />
		@endif
	</div>
</section>