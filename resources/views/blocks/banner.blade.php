<!-- banner --->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-banner relative -spt overflow-visible' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	@if (!empty($g_banner['image']))
	<figure class="absolute inset-x-0 top-0 w-full h-[40svh] sm:h-full z-0 m-0">
		<picture class="w-full h-full">
			<img src="{{ $g_banner['image']['url'] }}" alt="{{ $g_banner['image']['alt'] }}" class="w-full h-full object-cover" />
		</picture>
	</figure>
	@endif

	@if (!empty($g_banner['video']) || !empty($g_banner['image']))
	<div class="absolute inset-x-0 top-0 h-[40svh] sm:h-full z-1 pointer-events-none" style="background: linear-gradient(0deg, rgba(21, 25, 35, 1) 0%, rgba(21, 25, 35, 0) 60%), linear-gradient(90deg, rgba(41, 7, 81, 1) 0%, rgba(41, 7, 81, 0.4) 100%);"></div>
	@endif

<!-- 	@if (!empty($g_banner['video']) || !empty($g_banner['image']))
	<div class="absolute inset-0 z-1 pointer-events-none" style="background: linear-gradient(0deg, rgba(21, 25, 35, 0.85) 0%, rgba(21, 25, 35, 0) 60%), linear-gradient(90deg, rgba(21, 25, 35, 1) 0%, rgba(21, 25, 35, 0) 100%);"></div>
	@endif -->

	<div class=" __wrapper c-main relative z-10">
        <div class="__content relative flex flex-col justify-center w-full md:w-10/12 lg:w-6/12 z-20 pt-28 sm:pt-48 pb-48 sm:pb-62">
			<p data-gsap-element="header" class="text-h6 text-white/20">
				{{ $g_banner['title'] }}
			</p>
			<h1 data-gsap-element="header" class="text-h2 text-white mt-2">
				{{ $g_banner['header'] }}
			</h1>
			@if (!empty($g_banner['text']))
            <div data-gsap-element="text" class="text-white mt-4">
                {!! $g_banner['text'] !!}
            </div>
			@endif

			<div class="inline-buttons m-btn">
				@if (!empty($g_banner['button1']))
				<x-button
					:href="$g_banner['button1']['url']"
					:target="$g_banner['button1']['target'] ?? '_self'"
					:rel="($g_banner['button1']['target'] ?? '') === '_blank' ? 'noopener noreferrer' : null"
					variant="primary"
					class=""
					data-gsap-element="btn">
					{{ $g_banner['button1']['title'] }}
				</x-button>
				@endif

				@if (!empty($g_banner['button2']))
				<x-button
					:href="$g_banner['button2']['url']"
					:target="$g_banner['button2']['target'] ?? '_self'"
					:rel="($g_banner['button2']['target'] ?? '') === '_blank' ? 'noopener noreferrer' : null"
					variant="outline"
					class=""
					data-gsap-element="btn">
					{{ $g_banner['button2']['title'] }}
				</x-button>
				@endif
			</div>
		</div>
	</div>

</section>
