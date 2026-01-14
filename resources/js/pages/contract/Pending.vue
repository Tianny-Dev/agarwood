<script setup lang="ts">
import Layout from '@/layouts/AppLayout.vue';
import axios from 'axios';

defineOptions({ layout: Layout });

const props = defineProps<{
    contract?: { id: number; contract_number: string; status: string };
}>();

const isLoading = ref(false);

const payContract = async () => {
    if (!props.contract?.id) return;

    isLoading.value = true;

    try {
        const response = await axios.post(`/contract/${props.contract.id}/pay`);

        if (response.data.checkout_url) {
            window.location.href = response.data.checkout_url;
        } else {
            alert('Failed to generate checkout URL');
        }
    } catch (err) {
        console.error(err);
        alert('Error processing payment');
    } finally {
        isLoading.value = false;
    }
};
</script>

<template>
    <UDashboardPanel id="home">
        <template #header>
            <UDashboardNavbar title="Home" :ui="{ right: 'gap-3' }">
                <template #leading>
                    <UDashboardSidebarCollapse as="button" :disabled="false" />
                </template>
            </UDashboardNavbar>
        </template>

        <template #body>
            <div class="pointer-events-none space-y-6 select-none" style="filter: blur(6px) brightness(0.6)">
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <USkeleton class="h-32 w-full" v-for="i in 4" :key="i" />
                </div>

                <div class="space-y-4">
                    <USkeleton class="h-8 w-48" />
                    <USkeleton class="h-80 w-full" />
                </div>

                <div class="space-y-4">
                    <USkeleton class="h-8 w-48" />
                    <div class="space-y-3">
                        <USkeleton class="h-16 w-full" v-for="i in 5" :key="i" />
                    </div>
                </div>
            </div>

            <!-- Overlay -->
            <div class="absolute inset-0 flex items-center justify-center px-4 text-center">
                <div class="z-10 w-full max-w-lg rounded-xl bg-white p-10 shadow-xl dark:bg-gray-900">
                    <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full bg-red-100">
                        <img src="/images/logo.png" alt="Locked" class="h-10 w-10 text-red-600" />
                    </div>

                    <h1 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">Contract Pending</h1>
                    <p class="mb-6 text-gray-600 dark:text-gray-300">You cannot access the dashboard until your contract payment is approved.</p>

                    <button
                        type="button"
                        @click="payContract"
                        :disabled="isLoading"
                        class="text-primary-foreground mb-2 inline-flex w-full items-center justify-center rounded-lg bg-primary px-6 py-3 font-semibold transition hover:bg-primary/90 focus:ring-2 focus:ring-primary/50 focus:ring-offset-2 focus:outline-none"
                    >
                        Pay Now
                    </button>

                    <p class="text-muted-foreground text-sm">
                        If you believe this is an error, <a href="mailto:support@example.com" class="text-primary underline">contact support</a>.
                    </p>
                </div>
            </div>
        </template>
    </UDashboardPanel>
</template>
