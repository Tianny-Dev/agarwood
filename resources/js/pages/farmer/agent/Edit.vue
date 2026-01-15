<script setup lang="ts">
import Layout from '@/layouts/AppLayout.vue';
import type { Agent, AppPageProps } from '@/types';
import { useForm, usePage } from '@inertiajs/vue3';
import { reactive } from 'vue';

defineOptions({ layout: Layout });
const toast = useToast();

const { props } = usePage<AppPageProps & { agent: Agent }>();
const agent = props.agent;

const form = useForm({
    first_name: agent.user?.first_name ?? '',
    middle_name: agent.user?.middle_name ?? '',
    last_name: agent.user?.last_name ?? '',
    username: agent.user?.username ?? '',
    email: agent.user?.email ?? '',
    phone_number: agent.user?.phone_number ?? '',
    birthday: agent.user?.birthday ? new Date(agent.user.birthday).toISOString().substring(0, 10) : '',
    gender: agent.user?.gender ?? '',
    civil_status: agent.user?.civil_status ?? '',
    address: agent.user?.address ?? '',
    password: '',
    password_confirmation: '',
});

const showPasswordFields = reactive({
    password: false,
    password_confirmation: false,
});

const genders = ['male', 'female', 'other'];
const civilStatusOptions = ['single', 'married', 'widowed', 'separated', 'divorced'];

function submit() {
    form.put(`/farmer/agents/${agent.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            toast.add({
                title: 'Agent updated',
                description: 'The agent information has been successfully updated.',
                icon: 'i-lucide-check-circle',
                duration: 4000,
            });
        },
    });
}
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
            <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-2xl font-semibold">Edit Agent</h2>
                <UButton :href="`/farmer/agents`" variant="outline" icon="i-lucide-arrow-left" size="sm">Back</UButton>
            </div>

            <div class="mx-auto w-full max-w-7xl">
                <form @submit.prevent="submit" class="flex flex-col gap-8">
                    <!-- Full Name -->
                    <UFormField label="First Name" :error="form.errors.first_name">
                        <UInput class="w-full" v-model="form.first_name" placeholder="Juan" />
                    </UFormField>

                    <UFormField label="Middle Name" :error="form.errors.middle_name">
                        <UInput class="w-full" v-model="form.middle_name" placeholder="Optional" />
                    </UFormField>

                    <UFormField label="Last Name" :error="form.errors.last_name">
                        <UInput class="w-full" v-model="form.last_name" placeholder="Cruz" />
                    </UFormField>

                    <!-- Account Info -->
                    <UFormField label="Username" :error="form.errors.username">
                        <UInput class="w-full" v-model="form.username" placeholder="juancruz" />
                    </UFormField>

                    <UFormField label="Email" :error="form.errors.email">
                        <UInput class="w-full" v-model="form.email" type="email" placeholder="juan@example.com" />
                    </UFormField>

                    <!-- Contact Info -->
                    <UFormField label="Phone Number" :error="form.errors.phone_number">
                        <UInput class="w-full" v-model="form.phone_number" placeholder="09123456789" />
                    </UFormField>

                    <UFormField label="Birthday" :error="form.errors.birthday">
                        <UInput class="w-full" v-model="form.birthday" type="date" />
                    </UFormField>

                    <UFormField label="Gender" :error="form.errors.gender">
                        <USelect class="w-full" v-model="form.gender" :options="genders" placeholder="Select gender" />
                    </UFormField>

                    <UFormField label="Civil Status" :error="form.errors.civil_status">
                        <USelect class="w-full" v-model="form.civil_status" :options="civilStatusOptions" placeholder="Select status" />
                    </UFormField>

                    <!-- Address -->
                    <UFormField label="Address" :error="form.errors.address">
                        <UInput class="w-full" v-model="form.address" placeholder="123 Street, City" />
                    </UFormField>

                    <!-- Password -->
                    <UFormField label="New Password" :error="form.errors.password">
                        <UInput
                            class="w-full"
                            v-model="form.password"
                            :type="showPasswordFields.password ? 'text' : 'password'"
                            placeholder="Enter new password"
                        >
                            <template #trailing>
                                <UButton
                                    color="neutral"
                                    variant="link"
                                    size="sm"
                                    :icon="showPasswordFields.password ? 'i-lucide-eye-off' : 'i-lucide-eye'"
                                    @click="showPasswordFields.password = !showPasswordFields.password"
                                />
                            </template>
                        </UInput>
                    </UFormField>

                    <UFormField label="Confirm Password" :error="form.errors.password_confirmation">
                        <UInput
                            class="w-full"
                            v-model="form.password_confirmation"
                            :type="showPasswordFields.password_confirmation ? 'text' : 'password'"
                            placeholder="Confirm new password"
                        >
                            <template #trailing>
                                <UButton
                                    color="neutral"
                                    variant="link"
                                    size="sm"
                                    :icon="showPasswordFields.password_confirmation ? 'i-lucide-eye-off' : 'i-lucide-eye'"
                                    @click="showPasswordFields.password_confirmation = !showPasswordFields.password_confirmation"
                                />
                            </template>
                        </UInput>
                    </UFormField>

                    <!-- Submit -->
                    <div class="flex justify-end">
                        <UButton type="submit" color="primary" :loading="form.processing">Update Agent</UButton>
                    </div>
                </form>
            </div>
        </template>
    </UDashboardPanel>
</template>
