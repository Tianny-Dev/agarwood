<script setup lang="ts">
import Layout from '@/layouts/AppLayout.vue';

defineOptions({ layout: Layout });
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
                    <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full bg-yellow-100">
                        <img src="/images/logo.png" alt="Pending Verification" class="h-10 w-10" />
                    </div>

                    <h1 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">Account Pending Verification</h1>

                    <p class="mb-6 text-gray-600 dark:text-gray-300">
                        Your agent account has been created but is currently under review. Please wait for an administrator to verify your account
                        before accessing the dashboard.
                    </p>

                    <div class="rounded-lg bg-gray-100 p-4 text-sm text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                        ⏳ Verification usually takes 24–48 hours.
                    </div>

                    <p class="mt-6 text-sm text-gray-500 dark:text-gray-400">
                        If you believe this is a mistake, please
                        <a href="mailto:support@example.com" class="text-primary underline"> contact support </a>.
                    </p>
                </div>
            </div>
        </template>
    </UDashboardPanel>
</template>
