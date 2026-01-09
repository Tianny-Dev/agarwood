<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { logout } from '@/routes';
import { Head } from '@inertiajs/vue3';

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
                    <TextLink :href="logout()" as="button" class="mx-auto block text-sm font-medium text-primary"> Log out </TextLink>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
