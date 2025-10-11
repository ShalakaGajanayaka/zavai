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
    // NEW GETTER: Calculate the total price of all items
    totalPrice: (state) => {
      return state.items
        .reduce((total, item) => {
          return total + item.price * item.quantity;
        }, 0)
        .toFixed(2); // .toFixed(2) for showing two decimal places
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
    // NEW ACTION: Remove an item completely from the cart
    removeFromCart(productId) {
      this.items = this.items.filter((item) => item.id !== productId);
    },
    // NEW ACTION: Increment item quantity
    incrementQuantity(productId) {
      const item = this.items.find((item) => item.id === productId);
      if (item) {
        item.quantity++;
      }
    },
    // NEW ACTION: Decrement item quantity
    decrementQuantity(productId) {
      const item = this.items.find((item) => item.id === productId);
      if (item && item.quantity > 1) {
        item.quantity--;
      } else if (item && item.quantity === 1) {
        // If quantity is 1 and user clicks '-', remove the item
        this.removeFromCart(productId);
      }
    },
  },
});
