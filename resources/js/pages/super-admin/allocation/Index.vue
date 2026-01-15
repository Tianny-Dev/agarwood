<script setup lang="ts">
import Layout from '@/layouts/AppLayout.vue';
import { router, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

// Props definition
const props = defineProps<{
    allocation: Array<{ id: number; name: string; value: string | number }>;
}>();

// UI State
const showModal = ref(false);
const showDeleteAlert = ref(false);
const isEditing = ref(false);
const editingId = ref<number | null>(null);
const itemToDelete = ref<number | null>(null);

const form = useForm({
    name: '',
    value: 0,
});

const displayName = computed({
    get: () => form.name.replace(/_/g, ' '),
    set: (val) => {
        form.name = val.replace(/\s+/g, '_');
    },
});

declare function route(name: string, params?: any): string;

// Helper for routing
const ziggyRoute = (name: string, params?: any) => {
    try {
        return route(name, params);
    } catch {
        if (name.includes('update') || name.includes('destroy')) {
            return `/super-admin/allocation/${params.allocation}`;
        }
        return '/super-admin/allocation';
    }
};

// Calculations
const totalPercentage = computed(() => {
    return props.allocation.reduce((sum, item) => sum + parseFloat(item.value.toString() || '0'), 0);
});

const remainingPercentage = computed(() => {
    let currentSum = totalPercentage.value;
    if (isEditing.value) {
        const item = props.allocation.find((a) => a.id === editingId.value);
        if (item) currentSum -= parseFloat(item.value.toString() || '0');
    }
    return parseFloat(Math.max(0, 100 - currentSum).toFixed(2));
});

// Actions
const openCreateModal = () => {
    isEditing.value = false;
    form.reset();
    form.clearErrors();
    showModal.value = true;
};

const openEditModal = (item: any) => {
    isEditing.value = true;
    editingId.value = item.id;
    form.name = item.name;
    form.value = parseFloat(item.value);
    form.clearErrors();
    showModal.value = true;
};

const submit = () => {
    const url = isEditing.value ? ziggyRoute('admin.allocation.update', { allocation: editingId.value }) : ziggyRoute('admin.allocation.store');

    const options = {
        preserveScroll: true,
        onSuccess: () => {
            showModal.value = false;
            form.reset();
        },
    };

    if (isEditing.value) {
        form.put(url, options);
    } else {
        form.post(url, options);
    }
};

const confirmDelete = (id: number) => {
    itemToDelete.value = id;
    showDeleteAlert.value = true;
};

const executeDelete = () => {
    router.delete(ziggyRoute('admin.allocation.destroy', { allocation: itemToDelete.value }), {
        preserveScroll: true,
        onSuccess: () => (showDeleteAlert.value = false),
    });
};

defineOptions({ layout: Layout });

const dropdownItems = [
    [{ label: 'New mail', icon: 'i-lucide-send', to: '/inbox' }],
    [{ label: 'New customer', icon: 'i-lucide-user-plus', to: '/customers' }],
];
</script>

<template>
    <UDashboardPanel id="home">
        <template #header>
            <UDashboardNavbar title="Home">
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
            <div class="space-y-6">
                <div class="flex items-end justify-between">
                    <div>
                        <h1 class="text-2xl font-bold">Percentage Allocations</h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Total:
                            <span :class="totalPercentage >= 100 ? 'text-red-500' : 'text-primary'" class="font-bold"> {{ totalPercentage }}% </span>
                            / 100%
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <UCard v-for="item in allocation" :key="item.id">
                        <template #header>
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold tracking-wider text-gray-500 uppercase">
                                    {{ item.name.replace(/_/g, ' ') }}
                                </span>
                                <UIcon name="i-lucide-percent" class="h-4 w-4 text-primary" />
                            </div>
                        </template>

                        <div class="my-4">
                            <h3 class="text-3xl font-black">{{ parseFloat(item.value.toString()) }}%</h3>
                        </div>

                        <template #footer>
                            <div class="flex justify-end space-x-3">
                                <UButton variant="ghost" size="xs" label="EDIT" @click="openEditModal(item)" />
                                <UButton variant="ghost" color="red" size="xs" label="DELETE" @click="confirmDelete(item.id)" />
                            </div>
                        </template>
                    </UCard>

                    <button
                        v-if="totalPercentage < 100"
                        @click="openCreateModal"
                        class="group flex min-h-[160px] flex-col items-center justify-center rounded-xl border-2 border-dashed border-gray-300 p-6 transition-all hover:border-primary hover:bg-primary/5 dark:border-gray-800"
                    >
                        <UIcon name="i-lucide-plus" class="mb-2 h-6 w-6 text-primary transition-transform group-hover:scale-110" />
                        <span class="text-sm font-medium text-gray-500 group-hover:text-primary">Add New Split</span>
                    </button>
                </div>

                <UModal
                    v-model:open="showModal"
                    :title="`${isEditing ? 'Update' : 'Create'} Allocation`"
                    description="Manage your percentage distribution split."
                >
                    <template #body>
                        <div class="space-y-4">
                            <UFormField label="Label Name" :error="form.errors.name">
                                <UInput v-model="displayName" class="w-full" placeholder="e.g. System Fee" />
                            </UFormField>

                            <UFormField :error="form.errors.value">
                                <template #label>
                                    <div class="flex w-full justify-between">
                                        <label
                                            >Percentage <span class="text-gray-400">Max Available: {{ remainingPercentage }}%</span></label
                                        >
                                    </div>
                                </template>
                                <UInput v-model="form.value" type="number" step="0.01" :max="remainingPercentage" class="w-full" />
                            </UFormField>
                        </div>
                    </template>

                    <template #footer>
                        <UButton color="neutral" variant="ghost" label="Cancel" @click="showModal = false" />
                        <UButton :loading="form.processing" class="text-white" label="Save Allocation" @click="submit" />
                    </template>
                </UModal>

                <UModal
                    v-model:open="showDeleteAlert"
                    title="Are you sure?"
                    description="This action will remove this allocation split and cannot be undone."
                >
                    <template #footer>
                        <UButton color="neutral" variant="ghost" label="Cancel" @click="showDeleteAlert = false" />
                        <UButton class="bg-red-500 text-white" label="Delete" @click="executeDelete" />
                    </template>
                </UModal>
            </div>
        </template>
    </UDashboardPanel>
</template>
