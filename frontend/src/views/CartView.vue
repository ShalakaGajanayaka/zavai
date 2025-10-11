<script setup>
import { useCartStore } from "../stores/cart";

const cartStore = useCartStore();
</script>

<template>
  <div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Your Shopping Cart</h1>

    <!-- Empty Cart Message -->
    <div
      v-if="cartStore.itemCount === 0"
      class="text-center py-10 bg-gray-100 rounded-lg"
    >
      <p class="text-xl text-gray-600">Your cart is empty.</p>
      <router-link
        to="/"
        class="mt-4 inline-block bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600"
      >
        Continue Shopping
      </router-link>
    </div>

    <!-- Cart Items Table -->
    <div v-else>
      <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <!-- Cart Item Loop -->
        <div
          v-for="item in cartStore.items"
          :key="item.id"
          class="flex items-center p-4 border-b"
        >
          <img
            :src="item.image_url"
            :alt="item.name"
            class="w-20 h-20 object-cover rounded mr-4"
          />
          <div class="flex-grow">
            <h2 class="font-semibold">{{ item.name }}</h2>
            <p class="text-gray-600">Rs. {{ item.price }}</p>
          </div>
          <!-- Quantity Controls -->
          <div class="flex items-center mx-4">
            <button
              @click="cartStore.decrementQuantity(item.id)"
              class="px-2 py-1 bg-gray-200 rounded"
            >
              -
            </button>
            <span class="px-4 font-semibold">{{ item.quantity }}</span>
            <button
              @click="cartStore.incrementQuantity(item.id)"
              class="px-2 py-1 bg-gray-200 rounded"
            >
              +
            </button>
          </div>
          <!-- Item Total -->
          <div class="w-24 text-right font-semibold">
            Rs. {{ (item.price * item.quantity).toFixed(2) }}
          </div>
          <!-- Remove Button -->
          <div class="ml-4">
            <button
              @click="cartStore.removeFromCart(item.id)"
              class="text-red-500 hover:text-red-700"
            >
              &times;
            </button>
          </div>
        </div>
      </div>

      <!-- Cart Summary -->
      <div class="mt-6 flex justify-end">
        <div class="w-full max-w-sm bg-white p-6 rounded-lg shadow-md">
          <div class="flex justify-between text-lg font-bold">
            <span>Total:</span>
            <span>Rs. {{ cartStore.totalPrice }}</span>
          </div>
          <button
            class="w-full mt-4 bg-green-500 text-white py-3 rounded-lg font-semibold hover:bg-green-600"
          >
            Proceed to Checkout
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
