import { defineStore } from "pinia";

export const useCartStore = defineStore("cart", {
  // State: The data we want to store
  state: () => ({
    items: [], // An array to hold the products in the cart
  }),

  // Getters: Computed properties based on state
  getters: {
    // Returns the total number of items in the cart
    itemCount: (state) => {
      return state.items.reduce((total, item) => total + item.quantity, 0);
    },
  },

  // Actions: Functions that change the state
  actions: {
    addToCart(product) {
      // Check if the product is already in the cart
      const existingItem = this.items.find((item) => item.id === product.id);

      if (existingItem) {
        // If it exists, just increase the quantity
        existingItem.quantity++;
      } else {
        // If it's a new product, add it to the items array with a quantity of 1
        this.items.push({ ...product, quantity: 1 });
      }
    },
  },
});
