<script setup>
import TheNavbar from "../components/TheNavbar.vue";
import TheFooter from "../components/TheFooter.vue";
</script>

<template>
  <div class="flex flex-col min-h-screen">
    <TheNavbar />

    <!-- Page content will be injected here -->
    <main class="flex-grow">
      <router-view />
    </main>

    <TheFooter />
  </div>
</template>

<style>
/* Global styles can go here if needed */
</style>
