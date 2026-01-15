<script setup lang="ts">
import Layout from '@/layouts/AppLayout.vue';
import type { Agent, AppPageProps } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { resolveComponent } from 'vue';

defineOptions({ layout: Layout });
// const toast = useToast();

// ---------------- Components ----------------
const UAvatar = resolveComponent('UAvatar');
const UBadge = resolveComponent('UBadge');
const UButton = resolveComponent('UButton');
const UCard = resolveComponent('UCard');

// ---------------- Props ----------------
type ShowPageProps = AppPageProps & { agent: Agent };
const { props } = usePage<ShowPageProps>();
const agent = props.agent;

// ---------------- Helpers ----------------
const df = new Intl.DateTimeFormat('en-US', { dateStyle: 'long' });

function getInitials(user?: Agent['user']) {
    if (!user) return '';
    return `${user.first_name?.[0] ?? ''}${user.last_name?.[0] ?? ''}`.toUpperCase();
}

function formatDate(date?: string | Date | null) {
    if (!date) return 'N/A';
    const d = typeof date === 'string' ? new Date(date) : date;
    return df.format(d);
}

// ---------------- Delete Modal ----------------
// const modalOpen = ref(false);

// function openDeleteModal() {
//     modalOpen.value = true;
// }

// function closeModal() {
//     modalOpen.value = false;
// }

// function deleteAgent() {
//     router.delete(`/super-admin/agents/${agent.id}`, {
//         preserveScroll: true,
//         preserveState: false,
//         onSuccess: () => {
//             toast.add({
//                 title: 'Agent deleted',
//                 description: `Agent ${agent.user?.name} has been deleted successfully.`,
//                 icon: 'i-lucide-trash',
//                 duration: 4000,
//             });
//         },
//     });
// }
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
            <div class="w-full space-y-6 px-4 py-6 sm:px-6 lg:px-8">
                <!-- Profile Header -->
                <UCard>
                    <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center gap-4">
                            <UAvatar
                                :src="agent.user?.avatar"
                                :text="!agent.user?.avatar ? getInitials(agent.user) : undefined"
                                size="3xl"
                                class="bg-primary text-white"
                            />

                            <div class="space-y-1">
                                <h1 class="text-xl leading-tight font-semibold sm:text-2xl">
                                    {{ agent.user?.name ?? 'Unknown User' }}
                                </h1>

                                <p class="text-sm text-muted">@{{ agent.user?.username ?? 'N/A' }}</p>

                                <UBadge :color="agent.is_verified ? 'success' : 'error'" variant="subtle" class="mt-1">
                                    {{ agent.is_verified ? 'Verified Agent' : 'Unverified Agent' }}
                                </UBadge>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <!-- <UButton :href="`/super-admin/agents/${agent.id}/edit`" color="primary" icon="i-lucide-pencil"> Edit Profile </UButton>

                            <UButton color="error" variant="outline" icon="i-lucide-trash" @click="openDeleteModal"> Delete </UButton> -->

                            <UButton :href="`/super-admin/agents`" variant="outline" icon="i-lucide-arrow-left"> Back </UButton>
                        </div>
                    </div>
                </UCard>

                <!-- Details -->
                <UCard>
                    <template #header>
                        <h2 class="text-base font-medium">Agent Information</h2>
                    </template>

                    <dl class="grid grid-cols-1 gap-x-6 gap-y-5 sm:grid-cols-2 lg:grid-cols-3">
                        <div>
                            <dt class="text-sm text-muted">Agent Code</dt>
                            <dd class="mt-1 font-medium">{{ agent.agent_code }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm text-muted">Email</dt>
                            <dd class="mt-1 font-medium">{{ agent.user?.email ?? 'N/A' }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm text-muted">Phone Number</dt>
                            <dd class="mt-1 font-medium">{{ agent.user?.phone_number ?? 'N/A' }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm text-muted">Birthday</dt>
                            <dd class="mt-1 font-medium">
                                {{ formatDate(agent.user?.birthday) }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm text-muted">Gender</dt>
                            <dd class="mt-1 font-medium capitalize">
                                {{ agent.user?.gender ?? 'N/A' }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm text-muted">Civil Status</dt>
                            <dd class="mt-1 font-medium capitalize">
                                {{ agent.user?.civil_status ?? 'N/A' }}
                            </dd>
                        </div>

                        <div class="sm:col-span-2 lg:col-span-3">
                            <dt class="text-sm text-muted">Address</dt>
                            <dd class="mt-1 font-medium">
                                {{ agent.user?.address ?? 'N/A' }}
                            </dd>
                        </div>
                    </dl>
                </UCard>

                <!-- QR Code -->
                <UCard v-if="agent.qr_code_path">
                    <template #header>
                        <h2 class="text-base font-medium">Agent QR Code</h2>
                    </template>

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                        <img :src="agent.qr_code_path" alt="Agent QR Code" class="h-32 w-32 rounded-lg border bg-white p-2" />

                        <p class="max-w-md text-sm text-muted">Scan this QR code to quickly identify or verify this agent.</p>
                    </div>
                </UCard>
            </div>
        </template>
    </UDashboardPanel>
    <!-- <UModal title="Delete Agent" v-model:open="modalOpen">
        <template #body>
            <p>
                Are you sure you want to delete
                <strong>{{ agent.user?.name ?? 'this agent' }}</strong
                >?
            </p>
            <p class="text-sm text-muted">This action cannot be undone.</p>

            <div class="mt-4 flex justify-end gap-2">
                <UButton color="neutral" variant="outline" @click="closeModal">Cancel</UButton>
                <UButton color="error" @click="deleteAgent">Delete</UButton>
            </div>
        </template>
    </UModal> -->
</template>
