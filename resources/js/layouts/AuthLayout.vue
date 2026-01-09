<template>
  <div class="relative min-h-screen flex items-center justify-center px-4 py-12 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-950">
    <!-- Background -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div class="absolute -top-40 -right-40 w-80 h-80 bg-primary-200/30 dark:bg-primary-800/20 rounded-full blur-3xl"></div>
      <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-blue-200/30 dark:bg-blue-800/20 rounded-full blur-3xl"></div>
    </div>

    <div class="relative w-full max-w-md">
      <!-- Logo -->
      <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-primary-600 dark:bg-primary-500 rounded-2xl mb-4 shadow-lg shadow-primary-500/30">
          <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
          </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">AGARWOOD</h1>
        <!-- <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Secure authentication portal</p> -->
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
