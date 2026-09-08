<!--- cta -->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-cta relative -smt' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<div class="__wrapper relative overflow-hidden">

		@if (!empty($g_octa['image']['url']))
		<figure class="absolute inset-0 m-0 z-0">
			<picture>
				<img src="{{ $g_octa['image']['url'] }}" alt="" class="w-full h-full object-cover object-right">
			</picture>
		</figure>
		@endif

		<div class="__inside c-main grid grid-cols-1 md:grid-cols-2 items-center gap-6 relative z-20">
			<div class="__content w-full py-52 w-full md:w-2/3">
				@if (!empty($g_octa['header']))
				<p data-gsap-element="header" class="block text-h3 text-white !m-header">{{ $g_octa['header'] }}</p>
				@endif
				@if (!empty($g_octa['txt']))
				<div data-gsap-element="txt" class="m-header">{!! $g_octa['txt'] !!}</div>
				@endif

				@if (!empty($g_octa['phone']) || !empty($g_octa['mail']))
				<div data-gsap-element="data" class="__contact contact-info m-btn grid gap-3">
					@if (!empty($g_octa['phone']))
					<a class="__phone flex items-center w-max" href="tel:{{ $g_octa['phone'] }}">{{ $g_octa['phone'] }}</a>
					@endif
					@if (!empty($g_octa['mail']))
					<a class="__mail flex items-center w-max" href="mailto:{{ $g_octa['mail'] }}">{{ $g_octa['mail'] }}</a>
					@endif
				</div>
				@endif

				<div class="inline-buttons m-btn">
					@if (!empty($g_octa['button1']))
					<x-button
						:href="$g_octa['button1']['url']"
						variant="white"
						class=""
						data-gsap-element="btn">
						{{ $g_octa['button1']['title'] }}
					</x-button>
					@endif

					@if (!empty($g_octa['button2']))
					<x-button
						:href="$g_octa['button2']['url']"
						variant="secondary"
						class=""
						data-gsap-element="btn">
						{{ $g_octa['button2']['title'] }}
					</x-button>
					@endif
				</div>
			</div>

			@if ($form)
			<div data-gsap-element="form" class="">
				<h4 class="!text-primary mb-4">{!! $g_octa['title'] !!}</h4>
				{!! do_shortcode($g_octa['shortcode']) !!}
			</div>
			@endif
		</div>

	</div>

</section>
