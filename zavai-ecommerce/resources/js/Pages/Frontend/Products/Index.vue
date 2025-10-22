<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import ShopLayout from '../../../Layouts/ShopLayout.vue';
import { ref, watch } from 'vue';

const props = defineProps({
    products: Object,
    categories: Array,
    filters: Object
});

const selectedCategory = ref(props.filters.category || '');
const searchQuery = ref(props.filters.search || '');

// URL parameter එකෙන් category එක pre-select කරන්න
const initializeFilters = () => {
    const urlParams = new URLSearchParams(window.location.search);
    const categoryParam = urlParams.get('category');
    if (categoryParam && !selectedCategory.value) {
        selectedCategory.value = categoryParam;
    }
};

// Component mount වෙන විට filters initialize කරන්න
initializeFilters();

// Category filter function
const filterByCategory = (categorySlug) => {
    selectedCategory.value = categorySlug;
    router.get(route('products.index'), {
        category: categorySlug,
        search: searchQuery.value
    }, {
        preserveState: true,
        replace: true
    });
};

// Search function
const searchProducts = () => {
    router.get(route('products.index'), {
        category: selectedCategory.value,
        search: searchQuery.value
    }, {
        preserveState: true,
        replace: true
    });
};

// Clear all filters
const clearFilters = () => {
    selectedCategory.value = '';
    searchQuery.value = '';
    router.get(route('products.index'));
};
</script>

<template>
    <Head title="All Products - Zavai" />

    <ShopLayout>
        <div class="bg-white">
            <!-- Header Section -->
            <div class="bg-gray-50 py-8">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="text-center">
                        <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                            <span v-if="selectedCategory">
                                {{ categories.find(cat => cat.slug === selectedCategory)?.name || 'All Products' }}
                            </span>
                            <span v-else>All Products</span>
                        </h1>
                        <p class="mt-4 text-lg text-gray-600">
                            <span v-if="selectedCategory">
                                Browse our {{ categories.find(cat => cat.slug === selectedCategory)?.name?.toLowerCase() || 'selected' }} collection
                            </span>
                            <span v-else>Discover our complete collection of premium products</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Filters Section -->
            <div class="bg-white border-b border-gray-200">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6">
                    <div class="flex flex-col sm:flex-row gap-4 items-center justify-between">
                        <!-- Category Filter -->
                        <div class="flex items-center gap-4">
                            <label for="category-filter" class="text-sm font-medium text-gray-700">
                                Category:
                            </label>
                            <select 
                                id="category-filter"
                                v-model="selectedCategory"
                                @change="filterByCategory(selectedCategory)"
                                class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                                <option value="">All Categories</option>
                                <option 
                                    v-for="category in categories" 
                                    :key="category.id" 
                                    :value="category.slug"
                                >
                                    {{ category.name }}
                                </option>
                            </select>
                        </div>

                        <!-- Search -->
                        <div class="flex items-center gap-4">
                            <div class="relative">
                                <input
                                    type="text"
                                    v-model="searchQuery"
                                    @keyup.enter="searchProducts"
                                    placeholder="Search products..."
                                    class="w-64 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pl-10"
                                />
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                            </div>
                            <button
                                @click="searchProducts"
                                class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition-colors"
                            >
                                Search
                            </button>
                        </div>

                        <!-- Clear Filters -->
                        <button
                            v-if="selectedCategory || searchQuery"
                            @click="clearFilters"
                            class="text-sm text-gray-600 hover:text-gray-800 underline"
                        >
                            Clear Filters
                        </button>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                <!-- Results Count -->
                <div v-if="products && products.data" class="mb-6">
                    <p class="text-sm text-gray-600">
                        Showing {{ products.data.length }} of {{ products.total || 0 }} products
                    </p>
                </div>

                <!-- Products Grid -->
                <div v-if="products && products.data && products.data.length > 0" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    <Link 
                        v-for="product in products.data" 
                        :key="product.id"
                        :href="route('products.show', product.id)" 
                        class="group"
                    >
                        <div class="rounded-lg border bg-card text-card-foreground shadow-sm transition-all hover:shadow-lg">
                            <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-t-lg bg-gray-100">
                                <img 
                                    v-if="product.image_path" 
                                    :src="'/storage/' + product.image_path" 
                                    :alt="product.name"
                                    class="h-full w-full object-cover object-center group-hover:scale-105 transition-transform duration-300" 
                                />
                                <div v-else class="h-full w-full bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-500">No Image</span>
                                </div>
                            </div>
                            <div class="p-4 border-t">
                                <h3 class="text-base font-semibold tracking-tight text-gray-900 line-clamp-2">
                                    {{ product.name }}
                                </h3>
                                <p class="text-sm text-gray-500 mt-1">
                                    {{ product.category?.name || 'No Category' }}
                                </p>
                                <p class="text-lg font-medium text-gray-900 mt-2">
                                    Rs. {{ product.price }}
                                </p>
                            </div>
                        </div>
                    </Link>
                </div>

                <!-- No Products Found -->
                <div v-else class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No products found</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Try adjusting your search or filter criteria.
                    </p>
                    <div class="mt-6">
                        <button
                            @click="clearFilters"
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700"
                        >
                            Clear Filters
                        </button>
                    </div>
                </div>

                <!-- Pagination -->
                <div v-if="products && products.links && products.links.length > 3" class="mt-8 flex justify-center">
                    <nav class="flex space-x-2">
                        <template v-for="link in products.links" :key="link.label">
                            <Link
                                v-if="link.url"
                                :href="link.url"
                                v-html="link.label"
                                :class="[
                                    'px-3 py-2 text-sm font-medium rounded-md',
                                    link.active 
                                        ? 'bg-indigo-600 text-white' 
                                        : 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-300'
                                ]"
                            />
                            <span
                                v-else
                                v-html="link.label"
                                class="px-3 py-2 text-sm font-medium rounded-md bg-gray-100 text-gray-400 cursor-not-allowed"
                            />
                        </template>
                    </nav>
                </div>
            </div>
        </div>
    </ShopLayout>
</template>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
