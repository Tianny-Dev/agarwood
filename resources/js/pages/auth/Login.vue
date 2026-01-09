<script setup lang="ts">
import { useForm, Link, Head } from '@inertiajs/vue3'
import AuthLayout from '@/layouts/AuthLayout.vue';
import { store } from '@/actions/App/Http/Controllers/Auth/LoginController'

const showPassword = ref(false)

const form = useForm({
    email: null,
    password: null,
})

function submit() {
    form.submit(store())
}
</script>

<template>
    <Head title="Register" />

    <AuthLayout>
        <h2 class="text-2xl font-semibold text-center mb-4">Login to your account</h2>
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
                </UFormField>

                <UButton :loading="form.processing" type="submit" block class="mt-4">Log in</UButton>
            </div>
        </form>

        <p class="mt-4 text-center text-sm text-gray-600">
            Don't have an account?
            <Link href="/register" class="text-blue-500 hover:underline">Register</Link>
        </p>
    </AuthLayout>
</template>
