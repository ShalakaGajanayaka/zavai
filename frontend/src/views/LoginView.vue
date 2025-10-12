<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import { useAuthStore } from "../stores/auth";

const authStore = useAuthStore();
const router = useRouter();

const email = ref("admin@example.com");
const password = ref("password");
const errorMessage = ref("");

async function handleLogin() {
  errorMessage.value = "";
  const success = await authStore.login(email.value, password.value);
  if (success) {
    router.push("/admin/products");
  } else {
    errorMessage.value = "Invalid email or password.";
  }
}
</script>

<template>
  <div class="flex items-center justify-center min-h-[60vh]">
    <div class="w-full max-w-md">
      <form
        @submit.prevent="handleLogin"
        class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"
      >
        <h1 class="text-2xl font-bold text-center mb-6">Admin Login</h1>
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="email"
            >Email</label
          >
          <input
            v-model="email"
            type="email"
            id="email"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            required
          />
        </div>
        <div class="mb-6">
          <label
            class="block text-gray-700 text-sm font-bold mb-2"
            for="password"
            >Password</label
          >
          <input
            v-model="password"
            type="password"
            id="password"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
            required
          />
        </div>
        <p v-if="errorMessage" class="text-red-500 text-xs italic mb-4">
          {{ errorMessage }}
        </p>
        <div class="flex items-center justify-between">
          <button
            type="submit"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
          >
            Sign In
          </button>
        </div>
      </form>
    </div>
  </div>
</template>
