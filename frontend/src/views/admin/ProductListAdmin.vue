<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

const products = ref([]);

// Products ඔක්කොම අරගන්නා function එක
async function fetchProducts() {
  try {
    const response = await axios.get("http://127.0.0.1:8000/api/products");
    products.value = response.data;
  } catch (error) {
    console.error("Failed to fetch products:", error);
  }
}

// Product එකක් delete කරන function එක
async function deleteProduct(id) {
  // Delete කරන්න කලින් user ගෙන් අහනවා, වැරදීමකින් delete වෙන එක නවත්තන්න
  if (confirm("Are you sure you want to delete this product?")) {
    try {
      await axios.delete(`http://127.0.0.1:8000/api/products/${id}`);
      // Delete කරාට පස්සේ list එක ආයෙත් load කරනවා
      fetchProducts();
    } catch (error) {
      console.error("Failed to delete product:", error);
    }
  }
}

// Component එක load වුන ගමන් products ටික fetch කරගන්නවා
onMounted(fetchProducts);
</script>

<template>
  <div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-bold">Manage Products</h1>
      <router-link
        to="/admin/products/new"
        class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600"
      >
        + Add New Product
      </router-link>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
      <table class="w-full table-auto">
        <thead class="bg-gray-200">
          <tr>
            <th class="px-4 py-2 text-left">ID</th>
            <th class="px-4 py-2 text-left">Name</th>
            <th class="px-4 py-2 text-left">Price</th>
            <th class="px-4 py-2 text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="product in products" :key="product.id" class="border-b">
            <td class="px-4 py-2">{{ product.id }}</td>
            <td class="px-4 py-2">{{ product.name }}</td>
            <td class="px-4 py-2">Rs. {{ product.price }}</td>
            <td class="px-4 py-2 text-center">
              <router-link
                :to="`/admin/products/edit/${product.id}`"
                class="text-blue-500 hover:underline mr-4"
              >
                Edit
              </router-link>
              <button
                @click="deleteProduct(product.id)"
                class="text-red-500 hover:underline"
              >
                Delete
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
