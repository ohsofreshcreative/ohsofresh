<!--- slider - realizacje --->

@php $bgClass = ($background && $background !== 'none') ? $background : ''; @endphp

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-slider relative -smt' ,
	$bgClass=> true,
	$sectionClass => filled($sectionClass),
	$section_class => filled($section_class),
	])>

	<div class="c-main">
		@if (!empty($slider_title) || !empty($slider_btn))
		<div class="__header flex flex-col sm:flex-row sm:items-end justify-between gap-6 mb-14">
			<div class="w-full md:w-1/2">
				@if (!empty($slider_title))
				<h2>{{ $slider_title }}</h2>
				@endif
				@if (!empty($slider_txt))
				<p class="m-header">{{ $slider_txt }}</p>
				@endif
			</div>
			@if (!empty($slider_btn))
			<div class="shrink-0">
				<x-button :href="$slider_btn['url']" variant="outline" :target="$slider_btn['target'] ?? ''">{{ $slider_btn['title'] }}</x-button>
			</div>
			@endif
		</div>
		@endif
		<div class="swiper slider-standard relative !overflow-visible z-20">
			<div class="swiper-wrapper">
				@foreach ($slides as $slide)
				<div class="swiper-slide">
					<article class="__card">
						<a href="{{ $slide['url'] }}" class="__link group relative block overflow-hidden aspect-[6/5] radius">
							@if (!empty($slide['image_url']))
							<figure class="__img absolute inset-0 m-0">
								<img
									src="{{ $slide['image_url'] }}"
									alt="{{ $slide['image_alt'] ?: $slide['title'] }}"
									class="w-full h-full object-cover transition-transform duration-500 ease-out group-hover:scale-110">
							</figure>
							@endif

							<div class="absolute inset-0 bg-gradient-to-b from-transparent to-[#0f1219] pointer-events-none"></div>

							@if (!empty($slide['categories']))
							<div class="__categories absolute inset-x-0 top-0 z-10 flex flex-wrap gap-2 p-6 md:p-8">
								@foreach ($slide['categories'] as $category)
								<span class="inline-flex items-center rounded-full border border-white bg-transparent px-3 py-1 text-xs font-medium leading-none text-white">
									{{ $category }}
								</span>
								@endforeach
							</div>
							@endif

							<div class="__content absolute inset-x-0 bottom-0 z-10 flex items-end justify-between gap-6 p-6 md:p-8 text-white">
								<h3 class="__title text-h4">{!! $slide['title'] !!}</h3>
								<span class="grid size-14 shrink-0 place-items-center rounded-full border border-white" aria-hidden="true">
									<x-icon.arrow-up class="h-4 w-4 rotate-[225deg] group-hover:rotate-[270deg] transition-transform text-white" />
								</span>
							</div>
						</a>
					</article>
				</div>
				@endforeach
			</div>

			{{-- Strzałki wycentrowane na środku obrazka --}}
			<div data-gsap-element="arrows" class="__prev absolute left-0 top-1/2 -translate-y-1/2 -translate-x-1/2 rounded-full bg-primary h-14 w-14 flex items-center justify-center cursor-pointer transition-all duration-400 z-10 hover:scale-110">
				<svg xmlns="http://www.w3.org/2000/svg" width="13" height="12" viewBox="0 0 13 12" fill="none">
					<path d="M0.270429 5.31498C0.270706 5.31469 0.270937 5.31435 0.27126 5.31406L5.08882 0.281803C5.44973 -0.0951806 6.03348 -0.0937777 6.39273 0.285093C6.75194 0.663916 6.75055 1.27664 6.38964 1.65367L3.15514 5.03226L12.078 5.03226C12.5872 5.03226 13 5.46552 13 6C13 6.53448 12.5872 6.96774 12.078 6.96774L3.15518 6.96774L6.3896 10.3463C6.75051 10.7234 6.75189 11.3361 6.39269 11.7149C6.03344 12.0938 5.44963 12.0951 5.08877 11.7182L0.271213 6.68594C0.270936 6.68565 0.270706 6.68531 0.270383 6.68502C-0.0907122 6.30673 -0.08956 5.69202 0.270429 5.31498Z" fill="#FFF" />
				</svg>
			</div>
			<div data-gsap-element="arrows" class="__next absolute right-0 top-1/2 -translate-y-1/2 translate-x-1/2 rounded-full bg-primary h-14 w-14 flex items-center justify-center cursor-pointer transition-all duration-300 z-10 hover:scale-110">
				<svg xmlns="http://www.w3.org/2000/svg" width="13" height="12" viewBox="0 0 13 12" fill="none">
					<path d="M12.7296 5.31498C12.7293 5.31469 12.7291 5.31435 12.7287 5.31406L7.91118 0.281803C7.55027 -0.0951806 6.96652 -0.0937777 6.60727 0.285093C6.24806 0.663916 6.24945 1.27664 6.61036 1.65367L9.84486 5.03226L0.921985 5.03226C0.412773 5.03226 0 5.46552 0 6C0 6.53448 0.412773 6.96774 0.921985 6.96774L9.84482 6.96774L6.6104 10.3463C6.24949 10.7234 6.24811 11.3361 6.60731 11.7149C6.96657 12.0938 7.55037 12.0951 7.91123 11.7182L12.7288 6.68594C12.7291 6.68565 12.7293 6.68531 12.7296 6.68502C13.0907 6.30673 13.0896 5.69202 12.7296 5.31498Z" fill="#FFF" />
				</svg>
			</div>
		</div>
	</div>
</section>
