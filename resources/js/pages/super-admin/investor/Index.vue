<script setup lang="ts">
import Layout from '@/layouts/AppLayout.vue';
import { router } from '@inertiajs/vue3';
import { type ColumnDef } from '@tanstack/table-core';
import { h, ref, resolveComponent, watch } from 'vue';

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
    investors: any[];
    agents_list: any[];
    filters: any;
}>();

// ---------------- Detail State ----------------
const isDetailsOpen = ref(false);
const selectedInvestor = ref<any>(null);

function openDetails(investor: any) {
    selectedInvestor.value = investor;
    isDetailsOpen.value = true;
}

// ---------------- Filter State ----------------
const statusFilter = ref(props.filters.status || 'all');
const agentFilter = ref(props.filters.agent_name || 'all');
const searchQuery = ref(props.filters.search || '');

const syncFilters = () => {
    router.get(
        '/super-admin/investors',
        {
            status: statusFilter.value === 'all' ? undefined : statusFilter.value,
            agent_name: agentFilter.value === 'all' ? undefined : agentFilter.value,
            search: searchQuery.value || undefined,
        },
        { preserveState: true, replace: true, preserveScroll: true },
    );
};

watch([statusFilter, agentFilter], () => syncFilters());

// ---------------- Helpers ----------------
function getInitials(first: string, last?: string) {
    return `${first?.[0] ?? ''}${last?.[0] ?? ''}`.toUpperCase();
}

const columns: ColumnDef<any>[] = [
    {
        accessorKey: 'name',
        header: 'Investor Name',
        cell: ({ row }) =>
            h('div', { class: 'flex items-center gap-3' }, [
                h(UAvatar, {
                    src: row.original.user.avatar || undefined,
                    text: !row.original.user.avatar ? getInitials(row.original.user.first_name, row.original.user.last_name) : undefined,
                    size: 'lg',
                    class: 'bg-primary',
                }),
                h('div', undefined, [
                    h('p', { class: 'font-medium text-highlighted text-sm' }, row.original.user.name),
                    h('p', { class: 'text-muted text-xs' }, row.original.user.email),
                ]),
            ]),
    },
    {
        accessorKey: 'agent_name',
        header: 'Referring Agent',
        cell: ({ row }) => h('p', { class: 'text-sm font-medium' }, row.original.agent_name),
    },
    {
        accessorKey: 'id_type',
        header: 'ID Type',
        cell: ({ row }) => h('span', { class: 'text-xs uppercase text-muted' }, row.original.id_type),
    },
    {
        accessorKey: 'is_paid',
        header: 'Payment',
        cell: ({ row }) =>
            h(UBadge, { color: row.original.is_paid ? 'success' : 'warning', variant: 'subtle' }, () => (row.original.is_paid ? 'Paid' : 'Unpaid')),
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
                        items: [[{ label: 'View Profile', icon: 'i-lucide-user', onSelect: () => openDetails(row.original) }]],
                        content: { align: 'end' },
                    },
                    () => h(UButton, { icon: 'i-lucide-ellipsis-vertical', variant: 'ghost', color: 'neutral' }),
                ),
            ),
    },
];
</script>

<template>
    <UDashboardPanel id="investors">
        <template #header>
            <UDashboardNavbar title="Investor Management" />
        </template>

        <template #body>
            <div class="mb-6 flex flex-wrap items-end gap-4">
                <div class="flex flex-col gap-1.5">
                    <span class="ml-1 text-[10px] font-bold text-muted uppercase">Payment Status</span>
                    <USelect
                        v-model="statusFilter"
                        :items="[
                            { label: 'All', value: 'all' },
                            { label: 'Paid', value: 'paid' },
                            { label: 'Unpaid', value: 'unpaid' },
                        ]"
                        class="w-36"
                    />
                </div>
                <div class="flex flex-col gap-1.5">
                    <span class="ml-1 text-[10px] font-bold text-muted uppercase">Filter by Agent</span>
                    <USelect v-model="agentFilter" :items="[{ label: 'All Agents', value: 'all' }, ...props.agents_list]" class="w-52" />
                </div>
                <!-- <div class="flex flex-col gap-1.5">
                    <span class="ml-1 text-[10px] font-bold text-muted uppercase">Search</span>
                    <UInput v-model="searchQuery" placeholder="Name or email..." class="w-64" icon="i-lucide-search" @keyup.enter="handleSearch" />
                </div> -->
                <UButton
                    color="neutral"
                    variant="ghost"
                    icon="i-lucide-filter-x"
                    @click="
                        statusFilter = 'all';
                        agentFilter = 'all';
                        searchQuery = '';
                        syncFilters();
                    "
                />
            </div>

            <UTable :data="props.investors" :columns="columns" />

            <USlideover v-model:open="isDetailsOpen" title="Investor Details">
                <template #body v-if="selectedInvestor">
                    <div class="space-y-6">
                        <div class="flex items-center gap-4 border-b pb-6">
                            <UAvatar
                                :src="selectedInvestor.user.avatar"
                                :text="getInitials(selectedInvestor.user.first_name, selectedInvestor.user.last_name)"
                                size="3xl"
                                class="bg-indigo-600 text-white"
                            />
                            <div>
                                <h3 class="text-xl font-bold">{{ selectedInvestor.user.name }}</h3>
                                <p class="text-sm text-muted">Referred by: {{ selectedInvestor.agent_name }}</p>
                                <UBadge :color="selectedInvestor.is_paid ? 'success' : 'warning'" variant="subtle" class="mt-1">
                                    {{ selectedInvestor.is_paid ? 'Paid' : 'Unpaid' }}
                                </UBadge>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-bold text-muted uppercase">ID Type</span><span>{{ selectedInvestor.id_type }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[10px] font-bold text-muted uppercase">Phone</span
                                ><span>{{ selectedInvestor.user.phone_number || 'N/A' }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[10px] font-bold text-muted uppercase">Gender</span
                                ><span class="capitalize">{{ selectedInvestor.user.gender }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[10px] font-bold text-muted uppercase">Civil Status</span
                                ><span class="capitalize">{{ selectedInvestor.user.civil_status }}</span>
                            </div>
                        </div>

                        <div class="rounded-lg border bg-gray-50 p-3 dark:bg-gray-800">
                            <span class="text-[10px] font-bold text-muted uppercase">Address</span>
                            <p class="text-sm">{{ selectedInvestor.user.address || 'No address provided.' }}</p>
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
