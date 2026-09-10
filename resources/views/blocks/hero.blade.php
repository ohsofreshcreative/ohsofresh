<!-- hero --->

<section
    data-gsap-anim="section"
    @if(!empty($section_id)) id="{{ $section_id }}" @endif
    @class([ 'b-hero relative h-screen -spt overflow-visible' ,
    $sectionClass=> filled($sectionClass),
    $section_class => filled($section_class),
    $background => filled($background) && $background !== 'none',
    ])>

    @if (!empty($g_hero['video']) || !empty($g_hero['image']))
    <div class="absolute inset-x-0 top-0 h-[40svh] sm:h-full overflow-hidden z-0" id="heroVideoWrapper">

        @if (!empty($g_hero['video']))
        <video class="absolute inset-0 w-full h-full object-cover" id="myVideo" autoplay loop muted playsinline>
            <source src="{{ $g_hero['video'] }}" type="video/mp4">
        </video>
        @endif

        @if (!empty($g_hero['image']))
        <img
            src="{{ $g_hero['image']['url'] }}"
            alt="{{ $g_hero['image']['alt'] }}"
            class="video-fallback absolute inset-0 w-full h-full object-cover transition-[opacity,visibility] duration-300 ease-in-out" />
        @endif

    </div>
    @endif


    <div class=" __wrapper c-main relative z-10">
        <div class="__content relative flex flex-col justify-center w-full md:w-10/12 lg:w-6/12 z-20 pt-28 sm:pt-48 pb-48 sm:pb-62">
            <p data-gsap-element="header" class="text-white">
                {{ $g_hero['title'] }}
            </p>
			@if (!empty($g_hero['text']))
            <div data-gsap-element="text" class="text-white mt-2">
                {!! $g_hero['text'] !!}
            </div>
			@endif

            <div class="inline-buttons m-btn">
                @if (!empty($g_hero['button1']))
                <x-button
                    :href="$g_hero['button1']['url']"
                    variant="primary"
                    class=""
                    data-gsap-element="btn">
                    {{ $g_hero['button1']['title'] }}
                </x-button>
                @endif

                @if (!empty($g_hero['button2']))
                <x-button
                    :href="$g_hero['button2']['url']"
                    variant="outline"
                    class=""
                    data-gsap-element="btn">
                    {{ $g_hero['button2']['title'] }}
                </x-button>
                @endif
            </div>
        </div>
    </div>

    @if (!empty($g_hero['video']))
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const video   = document.getElementById('myVideo');
        const wrapper = document.getElementById('heroVideoWrapper');
        if (!video || !wrapper) return;

        const markPlaying = () => wrapper.classList.add('is-playing');
        video.addEventListener('canplay', markPlaying, { once: true });
        video.addEventListener('playing', markPlaying, { once: true });

        const tryPlay = video.play?.();
        if (tryPlay && typeof tryPlay.catch === 'function') {
            tryPlay.catch(() => {});
        }
    });
    </script>
    @endif

</section>
