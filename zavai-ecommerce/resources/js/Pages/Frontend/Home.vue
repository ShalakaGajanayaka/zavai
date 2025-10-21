<script setup>
import { Head, Link } from '@inertiajs/vue3';
import ShopLayout from '../../Layouts/ShopLayout.vue';
import Button from '../../Components/ui/Button.vue';

// Controller එකෙන් එවන 'categories' data ටික props විදිහට භාරගන්නවා
const props = defineProps({
    categories: Array,
});

// Debug: Log the categories data
console.log('Categories received:', props.categories);
</script>

<template>

    <Head title="Welcome to Zavai" />

    <ShopLayout>
        <div class="relative bg-gray-900">
            <div aria-hidden="true" class="absolute inset-0 overflow-hidden"></div>
            <div class="relative mx-auto flex max-w-3xl flex-col items-center px-6 py-32 text-center sm:py-64 lg:px-0">
                <h1 class="text-4xl font-bold tracking-tight text-white lg:text-6xl">
                    Welcome to Zavai
                </h1>
                <p class="mt-4 text-xl text-white">
                    The new generation of style is here. Discover our latest
                    collection and redefine your look.
                </p>
                <div class="mt-8">
                    <Button as="a" href="#" size="lg">Shop The Collection</Button>
                </div>
            </div>
        </div>
        <!-- Debug: Show categories count -->
        <div v-if="!categories || categories.length === 0" class="bg-white py-16 text-center">
            <p class="text-gray-500">No categories with products found.</p>
            <p class="text-sm text-gray-400 mt-2">Categories count: {{ categories ? categories.length : 'undefined' }}
            </p>
        </div>

        <div v-for="category in categories" :key="category.id" class="bg-white">
            <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
                <h2 class="text-2xl font-bold tracking-tight text-gray-900">
                    <Link :href="route('category.show', category.slug)" class="hover:text-indigo-600">{{ category.name
                    }}</Link>
                </h2>

                <div class="mt-6 grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">

                    <Link v-for="product in category.products" :key="product.id"
                        :href="route('products.show', product.id)" class="group">
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
                            <h3 class="text-base font-semibold tracking-tight text-gray-900">
                                {{ product.name }}
                            </h3>
                            <p class="text-lg font-medium text-gray-900 mt-2">
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