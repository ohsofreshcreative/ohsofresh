@props([
	'image' => null,
	'mobileImage' => null,
	'figureClass' => null,
	'class' => null,
	'loading' => 'lazy',
	'fetchpriority' => null,
])

@php
$imageSizes = ['img-xs', 'img-s', 'img-m', 'img-md', 'img-l', 'img-xl', 'img-2xl', 'img-3xl'];

$buildSrcset = function ($img) use ($imageSizes) {
	if (empty($img['sizes'])) {
		return null;
	}

	$candidates = [];

	foreach ($imageSizes as $size) {
		if (!empty($img['sizes'][$size]) && !empty($img['sizes']["{$size}-width"])) {
			$candidates[] = $img['sizes'][$size] . ' ' . $img['sizes']["{$size}-width"] . 'w';
		}
	}

	return $candidates ? implode(', ', $candidates) : null;
};

$srcset = !empty($image) ? $buildSrcset($image) : null;
$mobileSrcset = !empty($mobileImage) ? $buildSrcset($mobileImage) : null;
@endphp

@if (!empty($image))
@if ($figureClass)
<figure {{ $attributes->merge(['class' => $figureClass]) }}>
@endif

@if (!empty($mobileImage))
<picture>
	<source media="(max-width: 767px)" srcset="{{ $mobileSrcset ?: $mobileImage['url'] }}">
	<img
		src="{{ $image['url'] }}"
		@if ($srcset) srcset="{{ $srcset }}" sizes="100vw" @endif
		@if (!empty($image['width'])) width="{{ $image['width'] }}" @endif
		@if (!empty($image['height'])) height="{{ $image['height'] }}" @endif
		alt="{{ $image['alt'] ?? '' }}"
		loading="{{ $loading }}"
		decoding="async"
		@if ($fetchpriority) fetchpriority="{{ $fetchpriority }}" @endif
		@if ($figureClass) @if ($class) class="{{ $class }}" @endif @else {{ $attributes->merge(['class' => $class]) }} @endif>
</picture>
@else
<img
	src="{{ $image['url'] }}"
	@if ($srcset) srcset="{{ $srcset }}" sizes="100vw" @endif
	@if (!empty($image['width'])) width="{{ $image['width'] }}" @endif
	@if (!empty($image['height'])) height="{{ $image['height'] }}" @endif
	alt="{{ $image['alt'] ?? '' }}"
	loading="{{ $loading }}"
	decoding="async"
	@if ($fetchpriority) fetchpriority="{{ $fetchpriority }}" @endif
	@if ($figureClass) @if ($class) class="{{ $class }}" @endif @else {{ $attributes->merge(['class' => $class]) }} @endif>
@endif

@if ($figureClass)
</figure>
@endif
@endif
