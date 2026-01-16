<script setup lang="ts">
import Layout from '@/layouts/AppLayout.vue';
import type { Agent } from '@/types';
import { router } from '@inertiajs/vue3';
import { type ColumnDef } from '@tanstack/table-core';
import { computed, h, ref, resolveComponent, watch } from 'vue';

defineOptions({ layout: Layout });

// ---------------- Components ----------------
const UAvatar = resolveComponent('UAvatar');
const UButton = resolveComponent('UButton');
const UBadge = resolveComponent('UBadge');
const UDropdownMenu = resolveComponent('UDropdownMenu');
const USelect = resolveComponent('USelect');
const USlideover = resolveComponent('USlideover');

// ---------------- Props ----------------
const props = defineProps<{
    agents: Agent[];
    farmers_list: any[];
    agents_list: any[];
    filters: any;
}>();

// ---------------- Detail State ----------------
const isDetailsOpen = ref(false);
const selectedAgent = ref<Agent | null>(null);

function openDetails(agent: Agent) {
    selectedAgent.value = agent;
    isDetailsOpen.value = true;
}

// ---------------- Filter State ----------------
const statusFilter = ref(props.filters.status || 'all');
const farmerFilter = ref(props.filters.farmer || 'all');
const agentNameFilter = ref(props.filters.agent_name || 'all');

const filteredAgentsList = computed(() => {
    if (farmerFilter.value === 'all') return props.agents_list;
    return props.agents_list.filter((agent) => agent.farmer_name === farmerFilter.value);
});

const syncFilters = () => {
    router.get(
        '/super-admin/agents',
        {
            status: statusFilter.value === 'all' ? undefined : statusFilter.value,
            farmer: farmerFilter.value === 'all' ? undefined : farmerFilter.value,
            agent_name: agentNameFilter.value === 'all' ? undefined : agentNameFilter.value,
        },
        { preserveState: true, replace: true, preserveScroll: true },
    );
};

watch(farmerFilter, () => {
    agentNameFilter.value = 'all';
    syncFilters();
});
watch([statusFilter, agentNameFilter], () => syncFilters());

// ---------------- Helpers ----------------
function getInitials(first: string, last?: string) {
    return `${first?.[0] ?? ''}${last?.[0] ?? ''}`.toUpperCase();
}

const columns: ColumnDef<Agent>[] = [
    {
        accessorKey: 'agent_code',
        header: 'Code',
        cell: ({ row }) => h(UBadge, { color: 'neutral', variant: 'subtle' }, () => row.original.agent_code),
    },
    {
        accessorKey: 'name',
        header: 'Agent Name',
        cell: ({ row }) =>
            h('div', { class: 'flex items-center gap-3' }, [
                h(UAvatar, {
                    src: row.original.user.avatar || undefined,
                    text: !row.original.user.avatar ? getInitials(row.original.user.first_name, row.original.user.last_name) : undefined,
                    size: 'lg',
                    class: 'bg-primary text-white',
                }),
                h('div', undefined, [
                    h('p', { class: 'font-medium text-highlighted text-sm' }, row.original.user.name),
                    h('p', { class: 'text-muted text-xs' }, `@${row.original.user.username}`),
                ]),
            ]),
    },
    {
        accessorKey: 'email',
        header: 'Email',
        cell: ({ row }) => h('span', { class: 'text-sm text-muted' }, row.original.user.email),
    },
    {
        accessorKey: 'farmer_name',
        header: 'Associated Farmer',
        cell: ({ row }) => h('p', { class: 'font-medium text-primary text-sm' }, row.original.farmer_name),
    },
    {
        accessorKey: 'verified',
        header: 'Status',
        cell: ({ row }) =>
            h(UBadge, { color: row.original.is_verified ? 'success' : 'error', variant: 'subtle' }, () =>
                row.original.is_verified ? 'Verified' : 'Unverified',
            ),
    },
    {
        id: 'actions',
        cell: ({ row }) =>
            h(
                'div',
                { class: 'text-right' },
                h(
                    UDropdownMenu,
                    {
                        items: [{ label: 'View Full Info', icon: 'i-lucide-user', onSelect: () => openDetails(row.original) }],
                        content: { align: 'end' },
                    },
                    () => h(UButton, { icon: 'i-lucide-ellipsis-vertical', variant: 'ghost', color: 'neutral' }),
                ),
            ),
    },
];

const dropdownItems = [
    [{ label: 'New mail', icon: 'i-lucide-send', to: '/inbox' }],
    [{ label: 'New customer', icon: 'i-lucide-user-plus', to: '/customers' }],
];
</script>

<template>
    <UDashboardPanel id="agents">
        <template #header>
            <UDashboardNavbar title="Agents">
                <template #leading>
                    <UDashboardSidebarCollapse />
                </template>

                <template #right>
                    <UDropdownMenu :items="dropdownItems">
                        <UButton icon="i-lucide-plus" color="neutral" variant="ghost" />
                    </UDropdownMenu>
                </template>
            </UDashboardNavbar>
        </template>

        <template #body>
            <div class="mb-6 flex flex-wrap items-end gap-4">
                <div class="flex flex-col gap-1.5">
                    <span class="ml-1 text-[10px] font-bold text-muted uppercase">Status</span>
                    <USelect
                        v-model="statusFilter"
                        :items="[
                            { label: 'All', value: 'all' },
                            { label: 'Verified', value: 'verified' },
                            { label: 'Unverified', value: 'unverified' },
                        ]"
                        class="w-36"
                    />
                </div>
                <div class="flex flex-col gap-1.5">
                    <span class="ml-1 text-[10px] font-bold text-muted uppercase">Farmer</span>
                    <USelect v-model="farmerFilter" :items="[{ label: 'All Farmers', value: 'all' }, ...props.farmers_list]" class="w-52" />
                </div>
                <div class="flex flex-col gap-1.5">
                    <span class="ml-1 text-[10px] font-bold text-muted uppercase">Agent Name</span>
                    <USelect v-model="agentNameFilter" :items="[{ label: 'All Agents', value: 'all' }, ...filteredAgentsList]" class="w-64" />
                </div>
                <UButton
                    color="neutral"
                    variant="ghost"
                    icon="i-lucide-filter-x"
                    @click="
                        statusFilter = 'all';
                        farmerFilter = 'all';
                        agentNameFilter = 'all';
                    "
                />
            </div>

            <UTable :data="props.agents" :columns="columns" />

            <USlideover v-model:open="isDetailsOpen" title="Agent Information" description="Full registration details of the agent.">
                <template #body v-if="selectedAgent">
                    <div class="space-y-6">
                        <div class="flex items-center gap-4 border-b pb-6">
                            <UAvatar
                                :src="selectedAgent.user.avatar"
                                :text="getInitials(selectedAgent.user.first_name, selectedAgent.user.last_name)"
                                size="3xl"
                                class="bg-primary text-white"
                            />
                            <div>
                                <h3 class="text-xl font-bold">{{ selectedAgent.user.name }}</h3>
                                <p class="text-sm text-muted">Agent Code: {{ selectedAgent.agent_code }}</p>
                                <UBadge :color="selectedAgent.is_verified ? 'success' : 'error'" variant="subtle" class="mt-1">
                                    {{ selectedAgent.is_verified ? 'Verified Account' : 'Pending Verification' }}
                                </UBadge>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-semibold text-muted uppercase">Email</span>
                                <span>{{ selectedAgent.user.email }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[10px] font-semibold text-muted uppercase">Phone</span>
                                <span>{{ selectedAgent.user.phone_number || 'None' }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[10px] font-semibold text-muted uppercase">Birthday</span>
                                <span>{{ selectedAgent.user.birthday || 'Not set' }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[10px] font-semibold text-muted uppercase">Gender</span>
                                <span class="capitalize">{{ selectedAgent.user.gender || 'Not set' }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[10px] font-semibold text-muted uppercase">Civil Status</span>
                                <span class="capitalize">{{ selectedAgent.user.civil_status || 'Not set' }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[10px] font-semibold text-muted uppercase">Associated Farmer</span>
                                <span class="font-medium text-primary">{{ selectedAgent.farmer_name }}</span>
                            </div>
                        </div>

                        <div class="rounded-lg border border-gray-100 bg-gray-50 p-3 dark:border-gray-700 dark:bg-gray-800">
                            <span class="text-[10px] font-semibold text-muted uppercase">Residential Address</span>
                            <p class="mt-1 text-sm leading-relaxed">{{ selectedAgent.user.address || 'No address provided.' }}</p>
                        </div>

                        <div class="space-y-1">
                            <span class="text-[10px] font-semibold text-muted uppercase">Farming Background</span>
                            <p class="text-sm text-muted italic">"{{ selectedAgent.farming_background || 'No background info.' }}"</p>
                        </div>
                    </div>
                </template>
                <template #footer>
                    <UButton label="Close" color="neutral" variant="ghost" @click="isDetailsOpen = false" />
                </template>
            </USlideover>
        </template>
    </UDashboardPanel>
</template>
