<script setup>
import { Link } from "@inertiajs/vue3";
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

                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <div v-if="$page.props.auth.user">
                            <Link
                                :href="route('dashboard')"
                                class="font-semibold text-gray-600 hover:text-gray-900"
                                >Dashboard</Link
                            >
                        </div>
                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="font-semibold text-gray-600 hover:text-gray-900"
                                >Log in</Link
                            >
                            <Link
                                :href="route('register')"
                                class="ms-4 font-semibold text-gray-600 hover:text-gray-900"
                                >Register</Link
                            >
                            <Link
                                :href="route('cart.index')"
                                class="ms-4 font-semibold text-gray-600 hover:text-gray-900"
                            >
                                Cart ({{ $page.props.cart.count }})
                            </Link>
                        </template>
                    </div>
                </div>
            </div>
        </nav>

        <div
            v-if="$page.props.flash && $page.props.flash.success"
            class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4"
            role="alert"
        >
            <p>{{ $page.props.flash.success }}</p>
        </div>

        <main>
            <slot />
        </main>
    </div>
</template>
