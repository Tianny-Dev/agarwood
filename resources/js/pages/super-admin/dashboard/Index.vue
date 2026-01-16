<script setup lang="ts">
import Layout from '@/layouts/AppLayout.vue';
import type { DropdownMenuItem } from '@nuxt/ui';

defineOptions({ layout: Layout });

// 1. Define specific types
export interface UserData {
    name: string;
    first_name: string;
    last_name: string;
    username: string;
    email: string;
    avatar: string | null;
}

export interface Investor {
    id: number;
    is_paid: boolean;
    agent_name: string;
    user: UserData;
}

export interface StatCard {
    label: string;
    value: number;
    icon: string;
    color: string;
}

// 2. Use the "Type-Only" defineProps syntax
defineProps<{
    stats: StatCard[];
    recentInvestors: Investor[];
}>();

// ---------------- Helpers ----------------
function getInitials(first: string | null, last?: string | null): string {
    const f = first ? first.charAt(0) : '';
    const l = last ? last.charAt(0) : '';
    return (f + l).toUpperCase() || '?';
}

const items = [
    [
        { label: 'New Agent', icon: 'i-lucide-user-plus', to: '/super-admin/agents' },
        { label: 'View Reports', icon: 'i-lucide-bar-chart-3', to: '/reports' },
    ],
] satisfies DropdownMenuItem[][];
</script>

<template>
    <UDashboardPanel id="home">
        <template #header>
            <UDashboardNavbar title="Super Admin Dashboard">
                <template #leading>
                    <UDashboardSidebarCollapse />
                </template>

                <template #right>
                    <UDropdownMenu :items="items">
                        <UButton icon="i-lucide-plus" size="md" class="rounded-full" color="primary" />
                    </UDropdownMenu>
                </template>
            </UDashboardNavbar>
        </template>

        <template #body>
            <div class="space-y-8">
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <UCard v-for="stat in stats" :key="stat.label" class="overflow-hidden">
                        <div class="flex items-center gap-4">
                            <div
                                :class="[
                                    'rounded-lg p-3',
                                    stat.color === 'primary' ? 'bg-primary-50 text-primary-600 dark:bg-primary-950' : '',
                                    stat.color === 'blue' ? 'bg-blue-50 text-blue-600 dark:bg-blue-950' : '',
                                    stat.color === 'green' ? 'bg-green-50 text-green-600 dark:bg-green-950' : '',
                                    stat.color === 'orange' ? 'bg-orange-50 text-orange-600 dark:bg-orange-950' : '',
                                ]"
                            >
                                <UIcon :name="stat.icon" class="h-6 w-6" />
                            </div>
                            <div>
                                <p class="text-xs font-medium tracking-wider text-muted uppercase">{{ stat.label }}</p>
                                <p class="text-2xl font-bold text-highlighted">{{ stat.value }}</p>
                            </div>
                        </div>
                    </UCard>
                </div>

                <div class="grid gap-8 lg:grid-cols-3">
                    <div class="space-y-4 lg:col-span-2">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold">Recent Investors</h3>
                            <UButton variant="ghost" label="View all" to="/super-admin/investors" trailing-icon="i-lucide-arrow-right" size="xs" />
                        </div>

                        <UCard shadow="none" class="ring-1 ring-gray-200 dark:ring-gray-800">
                            <div v-if="recentInvestors.length > 0" class="divide-y divide-gray-100 dark:divide-gray-800">
                                <div
                                    v-for="item in recentInvestors"
                                    :key="item.id"
                                    class="flex items-center justify-between py-4 first:pt-0 last:pb-0"
                                >
                                    <div class="flex items-center gap-3">
                                        <UAvatar
                                            src="item.user.avatar"
                                            :text="!item.user.avatar ? getInitials(item.user.first_name, item.user.last_name) : undefined"
                                            size="sm"
                                            class="bg-primary font-medium text-white"
                                        />
                                        <div>
                                            <p class="text-sm font-medium text-highlighted">{{ item.user.name }}</p>
                                            <p class="text-xs text-muted">via {{ item.agent_name }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <UBadge :color="item.is_paid ? 'success' : 'warning'" variant="subtle" size="xs">
                                            {{ item.is_paid ? 'Paid' : 'Unpaid' }}
                                        </UBadge>
                                        <span class="text-xs text-muted">{{ item.user.username }}</span>
                                    </div>
                                </div>
                            </div>
                            <div v-else class="py-8 text-center text-sm text-muted">No recent investors found.</div>
                        </UCard>
                    </div>

                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold">Quick Actions</h3>
                        <div class="flex flex-col gap-2">
                            <UButton
                                block
                                label="Manage Farmers"
                                icon="i-lucide-tractor"
                                color="neutral"
                                variant="outline"
                                to="/super-admin/farmers"
                            />
                            <UButton block label="Manage Agents" icon="i-lucide-users" color="neutral" variant="outline" to="/super-admin/agents" />
                            <!-- <UButton block label="Financial Logs" icon="i-lucide-file-text" color="neutral" variant="outline" /> -->
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </UDashboardPanel>
</template>
