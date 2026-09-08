<footer class="footer overflow-hidden relative z-10">

	<div class="__wrapper relative z-10">
		<div class="c-main">
			<div class="__widgets grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-1 md:gap-6 footer-py">

				<div class="flex flex-col gap-4 mb-10 md:mb-0">

					@if(!empty($footer_contact['address']))
					@if(!empty($logo_footer))
					<a href="{{ home_url('/') }}" class="block max-w-[180px]">
						<img src="{{ $logo_footer['url'] }}" alt="{{ $logo_footer['alt'] ?? get_bloginfo('name') }}" class="w-full h-auto object-contain" />
					</a>
					@endif
					<div class="__txt mt-2">
						{!! $footer_contact['address'] !!}
					</div>
					@endif
					<div class="flex flex-col gap-2">
						@if(!empty($footer_contact['phone']))
						<a href="tel:{{ str_replace(' ', '', $footer_contact['phone']) }}" class="font-medium inline-flex items-center gap-2 hover:!underline">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.79 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
							</svg>
							{{ $footer_contact['phone'] }}
						</a>
						@endif
						@if(!empty($footer_contact['email']))
						<a href="mailto:{{ $footer_contact['email'] }}" class="font-medium inline-flex items-center gap-2 hover:!underline">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
								<polyline points="22,6 12,13 2,6"></polyline>
							</svg>
							{{ $footer_contact['email'] }}
						</a>
						@endif
					</div>
				</div>

				@for ($i = 1; $i <= 4; $i++)
					@if (is_active_sidebar('sidebar-footer-' . $i))
					<div>@php(dynamic_sidebar('sidebar-footer-' . $i))
			</div>
			@endif
			@endfor
		</div>
	</div>

	</div>

	<div class="c-main flex flex-col md:flex-row justify-between gap-6 py-10 footer-bottom">
		<p class="">Copyright ©{{ date('Y') }} {{ get_bloginfo('name') }}. All Rights Reserved</p>
		<p class="flex gap-2">Designed &amp; Developed by
			<a target="_blank" rel="nofollow" href="https://www.ohsofresh.pl" title="OhSoFresh"><img class="oh" src="{{ get_template_directory_uri() }}/resources/images/ohsofresh.svg"></a>
		</p>
	</div>

</footer>