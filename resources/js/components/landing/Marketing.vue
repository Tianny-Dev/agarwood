<script setup lang="ts">
import { ref, watch } from 'vue';

// Use an object to track multiple modals by name/key
const modals = ref<Record<string, boolean>>({
    globalDemand: false,
    harvestCycle: false,
    futurePotential: false,
});

// Function to toggle modal
const toggleModal = (key: string, state: boolean) => {
    modals.value[key] = state;
};

// Function to limit text
const limitText = (text: string, limit: number) => {
    return text.length > limit ? text.substring(0, limit) + '...' : text;
};

// Watcher to lock body scroll if ANY modal is open
watch(
    modals,
    (current) => {
        const isAnyOpen = Object.values(current).some((val) => val === true);
        document.body.style.overflow = isAnyOpen ? 'hidden' : 'auto';
    },
    { deep: true },
);
</script>

<template>
    <div id="Marketing" class="marketing-bg scroll-mt-18 bg-cover bg-center bg-no-repeat px-5 py-10 lg:scroll-mt-14">
        <div class="mx-auto w-full max-w-[1200px]">
            <div class="flex w-full items-center gap-5 py-2">
                <h1 class="mx-auto text-3xl font-bold text-white sm:text-4xl sm:whitespace-nowrap">Marketing Potential</h1>
                <div class="hidden h-1 w-full bg-white sm:block"></div>
            </div>

            <div class="mt-5 w-full py-2 sm:mt-8">
                <div class="grid grid-cols-12 gap-5 xl:gap-10">
                    <div class="col-span-3 hidden xl:block">
                        <div class="grid h-full w-full place-items-center">
                            <img src="images/icon.png" class="w-full" alt="Purpose" />
                        </div>
                    </div>
                    <div class="col-span-12 grid rounded-2xl bg-white p-4 text-medium-brown md:col-span-4 xl:col-span-3">
                        <div>
                            <p class="text-lg font-bold">Global Demand:</p>
                            <p class="text-md pt-3">
                                {{
                                    limitText(
                                        'Agarwood known for its aromatic resin which is used in production of high-end perfumes, incense, and herbal medicine. Known as “oud” the resin is derived from Aquilaria trees after a natural or artificial...',
                                        200,
                                    )
                                }}
                            </p>
                        </div>
                        <div class="pt-4 text-center">
                            <button
                                @click="toggleModal('globalDemand', true)"
                                class="w-[90%] bg-medium-brown py-2 text-2xl text-white transition hover:bg-dark-brown"
                            >
                                Read more
                            </button>
                        </div>
                    </div>

                    <div class="col-span-12 grid rounded-2xl bg-white p-4 text-medium-brown md:col-span-4 xl:col-span-3">
                        <div>
                            <p class="text-lg font-bold">Harvest Cycle:</p>
                            <p class="text-md pt-3">
                                {{
                                    limitText(
                                        'Production cycle spans approximately 8 to 10 years, beginning with seedling cultivation and culminating in the resin harvest. The first five years are typically focused on nurturing the trees to a healthy, mature state...',
                                        200,
                                    )
                                }}
                            </p>
                        </div>
                        <div class="pt-4 text-center">
                            <button
                                @click="toggleModal('harvestCycle', true)"
                                class="w-[90%] bg-medium-brown py-2 text-2xl text-white transition hover:bg-dark-brown"
                            >
                                Read more
                            </button>
                        </div>
                    </div>

                    <div class="col-span-12 grid rounded-2xl bg-white p-4 text-medium-brown md:col-span-4 xl:col-span-3">
                        <div>
                            <p class="text-lg font-bold">Future Potential:</p>
                            <p class="text-md pt-3">
                                {{
                                    limitText(
                                        'The optimal age for inoculation is around 6 years. Inoculation, the process of artificially triggering resin production, both the Partner(s) and the Farmer(s) may opt to renegotiate their agreement, entering into a new...',
                                        200,
                                    )
                                }}
                            </p>
                        </div>
                        <div class="pt-4 text-center">
                            <button
                                @click="toggleModal('futurePotential', true)"
                                class="w-[90%] bg-medium-brown py-2 text-2xl text-white transition hover:bg-dark-brown"
                            >
                                Read more
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div
        v-if="modals.globalDemand"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-2 backdrop-blur-sm"
        @click.self="toggleModal('globalDemand', false)"
    >
        <div class="relative flex max-h-[90dvh] w-full max-w-2xl flex-col rounded-lg bg-white shadow-2xl">
            <div class="border-b border-gray-100 p-6">
                <h2 class="text-3xl font-bold text-medium-brown">Global Demand</h2>
                <button @click="toggleModal('globalDemand', false)" class="absolute top-4 right-4 text-2xl text-gray-500">&times;</button>
            </div>
            <div class="overflow-y-auto p-6 text-lg leading-relaxed text-gray-700">
                Agarwood known for its aromatic resin which is used in production of high-end perfumes, incense, and herbal medicine. Known as “oud”
                the resin is derived from Aquilaria trees after a natural or artificial inoculation process triggers the formation of a fragrant, dark
                resin in the heartwood. The global luxury market consistently demonstrated a strong demand for oud-based products. Due to
                overharvesting of agarwood leading to it being endangered, it has opened an opportunity for sustainable, cultivated sources of
                agarwood resin.
            </div>
            <div class="border-t border-gray-100 p-4 text-end">
                <button @click="toggleModal('globalDemand', false)" class="bg-medium-brown px-8 py-2 text-white">Close</button>
            </div>
        </div>
    </div>

    <div
        v-if="modals.harvestCycle"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-2 backdrop-blur-sm"
        @click.self="toggleModal('harvestCycle', false)"
    >
        <div class="relative flex max-h-[90dvh] w-full max-w-2xl flex-col rounded-lg bg-white shadow-2xl">
            <div class="border-b border-gray-100 p-6">
                <h2 class="text-3xl font-bold text-medium-brown">Harvest Cycle</h2>
                <button @click="toggleModal('harvestCycle', false)" class="absolute top-4 right-4 text-2xl text-gray-500">&times;</button>
            </div>
            <div class="overflow-y-auto p-6 text-lg text-gray-700">
                Production cycle spans approximately 8 to 10 years, beginning with seedling cultivation and culminating in the resin harvest. The
                first five years are typically focused on nurturing the trees to a healthy, mature state, which is crucial for ensuring successful
                inoculation later. This partnership specifically focuses on the early stage; the partnership significantly reduces upfront costs and
                technical risks for both parties while laying the groundwork for future profitability.
            </div>
            <div class="border-t border-gray-100 p-4 text-end">
                <button @click="toggleModal('harvestCycle', false)" class="bg-medium-brown px-8 py-2 text-white">Close</button>
            </div>
        </div>
    </div>

    <div
        v-if="modals.futurePotential"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-2 backdrop-blur-sm"
        @click.self="toggleModal('futurePotential', false)"
    >
        <div class="relative flex max-h-[90dvh] w-full max-w-2xl flex-col rounded-lg bg-white shadow-2xl">
            <div class="border-b border-gray-100 p-6">
                <h2 class="text-3xl font-bold text-medium-brown">Future Potential</h2>
                <button @click="toggleModal('futurePotential', false)" class="absolute top-4 right-4 text-2xl text-gray-500">&times;</button>
            </div>
            <div class="overflow-y-auto p-6 text-lg text-gray-700">
                The optimal age for inoculation is around 6 years. Inoculation, the process of artificially triggering resin production, both the
                Partner(s) and the Farmer(s) may opt to renegotiate their agreement, entering into a new phase of partnership that focuses on value
                generation from resin extraction.
            </div>
            <div class="border-t border-gray-100 p-4 text-end">
                <button @click="toggleModal('futurePotential', false)" class="bg-medium-brown px-8 py-2 text-white">Close</button>
            </div>
        </div>
    </div>
</template>

<style scoped>
.marketing-bg {
    background-image: url('/images/mar.jpg');
}
</style>
