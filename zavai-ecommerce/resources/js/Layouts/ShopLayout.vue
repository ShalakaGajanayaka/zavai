<script setup>
import { Link, router } from "@inertiajs/vue3";
import { ref, computed, onMounted, onUnmounted } from 'vue';
import Button from '../Components/ui/Button.vue';
import { Badge } from '../Components/ui/badge';
import { Separator } from '../Components/ui/separator';
import { Input } from '../Components/ui/input';

const searchQuery = ref('');
const mobileMenuOpen = ref(false);
const showCategories = ref(true);
let heroObserver = null;

function performSearch() {
    if (searchQuery.value.trim()) {
        router.get(route('search.index'), { q: searchQuery.value });
    }
}

const categories = [
    { name: "Men's Clothing", slug: 'mens', icon: 'M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4' },
    { name: "Women's Clothing", slug: 'womens', icon: 'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h8m-8 0h-2a2 2 0 01-2-2v-1m4-7h8' },
    { name: "T-Shirts", slug: 't-shirts', icon: 'M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4' },
    { name: "New Arrivals", slug: 'new-arrivals', icon: 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z' },
    { name: "Sale", slug: 'sale', icon: 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z' },
];

// Setup Intersection Observer to detect hero section visibility
const setupHeroObserver = () => {
    // Wait for DOM to be ready and find the hero section
    setTimeout(() => {
        const heroSection = document.querySelector('.home-page-hero');
        
        if (heroSection) {
            // Create Intersection Observer
            heroObserver = new IntersectionObserver(
                (entries) => {
                    entries.forEach((entry) => {
                        // When hero is visible (intersecting), show categories
                        // When hero is not visible, hide categories
                        showCategories.value = entry.isIntersecting;
                    });
                },
                {
                    // Trigger when 20% of the hero is visible
                    threshold: 0.2,
                    rootMargin: '-80px 0px 0px 0px' // Account for sticky navbar
                }
            );
            
            heroObserver.observe(heroSection);
        }
    }, 100);
};

onMounted(() => {
    setupHeroObserver();
});

onUnmounted(() => {
    if (heroObserver) {
        heroObserver.disconnect();
    }
});
</script>

<template>
    <div class="min-h-screen bg-gray-100">
        <!-- Modern Clothing Store Navbar -->
        <nav class="bg-white shadow-md sticky top-0 z-50">
            <!-- Top Bar - Announcement/Promo -->
            <div class="bg-indigo-600 text-white text-center py-2 px-4">
                <p class="text-sm font-medium">
                    🎉 Free Shipping on Orders Over $50 | New Arrivals Now Available!
                </p>
            </div>

            <!-- Main Navbar -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <!-- Logo Section - Larger and More Prominent -->
                    <div class="flex items-center">
                        <Link :href="route('home')" class="flex items-center space-x-3 group">
                            <div class="w-12 h-12 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl flex items-center justify-center shadow-lg transform group-hover:scale-105 transition-transform duration-200">
                                <span class="text-white font-bold text-2xl">Z</span>
                            </div>
                            <div class="hidden sm:block">
                                <h1 class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Zavai</h1>
                                <p class="text-xs text-gray-500 -mt-1">Style & Comfort</p>
                            </div>
                        </Link>
                    </div>

                    <!-- Search Section - Improved Design -->
                    <div class="hidden lg:block flex-1 max-w-xl mx-8">
                        <form @submit.prevent="performSearch" class="relative">
                            <div class="relative group">
                                <Input 
                                    v-model="searchQuery" 
                                    id="search" 
                                    name="search"
                                    placeholder="Search t-shirts, hoodies, accessories..." 
                                    type="search"
                                    class="pl-12 pr-4 py-3 w-full rounded-full border-2 border-gray-200 focus:border-indigo-500 transition-all duration-200"
                                />
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-6 w-6 text-gray-400 group-focus-within:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 bg-indigo-600 text-white px-6 py-1.5 rounded-full hover:bg-indigo-700 transition-colors duration-200 text-sm font-medium">
                                    Search
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Right Section - Cart & User -->
                    <div class="flex items-center space-x-2">
                        <!-- Mobile Search Icon -->
                        <Button variant="ghost" size="sm" class="lg:hidden" @click="mobileMenuOpen = !mobileMenuOpen">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </Button>

                        <!-- Cart with Enhanced Badge -->
                        <Link :href="route('cart.index')">
                            <Button variant="ghost" size="sm" class="relative">
                                <div class="flex items-center gap-2">
                                    <div class="relative">
                                        <svg class="h-6 w-6 text-gray-700 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                        <Badge v-if="$page.props.cart.count > 0" 
                                               variant="destructive" 
                                               class="absolute -top-2 -right-2 h-5 w-5 flex items-center justify-center text-xs font-bold animate-pulse">
                                            {{ $page.props.cart.count }}
                                        </Badge>
                                    </div>
                                    <span class="hidden xl:inline text-sm font-medium">Cart</span>
                                </div>
                            </Button>
                        </Link>

                        <!-- User Menu - Compact -->
                        <div v-if="$page.props.auth.user" class="flex items-center space-x-1">
                            <Separator orientation="vertical" class="h-8 hidden md:block" />
                            
                            <Link :href="route('dashboard')">
                                <Button variant="ghost" size="sm" class="hidden md:flex">
                                    <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span class="hidden lg:inline">Account</span>
                                </Button>
                            </Link>

                            <Link :href="route('orders.history')">
                                <Button variant="ghost" size="sm" class="hidden md:flex">
                                    <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <span class="hidden lg:inline">Orders</span>
                                </Button>
                            </Link>

                            <Link :href="route('logout')" method="post" as="button">
                                <Button variant="ghost" size="sm">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                </Button>
                            </Link>
                        </div>

                        <!-- Guest Menu - Modern Design -->
                        <div v-else class="flex items-center space-x-2">
                            <Link :href="route('login')">
                                <Button variant="ghost" size="sm">
                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                    </svg>
                                    <span class="hidden sm:inline">Login</span>
                                </Button>
                            </Link>

                            <Link :href="route('register')">
                                <Button size="sm" class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700">
                                    <span class="hidden sm:inline">Sign Up</span>
                                    <span class="sm:hidden">Join</span>
                                </Button>
                            </Link>
                        </div>

                        <!-- Mobile Menu Toggle -->
                        <Button variant="ghost" size="sm" class="md:hidden" @click="mobileMenuOpen = !mobileMenuOpen">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path v-if="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </Button>
                    </div>
                </div>
            </div>

            <!-- Categories Navigation Bar with Height Transition -->
            <Transition
                enter-active-class="transition-all duration-300 ease-out"
                enter-from-class="max-h-0 opacity-0"
                enter-to-class="max-h-20 opacity-100"
                leave-active-class="transition-all duration-300 ease-in"
                leave-from-class="max-h-20 opacity-100"
                leave-to-class="max-h-0 opacity-0"
            >
                <div v-if="showCategories" class="border-t border-gray-200 bg-gray-50 overflow-hidden">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="hidden md:flex items-center justify-center space-x-1 py-3">
                            <Link 
                                v-for="category in categories" 
                                :key="category.slug"
                                :href="route('products.index', { category: category.slug })" 
                                class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:text-indigo-600 hover:bg-white rounded-lg transition-all duration-200 group">
                                <svg class="h-4 w-4 mr-2 text-gray-400 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="category.icon" />
                                </svg>
                                {{ category.name }}
                                <Badge v-if="category.slug === 'sale'" variant="destructive" class="ml-2 text-xs">Hot</Badge>
                                <Badge v-if="category.slug === 'new-arrivals'" class="ml-2 text-xs bg-green-500">New</Badge>
                            </Link>
                        </div>
                    </div>
                </div>
            </Transition>

            <!-- Mobile Menu -->
            <div v-if="mobileMenuOpen" class="md:hidden border-t border-gray-200 bg-white shadow-lg">
                <div class="px-4 py-4 space-y-3">
                    <!-- Mobile Search -->
                    <form @submit.prevent="performSearch" class="lg:hidden">
                        <div class="relative">
                            <Input 
                                v-model="searchQuery" 
                                placeholder="Search products..." 
                                type="search"
                                class="pl-10 pr-4 py-2 w-full rounded-lg"
                            />
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>
                    </form>

                    <!-- Mobile Categories -->
                    <div class="space-y-1">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-3 py-2">Shop by Category</p>
                        <Link 
                            v-for="category in categories" 
                            :key="category.slug"
                            :href="route('products.index', { category: category.slug })" 
                            class="flex items-center px-3 py-3 text-sm font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg transition-colors duration-200"
                            @click="mobileMenuOpen = false">
                            <svg class="h-5 w-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="category.icon" />
                            </svg>
                            {{ category.name }}
                        </Link>
                    </div>

                    <!-- Mobile User Links -->
                    <div v-if="$page.props.auth.user" class="border-t pt-3 space-y-1">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-3 py-2">My Account</p>
                        <Link :href="route('dashboard')" class="flex items-center px-3 py-3 text-sm font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg" @click="mobileMenuOpen = false">
                            <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            My Account
                        </Link>
                        <Link :href="route('orders.history')" class="flex items-center px-3 py-3 text-sm font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg" @click="mobileMenuOpen = false">
                            <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Order History
                        </Link>
                    </div>
                </div>
            </div>
        </nav>

        <div v-if="$page.props.flash && $page.props.flash.success"
            class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4"
            role="alert">
            <p>{{ $page.props.flash.success }}</p>
        </div>

        <main>
            <slot />
        </main>

        <!-- Enhanced Footer with shadcn-vue components -->
        <footer class="bg-gray-900 text-white" aria-labelledby="footer-heading">
            <h2 id="footer-heading" class="sr-only">Footer</h2>
            <div class="mx-auto max-w-7xl px-6 pb-8 pt-16 sm:pt-24 lg:px-8 lg:pt-32">
                <div class="xl:grid xl:grid-cols-3 xl:gap-8">
                    <!-- Brand Section -->
                    <div class="space-y-8">
                        <div class="flex items-center space-x-2">
                            <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                                <span class="text-white font-bold text-lg">Z</span>
                            </div>
                            <h1 class="text-2xl font-bold">Zavai</h1>
                        </div>
                        <p class="text-sm leading-6 text-gray-300 max-w-md">
                            Premium quality t-shirts and apparel, designed with you in mind. 
                            Experience comfort, style, and sustainability in every piece.
                        </p>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.459 8.459 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.207 0 1.031.397 2.138.893 2.738a.36.36 0 01.083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.357-.631-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001.012.001z"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Links Section -->
                    <div class="mt-16 grid grid-cols-2 gap-8 xl:col-span-2 xl:mt-0">
                        <div class="md:grid md:grid-cols-2 md:gap-8">
                            <!-- Shop Links -->
                            <div>
                                <h3 class="text-sm font-semibold leading-6 text-white">
                                    Shop
                                </h3>
                                <ul role="list" class="mt-6 space-y-4">
                                    <li>
                                        <Link :href="route('products.index')" 
                                              class="text-sm leading-6 text-gray-300 hover:text-white transition-colors duration-200">
                                            All Products
                                        </Link>
                                    </li>
                                    <li>
                                        <Link :href="route('products.index', { category: 't-shirts' })" 
                                              class="text-sm leading-6 text-gray-300 hover:text-white transition-colors duration-200">
                                            T-Shirts
                                        </Link>
                                    </li>
                                    <li>
                                        <Link :href="route('products.index', { category: 'new-arrivals' })" 
                                              class="text-sm leading-6 text-gray-300 hover:text-white transition-colors duration-200">
                                            New Arrivals
                                        </Link>
                                    </li>
                                    <li>
                                        <Link :href="route('products.index', { category: 'sale' })" 
                                              class="text-sm leading-6 text-gray-300 hover:text-white transition-colors duration-200">
                                            Sale Items
                                        </Link>
                                    </li>
                                </ul>
                            </div>

                            <!-- Customer Service -->
                            <div class="mt-10 md:mt-0">
                                <h3 class="text-sm font-semibold leading-6 text-white">
                                    Customer Service
                                </h3>
                                <ul role="list" class="mt-6 space-y-4">
                                    <li>
                                        <a href="#" class="text-sm leading-6 text-gray-300 hover:text-white transition-colors duration-200">
                                            Shipping & Returns
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="text-sm leading-6 text-gray-300 hover:text-white transition-colors duration-200">
                                            Size Guide
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="text-sm leading-6 text-gray-300 hover:text-white transition-colors duration-200">
                                            FAQ
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="text-sm leading-6 text-gray-300 hover:text-white transition-colors duration-200">
                                            Contact Us
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Company Info -->
                        <div class="md:grid md:grid-cols-2 md:gap-8">
                            <div>
                                <h3 class="text-sm font-semibold leading-6 text-white">
                                    Company
                                </h3>
                                <ul role="list" class="mt-6 space-y-4">
                                    <li>
                                        <a href="#" class="text-sm leading-6 text-gray-300 hover:text-white transition-colors duration-200">
                                            About Us
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="text-sm leading-6 text-gray-300 hover:text-white transition-colors duration-200">
                                            Our Story
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="text-sm leading-6 text-gray-300 hover:text-white transition-colors duration-200">
                                            Sustainability
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="text-sm leading-6 text-gray-300 hover:text-white transition-colors duration-200">
                                            Careers
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="mt-10 md:mt-0">
                                <h3 class="text-sm font-semibold leading-6 text-white">
                                    Account
                                </h3>
                                <ul role="list" class="mt-6 space-y-4">
                                    <li>
                                        <Link :href="route('login')" 
                                              class="text-sm leading-6 text-gray-300 hover:text-white transition-colors duration-200">
                                            Sign In
                                        </Link>
                                    </li>
                                    <li>
                                        <Link :href="route('register')" 
                                              class="text-sm leading-6 text-gray-300 hover:text-white transition-colors duration-200">
                                            Create Account
                                        </Link>
                                    </li>
                                    <li>
                                        <Link :href="route('orders.history')" 
                                              class="text-sm leading-6 text-gray-300 hover:text-white transition-colors duration-200">
                                            Order History
                                        </Link>
                                    </li>
                                    <li>
                                        <Link :href="route('cart.index')" 
                                              class="text-sm leading-6 text-gray-300 hover:text-white transition-colors duration-200">
                                            Shopping Cart
                                        </Link>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Section -->
                <div class="mt-16 border-t border-gray-800 pt-8 sm:mt-20 lg:mt-24">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <p class="text-xs leading-5 text-gray-400">
                            &copy; {{ new Date().getFullYear() }} Zavai, Inc. All rights reserved.
                        </p>
                        <div class="mt-4 md:mt-0 flex space-x-6">
                            <a href="#" class="text-xs text-gray-400 hover:text-white transition-colors duration-200">
                                Privacy Policy
                            </a>
                            <a href="#" class="text-xs text-gray-400 hover:text-white transition-colors duration-200">
                                Terms of Service
                            </a>
                            <a href="#" class="text-xs text-gray-400 hover:text-white transition-colors duration-200">
                                Cookie Policy
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>
