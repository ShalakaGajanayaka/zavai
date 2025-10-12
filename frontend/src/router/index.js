import { createRouter, createWebHistory } from "vue-router";
import ProductList from "../components/ProductList.vue";
import ProductDetail from "../components/ProductDetail.vue";
import CartView from "../views/CartView.vue";
// --- Admin Views
import ProductListAdmin from '../views/admin/ProductListAdmin.vue';
import ProductForm from '../views/admin/ProductForm.vue';

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

  // --- Admin Routes ---
  // Admin Panel එකේ products ඔක්කොම පෙන්නන page එක
  {
    path: "/admin/products",
    name: "AdminProductList",
    component: ProductListAdmin,
  },
  // අලුත් product එකක් හදන page එක
  {
    path: "/admin/products/new",
    name: "AdminProductCreate",
    component: ProductForm,
  },
  // පරණ product එකක් edit කරන page එක ( :id එක බලන්න)
  {
    path: "/admin/products/edit/:id",
    name: "AdminProductEdit",
    component: ProductForm,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
