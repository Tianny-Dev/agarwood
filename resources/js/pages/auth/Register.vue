<script setup lang="ts">
import { useForm, Link, Head } from '@inertiajs/vue3'
import AuthLayout from '@/layouts/AuthLayout.vue';
import { store } from '@/actions/App/Http/Controllers/Auth/RegisterController'

const showPassword = ref(false)
const showPasswordConfirmation = ref(false)

const form = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
})

function submit() {
    form.submit(store())
}
</script>

<template>
    <Head title="Register" />

    <AuthLayout>
        <h2 class="text-2xl font-semibold text-center mb-4">Create an account</h2>
        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div class="grid gap-6">
                <UFormField name="name" :error="form.errors.name" label="Name">
                    <UInput v-model="form.name" type="name" class="w-full" autocomplete="name" placeholder="Juan Delacruz" autofocus required />
                </UFormField>

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

                <UFormField
                  name="password_confirmation"
                  :error="form.errors.password_confirmation"
                  label="Confirm Password"
                >
                  <UInput
                    v-model="form.password_confirmation"
                    class="w-full"
                    :type="showPasswordConfirmation ? 'text' : 'password'"
                    autocomplete="new-password"
                    placeholder="Confirm Password"
                    :ui="{ trailing: 'pe-1' }"
                    required
                  >
                    <template #trailing>
                      <UButton
                        color="neutral"
                        variant="link"
                        size="sm"
                        :icon="showPasswordConfirmation ? 'i-lucide-eye-off' : 'i-lucide-eye'"
                        :aria-label="showPasswordConfirmation ? 'Hide password' : 'Show password'"
                        :aria-pressed="showPasswordConfirmation"
                        @click="showPasswordConfirmation = !showPasswordConfirmation"
                      />
                    </template>
                  </UInput>
                </UFormField>

                <UButton :loading="form.processing" type="submit" block class="mt-4">Log in</UButton>
            </div>
        </form>

        <p class="mt-4 text-center text-sm text-gray-600">
            Already have an account?
            <Link href="/login" class="text-blue-500 hover:underline">Login</Link>
        </p>
    </AuthLayout>
</template>
