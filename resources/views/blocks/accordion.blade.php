<!-- accordion -->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-accordion relative -smt' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<div class="c-main">
		<div class="__wrapper">
			<div class="grid grid-cols-1 lg:grid-cols-2 items-start gap-8 lg:gap-20 my-10">
				<div class="__col">
					<h4 data-gsap-element="header" class=" text-primary">{{ $g_accordion['title'] }}</h4>
					<div data-gsap-element="txt" class="m-header">{!! $g_accordion['text'] !!}</div>
					@if (!empty($g_accordion['image']))
					<figure data-gsap-element="img" class="__img order1 h-full mt-8">
						<picture>
							<img class="object-cover img-md w-full radius-img" src="{{ $g_accordion['image']['url'] }}" alt="{{ $g_accordion['image']['alt'] ?? '' }}">
						</picture>
					</figure>
					@endif

					@if (!empty($g_accordion['button']))
					<a class="main-btn m-btn" href="{{ $g_accordion['button']['url'] }}">{{ $g_accordion['button']['title'] }}</a>
					@endif
				</div>

				<div class="__content order2">
					@php($accordion_uid = wp_unique_id('accordion-'))
					<div data-gsap-element="accordion" class="accordion-wrapper grid">
						@foreach ($r_accordion as $item)
						<div class="accordion rounded-xl border border-white/20 h-max p-4">
							<input class="acc-check" type="radio" name="{{ $accordion_uid }}-radio" id="{{ $accordion_uid }}-item-{{ $loop->index }}" {{ $loop->first ? 'checked' : '' }}>

							<label class="accordion-label flex items-center justify-between !text-white text-base font-medium font-header gap-4" for="{{ $accordion_uid }}-item-{{ $loop->index }}">
								<div class="flex items-center gap-2">
									@if (!empty($item['icon']['url']))
									<img src="{{ $item['icon']['url'] }}" alt="{{ $item['icon']['alt'] ?? '' }}" class="w-8 h-8 mr-2">
									@endif
									{{ $item['title'] }}
								</div>
								<span class="__toggle-icon relative flex h-4 w-4 shrink-0 items-center justify-center rounded-full border border-white bg-transparent" aria-hidden="true">
									<span class="__toggle-horizontal absolute left-1/2 top-1/2 h-0.5 w-2 -translate-x-1/2 -translate-y-1/2 rounded-full bg-white"></span>
									<span class="__toggle-vertical absolute left-1/2 top-1/2 h-2 w-0.5 -translate-x-1/2 -translate-y-1/2 rounded-full bg-white"></span>
								</span>
							</label>
							<div class="accordion-content">
								{!! $item['text'] !!}
							</div>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
