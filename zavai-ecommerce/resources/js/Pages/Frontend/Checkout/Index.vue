<script setup>
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import ShopLayout from "@/Layouts/ShopLayout.vue";
import { computed } from "vue";

const props = defineProps({
    cartItems: Object,
});

// Log වෙලා ඉන්න user ගේ details ගන්නවා
const user = usePage().props.auth.user;

// Inertia වල form helper එක පාවිච්චි කරනවා
const form = useForm({
    customer_name: user ? user.name : "",
    customer_email: user ? user.email : "",
    address: "",
    phone: "",
});

const cartTotal = computed(() => {
    let total = 0;
    for (const productId in props.cartItems) {
        total +=
            props.cartItems[productId].price *
            props.cartItems[productId].quantity;
    }
    return total.toFixed(2);
});

const submit = () => {
    form.post(route('checkout.store'), {
        onError: () => {
            // Handle validation errors if any
        },
        onSuccess: () => {
            // Backend එකෙන් redirect කරන නිසා මෙතනට විශේෂ දෙයක් ඕන නෑ
        }
    });
};
</script>

<template>
    <Head title="Checkout" />

    <ShopLayout>
        <div class="mx-auto max-w-7xl px-4 pt-16 pb-24 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">
                Checkout
            </h1>

            <form
                @submit.prevent="submit"
                class="lg:grid lg:grid-cols-2 lg:gap-x-12 xl:gap-x-16 mt-12"
            >
                <div>
                    <h2 class="text-lg font-medium text-gray-900">
                        Shipping Information
                    </h2>

                    <div
                        class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4"
                    >
                        <div class="sm:col-span-2">
                            <label
                                for="customer_name"
                                class="block text-sm font-medium text-gray-700"
                                >Full Name</label
                            >
                            <div class="mt-1">
                                <input
                                    v-model="form.customer_name"
                                    type="text"
                                    id="customer_name"
                                    name="customer_name"
                                    required
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                />
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label
                                for="customer_email"
                                class="block text-sm font-medium text-gray-700"
                                >Email Address</label
                            >
                            <div class="mt-1">
                                <input
                                    v-model="form.customer_email"
                                    type="email"
                                    id="customer_email"
                                    name="customer_email"
                                    required
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                />
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label
                                for="address"
                                class="block text-sm font-medium text-gray-700"
                                >Address</label
                            >
                            <div class="mt-1">
                                <input
                                    v-model="form.address"
                                    type="text"
                                    id="address"
                                    name="address"
                                    required
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                />
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label
                                for="phone"
                                class="block text-sm font-medium text-gray-700"
                                >Phone</label
                            >
                            <div class="mt-1">
                                <input
                                    v-model="form.phone"
                                    type="text"
                                    id="phone"
                                    name="phone"
                                    required
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-10 lg:mt-0">
                    <h2 class="text-lg font-medium text-gray-900">
                        Order summary
                    </h2>
                    <div
                        class="mt-4 rounded-lg border border-gray-200 bg-white shadow-sm"
                    >
                        <ul
                            role="list"
                            class="divide-y divide-gray-200 px-4 sm:px-6"
                        >
                            <li
                                v-for="(item, productId) in cartItems"
                                :key="productId"
                                class="flex items-center py-6"
                            >
                                <img
                                    :src="'/storage/' + item.image_path"
                                    class="h-20 w-20 flex-none rounded-md object-cover object-center"
                                />
                                <div class="ml-4 flex-auto">
                                    <h3 class="font-medium text-gray-900">
                                        {{ item.name }}
                                    </h3>
                                    <p class="text-gray-500">
                                        Qty: {{ item.quantity }}
                                    </p>
                                </div>
                                <p class="flex-none font-medium text-gray-900">
                                    Rs.
                                    {{
                                        (item.price * item.quantity).toFixed(2)
                                    }}
                                </p>
                            </li>
                        </ul>
                        <dl
                            class="space-y-6 border-t border-gray-200 px-4 py-6 sm:px-6"
                        >
                            <div
                                class="flex items-center justify-between text-base font-medium text-gray-900"
                            >
                                <dt>Total</dt>
                                <dd>Rs. {{ cartTotal }}</dd>
                            </div>
                        </dl>
                        <div class="border-t border-gray-200 px-4 py-6 sm:px-6">
                            <button
                                type="submit"
                                class="w-full rounded-md border border-transparent bg-indigo-600 px-4 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700"
                            >
                                Place Order
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </ShopLayout>
</template>
