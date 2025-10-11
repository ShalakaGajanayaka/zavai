import { defineStore } from 'pinia';

const LOCAL_STORAGE_KEY = 'brandme-cart';

const loadCartFromLocalStorage = () => {
  const storedCart = localStorage.getItem(LOCAL_STORAGE_KEY);
  if (storedCart) {
    try {
      return JSON.parse(storedCart);
    } catch (e) {
      console.error('Error parsing cart from Local Storage', e);
      localStorage.removeItem(LOCAL_STORAGE_KEY);
      return [];
    }
  }
  return [];
};

export const useCartStore = defineStore('cart', {
  state: () => ({
    items: loadCartFromLocalStorage(),
  }),
  getters: {
    itemCount: (state) => {
      return state.items.reduce((total, item) => total + item.quantity, 0);
    },
    totalPrice: (state) => {
      const total = state.items.reduce((total, item) => {
        return total + (item.price * item.quantity);
      }, 0);
      return total.toFixed(2);
    },
  },
  actions: {
    addToCart(product) {
      const existingItem = this.items.find(item => item.id === product.id);
      if (existingItem) {
        existingItem.quantity++;
      } else {
        this.items.push({ ...product, quantity: 1 });
      }
    },
    removeFromCart(productId) {
      this.items = this.items.filter(item => item.id !== productId);
    },
    incrementQuantity(productId) {
      const item = this.items.find(item => item.id === productId);
      if (item) {
        item.quantity++;
      }
    },
    decrementQuantity(productId) {
      const item = this.items.find(item => item.id === productId);
      if (item && item.quantity > 1) {
        item.quantity--;
      } else if (item && item.quantity === 1) {
        this.removeFromCart(productId);
      }
    },
  },
});

// අපි මෙතන තිබ්බ subscribe logic එක අයින් කරා!