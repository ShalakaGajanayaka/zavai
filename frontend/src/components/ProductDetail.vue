<script setup>
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import apiClient from "../api/axios"; // axios වෙනුවට apiClient import කරගන්නවා
import { useCartStore } from "../stores/cart";
import LoadingSpinner from "./LoadingSpinner.vue";

const route = useRoute(); // URL එකේ තියෙන data ගන්න
const product = ref(null); // තනි product එකේ data තියාගන්න
const isLoading = ref(true);
const cartStore = useCartStore();

onMounted(async () => {
  const productId = route.params.id;
  try {
    const response = await apiClient.get(`/products/${productId}`); // apiClient පාවිච්චි කරනවා
    product.value = response.data;
  } catch (error) {
    console.error("Error fetching product details:", error);
    // 404 error එකක් ආවොත් product එක null විදිහට තියෙනවා
  } finally {
    isLoading.value = false; // Data load වෙලා ඉවර වුනාම false කරනවා
  }
});

function handleAddToCart() {
  if (product.value) {
    cartStore.addToCart(product.value);
    // අපි පස්සේ මේ alert එක වෙනුවට ලස්සන notification එකක් දාමු
    alert(`${product.value.name} was added to the cart!`);
  }
}
</script>

<template>
  <div class="container mx-auto p-4 md:p-8">
    <router-link
      to="/"
      class="inline-block mb-6 text-blue-600 hover:underline"
      >&larr; Back to Products</router-link
    >
    <div
      v-if="isLoading"
      class="min-h-[50vh] flex items-center justify-center"
    >
      <LoadingSpinner />
    </div>
    <div
      v-else-if="product"
      class="bg-white p-6 rounded-lg shadow-lg grid grid-cols-1 md:grid-cols-2 gap-8"
    >
      <!-- Image Column -->
      <div>
        <img
          :src="product.image_url"
          :alt="product.name"
          class="w-full h-auto object-cover rounded-md"
        />
      </div>
      <!-- Details Column -->
      <div class="flex flex-col justify-center">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-800">
          {{ product.name }}
        </h1>
        <p class="text-3xl font-light text-gray-700 my-3">
          Rs. {{ product.price }}
        </p>
        <p class="text-gray-600 leading-relaxed">{{ product.description }}</p>
        <p class="text-gray-600 mt-4">
          <strong>Color:</strong> {{ product.color }}
        </p>
        <button
          @click="handleAddToCart"
          class="mt-6 w-full md:w-auto bg-blue-600 text-white font-bold py-3 px-8 rounded-lg hover:bg-blue-700 transition-colors duration-300"
        >
          Add to Cart
        </button>
      </div>
    </div>
    <div v-else class="text-center py-10 text-xl text-red-500">
      Sorry, the product could not be found.
    </div>
  </div>
</template>
