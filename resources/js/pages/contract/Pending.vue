<script setup lang="ts">
import ContractGateLayout from '@/layouts/ContractGateLayout.vue';
import type { DropdownMenuItem } from '@nuxt/ui';

// Example dropdown items (for skeleton dashboard)
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
    <ContractGateLayout
        title="Contract Pending"
        subtitle="You cannot access the dashboard until your contract payment is approved."
        cta-label="Pay Now"
        cta-href="/contract/pay"
    >
        <!-- Dashboard content rendered behind blur -->
        <UDashboardPanel id="home">
            <template #header>
                <UDashboardNavbar title="Home" :ui="{ right: 'gap-3' }">
                    <template #leading>
                        <UDashboardSidebarCollapse as="button" :disabled="true" />
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
                    <!-- Top cards -->
                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        <USkeleton class="h-32 w-full" v-for="i in 4" :key="i" />
                    </div>

                    <!-- Large panel -->
                    <div class="space-y-4">
                        <USkeleton class="h-8 w-48" />
                        <USkeleton class="h-80 w-full" />
                    </div>

                    <!-- List panels -->
                    <div class="space-y-4">
                        <USkeleton class="h-8 w-48" />
                        <div class="space-y-3">
                            <USkeleton class="h-16 w-full" v-for="i in 5" :key="i" />
                        </div>
                    </div>
                </div>
            </template>
        </UDashboardPanel>
    </ContractGateLayout>
</template>
