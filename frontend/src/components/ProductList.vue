<script setup>
import { ref, onMounted } from "vue";
import apiClient from "../api/axios"; // axios වෙනුවට අපේ apiClient එක import කරගන්නවා
import LoadingSpinner from "./LoadingSpinner.vue";

// products ටික store කරගන්න reactive variable එකක්
const products = ref([]);
const isLoading = ref(true); // isLoading state එකක් හදාගන්න

// මේ component එක page එකට load උන ගමන්ම මේ function එක run වෙනවා
onMounted(async () => {
  try {
    // අපේ Laravel API එකට request එක යවනවා
    // අපි හදාගත් apiClient එක හරහා request එක යවන නිසා full URL එක ඕන නෑ.
    const response = await apiClient.get("/products");
    // API එකෙන් එන data ටික products variable එකට දාගන්නවා
    products.value = response.data;
  } catch (error) {
    console.error("Error fetching products:", error);
  } finally {
    // Data load වෙලා ඉවර වුනාම (සාර්ථක වුනත්, අසාර්ථක වුනත්) isLoading false කරනවා.
    isLoading.value = false;
  }
});
</script>

<template>
  <!-- අපි මෙතනට class එකතු කරනවා -->
  <div class="container mx-auto px-4">
    <h1 class="text-4xl font-bold text-center my-8 text-gray-800">
      Our T-Shirt Collection
    </h1>
    <!-- v-if/v-else දාලා spinner එකයි content එකයි මාරු කරනවා -->
    <div v-if="isLoading" class="min-h-[50vh] flex items-center justify-center">
      <LoadingSpinner />
    </div>
    <div
      v-else-if="products.length > 0"
      class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
    >
      <router-link
        v-for="product in products"
        :key="product.id"
        :to="`/product/${product.id}`"
        class="group"
      >
        <div
          class="bg-white rounded-lg shadow-md overflow-hidden transform hover:-translate-y-2 transition-all duration-300"
        >
          <img
            :src="product.image_url"
            :alt="product.name"
            class="w-full h-64 object-cover"
          />
          <div class="p-4">
            <h2 class="text-xl font-semibold text-gray-900 truncate">
              {{ product.name }}
            </h2>
            <p class="text-gray-600 mt-1">Color: {{ product.color }}</p>
            <p class="text-lg font-bold text-gray-800 mt-2">
              Rs. {{ product.price }}
            </p>
          </div>
        </div>
      </router-link>
    </div>
    <div v-else class="text-center py-10 text-xl text-gray-500">
      <p>No products found at the moment. Please check back later!</p>
    </div>
  </div>
</template>
