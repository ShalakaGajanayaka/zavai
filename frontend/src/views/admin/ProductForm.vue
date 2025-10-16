<script setup>
import { ref, onMounted, computed } from "vue";
import { useRoute, useRouter } from "vue-router";
import apiClient from "../../api/axios"; // axios වෙනුවට apiClient පාවිච්චි කරන්න

const route = useRoute();
const router = useRouter();

// Form එකේ data තියාගන්න ref එකක්
const productData = ref({
  name: "",
  description: "",
  price: "",
  color: "",
  image_url: null,
});

// --- අලුත් වෙනස්කම් මෙතනින් පටන් ගන්නවා ---

// Validation errors තියාගන්න අලුත් ref එකක්
const validationErrors = ref({});
const isLoading = ref(false); // Submit කරද්දී loading state එකක් පෙන්නන්න

// --- අලුත් වෙනස්කම් මෙතනින් ඉවර වෙනවා ---

const imageFile = ref(null);
function handleFileChange(event) {
  imageFile.value = event.target.files[0];
  if (imageFile.value) {
    // තාවකාලිකව image preview එකක් පෙන්නන්න
    productData.value.image_url = URL.createObjectURL(imageFile.value);
  }
}

const isEditMode = computed(() => !!route.params.id);
const productId = ref(null);

onMounted(async () => {
  if (isEditMode.value) {
    productId.value = route.params.id;
    try {
      // Edit mode නම්, apiClient එකෙන් data අරගන්නවා
      const response = await apiClient.get(`/products/${productId.value}`);
      productData.value = response.data;
    } catch (error) {
      console.error("Failed to fetch product for editing:", error);
      alert("Could not load product data. Please try again.");
      router.push("/admin/products");
    }
  }
});

// Form එක submit කරාම වැඩ කරන function එක
async function handleSubmit() {
  // --- අලුත් වෙනස්කම් මෙතනින් පටන් ගන්නවා ---
  isLoading.value = true;
  validationErrors.value = {}; // හැම submit එකකදීම පරණ errors අයින් කරනවා

  const formData = new FormData();
  formData.append("name", productData.value.name);
  formData.append("description", productData.value.description);
  formData.append("price", productData.value.price);
  formData.append("color", productData.value.color);

  if (imageFile.value) {
    formData.append("image", imageFile.value);
  }

  if (isEditMode.value) {
    formData.append("_method", "PUT");
  }

  try {
    const url = isEditMode.value ? `/products/${productId.value}` : "/products";
    await apiClient.post(url, formData, {
      headers: {
        "Content-Type": "multipart/form-data",
      },
    });

    router.push("/admin/products");
  } catch (error) {
    // --- මෙතන තමයි වැදගත්ම දේ වෙන්නේ ---
    if (error.response && error.response.status === 422) {
      // Laravel එකෙන් එවන validation errors ටික validationErrors ref එකට දාගන්නවා
      validationErrors.value = error.response.data.errors;
    } else {
      console.error("Failed to save product:", error);
      alert("An unexpected error occurred. Please check the console.");
    }
  } finally {
    isLoading.value = false; // අවසානයේ loading state එක අයින් කරනවා
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
          :class="{ 'border-red-500': validationErrors.name }"
        />
        <!-- Validation error message එක මෙතන පෙන්නනවා -->
        <p v-if="validationErrors.name" class="text-red-500 text-xs mt-1">
          {{ validationErrors.name[0] }}
        </p>
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
          :class="{ 'border-red-500': validationErrors.description }"
        ></textarea>
        <p
          v-if="validationErrors.description"
          class="text-red-500 text-xs mt-1"
        >
          {{ validationErrors.description[0] }}
        </p>
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
          :class="{ 'border-red-500': validationErrors.price }"
        />
        <p v-if="validationErrors.price" class="text-red-500 text-xs mt-1">
          {{ validationErrors.price[0] }}
        </p>
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
          :class="{ 'border-red-500': validationErrors.color }"
        />
        <p v-if="validationErrors.color" class="text-red-500 text-xs mt-1">
          {{ validationErrors.color[0] }}
        </p>
      </div>

      <!-- Image input -->
      <div class="mb-4">
        <label for="image" class="block text-gray-700 font-semibold mb-2"
          >Product Image</label
        >
        <input
          @change="handleFileChange"
          type="file"
          id="image"
          class="w-full px-3 py-2 border rounded"
          :class="{ 'border-red-500': validationErrors.image }"
        />
        <p v-if="validationErrors.image" class="text-red-500 text-xs mt-1">
          {{ validationErrors.image[0] }}
        </p>
        <div v-if="productData.image_url" class="mt-2">
          <p class="text-sm text-gray-500 mb-1">Current Image Preview:</p>
          <img
            :src="productData.image_url"
            class="w-32 h-32 object-cover rounded"
          />
        </div>
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
          class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 disabled:bg-blue-300"
          :disabled="isLoading"
        >
          {{ isLoading ? "Saving..." : (isEditMode ? "Update Product" : "Create Product") }}
        </button>
      </div>
    </form>
  </div>
</template>
