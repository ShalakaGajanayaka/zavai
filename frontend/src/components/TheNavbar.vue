<template>
  <nav class="bg-white shadow-md">
    <div class="container mx-auto px-6 py-3">
      <div class="flex items-center justify-between">
        <!-- Brand Logo -->
        <div class="text-xl font-semibold text-gray-700">
          <router-link to="/" class="text-gray-800 hover:text-blue-500">
            ZAVAI
            <!-- ඔයාගේ Brand එකේ නම මෙතනට දාන්න -->
          </router-link>
        </div>

        <!-- Primary Nav -->
        <div class="hidden md:flex items-center space-x-4">
          <router-link to="/" class="text-gray-600 hover:text-blue-500"
            >T-Shirts</router-link
          >
          <a href="#" class="text-gray-400 cursor-not-allowed">Shorts</a>
          <a href="#" class="text-gray-400 cursor-not-allowed">Kids</a>
        </div>

        <!-- Secondary Nav (Cart Icon) -->
        <div>
          <a href="#" class="text-gray-600 hover:text-blue-500">
            <!-- Shopping Cart Icon -->
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-6 w-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
              />
            </svg>
          </a>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup>
// No script needed for now
</script>

<style scoped>
/* We are using Tailwind, so no extra styles are needed here! */
</style>
