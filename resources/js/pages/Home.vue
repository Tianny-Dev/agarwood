<script setup lang="ts">
import GuestLayout from '@/layouts/GuestLayout.vue';
import { login, register } from '@/routes';
import { index as dashboard } from '@/routes/dashboard'
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Home" />
    <GuestLayout>
        <div class="min-h-full flex items-center justify-center ">
            <div class="max-w-md w-full rounded-lg p-8 text-center">
                <h1 class="text-3xl font-bold mb-4 text-gray-800">Welcome</h1>
                <p class="text-gray-600 mb-6">Hello, welcome to Agarwood!</p>
                <div class="flex gap-2">
                    <Link
                        v-if="$page.props.auth.user"
                        :href="dashboard()"
                        class="inline-block w-full bg-amber-950 text-white font-medium py-2 px-4 rounded hover:bg-amber-900 transition"
                    >
                        Dashboard
                    </Link>

                    <template v-else>
                        <Link
                            :href="login()"
                            class="inline-block w-full bg-amber-950 text-white font-medium py-2 px-4 rounded hover:bg-amber-900 transition"
                        >
                            Login
                        </Link>
                        <Link
                            :href="register()"
                            class="inline-block w-full bg-amber-950 text-white font-medium py-2 px-4 rounded hover:bg-amber-900 transition"
                        >
                            Register
                        </Link>
                    </template>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
