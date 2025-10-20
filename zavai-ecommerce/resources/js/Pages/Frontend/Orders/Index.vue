<script setup>
import { Head, Link } from '@inertiajs/vue3';
import ShopLayout from '@/Layouts/ShopLayout.vue';

defineProps({
    orders: Array,
});
</script>

<template>
    <Head title="My Orders" />

    <ShopLayout>
        <div class="bg-gray-100">
            <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:py-24 lg:px-8">
                <div class="max-w-3xl mx-auto">
                    <h1 class="text-3xl font-bold tracking-tight text-gray-900">Your Order History</h1>

                    <div v-if="orders.length === 0" class="mt-12 text-center bg-white p-8 rounded-lg shadow-sm">
                        <p class="text-gray-500">You haven't placed any orders yet.</p>
                        <Link :href="route('home')" class="mt-4 inline-block font-medium text-indigo-600 hover:text-indigo-500">
                            Start Shopping
                            <span aria-hidden="true"> &rarr;</span>
                        </Link>
                    </div>

                    <div v-else class="mt-8 space-y-6">
                        <div v-for="order in orders" :key="order.id" class="bg-white border border-gray-200 rounded-lg shadow-sm">
                            <div class="flex items-center justify-between border-b border-gray-200 p-4 sm:p-6">
                                <dl class="grid flex-1 grid-cols-2 gap-x-6 text-sm sm:grid-cols-4">
                                    <div>
                                        <dt class="font-medium text-gray-900">Order number</dt>
                                        <dd class="mt-1 text-gray-500">#{{ order.id }}</dd>
                                    </div>
                                    <div class="hidden sm:block">
                                        <dt class="font-medium text-gray-900">Date placed</dt>
                                        <dd class="mt-1 text-gray-500">
                                            <time :datetime="order.created_at">{{ new Date(order.created_at).toLocaleDateString() }}</time>
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-900">Total amount</dt>
                                        <dd class="mt-1 font-medium text-gray-900">Rs. {{ order.total_amount }}</dd>
                                    </div>
                                    <div class="hidden sm:block">
                                        <dt class="font-medium text-gray-900">Status</dt>
                                        <dd class="mt-1 font-medium text-indigo-600 capitalize">{{ order.status }}</dd>
                                    </div>
                                </dl>

                                <div class="ml-4">
                                     <Link :href="route('orders.history.show', order.id)" class="text-indigo-600 hover:text-indigo-500 font-medium">
                                        View Details
                                    </Link>
                                </div>
                            </div>
                            <div class="p-4 sm:p-6 text-sm text-gray-600">
                                {{ order.items_count }} items in this order.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </ShopLayout>
</template>