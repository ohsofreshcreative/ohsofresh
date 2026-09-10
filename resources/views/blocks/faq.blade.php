<!--- faq --->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-faq relative -smt section-dark' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<div class="__wrapper c-main grid grid-cols-1 md:grid-cols-3 gap-10 md:gap-20">

		<div class="__content">
			<h3 data-gsap-element="header" class="">{{ $g_faq['header'] }}</h3>
			<div data-gsap-element="txt" class="m-header">{!! $g_faq['text'] !!}</div>
			<x-button
				:href="$g_faq['button']['url']"
				variant="primary"
				class="m-btn"
				data-gsap-element="btn">
				{{ $g_faq['button']['title'] }}
			</x-button>
		</div>
		@php($faq_uid = wp_unique_id('faq-'))
		<div data-gsap-element="tabs" class="tabs-wrapper flex flex-col col-span-2">
			@foreach ($r_faq as $item)
			<div class="tabs rounded-xl border border-white/20 h-max p-4">
				<input class="tab-check" type="radio" name="{{ $faq_uid }}-radio" id="{{ $faq_uid }}-item-{{ $loop->index }}">
				<label class="tabs-label flex items-center justify-between !text-white text-base font-medium font-header gap-4" for="{{ $faq_uid }}-item-{{ $loop->index }}">
					<div class="flex items-center gap-2">
						{{ $item['title'] }}
					</div>
					<span class="__toggle-icon relative flex h-4 w-4 shrink-0 items-center justify-center rounded-full border border-white bg-transparent" aria-hidden="true">
						<span class="__toggle-horizontal absolute left-1/2 top-1/2 h-0.5 w-2 -translate-x-1/2 -translate-y-1/2 rounded-full bg-white"></span>
						<span class="__toggle-vertical absolute left-1/2 top-1/2 h-2 w-0.5 -translate-x-1/2 -translate-y-1/2 rounded-full bg-white"></span>
					</span>
				</label>
				<div class="tabs-content">
					{!! $item['txt'] !!}
				</div>
			</div>
			@endforeach
		</div>

	</div>

</section>