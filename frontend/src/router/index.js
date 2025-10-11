import { createRouter, createWebHistory } from "vue-router";
import ProductList from "../components/ProductList.vue";
import ProductDetail from "../components/ProductDetail.vue";
import CartView from "../views/CartView.vue";

const routes = [
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
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
