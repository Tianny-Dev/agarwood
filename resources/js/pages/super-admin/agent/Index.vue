<script setup lang="ts">
import Layout from '@/layouts/AppLayout.vue';
import type { Agent, AppPageProps, User } from '@/types';
import { router, usePage } from '@inertiajs/vue3';
import { ColumnFiltersState, getFilteredRowModel, getPaginationRowModel, Table, type ColumnDef, type Row } from '@tanstack/table-core';
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

// ---------------- Delete Modal ----------------
// const agentToDelete = ref<Agent | null>(null);
// const modalOpen = ref(false);

// function openDeleteModal(agent: Agent) {
//     agentToDelete.value = agent;
//     modalOpen.value = true;
// }

// function closeModal() {
//     agentToDelete.value = null;
//     modalOpen.value = false;
// }

// function deleteAgent() {
//     if (!agentToDelete.value) return;

//     const agentName = agentToDelete.value.user.name;

//     router.delete(`/super-admin/agents/${agentToDelete.value.id}`, {
//         preserveScroll: true,
//         preserveState: false,
//         onSuccess: () => {
//             toast.add({
//                 title: 'Agent deleted',
//                 description: `Agent ${agentName} was deleted successfully.`,
//                 icon: 'i-lucide-trash',
//                 duration: 4000,
//             });
//         },
//         onFinish: () => {
//             closeModal();
//         },
//     });
// }

// ---------------- Verify Modal ----------------
const agentToVerify = ref<Agent | null>(null);
const verifyModalOpen = ref(false);

function openVerifyModal(agent: Agent) {
    agentToVerify.value = agent;
    verifyModalOpen.value = true;
}

function closeVerifyModal() {
    agentToVerify.value = null;
    verifyModalOpen.value = false;
}

function verifyAgent() {
    if (!agentToVerify.value) return;

    const agent = agentToVerify.value;
    const agentName = agent.user.name;

    router.patch(
        `/super-admin/agents/${agent.id}`,
        { is_verified: true },
        {
            preserveScroll: true,
            preserveState: false,
            onSuccess: () => {
                toast.add({
                    title: 'Agent Updated',
                    description: `Agent ${agentName} was updated successfully.`,
                    icon: 'i-lucide-check',
                    duration: 4000,
                });
            },
            onFinish: () => {
                closeVerifyModal();
            },
        },
    );
}

// ---------------- Row Actions ----------------
function getRowActions(row: Row<Agent>) {
    return [
        { type: 'label', label: 'Actions' },
        {
            label: 'Verify Agent',
            icon: 'i-lucide-check',
            onSelect: () => openVerifyModal(row.original),
        },
        {
            label: 'View Agent',
            icon: 'i-lucide-eye',
            onSelect: () => router.visit(`/super-admin/agents/${row.original.id}`),
        },
        {
            label: 'View QR',
            icon: 'i-lucide-code',
            onSelect: () =>
                toast.add({
                    title: 'QR Code',
                    description: row.original.qr_code_path || 'No QR code available',
                }),
        },
        // { type: 'separator' },
        // {
        //     label: 'Edit Agent',
        //     icon: 'i-lucide-edit',
        //     onSelect: () => router.visit(`/super-admin/agents/${row.original.id}/edit`),
        // },
        // {
        //     label: 'Delete Agent',
        //     icon: 'i-lucide-trash',
        //     color: 'error',
        //     onSelect: () => openDeleteModal(row.original),
        // },
    ];
}

// ---------------- Columns ----------------
const columns: ColumnDef<Agent>[] = [
    // Select checkbox
    {
        id: 'select',
        header: ({ table }) =>
            h(UCheckbox, {
                modelValue: table.getIsSomePageRowsSelected() ? 'indeterminate' : table.getIsAllPageRowsSelected(),
                'onUpdate:modelValue': (v: boolean | 'indeterminate') => table.toggleAllPageRowsSelected(!!v),
                ariaLabel: 'Select all',
            }),
        cell: ({ row }) =>
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
        accessorFn: (row) => row.agent_code,
        cell: ({ row }) => h(UBadge, { color: 'neutral', variant: 'subtle' }, () => row.original.agent_code),
    },

    // Name + Avatar
    {
        accessorKey: 'name',
        header: 'Name',
        accessorFn: (row) => row.user.name,
        cell: ({ row }) =>
            h('div', { class: 'flex items-center gap-3' }, [
                h(UAvatar, getAvatarProps(row.original.user)),
                h('div', undefined, [
                    h('p', { class: 'font-medium text-highlighted' }, row.original.user.name),
                    h('p', { class: 'text-muted text-sm' }, `@${row.original.user.username}`),
                ]),
            ]),
    },

    // Email
    {
        accessorKey: 'email',
        header: ({ column }) => {
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
        accessorFn: (row) => row.user.email,
    },

    // Phone
    {
        accessorKey: 'phone',
        header: 'Phone',
        accessorFn: (row) => row.user.phone_number,
    },

    // Verified
    {
        accessorKey: 'verified',
        header: 'Verified',
        accessorFn: (row) => row.is_verified,
        filterFn: (row, _id, value: boolean) => row.original.is_verified === value,
        cell: ({ row }) =>
            h(UBadge, { color: row.original.is_verified ? 'success' : 'error', variant: 'subtle' }, () =>
                row.original.is_verified ? 'Verified' : 'Unverified',
            ),
    },

    // Actions dropdown
    {
        id: 'actions',
        cell: ({ row }) =>
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

watch(
    () => props.agents,
    (newAgents) => {
        agents.value = newAgents;
    },
    { immediate: true },
);
</script>

<template>
    <UDashboardPanel id="agents">
        <template #header>
            <UDashboardNavbar title="Agents">
                <template #leading>
                    <UDashboardSidebarCollapse as="button" />
                </template>
            </UDashboardNavbar>
        </template>

        <template #body>
            <div class="mb-4 flex items-center justify-between gap-2">
                <!-- Status Filters -->
                <div class="flex items-center gap-2">
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

                <!-- Add Agent Button -->
                <UButton
                    icon="i-lucide-plus"
                    :disabled="agents.length === 0 && statusFilter !== 'all'"
                    color="primary"
                    title="Add Agent (A)"
                    :href="`/super-admin/agents/create`"
                >
                    Add Agent
                </UButton>
            </div>

            <!-- Agents Table -->
            <UTable
                @ready="tanstackTable = $event"
                v-model:column-filters="columnFilters"
                v-model:column-visibility="columnVisibility"
                v-model:row-selection="rowSelection"
                v-model:pagination="pagination"
                :table-options="{ getFilteredRowModel: getFilteredRowModel() }"
                :pagination-options="{ getPaginationRowModel: getPaginationRowModel() }"
                :data="agents"
                :columns="columns"
                :loading="false"
            />
        </template>
    </UDashboardPanel>

    <!-- Delete Modal -->
    <!-- <UModal title="Delete Agent" v-model:open="modalOpen">
        <template #body>
            <p>
                Are you sure you want to delete
                <strong>{{ agentToDelete?.user.name }}</strong
                >?
            </p>
            <p class="text-sm text-muted">This action cannot be undone.</p>

            <div class="mt-4 flex justify-end gap-2">
                <UButton color="neutral" variant="outline" @click="closeModal">Cancel</UButton>
                <UButton color="error" @click="deleteAgent">Delete</UButton>
            </div>
        </template>
    </UModal> -->

    <!-- Verify Modal -->
    <UModal title="Verify Agent" v-model:open="verifyModalOpen">
        <template #body>
            <p>
                Are you sure you want to verify
                <strong>{{ agentToVerify?.user.name }}</strong
                >?
            </p>

            <div class="mt-4 flex justify-end gap-2">
                <UButton color="neutral" variant="outline" @click="closeVerifyModal">Cancel</UButton>
                <UButton color="primary" @click="verifyAgent">Yes Verify</UButton>
            </div>
        </template>
    </UModal>
</template>
