<script setup lang="ts">
import type { NavigationMenuItem } from '@nuxt/ui';

const links = [
    [
        {
            label: 'Profile',
            icon: 'i-lucide-user',
            to: '/settings/profile',
            exact: true,
        },
        {
            label: 'Security',
            icon: 'i-lucide-shield',
            to: '/settings/security',
        },
    ],
] satisfies NavigationMenuItem[][];
</script>

<template>
    <UDashboardPanel id="settings" :ui="{ body: 'lg:py-12' }">
        <template #header>
            <UDashboardNavbar title="Settings">
                <template #leading>
                    <UDashboardSidebarCollapse as="button" :disabled="false" />
                </template>
            </UDashboardNavbar>

            <UDashboardToolbar>
                <UNavigationMenu :items="links" highlight class="-mx-1 flex-1" />
            </UDashboardToolbar>
        </template>

        <template #body>
            <div class="mx-auto flex w-full flex-col gap-4 sm:gap-6 lg:max-w-2xl lg:gap-12">
                <slot />
            </div>
        </template>
    </UDashboardPanel>
</template>
