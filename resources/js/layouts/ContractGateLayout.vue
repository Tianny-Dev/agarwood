<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

const props = defineProps<{
    title?: string;
    subtitle?: string;
    ctaLabel?: string;
    ctaHref?: string;
}>();

// Default values
const title = props.title ?? 'Dashboard Access Blocked';
const subtitle =
    props.subtitle ?? 'Your dashboard is temporarily locked because your contract payment is pending. Once approved, full access will be restored.';
const ctaLabel = props.ctaLabel ?? 'Pay Pending Contract';
const ctaHref = props.ctaHref ?? '/contract/pay';
</script>

<template>
    <UDashboardPanel class="relative">
        <!-- Blurred dashboard content -->
        <div class="pointer-events-none select-none" style="filter: blur(6px) brightness(0.6)">
            <slot />
        </div>

        <!-- Overlay notice -->
        <div class="absolute inset-0 flex items-center justify-center px-4 text-center">
            <div class="z-10 w-full max-w-lg rounded-xl bg-white p-10 shadow-xl dark:bg-gray-900">
                <!-- Lock Icon -->
                <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full bg-red-100">
                    <img src="/images/logo.png" alt="Locked" class="h-10 w-10 text-red-600" />
                </div>

                <!-- Title -->
                <h1 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">
                    {{ title }}
                </h1>

                <!-- Subtitle -->
                <p class="mb-6 text-gray-600 dark:text-gray-300">
                    {{ subtitle }}
                </p>

                <!-- CTA Button -->
                <Link
                    :href="ctaHref"
                    as="button"
                    class="text-primary-foreground mb-2 inline-flex w-full items-center justify-center rounded-lg bg-primary px-6 py-3 font-semibold transition hover:bg-primary/90 focus:ring-2 focus:ring-primary/50 focus:ring-offset-2 focus:outline-none"
                >
                    {{ ctaLabel }}
                </Link>

                <!-- Optional Info -->
                <p class="text-muted-foreground text-sm">
                    If you believe this is an error, <a href="mailto:support@example.com" class="text-primary underline">contact support</a>.
                </p>
            </div>
        </div>
    </UDashboardPanel>
</template>
