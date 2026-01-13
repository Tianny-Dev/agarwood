<script setup lang="ts">
import axios from 'axios';
// Props for layout
const props = defineProps<{
    title?: string;
    subtitle?: string;
    ctaLabel?: string;
    contract?: { id: number };
}>();

const title = props.title ?? 'Dashboard Access Blocked';
const subtitle = props.subtitle ?? 'Your dashboard is temporarily locked until your contract is approved.';
const ctaLabel = props.ctaLabel ?? 'Pay Pending Contract';

const isLoading = ref(false);

const payContract = async () => {
    if (!props.contract?.id) return;

    isLoading.value = true;

    try {
        // 1. Call your Laravel endpoint to create PayMongo session
        const response = await axios.post(`/contract/${props.contract.id}/pay`);

        // 2. Redirect browser to PayMongo checkout page
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
    <UDashboardPanel class="relative">
        <!-- Blurred content -->
        <div class="pointer-events-none select-none" style="filter: blur(6px) brightness(0.6)">
            <slot />
        </div>

        <!-- Overlay -->
        <div class="absolute inset-0 flex items-center justify-center px-4 text-center">
            <div class="z-10 w-full max-w-lg rounded-xl bg-white p-10 shadow-xl dark:bg-gray-900">
                <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full bg-red-100">
                    <img src="/images/logo.png" alt="Locked" class="h-10 w-10 text-red-600" />
                </div>

                <h1 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">{{ title }}</h1>
                <p class="mb-6 text-gray-600 dark:text-gray-300">{{ subtitle }}</p>

                <button
                    type="button"
                    @click="payContract"
                    :disabled="isLoading"
                    class="text-primary-foreground mb-2 inline-flex w-full items-center justify-center rounded-lg bg-primary px-6 py-3 font-semibold transition hover:bg-primary/90 focus:ring-2 focus:ring-primary/50 focus:ring-offset-2 focus:outline-none"
                >
                    {{ ctaLabel }}
                </button>

                <p class="text-muted-foreground text-sm">
                    If you believe this is an error, <a href="mailto:support@example.com" class="text-primary underline">contact support</a>.
                </p>
            </div>
        </div>
    </UDashboardPanel>
</template>
