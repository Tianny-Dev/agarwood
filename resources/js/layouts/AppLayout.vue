<script setup lang="ts">
import type { AppPageProps } from '@/types';
import { usePage } from '@inertiajs/vue3';
import type { CommandPaletteGroup, CommandPaletteItem, NavigationMenuItem } from '@nuxt/ui';

const toast = useToast();
const open = ref(false);

// Get user roles
const page = usePage<AppPageProps>();
const roles = page.props.auth?.roles ?? [];

const rolePriority = ['super_admin', 'agent', 'farmer', 'investor', 'partner'];
const userRole = rolePriority.find((r) => roles.includes(r)) || 'guest';

// Sidebar config per role

type SidebarConfigItem = {
    label: string;
    icon: string;
    to: string;
};

const sidebarConfig: Record<string, SidebarConfigItem[]> = {
    super_admin: [
        { label: 'Dashboard', icon: 'i-lucide-house', to: '/admin/dashboard' },
        { label: 'Agents', icon: 'i-lucide-users', to: '/admin/agents' },
        { label: 'Farmers', icon: 'i-lucide-leaf', to: '/admin/farmers' },
        { label: 'Investors', icon: 'i-lucide-banknote', to: '/admin/investors' },
    ],
    agent: [
        { label: 'Dashboard', icon: 'i-lucide-house', to: '/agent/dashboard' },
        { label: 'Farmers', icon: 'i-lucide-leaf', to: '/agent/farmers' },
        { label: 'Investors', icon: 'i-lucide-banknote', to: '/agent/investors' },
    ],
    farmer: [
        { label: 'Dashboard', icon: 'i-lucide-house', to: '/farmer/dashboard' },
        { label: 'Agents', icon: 'i-lucide-users', to: '/farmer/agents' },
        { label: 'My Investments', icon: 'i-lucide-banknote', to: '/farmer/investments' },
        { label: 'Contracts', icon: 'i-lucide-receipt', to: '/farmer/contracts' },
    ],
    investor: [
        { label: 'Dashboard', icon: 'i-lucide-house', to: '/investor/dashboard' },
        { label: 'Investments', icon: 'i-lucide-banknote', to: '/investor/investments' },
        { label: 'Contracts', icon: 'i-lucide-receipt', to: '/investor/contracts' },
        { label: 'GPS Monitoring', icon: 'i-lucide-map', to: '/investor/gps' },
    ],
    partner: [
        { label: 'Dashboard', icon: 'i-lucide-house', to: '/partner/dashboard' },
        { label: 'Revenue', icon: 'i-lucide-dollar-sign', to: '/partner/revenue' },
        { label: 'Expenses', icon: 'i-lucide-banknote-arrow-down', to: '/partner/expenses' },
    ],
    guest: [],
};

// Links for NavigationMenu
const links = computed<NavigationMenuItem[][]>(() => [
    (sidebarConfig[userRole] || []).map((item) => ({
        label: item.label,
        icon: item.icon,
        to: item.to,
        onSelect: () => {
            open.value = false;
        },
    })),
]);

// Groups for UDashboardSearch
const groups = computed<CommandPaletteGroup<CommandPaletteItem>[]>(() => [
    {
        id: 'links',
        label: 'Go to',
        items: (sidebarConfig[userRole] || []).map((item) => ({
            id: item.to,
            label: item.label,
            icon: item.icon,
            to: item.to,
        })),
    },
]);

// Cookie consent

const cookie = useStorage('cookie-consent', 'pending');
if (cookie.value !== 'accepted' && cookie.value !== 'opt') {
    toast.add({
        title: 'We use first-party cookies to enhance your experience on our website.',
        duration: 0,
        close: false,
        actions: [
            {
                label: 'Accept',
                color: 'neutral',
                variant: 'outline',
                onClick: () => {
                    cookie.value = 'accepted';
                },
            },
            {
                label: 'Opt out',
                color: 'neutral',
                variant: 'ghost',
                onClick: () => {
                    cookie.value = 'opt';
                },
            },
        ],
    });
}
</script>

<template>
    <Suspense>
        <UApp>
            <UDashboardGroup unit="rem" storage="local">
                <UDashboardSidebar
                    id="default"
                    v-model:open="open"
                    collapsible
                    resizable
                    class="bg-elevated/25"
                    :ui="{ footer: 'lg:border-t lg:border-default' }"
                >
                    <!-- Header -->
                    <template #header="{ collapsed }">
                        <div class="flex items-center gap-3 px-3 py-2">
                            <img v-if="!collapsed" src="/images/logo.png" alt="Logo" class="h-8 w-auto" />
                            <img v-else src="/images/logo.png" alt="Logo" class="h-8 w-8" />
                        </div>
                    </template>

                    <!-- Sidebar -->
                    <template #default="{ collapsed }">
                        <UDashboardSearchButton :collapsed="collapsed" class="bg-transparent ring-default" />

                        <UNavigationMenu :collapsed="collapsed" :items="links[0]" orientation="vertical" tooltip popover />
                    </template>

                    <!-- Footer -->
                    <template #footer="{ collapsed }">
                        <UserMenu :collapsed="collapsed" />
                    </template>
                </UDashboardSidebar>

                <!-- Global search -->
                <UDashboardSearch :groups="groups" />

                <!-- Page content -->
                <slot />

                <!-- Notifications -->
                <NotificationsSlideover />
            </UDashboardGroup>
        </UApp>
    </Suspense>
</template>
