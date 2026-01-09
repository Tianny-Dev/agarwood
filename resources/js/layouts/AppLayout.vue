<script setup lang="ts">
import type { NavigationMenuItem } from '@nuxt/ui';

const toast = useToast();

const open = ref(false);

const links = [
    [
        {
            label: 'Dashboard',
            icon: 'i-lucide-house',
            to: '/dashboard',
            onSelect: () => {
                open.value = false;
            },
        },
    ],
] satisfies NavigationMenuItem[][];

const groups = computed(() => [
    {
        id: 'links',
        label: 'Go to',
        items: links.flat(),
    },
]);

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
                    <template #header="{ collapsed }">
                        <div class="flex items-center gap-3 px-3 py-2">
                            <img v-if="!collapsed" src="/images/logo.png" alt="Logo" class="h-8 w-auto" />
                            <img v-else src="/images/logo.png" alt="Logo" class="h-8 w-8" />
                        </div>
                    </template>

                    <template #default="{ collapsed }">
                        <UDashboardSearchButton :collapsed="collapsed" class="bg-transparent ring-default" />

                        <UNavigationMenu :collapsed="collapsed" :items="links[0]" orientation="vertical" tooltip popover />

                        <UNavigationMenu :collapsed="collapsed" :items="links[1]" orientation="vertical" tooltip class="mt-auto" />
                    </template>

                    <template #footer="{ collapsed }">
                        <UserMenu :collapsed="collapsed" />
                    </template>
                </UDashboardSidebar>

                <UDashboardSearch :groups="groups" />

                <slot />

                <NotificationsSlideover />
            </UDashboardGroup>
        </UApp>
    </Suspense>
</template>
