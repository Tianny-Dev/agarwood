<script setup lang="ts">
import { store } from '@/actions/App/Http/Controllers/Auth/LoginController';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { register } from '@/routes';
import { request } from '@/routes/password';
import { Head, useForm } from '@inertiajs/vue3';

const showPassword = ref(false);

const form = useForm({
    email: null,
    password: null,
});

function submit() {
    form.submit(store());
}

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();
</script>

<template>
    <Head title="Register" />

    <AuthLayout>
        <h2 class="mb-4 text-center text-2xl font-semibold">Login to your account</h2>

        <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div class="grid gap-6">
                <UFormField name="email" :error="form.errors.email" label="Email address">
                    <UInput v-model="form.email" type="email" class="w-full" autocomplete="email" placeholder="email@example.com" required />
                </UFormField>

                <UFormField name="password" :error="form.errors.password" label="Password">
                    <UInput
                        v-model="form.password"
                        class="w-full"
                        :type="showPassword ? 'text' : 'password'"
                        autocomplete="new-password"
                        placeholder="Password"
                        :ui="{ trailing: 'pe-1' }"
                        required
                    >
                        <template #trailing>
                            <UButton
                                color="neutral"
                                variant="link"
                                size="sm"
                                :icon="showPassword ? 'i-lucide-eye-off' : 'i-lucide-eye'"
                                :aria-label="showPassword ? 'Hide password' : 'Show password'"
                                :aria-pressed="showPassword"
                                @click="showPassword = !showPassword"
                            />
                        </template>
                    </UInput>
                    <template #hint>
                        <TextLink v-if="canResetPassword" :href="request()" class="text-sm text-primary" :tabindex="5"> Forgot password? </TextLink>
                    </template>
                </UFormField>

                <UButton :loading="form.processing" type="submit" block class="mt-4">Log in</UButton>
            </div>
        </form>

        <p class="mt-4 text-center text-sm text-gray-600">
            Don't have an account?
            <TextLink :href="register()" class="text-sm font-medium text-primary">Register</TextLink>
        </p>
    </AuthLayout>
</template>
