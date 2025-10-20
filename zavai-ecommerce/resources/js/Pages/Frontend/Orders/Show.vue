<script setup>
import { Head, Link } from "@inertiajs/vue3";
import ShopLayout from "@/Layouts/ShopLayout.vue";

defineProps({
    order: Object,
});
</script>

<template>
    <Head :title="`Order #${order.id}`" />

    <ShopLayout>
        <div class="bg-white">
            <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:py-24 lg:px-8">
                <div class="flex justify-between items-baseline">
                    <h1 class="text-3xl font-bold tracking-tight text-gray-900">
                        Order #{{ order.id }}
                    </h1>
                    <Link
                        :href="route('orders.history')"
                        class="text-sm font-medium text-indigo-600 hover:text-indigo-500"
                    >
                        &larr; Back to all orders
                    </Link>
                </div>

                <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2">
                        <h2 class="text-lg font-medium text-gray-900">
                            Items in this order
                        </h2>
                        <ul
                            role="list"
                            class="mt-6 divide-y divide-gray-200 border-t border-b border-gray-200"
                        >
                            <li
                                v-for="item in order.items"
                                :key="item.id"
                                class="flex py-6"
                            >
                                <div class="flex-shrink-0">
                                    <img
                                        :src="
                                            '/storage/' +
                                            item.product.image_path
                                        "
                                        :alt="item.product.name"
                                        class="h-24 w-24 rounded-md object-cover object-center"
                                    />
                                </div>
                                <div class="ml-4 flex flex-1 flex-col">
                                    <div>
                                        <h4 class="font-medium text-gray-900">
                                            {{ item.product.name }}
                                        </h4>
                                        <p class="mt-1 text-sm text-gray-500">
                                            SKU: {{ item.product.sku }}
                                        </p>
                                    </div>
                                    <div
                                        class="flex flex-1 items-end justify-between text-sm"
                                    >
                                        <p class="text-gray-700">
                                            Price: Rs. {{ item.price }}
                                        </p>
                                        <p class="text-gray-700">
                                            Qty: {{ item.quantity }}
                                        </p>
                                        <p class="font-medium text-gray-900">
                                            Subtotal: Rs.
                                            {{
                                                (
                                                    item.price * item.quantity
                                                ).toFixed(2)
                                            }}
                                        </p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="lg:col-span-1">
                        <div
                            class="rounded-lg bg-gray-50 px-4 py-6 sm:p-6 lg:p-8"
                        >
                            <h2 class="text-lg font-medium text-gray-900">
                                Order Summary
                            </h2>
                            <dl class="mt-6 space-y-4">
                                <div class="flex items-center justify-between">
                                    <dt class="text-sm text-gray-600">
                                        Status
                                    </dt>
                                    <dd
                                        class="text-sm font-medium text-indigo-600"
                                    >
                                        {{ order.status }}
                                    </dd>
                                </div>
                                <div
                                    class="flex items-center justify-between border-t border-gray-200 pt-4"
                                >
                                    <dt
                                        class="text-base font-medium text-gray-900"
                                    >
                                        Total
                                    </dt>
                                    <dd
                                        class="text-base font-medium text-gray-900"
                                    >
                                        Rs. {{ order.total_amount }}
                                    </dd>
                                </div>
                            </dl>

                            <div class="mt-8 border-t border-gray-200 pt-6">
                                <h2 class="text-lg font-medium text-gray-900">
                                    Shipping Details
                                </h2>
                                <div class="mt-4 text-sm text-gray-600">
                                    <p class="font-medium text-gray-800">
                                        {{ order.customer_name }}
                                    </p>
                                    <p>{{ order.address }}</p>
                                    <p>Email: {{ order.customer_email }}</p>
                                    <p>Phone: {{ order.phone }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </ShopLayout>
</template>
