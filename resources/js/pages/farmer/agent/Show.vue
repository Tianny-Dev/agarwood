<script setup lang="ts">
import Layout from '@/layouts/AppLayout.vue';
import type { Agent, AppPageProps } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { resolveComponent } from 'vue';

defineOptions({ layout: Layout });

// ---------------- Components ----------------
const UAvatar = resolveComponent('UAvatar');
const UBadge = resolveComponent('UBadge');
const UButton = resolveComponent('UButton');

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
</script>

<template>
    <div class="mx-auto max-w-4xl space-y-8 p-6">
        <!-- Header -->
        <div class="flex items-center gap-6">
            <UAvatar
                :src="agent.user?.avatar"
                :text="!agent.user?.avatar ? getInitials(agent.user) : undefined"
                size="2xl"
                class="bg-primary text-white"
            />
            <div>
                <h1 class="text-3xl font-bold">{{ agent.user?.name ?? 'Unknown User' }}</h1>
                <p class="text-muted">@{{ agent.user?.username ?? 'N/A' }}</p>
                <UBadge :color="agent.is_verified ? 'success' : 'error'" variant="subtle" class="mt-2 inline-block">
                    {{ agent.is_verified ? 'Verified Agent' : 'Unverified Agent' }}
                </UBadge>
            </div>
        </div>

        <!-- Agent Details Grid -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Agent Code -->
            <div>
                <p class="text-sm text-muted">Agent Code</p>
                <p class="font-medium">{{ agent.agent_code }}</p>
            </div>

            <!-- Email -->
            <div>
                <p class="text-sm text-muted">Email</p>
                <p class="font-medium">{{ agent.user?.email ?? 'N/A' }}</p>
            </div>

            <!-- Phone Number -->
            <div>
                <p class="text-sm text-muted">Phone Number</p>
                <p class="font-medium">{{ agent.user?.phone_number ?? 'N/A' }}</p>
            </div>

            <!-- Birthday -->
            <div>
                <p class="text-sm text-muted">Birthday</p>
                <p class="font-medium">{{ formatDate(agent.user?.birthday) }}</p>
            </div>

            <!-- Gender -->
            <div>
                <p class="text-sm text-muted">Gender</p>
                <p class="font-medium capitalize">{{ agent.user?.gender ?? 'N/A' }}</p>
            </div>

            <!-- Civil Status -->
            <div>
                <p class="text-sm text-muted">Civil Status</p>
                <p class="font-medium capitalize">{{ agent.user?.civil_status ?? 'N/A' }}</p>
            </div>

            <!-- Address -->
            <div class="sm:col-span-2 lg:col-span-3">
                <p class="text-sm text-muted">Address</p>
                <p class="font-medium">{{ agent.user?.address ?? 'N/A' }}</p>
            </div>

            <!-- Verification Info -->
            <div>
                <p class="text-sm text-muted">Email Verified At</p>
                <p class="font-medium">{{ formatDate(agent.user?.email_verified_at) }}</p>
            </div>

            <div>
                <p class="text-sm text-muted">Phone Verified At</p>
                <p class="font-medium">{{ formatDate(agent.user?.phone_number_verified_at) }}</p>
            </div>

            <div>
                <p class="text-sm text-muted">Joined</p>
                <p class="font-medium">{{ formatDate(agent.user?.created_at) }}</p>
            </div>
        </div>

        <!-- QR Code -->
        <div v-if="agent.qr_code_path" class="mt-6 flex flex-col items-start gap-2">
            <p class="text-sm text-muted">QR Code</p>
            <img :src="agent.qr_code_path" alt="Agent QR Code" class="h-32 w-32 rounded-md border" />
        </div>

        <!-- Actions -->
        <div class="mt-6 flex justify-end gap-3">
            <UButton :href="`/farmer/agents/${agent.id}/edit`" color="primary">Edit</UButton>
            <UButton :href="`/farmer/agents`" variant="outline">Back</UButton>
        </div>
    </div>
</template>
