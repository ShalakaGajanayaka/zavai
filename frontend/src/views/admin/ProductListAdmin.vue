<script setup>
import { ref, onMounted } from "vue";
import apiClient from "../../api/axios"; // axios වෙනුවට apiClient import කරගන්නවා

const products = ref([]);
const isLoading = ref(true);

// Products ඔක්කොම අරගන්නා function එක
async function fetchProducts() {
  isLoading.value = true;
  try {
    const response = await apiClient.get("/products"); // apiClient පාවිච්චි කරනවා
    products.value = response.data;
  } catch (error) {
    console.error("Failed to fetch products:", error);
  } finally {
    isLoading.value = false;
  }
}

// Product එකක් delete කරන function එක
async function deleteProduct(id) {
  // Delete කරන්න කලින් user ගෙන් අහනවා, වැරදීමකින් delete වෙන එක නවත්තන්න
  if (confirm("Are you sure you want to delete this product?")) {
    try {
      await apiClient.delete(`/products/${id}`); // apiClient පාවිච්චි කරනවා
      // Delete කරාට පස්සේ list එක ආයෙත් load කරනවා
      fetchProducts();
    } catch (error) {
      console.error("Failed to delete product:", error);
      alert("Failed to delete product. Please try again.");
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
            <th class="px-4 py-2 text-left">Image</th>
            <th class="px-4 py-2 text-left">Name</th>
            <th class="px-4 py-2 text-left">Price</th>
            <th class="px-4 py-2 text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="isLoading">
            <td colspan="5" class="text-center py-4">Loading products...</td>
          </tr>
          <tr
            v-else-if="products.length > 0"
            v-for="product in products"
            :key="product.id"
            class="border-b"
          >
            <td class="px-4 py-2">{{ product.id }}</td>
            <td class="px-4 py-2">
              <img
                :src="product.image_url"
                :alt="product.name"
                class="w-12 h-12 object-cover rounded"
              />
            </td>
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
          <tr v-else>
            <td colspan="5" class="text-center py-4 text-gray-500">
              No products found.
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
