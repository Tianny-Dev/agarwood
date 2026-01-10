<script setup lang="ts">
import { store } from '@/actions/App/Http/Controllers/Auth/PasswordResetLinkController';
import TextLink from '@/components/TextLink.vue';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { login } from '@/routes';
import { Head, useForm } from '@inertiajs/vue3';

defineProps<{
    status?: string;
}>();

const form = useForm({
    email: null,
});

function submit() {
    form.submit(store());
}
</script>

<template>
    <Head title="Forgot password" />

    <AuthLayout>
        <h2 class="mb-4 text-center text-2xl font-semibold">Forgot password</h2>
        <p class="text-muted-foreground mb-6 text-center text-sm">Enter your email to receive a password reset link</p>

        <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <div class="space-y-6">
            <form @submit.prevent="submit" class="flex flex-col gap-6">
                <div class="grid gap-6">
                    <UFormField name="email" :error="form.errors.email" label="Email address">
                        <UInput v-model="form.email" type="email" class="w-full" autocomplete="email" placeholder="email@example.com" required />
                    </UFormField>

                    <UButton :loading="form.processing" type="submit" block class="mt-4">Email Password Reset Link</UButton>
                </div>
            </form>

            <div class="text-muted-foreground space-x-1 text-center text-sm">
                <span class="text-muted">Or, return to</span>
                <TextLink :href="login()" class="text-sm font-medium text-primary">Log in</TextLink>
            </div>
        </div>
    </AuthLayout>
</template>
