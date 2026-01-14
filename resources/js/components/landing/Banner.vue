<script setup lang="ts">
import { computed, ref } from 'vue';
// 1. Define the slide data
const slides = [
    {
        title: 'Growing Value, Sustaining Futures',
        description:
            "We build transparent partnerships that connect investors and farmers to cultivate <br class='lg:block hidden' /> <span class='font-bold'>agarwood</span>, one of the world’s most valuable trees. Through a <span class='font-bold'>5-year sustainable <br class='lg:block hidden' /> farming model</span>, we create opportunities for profit, reforestation, and community growth, laying the foundation for future resin harvest and long-term impact.",
        image: 'images/1.jpg',
    },
    {
        title: 'Invest in Trees, Grow in Value',
        description:
            'Join our agarwood farming partnership, where your ₱150,000 investment <br class="lg:block hidden" /> in 10 seedlings grows into a sustainable, high-value future in the <br class="lg:block hidden" /> global agarwood market.',
        image: 'images/2.jpg',
    },
    {
        title: 'Profit with Purpose, Growth with Green',
        description:
            'We cultivate agarwood through eco-friendly farming that restores forests, <br class="lg:block hidden" /> empowers communities, and creates long-term value for both <br class="lg:block hidden" /> investors and the environment.',
        image: 'images/7.jpg',
    },
    {
        title: 'Empowering Farmers, Cultivating Wealth',
        description:
            'Our model connects farmers with investors, giving local growers <br class="lg:block hidden" /> access to high-value agarwood while ensuring transparency, <br class="lg:block hidden" /> training, and shared prosperity.',
        image: 'images/8.jpg',
    },
    {
        title: 'Plant Today, Prosper Tomorrow',
        description:
            'Through a 5-year Agarwood seedling partnership, we prepare the foundation <br class="lg:block hidden" /> for future resin harvesting, creating sustainable income, jobs, and opportunities.',
        image: 'images/5.jpg',
    },
    {
        title: 'From Seedlings to World’s Finest Oud',
        description:
            'Agarwood, known as the “liquid gold” of the forest, is in high global demand. <br class="lg:block hidden" /> Our cultivation program offers a secure, sustainable entry point <br class="lg:block hidden" /> into this billion-dollar market.',
        image: 'images/6.jpg',
    },
];

const currentIndex = ref(0);

// 2. Navigation logic
const nextSlide = () => {
    currentIndex.value = (currentIndex.value + 1) % slides.length;
};

const prevSlide = () => {
    currentIndex.value = (currentIndex.value - 1 + slides.length) % slides.length;
};

// 3. Computed style for the dynamic background
const currentBgStyle = computed(() => ({
    backgroundImage: `url(${slides[currentIndex.value].image})`,
}));
</script>

<template>
    <div
        class="h-full min-h-full w-full bg-cover bg-center bg-no-repeat px-5 pt-0 pb-42 text-white transition-all duration-700 ease-in-out lg:pt-15"
        :style="currentBgStyle"
    >
        <div class="mx-auto w-full max-w-[1200px] text-center">
            <div class="relative">
                <div class="absolute top-1/2 left-[-12px] z-0 w-fit -translate-y-1/2 cursor-pointer lg:left-0" @click="prevSlide">
                    <div class="grid h-10 w-10 place-items-center rounded-full bg-white/50 transition-colors hover:bg-gray-200 lg:bg-white">
                        <i class="fa-solid fa-angle-left text-3xl font-extrabold text-medium-brown/50"></i>
                    </div>
                </div>

                <div class="absolute top-1/2 right-[-12px] z-0 w-fit -translate-y-1/2 cursor-pointer lg:right-0" @click="nextSlide">
                    <div class="grid h-10 w-10 place-items-center rounded-full bg-white/50 transition-colors hover:bg-gray-200 lg:bg-white">
                        <i class="fa-solid fa-angle-right text-3xl font-extrabold text-medium-brown/50"></i>
                    </div>
                </div>

                <div class="banner-text grid h-[350px] place-items-center sm:h-[300px] lg:h-[230px]">
                    <transition name="fade" mode="out-in">
                        <div :key="currentIndex">
                            <h2 class="text-3xl font-bold md:text-4xl">"{{ slides[currentIndex].title }}"</h2>
                            <p class="mx-auto max-w-[900px] pt-5 text-xl md:text-2xl" v-html="slides[currentIndex].description"></p>
                        </div>
                    </transition>
                </div>
            </div>
            <button
                class="w-full max-w-[300px] rounded-3xl border-3 border-white bg-medium-brown px-5 py-1.5 text-2xl font-bold transition-all hover:brightness-110"
            >
                Invest Now!
            </button>
        </div>
    </div>

    <div class="what-we relative mx-5 h-[130px] bg-white">
        <div class="absolute top-[-130px] w-full">
            <div class="mx-auto w-full max-w-[1200px]">
                <div class="relative mt-10 rounded-2xl bg-light-brown p-6 text-white">
                    <div
                        class="absolute start-0 end-0 top-[-28px] mx-auto w-fit rounded-3xl border-3 border-light-brown bg-medium-brown px-5 px-9 py-1.5 text-3xl font-bold sm:w-[500px]"
                    >
                        <p class="text-center">What we do?</p>
                    </div>

                    <div class="mt-6 grid grid-cols-12 gap-3">
                        <div
                            class="col-span-12 grid place-items-center rounded-xl bg-medium-brown p-6 text-center text-xl font-semibold sm:col-span-4"
                        >
                            10 Agarwood Seedlings
                        </div>
                        <div
                            class="col-span-12 grid place-items-center rounded-xl bg-medium-brown p-6 text-center text-xl font-semibold sm:col-span-4"
                        >
                            Planted & Cared for <br />
                            at our Farm
                        </div>
                        <div
                            class="col-span-12 grid place-items-center rounded-xl bg-medium-brown p-6 text-center text-xl font-semibold sm:col-span-4"
                        >
                            5 years of Maintenance
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
@media only screen and (max-width: 472px) {
    .banner-text {
        height: 400px !important;
    }
}
@media only screen and (max-width: 392px) {
    .banner-text {
        height: 450px !important;
    }
}
@media only screen and (max-width: 334px) {
    .banner-text {
        height: 500px !important;
    }
}

@media only screen and (max-width: 816px) {
    .what-we {
        height: 150px !important;
    }
}

@media only screen and (max-width: 639px) {
    .what-we {
        height: 290px !important;
    }
}
@media only screen and (max-width: 360px) {
    .what-we {
        height: 312px !important;
    }
}
@media only screen and (max-width: 356px) {
    .what-we {
        height: 335px !important;
    }
}

@media only screen and (max-width: 322px) {
    .what-we {
        height: 365px !important;
    }
}
</style>
