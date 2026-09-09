@php
use App\Walkers\DropdownWalker;
use App\Walkers\MobileDropdownWalker;

$gtranslate = $_COOKIE['googtrans'] ?? '';
$currentLanguage = is_string($gtranslate) && str_ends_with($gtranslate, '/en') ? 'en' : 'pl';
$languageLinks = shortcode_exists('gt-link') ? [
'en' => do_shortcode('[gt-link lang="en" label="EN" widget_look="lang_codes"]'),
'pl' => do_shortcode('[gt-link lang="pl" label="PL" widget_look="lang_codes"]'),
] : [];
@endphp

<header x-data="{ mobileOpen: false }" class="relative top-0 z-50 bg-transparent masthead fixed-top mx-0">

	<!-- Desktop Header -->
	<div class="items-center justify-between hidden h-full py-4 px-12 mx-auto lg:flex">
		<a class="brand shrink-0" href="{{ home_url('/') }}">
			@if ($logo)
			<img src="{{ $logo['url'] }}" alt="{{ $logo['alt'] ?? 'Logo' }}" class="w-auto h-12">
			@else
			<span class="text-xl font-bold">{{ $siteName }}</span>
			@endif
		</a>
		@if (has_nav_menu('primary_navigation'))
		<nav class="ml-auto nav-primary" aria-label="{{ wp_get_nav_menu_name('primary_navigation') }}">
			{!! wp_nav_menu([
			'theme_location' => 'primary_navigation',
			'menu_class' => 'nav flex gap-x-3 lg:gap-x-10 text-lg font-medium',
			'container' => false,
			'echo' => false,
			'depth' => 3,
			'walker' => new DropdownWalker(),
			]) !!}
		</nav>
		@endif

		@if ($languageLinks)
		<div class="language-switcher notranslate shrink-0 mx-6 border-l pl-4" translate="no">
			@foreach ($languageLinks as $language => $link)
			<span data-language-target="{{ $language }}" @if ($currentLanguage===$language) hidden @endif>
				{!! $link !!}
			</span>
			@endforeach
		</div>
		@endif


		<div class="">
			<a href="/kontakt/" class="block w-full btn btn-primary btn-primary-small">
				Kontakt
			</a>
		</div>
	</div>

	<!-- Mobile Header Bar -->
	<div class="flex items-center justify-between p-4 mobile-menu fixed-top lg:hidden">
		<a class="brand shrink-0" href="{{ home_url('/') }}">
			@if ($logo)
			<img src="{{ $logo['url'] }}" alt="{{ $logo['alt'] ?? 'Logo' }}" class="w-auto h-12">
			@else
			<span class="text-lg font-bold">{{ $siteName }}</span>
			@endif
		</a>
		<button
			@click.stop="mobileOpen = !mobileOpen"
			class="p-2 primary bg-brand-body rounded-md"
			:aria-expanded="mobileOpen.toString()"
			aria-controls="mobile-menu-panel">
			<span class="sr-only">Otwórz menu główne</span>
			<svg x-show="!mobileOpen" class="block w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
				<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
			</svg>
			<svg x-show="mobileOpen" class="block w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" style="display: none;">
				<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
			</svg>
		</button>
	</div>

	<!-- Mobile Menu Panel -->
	<div
		id="mobile-menu-panel"
		x-show="mobileOpen"
		@click.away="mobileOpen = false"
		@keydown.escape.window="mobileOpen = false"
		x-transition:enter="transition ease-out duration-200"
		x-transition:enter-start="opacity-0 transform translate-x-full"
		x-transition:enter-end="opacity-100 transform translate-x-0"
		x-transition:leave="transition ease-in duration-150"
		x-transition:leave-start="opacity-100 transform translate-x-0"
		x-transition:leave-end="opacity-0 transform translate-x-full"
		class="mobile-menu fixed top-0 right-0 bottom-0 w-full h-full bg-brand-body shadow-xl z-[51] overflow-y-auto lg:hidden"
		aria-label="Menu mobilne">
		<div class="p-4 relative z-10">
			<div class="flex items-center justify-between mb-6">
				<span class=""><a class="brand shrink-0" href="{{ home_url('/') }}"><img src="{{ $logo['url'] }}" alt="{{ $logo['alt'] ?? 'Logo' }}" class="w-auto h-12"></a></span>
				<button
					@click="mobileOpen = false"
					class="p-2 text-white rounded-md">
					<span class="sr-only">Zamknij menu</span>
					<svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
						<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
					</svg>
				</button>
			</div>

			@if (has_nav_menu('primary_navigation'))
			<nav class="flex flex-col space-y-1 mt-20">
				{!! wp_nav_menu([
				'theme_location' => 'primary_navigation',
				'menu_class' => 'nav-mobile flex flex-col space-y-2',
				'container' => false,
				'echo' => false,
				'depth' => 3,
				'walker' => new MobileDropdownWalker(),
				]) !!}
			</nav>
			@endif

			@if ($languageLinks)
			<div class="language-switcher notranslate mt-8" translate="no">
				@foreach ($languageLinks as $language => $link)
				<span data-language-target="{{ $language }}" @if ($currentLanguage===$language) hidden @endif>
					{!! $link !!}
				</span>
				@endforeach
			</div>
			@endif

			<div class="mt-8">
				<a href="/kontakt/" class="block w-full btn btn-primary">
					Kontakt
				</a>
			</div>
		</div>

	</div>
</header>