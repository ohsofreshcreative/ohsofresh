<!--- action -->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-action relative overflow-hidden mt-12 mb-12' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<div class="__wrapper relative border-1 border-dashed border-white radius-img p-8">

		<div class="__col grid grid-cols-1 lg:grid-cols-2 items-center gap-8 lg:gap-16">
			@if (!empty($g_action['image']))
			<figure data-gsap-element="img" class="__img order1 !m-0">
				<picture>
					<img class="radius w-full aspect-square object-cover" src="{{ $g_action['image']['url'] }}" alt="{{ $g_action['image']['alt'] ?? '' }}">
				</picture>
			</figure>
			@endif

			<div class="__content order2">
				<p data-gsap-element="header" class="__header text-h4 text-white">{{ $g_action['header'] }}</p>

				<div data-gsap-element="txt" class="__txt text-white">
					{!! $g_action['text'] !!}
				</div>

				@if (!empty($g_action['button1']))
				<div class="inline-buttons m-btn">
					<x-button
						:href="$g_action['button1']['url']"
						variant="primary"
						class="!no-underline"
						data-gsap-element="btn">
						{{ $g_action['button1']['title'] }}
					</x-button>
					@endif
				</div>

			</div>
		</div>

</section>