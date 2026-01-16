<script setup lang="ts">
import Layout from '@/layouts/AppLayout.vue';
import { router } from '@inertiajs/vue3';
import { type ColumnDef } from '@tanstack/table-core';
import { h, ref, resolveComponent, watch } from 'vue';

defineOptions({ layout: Layout });

// ---------------- Components & Composables ----------------
const toast = useToast();
const UAvatar = resolveComponent('UAvatar');
const UButton = resolveComponent('UButton');
const UBadge = resolveComponent('UBadge');
const UDropdownMenu = resolveComponent('UDropdownMenu');
const USelect = resolveComponent('USelect');
const USlideover = resolveComponent('USlideover');

// ---------------- Props ----------------
const props = defineProps<{
    farmers: any[];
    filters: any;
}>();

// ---------------- Detail State ----------------
const isDetailsOpen = ref(false);
const selectedFarmer = ref<any>(null);

function openDetails(farmer: any) {
    selectedFarmer.value = farmer;
    isDetailsOpen.value = true;
}

// ---------------- Actions ----------------
const toggleVerification = (farmer: any) => {
    router.patch(
        `/super-admin/farmers/${farmer.id}/status`,
        {},
        {
            preserveScroll: true,
            onSuccess: () => {
                // Update local state if slideover is open
                if (selectedFarmer.value && selectedFarmer.value.id === farmer.id) {
                    selectedFarmer.value.is_verified = !selectedFarmer.value.is_verified;
                }

                // Alert Success
                toast.add({
                    title: 'Success',
                    description: `Farmer status has been updated.`,
                    color: 'success',
                    icon: 'i-lucide-check-circle',
                });
            },
        },
    );
};

// ---------------- Filter State ----------------
const statusFilter = ref(props.filters.status || 'all');
const searchQuery = ref(props.filters.search || '');

const syncFilters = () => {
    router.get(
        '/super-admin/farmers',
        {
            status: statusFilter.value === 'all' ? undefined : statusFilter.value,
            search: searchQuery.value || undefined,
        },
        { preserveState: true, replace: true, preserveScroll: true },
    );
};

watch([statusFilter], () => syncFilters());

// ---------------- Helpers ----------------
function getInitials(first: string, last?: string) {
    return `${first?.[0] ?? ''}${last?.[0] ?? ''}`.toUpperCase();
}

const columns: ColumnDef<any>[] = [
    {
        accessorKey: 'name',
        header: 'Farmer Name',
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
                    h('p', { class: 'text-muted text-xs' }, row.original.user.email),
                ]),
            ]),
    },
    {
        accessorKey: 'phone',
        header: 'Phone',
        cell: ({ row }) => h('span', { class: 'text-sm text-muted' }, row.original.user.phone_number || 'N/A'),
    },
    {
        accessorKey: 'verified',
        header: 'Status',
        cell: ({ row }) =>
            h(UBadge, { color: row.original.is_verified ? 'success' : 'warning', variant: 'subtle' }, () =>
                row.original.is_verified ? 'Verified' : 'Pending',
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
                        items: [
                            [
                                {
                                    label: 'View Profile',
                                    icon: 'i-lucide-user',
                                    onSelect: () => openDetails(row.original),
                                },
                            ],
                            [
                                {
                                    label: row.original.is_verified ? 'Unverify Farmer' : 'Approve Farmer',
                                    icon: row.original.is_verified ? 'i-lucide-x-circle' : 'i-lucide-check-circle',
                                    color: row.original.is_verified ? 'error' : 'success',
                                    onSelect: () => toggleVerification(row.original),
                                },
                            ],
                        ],
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
    <UDashboardPanel id="farmers">
        <template #header>
            <UDashboardNavbar title="Farmer Management">
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
                            { label: 'Pending', value: 'unverified' },
                        ]"
                        class="w-36"
                    />
                </div>

                <!-- <div class="flex flex-col gap-1.5">
                    <span class="ml-1 text-[10px] font-bold text-muted uppercase">Search</span>
                    <UInput
                        v-model="searchQuery"
                        placeholder="Search name or email..."
                        class="w-64"
                        icon="i-lucide-search"
                        @keyup.enter="handleSearch"
                    />
                </div> -->

                <UButton
                    color="neutral"
                    variant="ghost"
                    icon="i-lucide-filter-x"
                    @click="
                        statusFilter = 'all';
                        searchQuery = '';
                        syncFilters();
                    "
                />
            </div>

            <UTable :data="props.farmers" :columns="columns" />

            <USlideover v-model:open="isDetailsOpen" title="Farmer Information" description="Full registration details of the farmer.">
                <template #body v-if="selectedFarmer">
                    <div class="space-y-6">
                        <div class="flex items-center gap-4 border-b pb-6">
                            <UAvatar
                                :src="selectedFarmer.user.avatar"
                                :text="getInitials(selectedFarmer.user.first_name, selectedFarmer.user.last_name)"
                                size="3xl"
                                class="bg-green-600 text-white"
                            />
                            <div>
                                <h3 class="text-xl font-bold">{{ selectedFarmer.user.name }}</h3>
                                <UBadge :color="selectedFarmer.is_verified ? 'success' : 'warning'" variant="subtle" class="mt-1">
                                    {{ selectedFarmer.is_verified ? 'Verified Account' : 'Pending Verification' }}
                                </UBadge>
                            </div>
                        </div>

                        <div class="rounded-lg border border-green-100 bg-green-50 p-4 dark:border-green-800 dark:bg-green-900/20">
                            <h4 class="mb-3 text-[10px] font-bold text-green-700 uppercase dark:text-green-400">Farming Profile</h4>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-semibold text-muted uppercase">Experience</span>
                                    <span class="font-medium text-highlighted">{{ selectedFarmer.years_of_farming || 0 }} Years</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-semibold text-muted uppercase">Tree Cultivation</span>
                                    <span class="font-medium text-highlighted">{{ selectedFarmer.familiarity_tree_cultivation ? 'Yes' : 'No' }}</span>
                                </div>
                                <div class="col-span-2 pt-2">
                                    <span class="text-[10px] font-semibold text-muted uppercase">Background Info</span>
                                    <p class="mt-1 text-muted italic">"{{ selectedFarmer.farming_background || 'No background provided.' }}"</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-semibold text-muted uppercase">Email</span>
                                <span>{{ selectedFarmer.user.email }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[10px] font-semibold text-muted uppercase">Phone</span>
                                <span>{{ selectedFarmer.user.phone_number || 'None' }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[10px] font-semibold text-muted uppercase">Birthday</span>
                                <span>{{ selectedFarmer.user.birthday || 'Not set' }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[10px] font-semibold text-muted uppercase">Gender</span>
                                <span class="capitalize">{{ selectedFarmer.user.gender || 'Not set' }}</span>
                            </div>
                        </div>
                    </div>
                </template>
                <template #footer>
                    <div class="flex w-full items-center justify-between gap-3">
                        <UButton
                            v-if="selectedFarmer"
                            :label="selectedFarmer.is_verified ? 'Unverify Account' : 'Approve & Verify'"
                            :color="selectedFarmer.is_verified ? 'error' : 'success'"
                            :icon="selectedFarmer.is_verified ? 'i-lucide-user-x' : 'i-lucide-user-check'"
                            variant="subtle"
                            class="flex-1"
                            @click="toggleVerification(selectedFarmer)"
                        />
                        <UButton label="Close" color="neutral" variant="ghost" @click="isDetailsOpen = false" />
                    </div>
                </template>
            </USlideover>
        </template>
    </UDashboardPanel>
</template>
