<script setup>
import { Link, router } from "@inertiajs/vue3";
import { ref } from 'vue';

const searchQuery = ref('');

function performSearch() {
    if (searchQuery.value.trim()) {
        router.get(route('search.index'), { q: searchQuery.value });
    }
}
</script>

<template>
    <div class="min-h-screen bg-gray-100">
        <nav class="bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="shrink-0 flex items-center">
                            <Link :href="route('home')">
                            <h1 class="text-xl font-bold">Zavai</h1>
                            </Link>
                        </div>
                    </div>

                    <div class="flex flex-1 items-center justify-center px-2 lg:ml-6 lg:justify-end">
                        <div class="w-full max-w-lg lg:max-w-xs">
                            <form @submit.prevent="performSearch">
                                <label for="search" class="sr-only">Search</label>
                                <div class="relative">
                                    <input v-model="searchQuery" id="search" name="search"
                                        class="block w-full rounded-md border-0 bg-gray-200 py-1.5 pl-4 pr-3 text-gray-900 placeholder:text-gray-400 focus:bg-white focus:text-gray-900 focus:ring-0 sm:text-sm sm:leading-6"
                                        placeholder="Search for products..." type="search" />
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <Link :href="route('cart.index')" class="font-semibold text-gray-600 hover:text-gray-900">
                        Cart ({{ $page.props.cart.count }})
                        </Link>

                        <div v-if="$page.props.auth.user" class="flex items-center gap-1">
                            <span class="text-sm text-gray-500 mr-2">Welcome, {{ $page.props.auth.user.name }}</span>

                            <Link :href="route('dashboard')"
                                class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
                            My Account
                            </Link>

                            <Link :href="route('orders.history')"
                                class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
                            My Orders
                            </Link>

                            <Link :href="route('logout')" method="post" as="button" type="button"
                                class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
                            Log Out
                            </Link>
                        </div>

                        <template v-else>
                            <Link :href="route('login')" class="ms-4 font-semibold text-gray-600 hover:text-gray-900">
                            Log in</Link>
                            <Link :href="route('register')"
                                class="ms-4 font-semibold text-gray-600 hover:text-gray-900">Register</Link>
                        </template>
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

        <footer class="bg-white border-t border-gray-200" aria-labelledby="footer-heading">
            <h2 id="footer-heading" class="sr-only">Footer</h2>
            <div class="mx-auto max-w-7xl px-6 pb-8 pt-16 sm:pt-24 lg:px-8 lg:pt-32">
                <div class="xl:grid xl:grid-cols-3 xl:gap-8">
                    <div class="space-y-8">
                        <h1 class="text-2xl font-bold">Zavai</h1>
                        <p class="text-sm leading-6 text-gray-600">
                            High quality t-shirts and apparel, designed for you.
                        </p>
                    </div>
                    <div class="mt-16 grid grid-cols-2 gap-8 xl:col-span-2 xl:mt-0">
                        <div class="md:grid md:grid-cols-2 md:gap-8">
                            <div>
                                <h3 class="text-sm font-semibold leading-6 text-gray-900">
                                    Shop
                                </h3>
                                <ul role="list" class="mt-6 space-y-4">
                                    <li>
                                        <a href="#"
                                            class="text-sm leading-6 text-gray-600 hover:text-gray-900">T-Shirts</a>
                                    </li>
                                    <li>
                                        <a href="#" class="text-sm leading-6 text-gray-600 hover:text-gray-900">New
                                            Arrivals</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="mt-10 md:mt-0">
                                <h3 class="text-sm font-semibold leading-6 text-gray-900">
                                    About Us
                                </h3>
                                <ul role="list" class="mt-6 space-y-4">
                                    <li>
                                        <a href="#" class="text-sm leading-6 text-gray-600 hover:text-gray-900">Our
                                            Story</a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="text-sm leading-6 text-gray-600 hover:text-gray-900">Contact</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="md:grid md:grid-cols-2 md:gap-8">
                            <div>
                                <h3 class="text-sm font-semibold leading-6 text-gray-900">
                                    Customer Service
                                </h3>
                                <ul role="list" class="mt-6 space-y-4">
                                    <li>
                                        <a href="#" class="text-sm leading-6 text-gray-600 hover:text-gray-900">Shipping
                                            &
                                            Returns</a>
                                    </li>
                                    <li>
                                        <a href="#" class="text-sm leading-6 text-gray-600 hover:text-gray-900">FAQ</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-16 border-t border-gray-900/10 pt-8 sm:mt-20 lg:mt-24">
                    <p class="text-xs leading-5 text-gray-500">
                        &copy; {{ new Date().getFullYear() }} Zavai, Inc. All
                        rights reserved.
                    </p>
                </div>
            </div>
        </footer>
    </div>
</template>
