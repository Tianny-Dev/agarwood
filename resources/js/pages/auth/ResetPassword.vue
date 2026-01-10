<script setup lang="ts">
import NewPasswordController from '@/actions/App/Http/Controllers/Auth/NewPasswordController';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { Form, Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps<{
    token: string;
    email: string;
}>();

const inputEmail = ref(props.email);
</script>

<template>
    <Head title="Reset password" />

    <AuthLayout>
        <h2 class="mb-4 text-center text-2xl font-semibold">Reset password</h2>

        <div class="space-y-6">
            <Form
                v-bind="NewPasswordController.store.form()"
                :transform="(data) => ({ ...data, token, email })"
                :reset-on-success="['password', 'password_confirmation']"
                class="flex flex-col gap-6"
                v-slot="{ errors, processing }"
            >
                <div class="grid gap-6">
                    <UFormField name="email" :error="errors.email" label="Email">
                        <UInput type="email" class="w-full" autocomplete="email" readonly v-model="inputEmail" />
                    </UFormField>

                    <UFormField name="password" :error="errors.password" label="New Password">
                        <UInput type="password" class="w-full" autocomplete="new-password" placeholder="Password" required />
                    </UFormField>

                    <UFormField name="password_confirmation" :error="errors.password_confirmation" label="Confirm Password">
                        <UInput type="password" class="w-full" autocomplete="new-password" placeholder="Confirm password" required />
                    </UFormField>

                    <UButton :loading="processing" type="submit" block class="mt-4">Confirm Password</UButton>
                </div>
            </Form>
        </div>
    </AuthLayout>
</template>
