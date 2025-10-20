<script setup>
import { Head, Link } from '@inertiajs/vue3';
import ShopLayout from "@/Layouts/ShopLayout.vue";

defineProps({
    product: Object,
});
</script>

<template>
    <Head :title="product.name" />

    <ShopLayout>
        <div class="bg-white">
            <div class="pt-6">
                <div
                    class="mx-auto mt-6 max-w-2xl sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-2 lg:gap-x-8 lg:px-8"
                >
                    <div
                        class="aspect-h-4 aspect-w-3 hidden overflow-hidden rounded-lg lg:block"
                    >
                        <img
                            :src="'/storage/' + product.image_path"
                            :alt="product.name"
                            class="h-full w-full object-cover object-center"
                        />
                    </div>

                    <div
                        class="lg:col-span-1 lg:border-l lg:border-gray-200 lg:pl-8"
                    >
                        <h1
                            class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl"
                        >
                            {{ product.name }}
                        </h1>

                        <div class="mt-4">
                            <p class="text-3xl tracking-tight text-gray-900">
                                Rs. {{ product.price }}
                            </p>
                        </div>

                        <div class="mt-10">
                            <h3 class="text-sm font-medium text-gray-900">
                                Description
                            </h3>
                            <div class="prose prose-sm mt-4 text-gray-600">
                                <p>{{ product.description }}</p>
                            </div>
                        </div>

                        <div class="mt-10">
                            <p class="text-sm text-gray-600">
                                SKU: {{ product.sku }}
                            </p>
                        </div>
                        <div class="mt-10">
                            <Link
                                :href="route('cart.store', product.id)"
                                method="post"
                                as="button"
                                class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-11 rounded-md px-8 w-full"
                            >
                                Add to cart
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </ShopLayout>
</template>
