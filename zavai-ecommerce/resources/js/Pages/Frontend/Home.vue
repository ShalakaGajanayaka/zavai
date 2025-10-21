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
        <div class="bg-gray-50">
            <div
                class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8"
            >
                <h2 class="text-3xl font-bold tracking-tight text-gray-900">
                    Our Latest Collection
                </h2>

                <div
                    class="mt-8 grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8"
                >
                    <Link
                        v-for="product in products"
                        :key="product.id"
                        :href="route('products.show', product.id)"
                        class="group"
                    >
                        <div
                            class="rounded-lg border bg-card text-card-foreground shadow-sm transition-all hover:shadow-lg"
                        >
                            <div
                                class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-t-lg bg-gray-100"
                            >
                                <img
                                    v-if="product.image_path"
                                    :src="'/storage/' + product.image_path"
                                    :alt="product.name"
                                    class="h-full w-full object-cover object-center"
                                />
                                <div
                                    v-else
                                    class="h-full w-full bg-gray-200 flex items-center justify-center"
                                >
                                    <span class="text-gray-500">No Image</span>
                                </div>
                            </div>
                            <div class="p-4 border-t">
                                <h3
                                    class="text-base font-semibold tracking-tight text-gray-900"
                                >
                                    {{ product.name }}
                                </h3>
                                <p
                                    class="text-lg font-medium text-gray-900 mt-2"
                                >
                                    Rs. {{ product.price }}
                                </p>
                            </div>
                        </div>
                    </Link>
                </div>
            </div>
        </div>
    </ShopLayout>
</template>
