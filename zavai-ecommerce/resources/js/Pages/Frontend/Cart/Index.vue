<script setup>
import { Head, Link } from "@inertiajs/vue3";
import ShopLayout from "@/Layouts/ShopLayout.vue";
import { computed } from "vue"; // 'computed' import කරගන්න

const props = defineProps({
    cartItems: Object,
});

// Cart එකේ මුළු මුදල ගණනය කිරීමට computed property එකක්
const cartTotal = computed(() => {
    let total = 0;
    for (const productId in props.cartItems) {
        total +=
            props.cartItems[productId].price *
            props.cartItems[productId].quantity;
    }
    return total.toFixed(2); // දಶමස්ථාන දෙකකට සීමා කරනවා
});

const isCartEmpty = computed(() => {
    return Object.keys(props.cartItems).length === 0;
});
</script>

<template>
    <Head title="Your Shopping Cart" />

    <ShopLayout>
        <div class="bg-white">
            <div class="mx-auto max-w-4xl px-4 py-16 sm:px-6 sm:py-24 lg:px-8">
                <div
                    v-if="$page.props.flash && $page.props.flash.error"
                    class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4"
                    role="alert"
                >
                    <p>{{ $page.props.flash.error }}</p>
                </div>

                <h1 class="text-3xl font-bold tracking-tight text-gray-900">
                    Shopping Cart
                </h1>

                <div v-if="isCartEmpty" class="mt-12">
                    <p class="text-gray-500">Your cart is currently empty.</p>
                    <Link
                        :href="route('home')"
                        class="mt-4 inline-block font-medium text-indigo-600 hover:text-indigo-500"
                    >
                        Continue Shopping
                        <span aria-hidden="true"> &rarr;</span>
                    </Link>
                </div>

                <form v-else class="mt-12">
                    <section>
                        <ul
                            role="list"
                            class="border-t border-b border-gray-200 divide-y divide-gray-200"
                        >
                            <li
                                v-for="(item, productId) in cartItems"
                                :key="productId"
                                class="flex py-6"
                            >
                                <div class="flex-shrink-0">
                                    <img
                                        :src="'/storage/' + item.image_path"
                                        :alt="item.name"
                                        class="h-24 w-24 rounded-md object-cover object-center sm:h-32 sm:w-32"
                                    />
                                </div>

                                <div class="ml-4 flex flex-1 flex-col sm:ml-6">
                                    <div>
                                        <div class="flex justify-between">
                                            <h4 class="text-sm">
                                                {{ item.name }}
                                            </h4>
                                            <p
                                                class="ml-4 text-sm font-medium text-gray-900"
                                            >
                                                Rs. {{ item.price }}
                                            </p>
                                        </div>
                                        <div class="flex items-center text-sm">
                                            <span class="text-gray-500 mr-2"
                                                >Qty:</span
                                            >
                                            <div class="flex items-center">
                                                <Link
                                                    :href="
                                                        route(
                                                            'cart.update',
                                                            productId
                                                        )
                                                    "
                                                    :data="{
                                                        quantity:
                                                            item.quantity - 1,
                                                    }"
                                                    method="patch"
                                                    as="button"
                                                    preserve-scroll
                                                    :disabled="
                                                        item.quantity <= 1
                                                    "
                                                    class="px-2 py-0 border rounded-l disabled:opacity-50"
                                                    >-</Link
                                                >

                                                <span
                                                    class="px-3 py-0 border-t border-b"
                                                    >{{ item.quantity }}</span
                                                >

                                                <Link
                                                    :href="
                                                        route(
                                                            'cart.update',
                                                            productId
                                                        )
                                                    "
                                                    :data="{
                                                        quantity:
                                                            item.quantity + 1,
                                                    }"
                                                    method="patch"
                                                    as="button"
                                                    preserve-scroll
                                                    class="px-2 py-0 border rounded-r"
                                                    >+</Link
                                                >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="ml-4">
                                        <Link
                                            :href="
                                                route('cart.destroy', productId)
                                            "
                                            method="delete"
                                            as="button"
                                            class="text-sm font-medium text-indigo-600 hover:text-indigo-500"
                                        >
                                            <span>Remove</span>
                                        </Link>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </section>

                    <section class="mt-10">
                        <div
                            class="bg-gray-50 rounded-lg px-4 py-6 sm:p-6 lg:p-8"
                        >
                            <h2 class="text-lg font-medium text-gray-900">
                                Order summary
                            </h2>
                            <dl class="mt-6 space-y-4">
                                <div
                                    class="flex items-center justify-between border-t border-gray-200 pt-4"
                                >
                                    <dt
                                        class="text-base font-medium text-gray-900"
                                    >
                                        Order total
                                    </dt>
                                    <dd
                                        class="text-base font-medium text-gray-900"
                                    >
                                        Rs. {{ cartTotal }}
                                    </dd>
                                </div>
                            </dl>

                            <div class="mt-6">
                                <Link
                                    :href="route('checkout.index')"
                                    class="w-full flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700"
                                    >Checkout</Link
                                >
                            </div>
                        </div>
                    </section>
                </form>
            </div>
        </div>
    </ShopLayout>
</template>
