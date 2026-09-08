<!--- values -->

<section
	data-gsap-anim="section"
	@if (!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-values relative -smt',
	$sectionClass => filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<div class="__wrapper c-main grid grid-cols-1 lg:grid-cols-3 items-center gap-12 lg:gap-20">
		@if (!empty($g_values['header']) || !empty($g_values['text']))
			<div class="__content">
				@if (!empty($g_values['header']))
					<h3 data-gsap-element="header" class="text-h3">{{ $g_values['header'] }}</h3>
				@endif

				@if (!empty($g_values['text']))
					<div data-gsap-element="txt" class="__intro m-btn">
						{!! $g_values['text'] !!}
					</div>
				@endif
			</div>
		@endif

		@if (!empty($r_values))
			<div class="__cards grid grid-cols-1 sm:grid-cols-2 gap-10 lg:col-span-2 mt-10">
				@foreach ($r_values as $item)
					<article data-gsap-element="stagger" class="__card relative bg-background-brand radius b-shadow p-8 pt-14">
						@if (!empty($item['icon']))
							<div class="__icon absolute">
								{!! wp_get_attachment_image($item['icon']['ID'], 'thumbnail', false, ['class' => 'max-h-10']) !!}
							</div>
						@endif

						@if (!empty($item['header']))
							<h3 class="text-h6">{{ $item['header'] }}</h3>
						@endif

						@if (!empty($item['text']))
							<div class="__text m-header">
								{!! $item['text'] !!}
							</div>
						@endif
					</article>
				@endforeach
			</div>
		@endif
	</div>
</section>
