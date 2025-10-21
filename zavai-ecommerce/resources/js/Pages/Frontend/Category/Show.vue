<script setup>
import { Head, Link } from '@inertiajs/vue3';
import ShopLayout from '../../../Layouts/ShopLayout.vue';

defineProps({
    category: Object,
    products: Object, // Laravel pagination එකෙන් එන්නේ object එකක්
});
</script>

<template>

    <Head :title="category.name" />

    <ShopLayout>
        <div class="bg-white">
            <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
                <h1 class="text-4xl font-bold tracking-tight text-gray-900">{{ category.name }}</h1>
                <p class="mt-4 max-w-xl text-sm text-gray-700">Browse all products in the {{ category.name }} category.
                </p>

                <div class="mt-8 grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                    <Link v-for="product in products.data" :key="product.id" :href="route('products.show', product.id)"
                        class="group">
                    <div
                        class="rounded-lg border bg-card text-card-foreground shadow-sm transition-all hover:shadow-lg">
                        <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-t-lg bg-gray-100">
                            <img v-if="product.image_path" :src="'/storage/' + product.image_path" :alt="product.name"
                                class="h-full w-full object-cover object-center" />
                            <div v-else class="h-full w-full bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-500">No Image</span>
                            </div>
                        </div>
                        <div class="p-4 border-t">
                            <h3 class="text-base font-semibold tracking-tight text-gray-900">{{ product.name }}</h3>
                            <p class="text-lg font-medium text-gray-900 mt-2">Rs. {{ product.price }}</p>
                        </div>
                    </div>
                    </Link>
                </div>

                <div v-if="products.links.length > 3" class="mt-12 flex justify-center items-center space-x-2">
                    <Link v-for="(link, index) in products.links" :key="index" :href="link.url" v-html="link.label"
                        class="px-4 py-2 text-sm font-medium rounded-md"
                        :class="{ 'bg-indigo-600 text-white': link.active, 'text-gray-700 bg-white hover:bg-gray-50 border': !link.active }" />
                </div>

            </div>
        </div>
    </ShopLayout>
</template>