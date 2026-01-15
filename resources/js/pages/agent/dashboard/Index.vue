<script setup lang="ts">
import Layout from '@/layouts/AppLayout.vue';
import type { DropdownMenuItem } from '@nuxt/ui';

defineOptions({ layout: Layout });

const items = [
    [
        {
            label: 'New mail',
            icon: 'i-lucide-send',
            to: '/inbox',
        },
        {
            label: 'New customer',
            icon: 'i-lucide-user-plus',
            to: '/customers',
        },
    ],
] satisfies DropdownMenuItem[][];
</script>

<template>
    <UDashboardPanel id="home">
        <template #header>
            <UDashboardNavbar title="Home" :ui="{ right: 'gap-3' }">
                <template #leading>
                    <UDashboardSidebarCollapse as="button" :disabled="false" />
                </template>

                <template #right>
                    <UDropdownMenu :items="items">
                        <UButton icon="i-lucide-plus" size="md" class="rounded-full" />
                    </UDropdownMenu>
                </template>
            </UDashboardNavbar>
        </template>

        <template #body>
            <div class="space-y-6">
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
        </template>
    </UDashboardPanel>
</template>
