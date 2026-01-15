<script setup lang="ts">
import Layout from '@/layouts/AppLayout.vue';
import type { Agent, AppPageProps, User } from '@/types';
import { router, usePage } from '@inertiajs/vue3';
import { ColumnFiltersState, getFilteredRowModel, getPaginationRowModel, Table, type Column, type ColumnDef, type Row } from '@tanstack/table-core';
import { h, ref, resolveComponent, watch } from 'vue';

defineOptions({ layout: Layout });

const toast = useToast();

// ---------------- Components ----------------
const UAvatar = resolveComponent('UAvatar');
const UButton = resolveComponent('UButton');
const UBadge = resolveComponent('UBadge');
const UDropdownMenu = resolveComponent('UDropdownMenu');
const UCheckbox = resolveComponent('UCheckbox');

// ---------------- Props ----------------
const { props } = usePage<AppPageProps>();
const agents = ref<Agent[]>(props.agents);

// ---------------- Table State ----------------
const columnFilters = ref<ColumnFiltersState>([{ id: 'email', value: '' }]);
const columnVisibility = ref<Record<string, boolean> | undefined>();
const rowSelection = ref<Record<string, boolean>>({});
const pagination = ref({ pageIndex: 0, pageSize: 10 });
const tanstackTable = ref<Table<Agent> | null>(null);

// ---------------- Helpers ----------------
function getInitials(first: string, last?: string) {
    return `${first[0] ?? ''}${last?.[0] ?? ''}`.toUpperCase();
}

function getAvatarProps(user: User) {
    return {
        src: user.avatar || undefined,
        text: !user.avatar ? getInitials(user.first_name, user.last_name) : undefined,
        size: 'lg',
        class: 'bg-primary text-white',
    };
}

// ---------------- Row Actions ----------------
function getRowActions(row: Row<Agent>) {
    return [
        { type: 'label', label: 'Actions' },
        {
            label: 'View Agent',
            icon: 'i-lucide-eye',
            onSelect: () => {
                router.visit(`/farmer/agents/${row.original.id}`);
            },
        },
        {
            label: 'View QR',
            icon: 'i-lucide-code',
            onSelect: () => {
                toast.add({
                    title: 'QR Code',
                    description: row.original.qr_code_path || 'No QR code available',
                });
            },
        },
        { type: 'separator' },

        {
            label: 'Edit Agent',
            icon: 'i-lucide-edit',
            onSelect: () => {
                toast.add({ title: 'Edit', description: `Edit agent ${row.original.user.name}` });
            },
        },
        {
            label: 'Delete Agent',
            icon: 'i-lucide-trash',
            color: 'error',
            onSelect: () => {
                toast.add({ title: 'Deleted', description: `Deleted agent ${row.original.user.name}` });
            },
        },
    ];
}

// ---------------- Columns ----------------
const columns: ColumnDef<Agent>[] = [
    // Select checkbox
    {
        id: 'select',
        header: ({ table }: { table: Table<Agent> }) =>
            h(UCheckbox, {
                modelValue: table.getIsSomePageRowsSelected() ? 'indeterminate' : table.getIsAllPageRowsSelected(),
                'onUpdate:modelValue': (v: boolean | 'indeterminate') => table.toggleAllPageRowsSelected(!!v),
                ariaLabel: 'Select all',
            }),
        cell: ({ row }: { row: Row<Agent> }) =>
            h(UCheckbox, {
                modelValue: row.getIsSelected(),
                'onUpdate:modelValue': (v: boolean | 'indeterminate') => row.toggleSelected(!!v),
                ariaLabel: 'Select row',
            }),
    },

    // Agent code
    {
        accessorKey: 'agent_code',
        header: 'Agent Code',
        accessorFn: (row: Agent) => row.agent_code,
        cell: ({ row }: { row: Row<Agent> }) => h(UBadge, { color: 'neutral', variant: 'subtle' }, () => row.original.agent_code),
    },

    // Name + Avatar
    {
        accessorKey: 'name',
        header: 'Name',
        accessorFn: (row: Agent) => row.user.name,
        cell: ({ row }: { row: Row<Agent> }) =>
            h('div', { class: 'flex items-center gap-3' }, [
                h(UAvatar, getAvatarProps(row.original.user)),
                h('div', undefined, [
                    h('p', { class: 'font-medium text-highlighted' }, row.original.user.name),
                    h('p', { class: 'text-muted text-sm' }, `@${row.original.user.username}`),
                ]),
            ]),
    },

    // Email (sortable)
    {
        accessorKey: 'email',
        header: ({ column }: { column: Column<Agent, any> }) => {
            const isSorted = column.getIsSorted();
            return h(UButton, {
                color: 'neutral',
                variant: 'ghost',
                label: 'Email',
                icon: isSorted
                    ? isSorted === 'asc'
                        ? 'i-lucide-arrow-up-narrow-wide'
                        : 'i-lucide-arrow-down-wide-narrow'
                    : 'i-lucide-arrow-up-down',
                class: '-mx-2.5',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            });
        },
        accessorFn: (row: Agent) => row.user.email,
    },

    // Phone
    {
        accessorKey: 'phone',
        header: 'Phone',
        accessorFn: (row: Agent) => row.user.phone_number,
    },

    // Verified
    {
        accessorKey: 'verified',
        header: 'Verified',
        accessorFn: (row: Agent) => row.is_verified,
        filterFn: (row, _columnId, filterValue: boolean) => {
            return row.original.is_verified === filterValue;
        },
        cell: ({ row }: { row: Row<Agent> }) =>
            h(
                UBadge,
                {
                    color: row.original.is_verified ? 'success' : 'error',
                    variant: 'subtle',
                },
                () => (row.original.is_verified ? 'Verified' : 'Unverified'),
            ),
    },

    // Actions dropdown
    {
        id: 'actions',
        cell: ({ row }: { row: Row<Agent> }) =>
            h(
                'div',
                { class: 'text-right' },
                h(UDropdownMenu, { items: getRowActions(row), content: { align: 'end' } }, () =>
                    h(UButton, { icon: 'i-lucide-ellipsis-vertical', variant: 'ghost', color: 'neutral' }),
                ),
            ),
    },
];

// ---------------- Status Filter ----------------
const statusFilter = ref<'all' | 'verified' | 'unverified'>('all');

watch(statusFilter, (val) => {
    columnFilters.value =
        val === 'all'
            ? columnFilters.value.filter((f) => f.id !== 'verified')
            : [...columnFilters.value.filter((f) => f.id !== 'verified'), { id: 'verified', value: val === 'verified' }];
});
</script>

<template>
    <UDashboardPanel id="agents">
        <template #header>
            <UDashboardNavbar title="Agents">
                <template #leading>
                    <UDashboardSidebarCollapse as="button" />
                </template>
                <template #right>
                    <AgentsAddModal />
                </template>
            </UDashboardNavbar>
        </template>

        <template #body>
            <div class="mb-4 flex items-center gap-2">
                <UButton
                    v-for="filter in ['all', 'verified', 'unverified'] as const"
                    :key="filter"
                    :variant="statusFilter === filter ? 'solid' : 'outline'"
                    @click="statusFilter = filter"
                    class="capitalize"
                >
                    {{ filter }}
                </UButton>
            </div>

            <UTable
                @ready="tanstackTable = $event"
                v-model:column-filters="columnFilters"
                v-model:column-visibility="columnVisibility"
                v-model:row-selection="rowSelection"
                v-model:pagination="pagination"
                :table-options="{
                    getFilteredRowModel: getFilteredRowModel(),
                }"
                :pagination-options="{
                    getPaginationRowModel: getPaginationRowModel(),
                }"
                :data="agents"
                :columns="columns"
                :loading="false"
            />
        </template>
    </UDashboardPanel>
</template>
