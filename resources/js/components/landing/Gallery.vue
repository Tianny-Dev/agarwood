<script setup lang="ts">
import { nextTick, onMounted } from 'vue';

// Define $ and the Owl event structure to avoid "any" issues
declare const $: any;

onMounted(async () => {
    await nextTick();
    const $carousel = $('.owl-1');

    if ($carousel.length > 0) {
        const owl1 = $carousel.owlCarousel({
            center: true,
            items: 1,
            loop: true,
            margin: 0,
            smartSpeed: 800,
            dots: false,
            responsive: {
                0: { items: 1 },
                768: { items: 3 },
            },
        });

        // Click Logic
        $('.btn-page-right, .btn-gallery-right').on('click', () => owl1.trigger('next.owl.carousel'));
        $('.btn-page-left, .btn-gallery-left').on('click', () => owl1.trigger('prev.owl.carousel'));

        // FIX: Added (this: HTMLElement) to remove the red line
        $('.page-num').on('click', function (this: HTMLElement) {
            owl1.trigger('to.owl.carousel', [$(this).data('index'), 800]);
        });

        // Sliding Window Logic
        owl1.on('changed.owl.carousel', function (event: any) {
            const count = event.item.count;
            const current = event.item.index;

            // Calculate real index safely
            const clones = event.relatedTarget._clones.length;
            const realIndex = (((current - clones / 2) % count) + count) % count;

            // Calculate the "Next" number in the duo
            const nextIndex = (realIndex + 1) % count;

            // 1. Reset all numbers
            $('.page-num').addClass('hidden').removeClass('bg-medium-brown text-white text-medium-brown border-medium-brown');

            // 2. Show and style the Active Number
            $(`.page-num[data-index="${realIndex}"]`).removeClass('hidden').addClass('bg-medium-brown text-white');

            // 3. Show and style the Next Number
            $(`.page-num[data-index="${nextIndex}"]`).removeClass('hidden').addClass('text-medium-brown border-medium-brown');
        });

        // Initialize the view on load
        owl1.trigger('refresh.owl.carousel');
    }
});
</script>

<template>
    <div id="gallery" class="scroll-mt-18 py-12 lg:scroll-mt-12">
        <div class="text-center">
            <div class="px-5">
                <h1 class="text-4xl font-bold text-medium-brown">Gallery</h1>

                <p class="pt-5 text-lg font-bold text-black">"Our Story in Growth and Impact"</p>
                <p class="pt-2 text-lg text-black">
                    Explore our gallery to see the journey of our <strong>AGARWOOD HIGHLAND VALLEY INC.</strong>, from seedling cultivation to
                    community <br class="hidden xl:block" />
                    impact. These photos show our progress, sustainability efforts, and the people behind our mission.
                </p>
            </div>

            <!-- <div class="flex justify-center gap-5 pt-6 text-xl text-medium-brown">
                    <button>All Photos</button>
                    <button>Seedling Stage</button>
                    <button>Farm Activities</button>
                    <button>Community & Farmers</button>
                    <button>Sustainability Efforts</button>
                    <button>Progress Reports</button>
                    <button>Events & Visits</button>
                </div> -->

            <div class="relative mx-auto w-full max-w-[1200px] pt-7">
                <div class="btn-gallery-left absolute top-1/2 left-2 z-10 w-fit -translate-y-1/2 cursor-pointer xl:left-[-60px]">
                    <div
                        class="grid h-10 w-10 place-items-center rounded-full bg-medium-brown/60 transition-colors hover:bg-dark-brown sm:h-14 sm:w-14 xl:bg-medium-brown"
                    >
                        <i class="fa-solid fa-angle-left text-3xl font-extrabold text-white/60 xl:text-white"></i>
                    </div>
                </div>

                <div class="btn-gallery-right absolute top-1/2 right-2 z-10 w-fit -translate-y-1/2 cursor-pointer xl:right-[-60px]">
                    <div
                        class="grid h-10 w-10 place-items-center rounded-full bg-medium-brown/60 transition-colors hover:bg-dark-brown sm:h-14 sm:w-14 xl:bg-medium-brown"
                    >
                        <i class="fa-solid fa-angle-right text-3xl font-extrabold text-white/60 xl:text-white"></i>
                    </div>
                </div>

                <div class="owl-1 owl-carousel owl-theme">
                    <div class="item md:py-10">
                        <div class="rounded-lg bg-white p-2 shadow-black transition-all duration-500 ease-in-out">
                            <img src="/images/g1.jpg" class="w-full rounded-md" alt="Gallery 1" />
                        </div>
                    </div>
                    <div class="item md:py-10">
                        <div class="rounded-lg bg-white p-2 shadow-black transition-all duration-500 ease-in-out">
                            <img src="/images/g1.jpg" class="w-full rounded-md" alt="Gallery 1" />
                        </div>
                    </div>

                    <div class="item md:py-10">
                        <div class="rounded-lg bg-white p-2 shadow-black transition-all duration-500 ease-in-out">
                            <img src="/images/g1.jpg" class="w-full rounded-md" alt="Gallery 1" />
                        </div>
                    </div>
                </div>

                <div class="flex justify-center gap-3 md:pt-6">
                    <div class="btn-page-left grid h-8 w-8 cursor-pointer place-items-center bg-medium-brown transition-colors hover:bg-dark-brown">
                        <i class="fa-solid fa-angle-left text-2xl font-extrabold text-white"></i>
                    </div>

                    <div id="pagination-numbers" class="flex gap-3">
                        <div
                            data-index="0"
                            class="page-num grid h-8 w-8 cursor-pointer place-items-center border border-medium-brown transition-all duration-300"
                        >
                            1
                        </div>
                        <div
                            data-index="1"
                            class="page-num grid h-8 w-8 cursor-pointer place-items-center border border-medium-brown transition-all duration-300"
                        >
                            2
                        </div>
                        <div
                            data-index="2"
                            class="page-num grid h-8 w-8 cursor-pointer place-items-center border border-medium-brown transition-all duration-300"
                        >
                            3
                        </div>
                    </div>

                    <div class="btn-page-right grid h-8 w-8 cursor-pointer place-items-center bg-medium-brown transition-colors hover:bg-dark-brown">
                        <i class="fa-solid fa-angle-right text-2xl font-extrabold text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.page-num.hidden {
    display: none;
}

.owl-item .item > div {
    transform: scale(0.8);
    transition: all 0.5s ease-in-out;
}
.owl-item.center .item > div {
    transform: scale(1.1);
}

@media only screen and (max-width: 768px) {
    .owl-item.center .item > div {
        transform: scale(1) !important;
        margin-left: 10px;
        margin-right: 10px;
    }
}
</style>
