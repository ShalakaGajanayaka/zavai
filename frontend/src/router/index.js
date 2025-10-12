import { createRouter, createWebHistory } from "vue-router";
import ProductList from "../components/ProductList.vue";
import ProductDetail from "../components/ProductDetail.vue";
import CartView from "../views/CartView.vue";
// --- Admin Views
import ProductListAdmin from "../views/admin/ProductListAdmin.vue";
import ProductForm from "../views/admin/ProductForm.vue";

import { useAuthStore } from "../stores/auth";
import LoginView from "../views/LoginView.vue";

const routes = [
  // --- Customer Routes ---
  {
    path: "/", // Homepage (URL එකේ මුල)
    name: "ProductList",
    component: ProductList,
  },
  {
    path: "/product/:id", // Single product page. :id කියන්නේ dynamic කොටස
    name: "ProductDetail",
    component: ProductDetail,
  },
  {
    path: "/cart",
    name: "Cart",
    component: CartView,
  },
  { path: "/login", name: "Login", component: LoginView },

  // --- Admin Routes ---
  {
    path: "/admin/products",
    name: "AdminProductList",
    component: ProductListAdmin,
    meta: { requiresAuth: true },
  },
  {
    path: "/admin/products/new",
    name: "AdminProductCreate",
    component: ProductForm,
    meta: { requiresAuth: true },
  },
  {
    path: "/admin/products/edit/:id",
    name: "AdminProductEdit",
    component: ProductForm,
    meta: { requiresAuth: true },
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

// Navigation Guard - The Bouncer
router.beforeEach((to, from, next) => {
  const authStore = useAuthStore();
  // Check if the route requires authentication
  if (to.meta.requiresAuth && !authStore.isAuthenticated) {
    // If not authenticated, redirect to the login page
    next({ name: "Login" });
  } else {
    // Otherwise, allow the navigation
    next();
  }
});

export default router;
