<script setup lang="ts">
import { ref, watch } from 'vue';

// modal
const showModal = ref(false);

// Watch the modal state to toggle body scroll
watch(showModal, (val) => {
    document.body.style.overflow = val ? 'hidden' : 'auto';
});
</script>
<template>
    <div id="Purpose" class="scroll-mt-18 px-5 py-10 lg:scroll-mt-14">
        <div class="mx-auto w-full max-w-[1200px]">
            <div class="w-full py-2 text-center">
                <h1 class="text-4xl font-bold text-medium-brown">Purpose & Objectives</h1>
            </div>

            <div class="mt-3 w-full py-2 md:mt-8">
                <div class="flex items-center gap-10">
                    <div class="hidden md:block">
                        <img src="images/pur.png" class="w-[500px]" alt="Purpose" />
                    </div>
                    <div class="text-xl text-medium-brown">
                        <p>
                            This project will serve as a testing the practicality and outcomes of ten seedlings under controlled, monitored
                            conditions. Initial efforts allow both the partners and farmers to gain insight into the specific requirements,
                            challenges, and opportunities of agarwood production.
                        </p>

                        <div class="pt-8 text-end">
                            <button @click="showModal = true" class="hover:bg-opacity-90 bg-medium-brown px-10 py-2 text-2xl text-white transition">
                                Read more
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div
        v-if="showModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-2 backdrop-blur-sm"
        @click.self="showModal = false"
    >
        <div class="relative flex max-h-[90dvh] w-full max-w-2xl flex-col rounded-lg bg-white shadow-2xl">
            <div class="border-b border-gray-100 p-6">
                <h2 class="text-3xl font-bold text-medium-brown">Purpose & Objectives</h2>
                <button @click="showModal = false" class="absolute top-4 right-4 text-2xl font-bold text-gray-500 hover:text-black">&times;</button>
            </div>

            <div class="space-y-4 overflow-y-auto p-6 text-lg leading-relaxed text-gray-700">
                <p>
                    This project will serve as a testing the practicality and outcomes of ten seedlings under controlled, monitored conditions.
                    Initial efforts allow both the partners and farmers to gain insight into the specific requirements, challenges, and opportunities
                    of agarwood production.
                </p>
                <p>
                    A critical objective of the project is to evaluate the viability of scaling agarwood farming through structured partnerships
                    between capital providers and on-ground cultivators. By monitoring performance, cost efficiency, and mutual accountability.
                    Helping to determine whether this model can be replicated of a broader scale.
                </p>

                <p>
                    In order to support sustainable, long-term agricultural investments in high-value crops such as agarwood. The cultivation aligns
                    with climate-smart agriculture principles, encouraging reforestation, carbon sequestration, and biodiversity, while tapping into
                    lucrative niche markets.
                </p>

                <p>
                    The project seeks to assess the readiness and capability of the Farmer(s) to manage a premium agroforestry crop that demands
                    long-term care, attention to detail, and adherence to scientific cultivation protocols. Farmer(s) will be evaluated on their
                    ability to uphold professional standards in plant care, documentation, and progress reporting, serving as a benchmark for future
                    agarwood expansion initiatives.
                </p>
            </div>

            <div class="border-t border-gray-100 p-4 text-end">
                <button @click="showModal = false" class="hover:bg-opacity-90 rounded bg-medium-brown px-8 py-2 font-semibold text-white transition">
                    Close
                </button>
            </div>
        </div>
    </div>
</template>
