<!--- contact --->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-contact  relative' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	@if (!empty($g_contact_1['image']))
	<figure class="absolute inset-0 w-1/2 h-full z-0 m-0">
		<picture class="w-full h-full">
			<img src="{{ $g_contact_1['image']['url'] }}" alt="{{ $g_contact_1['image']['alt'] }}" class="w-full h-full object-cover" />
		</picture>
	</figure>
	@endif

	@if (!empty($g_contact_1['image']))
	<div class="absolute inset-0 z-1 pointer-events-none" style="background-image: linear-gradient(0deg, #1b202c 0%, rgba(27, 32, 44, 0) 100%), linear-gradient(90deg, #290751 0%, rgba(41, 7, 81, 0) 100%), url('https://ohsofresh.pl/wp-content/uploads/2022/12/contact-bg.jpg');"></div>
	@endif

	<div class="__wrapper c-main relative z-2 pt-10 pb-10 md:pt-48 md:pb-32">

		<div class="relative grid grid-cols-1 lg:grid-cols-2 items-center gap-10 z-10">
			<div class="__content flex flex-col justify-between">
				<h2 data-gsap-element="header" class="text-white m-header">{!! $g_contact_1['header'] !!}</h2>
				<a data-gsap-element="txt" class="__phone flex items-center !text-white hover:!text-primary-200 w-max mt-6" href="tel:{{ $g_contact_1['phone'] }}">{{ $g_contact_1['phone'] }}</a>
				<a data-gsap-element="txt" class="__mail flex items-center !text-white hover:!text-primary-200 w-max mt-2" href="mailto:{{ $g_contact_1['mail'] }}">{{ $g_contact_1['mail'] }}</a>
				<div data-gsap-element="txt" class="__address text-white mt-10">{!! $g_contact_1['address'] !!}</div>

				@if (!empty($g_contact_1['r_contact']))
				<div class="__socials flex flex-wrap items-center gap-3 mt-6">
					@foreach ($g_contact_1['r_contact'] as $social)
						@if (!empty($social['image']) && !empty($social['link']))
						<a
							data-gsap-element="stagger"
							href="{{ $social['link'] }}"
							target="_blank"
							rel="noopener noreferrer"
							class="block rounded-full transition-transform duration-300 hover:scale-110">
							<img
								class=""
								src="{{ $social['image']['url'] }}"
								alt="{{ $social['image']['alt'] ?: 'Social media' }}"
								loading="lazy"
								decoding="async">
						</a>
						@endif
					@endforeach
				</div>
				@endif
			</div>

			<div data-gsap-element="form" class="">
				<h4 class="!text-primary mb-4">{!! $g_contact_2['title'] !!}</h4>
				<p class="block pb-8">{!! $g_contact_2['text'] !!}</p>
				{!! do_shortcode($g_contact_2['shortcode']) !!}
			</div>
		</div>
	</div>

</section>
