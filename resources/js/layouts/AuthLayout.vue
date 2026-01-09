<script setup lang="ts">
import ApplicationLogo from '@/components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';

</script>

<template>
  <div class="relative min-h-screen flex items-center justify-center px-4 py-12 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-950">
    <!-- Background -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div class="absolute -top-40 -right-40 w-80 h-80 bg-primary-200/30 dark:bg-primary-800/20 rounded-full blur-3xl"></div>
      <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-blue-200/30 dark:bg-blue-800/20 rounded-full blur-3xl"></div>
    </div>

    <div class="relative w-full max-w-md">
      <!-- Logo -->
      <div class="text-center mb-2">
        <div class="inline-flex items-center justify-center">
            <Link href="/">
                <ApplicationLogo class="h-20 w-auto" />
            </Link>
        </div>
      </div>

      <!-- Card -->
      <UCard
        :ui="{
          base: 'overflow-hidden',
          background: 'bg-white dark:bg-gray-900',
          ring: 'ring-1 ring-gray-200 dark:ring-gray-800',
          shadow: 'shadow-xl',
        }"
      >
        <slot />
      </UCard>

      <!-- Footer -->
      <div class="text-center mt-6 text-sm text-gray-600 dark:text-gray-400">
        <p>© {{ new Date().getFullYear() }} Agarwood. All rights reserved.</p>
      </div>
    </div>
  </div>
</template>
