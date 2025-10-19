<script setup>
import { Head, Link } from "@inertiajs/vue3";
import ShopLayout from "@/Layouts/ShopLayout.vue";

defineProps({
    order: Object,
});
</script>

<template>
    <Head title="Order Successful" />

    <ShopLayout>
        <div
            class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8 text-center"
        >
            <h1 class="text-3xl font-bold tracking-tight text-green-700">
                Thank You!
            </h1>
            <p class="mt-4 text-lg text-gray-600">
                Your order has been placed successfully.
            </p>
            <p class="mt-2 text-gray-800">
                Your Order ID is: <span class="font-bold">#{{ order.id }}</span>
            </p>

            <Link
                :href="route('home')"
                class="mt-8 inline-block rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700"
            >
                Continue Shopping
            </Link>
        </div>
    </ShopLayout>
</template>
