<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

// products ටික store කරගන්න reactive variable එකක්
const products = ref([]);

// මේ component එක page එකට load උන ගමන්ම මේ function එක run වෙනවා
onMounted(async () => {
  try {
    // අපේ Laravel API එකට request එක යවනවා
    // Laravel project එක run වෙන port එක බලලා මෙතනට දාන්න (සාමාන්‍යයෙන් 8000)
    const response = await axios.get('http://127.0.0.1:8000/api/products');
    // API එකෙන් එන data ටික products variable එකට දාගන්නවා
    products.value = response.data;
  } catch (error) {
    console.error('Error fetching products:', error);
  }
});
</script>

<template>
  <div class="product-gallery">
    <h1>Our T-Shirt Collection</h1>
    <div class="product-grid">
      <!-- v-for එකෙන් products array එකේ තියෙන එකින් එක අරන් පෙන්නනවා -->
      <div v-for="product in products" :key="product.id" class="product-card">
        <img :src="product.image_url" :alt="product.name" class="product-image">
        <h2>{{ product.name }}</h2>
        <p class="product-color">Color: {{ product.color }}</p>
        <p class="product-price">Rs. {{ product.price }}</p>
      </div>
    </div>
  </div>
</template>

<style scoped>
.product-gallery {
  text-align: center;
  font-family: Arial, sans-serif;
}
.product-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr); /* එක පේලියට 3ක් පෙන්නන්න */
  gap: 20px;
  padding: 20px;
}
.product-card {
  border: 1px solid #ccc;
  border-radius: 8px;
  padding: 15px;
  box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}
.product-image {
  max-width: 100%;
  height: auto;
  border-radius: 5px;
}
.product-price {
  font-weight: bold;
  color: #2c3e50;
}
</style>