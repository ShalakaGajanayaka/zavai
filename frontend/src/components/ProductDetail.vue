<script setup>
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import axios from "axios";
import { useCartStore } from "../stores/cart";
import LoadingSpinner from "./LoadingSpinner.vue";

const route = useRoute(); // URL එකේ තියෙන data ගන්න
const product = ref(null); // තනි product එකේ data තියාගන්න
const isLoading = ref(true);
const cartStore = useCartStore();

onMounted(async () => {
  const productId = route.params.id;
  try {
    const response = await axios.get(
      `http://127.0.0.1:8000/api/products/${productId}`
    );
    product.value = response.data;
  } catch (error) {
    console.error("Error fetching product details:", error);
  } finally {
    isLoading.value = false; // Data load වෙලා ඉවර වුනාම false කරනවා
  }
});

function handleAddToCart() {
  if (product.value) {
    cartStore.addToCart(product.value);
    alert(`${product.value.name} was added to the cart!`); // Simple feedback
  }
}
</script>

<template>
  <div>
    <router-link to="/">&larr; Back to Products</router-link>
    <div v-if="isLoading">
      <LoadingSpinner />
    </div>
    <div v-else-if="product" class="mt-6 flex flex-col md:flex-row gap-8">
      <img
        :src="product.image_url"
        :alt="product.name"
        class="product-detail-image"
      />
      <div class="product-info">
        <h1>{{ product.name }}</h1>
        <p class="price">Rs. {{ product.price }}</p>
        <p class="description">{{ product.description }}</p>
        <p class="color"><strong>Color:</strong> {{ product.color }}</p>
        <button @click="handleAddToCart" class="add-to-cart-btn">
          Add to Cart
        </button>
      </div>
    </div>
    <div v-else class="text-center py-10 text-xl text-red-500">
      Sorry, the product could not be found.
    </div>
  </div>
</template>

<style scoped>
.loading {
  text-align: center;
  padding: 50px;
  font-size: 1.5em;
}
.product-detail {
  display: flex;
  gap: 30px;
  margin-top: 20px;
  background: white;
  padding: 30px;
  border-radius: 8px;
}
.product-detail-image {
  max-width: 400px;
  border-radius: 8px;
}
.product-info h1 {
  margin-top: 0;
}
.price {
  font-size: 2em;
  font-weight: bold;
  color: #3498db;
}
.add-to-cart-btn {
  padding: 15px 30px;
  font-size: 1em;
  background-color: #2ecc71;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  margin-top: 20px;
}
</style>
