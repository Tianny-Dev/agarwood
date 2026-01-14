<script setup lang="ts">
import { ref, watch } from 'vue';

// Use an object to track multiple modals by name/key
const modals = ref<Record<string, boolean>>({
    Well: false,
    Warm: false,
    Regular: false,
    Knowledge: false,
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
    <div id="Technical" class="scroll-mt-18 px-5 py-10 lg:scroll-mt-14">
        <div class="mx-auto w-full max-w-[1200px]">
            <div class="w-full py-2 text-center">
                <h1 class="text-4xl font-bold text-medium-brown">Technical Feasibility</h1>
            </div>

            <div class="mx-auto w-full max-w-[1200px]">
                <div class="mt-8 w-full sm:mt-16 md:mt-22">
                    <div class="grid grid-cols-12 sm:gap-10">
                        <div
                            class="relative col-span-12 mb-15 grid rounded-2xl bg-light-brown p-4 text-medium-brown md:col-span-6 xl:col-span-4 xl:mb-0"
                        >
                            <div
                                class="absolute top-[-35px] left-1/2 hidden w-full -translate-x-1/2 rounded-full bg-medium-brown py-4 text-center text-white shadow-md sm:block md:top-[-67px] md:w-[106%]"
                            >
                                <p class="text-2xl leading-tight font-bold">
                                    Well-Drained Soil and <br class="hidden md:block" />
                                    Partial Shade:
                                </p>
                            </div>

                            <div class="block bg-medium-brown px-3 py-4 text-center text-white shadow-md sm:hidden">
                                <p class="text-2xl leading-tight font-bold">Well-Drained Soil and Partial Shade:</p>
                            </div>

                            <div class="py-3">
                                <p class="text-md pt-3">
                                    {{
                                        limitText(
                                            'The species of “Aquilaria” thrive best in well-drained soils, that prevents waterlogging, which damages the root system that may lead to fungal infections. Moisture is another key factor in maintaining “Aquilaria”, moderately fertile and loamy soil. Additionally, they benefit from partial shade in their early years. In community farming settings...',
                                            350,
                                        )
                                    }}
                                </p>
                            </div>
                            <div class="py-2">
                                <button
                                    @click="toggleModal('Well', true)"
                                    class="absolute start-0 end-0 mx-auto w-fit bg-medium-brown px-10 py-2 text-2xl text-white transition hover:bg-dark-brown"
                                >
                                    Read more
                                </button>
                            </div>
                        </div>

                        <div
                            class="relative col-span-12 mb-15 grid rounded-2xl bg-light-brown p-4 text-medium-brown md:col-span-6 xl:col-span-4 xl:mb-0"
                        >
                            <div
                                class="absolute top-[-35px] left-1/2 hidden w-full -translate-x-1/2 rounded-full bg-medium-brown py-4 text-center text-white shadow-md sm:block md:top-[-67px] md:w-[106%]"
                            >
                                <p class="text-2xl leading-tight font-bold">
                                    Warm Temperatures and <br class="hidden md:block" />
                                    Minimal Early Intervention:
                                </p>
                            </div>

                            <div class="block bg-medium-brown px-3 py-4 text-center text-white shadow-md sm:hidden">
                                <p class="text-2xl leading-tight font-bold">Warm Temperatures and Minimal Early Intervention:</p>
                            </div>

                            <div class="py-3">
                                <p class="text-md pt-3">
                                    {{
                                        limitText(
                                            'Agarwood thrives in warm, humid tropical climates, making countries like the Philippines, Indonesia, and Thailand ideal for its cultivation. They also perform well with regular rainfall but must be protected from extreme flooding or prolonged droughts. One of the advantages of cultivating agarwood is that it requires minimal intervention during the first few years. The trees grow with limited interference. This makes it suitable for integration...',
                                            350,
                                        )
                                    }}
                                </p>
                            </div>
                            <div class="py-2">
                                <button
                                    @click="toggleModal('Warm', true)"
                                    class="absolute start-0 end-0 mx-auto w-fit bg-medium-brown px-10 py-2 text-2xl text-white transition hover:bg-dark-brown"
                                >
                                    Read more
                                </button>
                            </div>
                        </div>

                        <div class="relative col-span-12 grid rounded-2xl bg-light-brown p-4 text-medium-brown xl:col-span-4">
                            <div
                                class="absolute top-[-35px] left-1/2 hidden w-[100%] -translate-x-1/2 rounded-full bg-medium-brown py-4 text-center text-white shadow-md sm:block xl:top-[-67px] xl:w-[106%]"
                            >
                                <p class="text-2xl leading-tight font-bold">
                                    Regular Monitoring, Watering, <br class="hidden xl:block" />
                                    and Fertilization:
                                </p>
                            </div>

                            <div class="block bg-medium-brown px-3 py-4 text-center text-white shadow-md sm:hidden">
                                <p class="text-2xl leading-tight font-bold">Regular Monitoring, Watering, and Fertilization:</p>
                            </div>

                            <div class="py-3">
                                <p class="text-md pt-4 xl:pt-3">
                                    {{
                                        limitText(
                                            "Watering schedules must be adjusted according to weather conditions, ensuring that the trees receive adequate moisture, particularly during dry spells. Proper fertilization, especially in the first three years, helps strengthen the tree's root structure and biomass, ensuring it reaches the right size and health for eventual inoculation...",
                                            350,
                                        )
                                    }}
                                </p>
                            </div>
                            <div class="py-2">
                                <button
                                    @click="toggleModal('Regular', true)"
                                    class="absolute start-0 end-0 mx-auto w-fit bg-medium-brown px-10 py-2 text-2xl text-white transition hover:bg-dark-brown"
                                >
                                    Read more
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative mt-16 mb-8 grid w-full rounded-2xl bg-light-brown p-4 text-medium-brown sm:mt-24 sm:p-12">
                <div
                    class="absolute top-[-33px] left-1/2 hidden w-full -translate-x-1/2 rounded-full bg-medium-brown px-10 py-4 text-center text-white shadow-md sm:block xl:w-fit"
                >
                    <p class="text-2xl leading-tight font-bold whitespace-nowrap">Knowledge of Pest and Disease Management:</p>
                </div>

                <div class="mb-7 block bg-medium-brown px-3 py-4 text-center text-white shadow-md sm:hidden">
                    <p class="text-2xl leading-tight font-bold">Knowledge of Pest and Disease Management:</p>
                </div>

                <div>
                    <div class="text-md flex gap-3">
                        <p class="font-bold">Risks:</p>
                        <p>
                            Agarwood can face threats like fungal infections, leaf miners, stem borers, and root rot, especially in poorly maintained
                            farms.
                        </p>
                    </div>

                    <div class="text-md flex gap-3">
                        <p class="font-bold whitespace-nowrap">Early Signs:</p>
                        <p>Watch for discolored leaves, unusual leaf drop, or stunted growth.</p>
                    </div>
                    <div class="text-md">
                        <p class="font-bold">Prevention:</p>
                        <p class="ps-5">- Maintain clean farm sites</p>
                        <p class="ps-5">- Prune infected parts regularly</p>
                        <p class="ps-5">- Use organic repellents or beneficial insects</p>
                    </div>
                </div>

                <div class="pt-7 sm:pt-0">
                    <button
                        @click="toggleModal('Knowledge', true)"
                        class="absolute start-0 end-0 bottom-[-24px] mx-auto w-fit bg-medium-brown px-10 py-2 text-2xl text-white transition hover:bg-dark-brown"
                    >
                        Read more
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- models -->
    <div
        v-if="modals.Well"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-2 backdrop-blur-sm"
        @click.self="toggleModal('Well', false)"
    >
        <div class="relative flex max-h-[90dvh] w-full max-w-2xl flex-col rounded-lg bg-white shadow-2xl">
            <div class="border-b border-gray-100 p-6">
                <h2 class="text-3xl font-bold text-medium-brown">Well-Drained Soil and Partial Shade:</h2>
                <button @click="toggleModal('Well', false)" class="absolute top-4 right-4 text-2xl text-gray-500">&times;</button>
            </div>
            <div class="overflow-y-auto p-6 text-lg leading-relaxed text-gray-700">
                The species of “Aquilaria” thrive best in well drained soils, that prevents waterlogging, which damages the root system that may lead
                to fungal infections. Moisture is another key factor in maintaining “Aquilaria”, moderately fertile and loamy soil. Additionally, they
                benefit from partial shade in their early years. In community farming settings, intercropping with taller plants can offer natural
                protection while maximizing land productivity.
            </div>
            <div class="border-t border-gray-100 p-4 text-end">
                <button @click="toggleModal('Well', false)" class="bg-medium-brown px-8 py-2 text-white">Close</button>
            </div>
        </div>
    </div>

    <div
        v-if="modals.Warm"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-2 backdrop-blur-sm"
        @click.self="toggleModal('Warm', false)"
    >
        <div class="relative flex max-h-[90dvh] w-full max-w-2xl flex-col rounded-lg bg-white shadow-2xl">
            <div class="border-b border-gray-100 p-6">
                <h2 class="text-3xl font-bold text-medium-brown">Warm Temperatures and Minimal Early Intervention:</h2>
                <button @click="toggleModal('Warm', false)" class="absolute top-4 right-4 text-2xl text-gray-500">&times;</button>
            </div>
            <div class="overflow-y-auto p-6 text-lg leading-relaxed text-gray-700">
                Agarwood thrives in warm, humid tropical climates, making countries like the Philippines, Indonesia, and Thailand ideal for its
                cultivation. They also perform well with regular rainfall but must be protected from extreme flooding or prolonged droughts. One of
                the advantages of cultivating agarwood is that it requires minimal intervention during the first few years. The trees grow with
                limited interference. This makes it suitable for integration into diversified farming systems. However, it still needs regular
                monitoring.
            </div>
            <div class="border-t border-gray-100 p-4 text-end">
                <button @click="toggleModal('Warm', false)" class="bg-medium-brown px-8 py-2 text-white">Close</button>
            </div>
        </div>
    </div>

    <div
        v-if="modals.Regular"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-2 backdrop-blur-sm"
        @click.self="toggleModal('Regular', false)"
    >
        <div class="relative flex max-h-[90dvh] w-full max-w-2xl flex-col rounded-lg bg-white shadow-2xl">
            <div class="border-b border-gray-100 p-6">
                <h2 class="text-3xl font-bold text-medium-brown">Regular Monitoring, Watering, and Fertilization:</h2>
                <button @click="toggleModal('Regular', false)" class="absolute top-4 right-4 text-2xl text-gray-500">&times;</button>
            </div>
            <div class="overflow-y-auto p-6 text-lg leading-relaxed text-gray-700">
                Watering schedules must be adjusted according to weather conditions, ensuring that the trees receive adequate moisture, particularly
                during dry spells. Proper fertilization, especially in the first three years, helps strengthen the tree's root structure and biomass,
                ensuring it reaches the right size and health for eventual inoculation. Monitoring should include routine assessments of growth rate,
                leaf health, soil quality, and surrounding vegetation. Over-fertilization should be avoided, as excessive nutrients may encourage fast
                but weak growth, making the tree more susceptible to diseases.
            </div>
            <div class="border-t border-gray-100 p-4 text-end">
                <button @click="toggleModal('Regular', false)" class="bg-medium-brown px-8 py-2 text-white">Close</button>
            </div>
        </div>
    </div>

    <div
        v-if="modals.Knowledge"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-2 backdrop-blur-sm"
        @click.self="toggleModal('Knowledge', false)"
    >
        <div class="relative flex max-h-[90dvh] w-full max-w-2xl flex-col rounded-lg bg-white shadow-2xl">
            <div class="border-b border-gray-100 p-6">
                <h2 class="text-3xl font-bold text-medium-brown">Knowledge of Pest and Disease Management:</h2>
                <button @click="toggleModal('Knowledge', false)" class="absolute top-4 right-4 text-2xl text-gray-500">&times;</button>
            </div>
            <div class="text-md overflow-y-auto p-6 text-lg leading-relaxed text-gray-700">
                <p class="font-bold">Risks:</p>
                <p>
                    Agarwood can face threats like fungal infections, leaf miners, stem borers, and root rot, especially in poorly maintained farms.
                </p>

                <p class="pt-1 font-bold whitespace-nowrap">Early Signs:</p>
                <p>Watch for discolored leaves, unusual leaf drop, or stunted growth.</p>

                <div class="text-md pt-1">
                    <p class="font-bold">Prevention:</p>
                    <p class="ps-5">- Maintain clean farm sites</p>
                    <p class="ps-5">- Prune infected parts regularly</p>
                    <p class="ps-5">- Use organic repellents or beneficial insects</p>
                </div>

                <p class="pt-1 font-bold whitespace-nowrap">Management Approach:</p>
                <p>
                    Follow Integrated Pest Management (IPM), cultural, mechanical, and organic methods first, chemicals only if necessary and with
                    professional advice.
                </p>

                <p class="pt-1 font-bold whitespace-nowrap">Farmer Training:</p>
                <p>Provide manuals, training, and expert support to strengthen technical skills and reduce risks.</p>
                <p class="pt-1 font-bold">Requirement:</p>
                <p>Farms should confirm soil suitability and ensure labor availability for ongoing care.</p>
            </div>
            <div class="border-t border-gray-100 p-4 text-end">
                <button @click="toggleModal('Knowledge', false)" class="bg-medium-brown px-8 py-2 text-white">Close</button>
            </div>
        </div>
    </div>
</template>
