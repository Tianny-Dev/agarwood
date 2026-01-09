<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, router } from '@inertiajs/vue3';

const handleLogout = () => {
    router.flushAll();
};
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        Protected Routes here
                    </div>
                    <button
                        @click="handleLogout()"
                        class="inline-block w-full bg-amber-950 text-white font-medium py-2 px-4 rounded hover:bg-amber-900 transition cursor-pointer"
                    >
                        Logout
                    </button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
