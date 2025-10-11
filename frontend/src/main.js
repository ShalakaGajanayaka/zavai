

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import './assets/main.css' 
import { createPinia } from 'pinia'
import { useCartStore } from './stores/cart'


const app = createApp(App)
const pinia = createPinia()

app.use(router)
app.use(pinia)

const cartStore = useCartStore();
cartStore.$subscribe((mutation, state) => {
  // state එක වෙනස් වෙන හැම වෙලාවකම Local Storage එකේ save කරනවා
  localStorage.setItem('brandme-cart', JSON.stringify(state.items));
});

app.mount('#app')
