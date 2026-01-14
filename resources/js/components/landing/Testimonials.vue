<script setup lang="ts">
import { nextTick, onMounted } from 'vue';

declare const $: any;

onMounted(async () => {
    await nextTick();
    const $carousel = $('.owl-2');

    if ($carousel.length > 0) {
        const owl2 = $carousel.owlCarousel({
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
        $('.btn-page-right, .btn-gallery-right').on('click', () => owl2.trigger('next.owl.carousel'));
        $('.btn-page-left, .btn-gallery-left').on('click', () => owl2.trigger('prev.owl.carousel'));

        $('.page-num').on('click', function (this: HTMLElement) {
            owl2.trigger('to.owl.carousel', [$(this).data('index'), 800]);
        });

        // Sliding Window Logic
        owl2.on('changed.owl.carousel', function (event: any) {
            const count = event.item.count; // Total items (e.g., 3)
            const current = event.item.index;
            const realIndex = (((current - event.relatedTarget._clones.length / 2) % count) + count) % count;

            // Calculate the "Next" number in the duo (if current is 3, next is 1)
            const nextIndex = (realIndex + 1) % count;

            // 1. Reset all numbers
            $('.page-num').addClass('hidden').removeClass('bg-medium-brown text-white text-medium-brown');

            // 2. Show and style the Active Number
            $(`.page-num[data-index="${realIndex}"]`).removeClass('hidden').addClass('bg-medium-brown text-white');

            // 3. Show and style the Next Number
            $(`.page-num[data-index="${nextIndex}"]`).removeClass('hidden').addClass('text-medium-brown border-medium-brown');
        });

        // Initialize the view on load
        owl2.trigger('refresh.owl.carousel');
    }
});
</script>

<template>
    <div id="testimonials" class="scroll-mt-20 bg-[url('images/tes.jpg')] bg-cover bg-center bg-no-repeat pt-10 lg:scroll-mt-16">
        <div class="relative mx-auto w-full max-w-[1200px]">
            <div class="px-5">
                <div class="mx-auto mb-10 w-full rounded-4xl bg-white py-2 text-center">
                    <h1 class="text-4xl font-bold text-medium-brown">Testimonials</h1>
                </div>
            </div>

            <div class="relative">
                <div class="btn-gallery-left absolute top-1/2 left-2 z-10 w-fit -translate-y-1/2 cursor-pointer xl:left-[-60px]">
                    <div
                        class="grid h-14 w-14 place-items-center rounded-full bg-medium-brown/60 transition-colors hover:bg-dark-brown xl:bg-medium-brown"
                    >
                        <i class="fa-solid fa-angle-left text-3xl font-extrabold text-white"></i>
                    </div>
                </div>

                <div class="btn-gallery-right absolute top-1/2 right-2 z-10 w-fit -translate-y-1/2 cursor-pointer xl:right-[-60px]">
                    <div
                        class="grid h-14 w-14 place-items-center rounded-full bg-medium-brown/60 transition-colors hover:bg-dark-brown xl:bg-medium-brown"
                    >
                        <i class="fa-solid fa-angle-right text-3xl font-extrabold text-white"></i>
                    </div>
                </div>

                <div class="owl-2 owl-carousel owl-theme pb-12">
                    <div class="h-full px-4 pt-22">
                        <div
                            class="relative flex h-full flex-col justify-between rounded-lg bg-white p-6 text-center text-xl text-black shadow-black transition-all duration-500 ease-in-out"
                        >
                            <div
                                class="absolute start-0 end-0 top-[-60px] mx-auto h-[120px] w-[120px] overflow-hidden rounded-full border-2 border-white shadow-black/40 shadow-lg"
                            >
                                <img src="images/g1.png" alt="" class="h-full w-full object-cover" />
                            </div>

                            <div class="grid gap-5 pt-16">
                                <p>
                                    "Investing in this agarwood farming partnership gave me peace of mind. I know my funds are used transparently, and
                                    I’m helping both the environment and local farmers grow."
                                </p>
                                <p><span class="font-bold text-medium-brown">Maria Santos</span> - Partner Investor</p>
                            </div>
                        </div>
                    </div>

                    <div class="h-full px-4 pt-22">
                        <div
                            class="relative flex h-full flex-col justify-between rounded-lg bg-white p-6 text-center text-xl text-black shadow-black transition-all duration-500 ease-in-out"
                        >
                            <div
                                class="absolute start-0 end-0 top-[-60px] mx-auto h-[120px] w-[120px] overflow-hidden rounded-full border-2 border-white shadow-black/40 shadow-lg"
                            >
                                <img src="images/b1.png" alt="" class="h-full w-full object-cover" />
                            </div>

                            <div class="grid gap-5 pt-16">
                                <p>
                                    "Through this program, I’ve learned proper ways to care for agarwood. It’s not just farming, it’s building a
                                    future for my family and community."
                                </p>
                                <p><span class="font-bold text-medium-brown">Juan Dela Cruz</span> - Partner Investor</p>
                            </div>
                        </div>
                    </div>

                    <div class="h-full px-4 pt-22">
                        <div
                            class="relative flex h-full flex-col justify-between rounded-lg bg-white p-6 text-center text-xl text-black shadow-black transition-all duration-500 ease-in-out"
                        >
                            <div
                                class="absolute start-0 end-0 top-[-60px] mx-auto h-[120px] w-[120px] overflow-hidden rounded-full border-2 border-white shadow-black/40 shadow-lg"
                            >
                                <img src="images/g2.png" alt="" class="h-full w-full object-cover" />
                            </div>

                            <div class="grid gap-5 pt-16">
                                <p>
                                    "What I love most is that this project creates impact beyond profits. It promotes reforestation, empowers farmers,
                                    and contributes to a greener future."
                                </p>
                                <p><span class="font-bold text-medium-brown">Angela Reyes</span> - Partner Investor</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
