<script setup>
import { Head, Link } from "@inertiajs/vue3";
import ShopLayout from "@/Layouts/ShopLayout.vue";

// Laravel controller එකෙන් එවන 'products' data ටික props විදිහට භාරගන්නවා
defineProps({
    products: Array,
});
</script>

<template>
    <Head title="Welcome to Zavai" />

    <ShopLayout>
        <div class="bg-white">
            <div
                class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8"
            >
                <h2 class="text-2xl font-bold tracking-tight text-gray-900">
                    Our Latest T-Shirts
                </h2>

                <div
                    class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8"
                >
                    <Link
                        v-for="product in products"
                        :key="product.id"
                        :href="route('products.show', product.id)"
                        class="group relative"
                    >
                        <div
                            class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80"
                        >
                            <img
                                v-if="product.image_path"
                                :src="'/storage/' + product.image_path"
                                :alt="product.name"
                                class="h-full w-full object-cover object-center lg:h-full lg:w-full"
                            />
                            <div
                                v-else
                                class="h-full w-full bg-gray-300 flex items-center justify-center"
                            >
                                <span class="text-gray-500">No Image</span>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-between">
                            <div>
                                <h3 class="text-sm text-gray-700">
                                    <span
                                        aria-hidden="true"
                                        class="absolute inset-0"
                                    />
                                    {{ product.name }}
                                </h3>
                            </div>
                            <p class="text-sm font-medium text-gray-900">
                                Rs. {{ product.price }}
                            </p>
                        </div>
                    </Link>
                </div>
            </div>
        </div>
    </ShopLayout>
</template>
