<script setup>
import { ref, onMounted, computed } from "vue";
import { useRoute, useRouter } from "vue-router";
import axios from "axios";

const route = useRoute();
const router = useRouter();

// Form එකේ data තියාගන්න ref එකක්
const productData = ref({
  name: "",
  description: "",
  price: "",
  color: "",
  image_url: "https://placehold.co/600x400",
});

// දැන් තියෙන්නේ "Edit" mode එකද කියලා බලනවා (URL එකේ id එකක් තියෙනවද බලලා)
const isEditMode = computed(() => !!route.params.id);
const productId = ref(null);

// Component එක load වුනාම
onMounted(async () => {
  if (isEditMode.value) {
    productId.value = route.params.id;
    // Edit mode නම්, පරණ data ටික API එකෙන් අරගෙන form එක පුරවනවා
    try {
      const response = await axios.get(
        `http://127.0.0.1:8000/api/products/${productId.value}`
      );
      productData.value = response.data;
    } catch (error) {
      console.error("Failed to fetch product for editing:", error);
    }
  }
});

// Form එක submit කරාම වැඩ කරන function එක
async function handleSubmit() {
  try {
    if (isEditMode.value) {
      // Edit mode නම්, PUT request එකක් යවනවා
      await axios.put(
        `http://127.0.0.1:8000/api/products/${productId.value}`,
        productData.value
      );
    } else {
      // අලුතින් හදනවා නම්, POST request එකක් යවනවා
      await axios.post("http://127.0.0.1:8000/api/products", productData.value);
    }
    // වැඩේ සාර්ථක වුනාම, ආපහු list page එකට යනවා
    router.push("/admin/products");
  } catch (error) {
    console.error("Failed to save product:", error);
    alert("Failed to save product. Check console for details.");
  }
}
</script>

<template>
  <div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">
      {{ isEditMode ? "Edit Product" : "Create New Product" }}
    </h1>

    <form
      @submit.prevent="handleSubmit"
      class="bg-white p-6 rounded-lg shadow-md max-w-lg mx-auto"
    >
      <!-- Name -->
      <div class="mb-4">
        <label for="name" class="block text-gray-700 font-semibold mb-2"
          >Product Name</label
        >
        <input
          v-model="productData.name"
          type="text"
          id="name"
          class="w-full px-3 py-2 border rounded"
          required
        />
      </div>
      <!-- Description -->
      <div class="mb-4">
        <label for="description" class="block text-gray-700 font-semibold mb-2"
          >Description</label
        >
        <textarea
          v-model="productData.description"
          id="description"
          rows="4"
          class="w-full px-3 py-2 border rounded"
          required
        ></textarea>
      </div>
      <!-- Price -->
      <div class="mb-4">
        <label for="price" class="block text-gray-700 font-semibold mb-2"
          >Price</label
        >
        <input
          v-model="productData.price"
          type="number"
          step="0.01"
          id="price"
          class="w-full px-3 py-2 border rounded"
          required
        />
      </div>
      <!-- Color -->
      <div class="mb-4">
        <label for="color" class="block text-gray-700 font-semibold mb-2"
          >Color</label
        >
        <input
          v-model="productData.color"
          type="text"
          id="color"
          class="w-full px-3 py-2 border rounded"
          required
        />
      </div>
      <!-- Image URL -->
      <div class="mb-4">
        <label for="image_url" class="block text-gray-700 font-semibold mb-2"
          >Image URL</label
        >
        <input
          v-model="productData.image_url"
          type="url"
          id="image_url"
          class="w-full px-3 py-2 border rounded"
          required
        />
      </div>

      <!-- Buttons -->
      <div class="flex justify-end space-x-4">
        <router-link
          to="/admin/products"
          class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
        >
          Cancel
        </router-link>
        <button
          type="submit"
          class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
        >
          {{ isEditMode ? "Update Product" : "Create Product" }}
        </button>
      </div>
    </form>
  </div>
</template>
