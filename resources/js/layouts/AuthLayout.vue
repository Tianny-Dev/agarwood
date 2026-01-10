<script setup lang="ts">
import ApplicationLogo from '@/components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div
        class="relative flex min-h-screen items-center justify-center bg-linear-to-br from-gray-50 to-gray-100 px-4 py-12 dark:from-gray-900 dark:to-gray-950"
    >
        <!-- Background -->
        <div class="pointer-events-none absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 h-80 w-80 rounded-full bg-primary-200/30 blur-3xl dark:bg-primary-800/20"></div>
            <div class="absolute -bottom-40 -left-40 h-80 w-80 rounded-full bg-blue-200/30 blur-3xl dark:bg-blue-800/20"></div>
        </div>

        <div class="relative w-full max-w-4xl">
            <!-- Logo -->
            <div class="mb-2 text-center">
                <div class="inline-flex items-center justify-center">
                    <Link href="/">
                        <ApplicationLogo class="h-20 w-auto" />
                    </Link>
                </div>
            </div>

            <!-- Card -->
            <UCard
                :ui="{
                    base: 'overflow-hidden',
                    background: 'bg-white dark:bg-gray-900',
                    ring: 'ring-1 ring-gray-200 dark:ring-gray-800',
                    shadow: 'shadow-xl',
                }"
            >
                <slot />
            </UCard>

            <!-- Footer -->
            <div class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400">
                <p>© {{ new Date().getFullYear() }} Agarwood. All rights reserved.</p>
            </div>
        </div>
    </div>
</template>
