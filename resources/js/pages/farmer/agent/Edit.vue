<script setup lang="ts">
import type { Agent, AppPageProps } from '@/types';
import { useForm, usePage } from '@inertiajs/vue3';

const { props } = usePage<AppPageProps & { agent: Agent }>();

const form = useForm({
    first_name: props.agent.user.first_name,
    middle_name: props.agent.user.middle_name,
    last_name: props.agent.user.last_name,
    username: props.agent.user.username,
    email: props.agent.user.email,
    phone_number: props.agent.user.phone_number,
    birthday: props.agent.user.birthday,
    gender: props.agent.user.gender,
    address: props.agent.user.address,
    civil_status: props.agent.user.civil_status,
    password: '',
    password_confirmation: '',
    is_verified: props.agent.is_verified,
});

const genders = ['male', 'female', 'other'];
const civilStatusOptions = ['single', 'married', 'widowed', 'divorced'];

function submit() {
    form.put(`/farmer/agents/${props.agent.id}`, {
        onSuccess: () => {
            console.log('Agent updated');
        },
    });
}
</script>

<template>
    <div class="w-full max-w-lg p-4">
        <h2 class="mb-4 text-lg font-semibold">Edit Agent</h2>
        <form @submit.prevent="submit" class="space-y-4">
            <!-- Name fields -->
            <div class="flex gap-2">
                <UInput v-model="form.first_name" label="First Name" :error="form.errors.first_name" />
                <UInput v-model="form.middle_name" label="Middle Name" :error="form.errors.middle_name" />
                <UInput v-model="form.last_name" label="Last Name" :error="form.errors.last_name" />
            </div>

            <!-- Username / Email -->
            <div class="flex gap-2">
                <UInput v-model="form.username" label="Username" :error="form.errors.username" />
                <UInput v-model="form.email" label="Email" type="email" :error="form.errors.email" />
            </div>

            <!-- Phone / Birthday -->
            <div class="flex gap-2">
                <UInput v-model="form.phone_number" label="Phone Number" :error="form.errors.phone_number" />
                <UInput v-model="form.birthday" label="Birthday" type="date" :error="form.errors.birthday" />
            </div>

            <!-- Gender / Civil Status -->
            <div class="flex gap-2">
                <USelect v-model="form.gender" :options="genders" label="Gender" :error="form.errors.gender" />
                <USelect v-model="form.civil_status" :options="civilStatusOptions" label="Civil Status" :error="form.errors.civil_status" />
            </div>

            <!-- Address -->
            <UInput v-model="form.address" label="Address" :error="form.errors.address" />

            <!-- Password -->
            <div class="flex gap-2">
                <UInput v-model="form.password" type="password" label="New Password" :error="form.errors.password" />
                <UInput v-model="form.password_confirmation" type="password" label="Confirm Password" :error="form.errors.password_confirmation" />
            </div>

            <!-- Verified toggle (optional) -->
            <div class="flex items-center gap-2">
                <UCheckbox v-model="form.is_verified" label="Verified" />
            </div>

            <!-- Submit -->
            <div class="flex justify-end">
                <UButton type="submit" color="primary">Update Agent</UButton>
            </div>
        </form>
    </div>
</template>
