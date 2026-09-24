<article @php(post_class('__card'))>

	<a class="rounded-2xl group" href="{{ get_permalink() }}">
		<div class="__content relative bg-white rounded-4xl p-6">
			@if (has_post_thumbnail())
			<div class="block rounded-2xl overflow-hidden">
				{!! get_the_post_thumbnail(null, 'large', ['class' => 'w-full img-s object-cover', 'alt' => get_the_title(), 'loading' => 'lazy']) !!}
			</div>
			@endif
			<h6 class="mt-6">
				{!! get_the_title() !!}
			</h6>
			<!--  <div class="mt-2">
            @php(the_excerpt())
        </div> -->
			<p href="{{ get_permalink() }}" class="btn btn-outline-secondary group-hover:!bg-secondary group-hover:!text-white !px-6 !py-3 mt-4">
				Przeczytaj
			</p>
		</div>
	</a>
</article>