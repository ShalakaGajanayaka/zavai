<script setup>
import { Head, Link } from '@inertiajs/vue3';
import ShopLayout from '../../Layouts/ShopLayout.vue';
import Button from '../../Components/ui/Button.vue';
import { ref, onMounted, onUnmounted } from 'vue';

const props = defineProps({
    categories: Array,
});

const slides = ref([
    {
        title: 'New Season Arrivals',
        subtitle: 'Check out all the new trends for the upcoming season. Find your style with Zavai.',
        image: 'https://images.unsplash.com/photo-1525134479668-1bee5c7c6845?q=80&w=1920&auto=format&fit=crop',
        buttonText: 'Shop Now',
        buttonLink: '#',
    },
    {
        title: 'Exclusive T-Shirts',
        subtitle: 'Unique designs that you won\'t find anywhere else. Express yourself with our collection.',
        image: 'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?q=80&w=1920&auto=format&fit=crop',
        buttonText: 'Explore T-Shirts',
        buttonLink: '#',
    },
    {
        title: 'Comfort & Style',
        subtitle: 'Our apparel is made with the highest quality materials for maximum comfort.',
        image: 'https://images.unsplash.com/photo-1576566588028-4147f3842f27?q=80&w=1920&auto=format&fit=crop',
        buttonText: 'Discover More',
        buttonLink: '#',
    }
]);

const currentSlide = ref(0);
let slideInterval;

// Timer එක reset කරන function එක
const resetInterval = () => {
    clearInterval(slideInterval);
    slideInterval = setInterval(() => {
        currentSlide.value = (currentSlide.value + 1) % slides.value.length;
    }, 7000);
};

// ඊළඟ slide එකට යන function එක
const nextSlide = () => {
    currentSlide.value = (currentSlide.value + 1) % slides.value.length;
    resetInterval();
};

// කලින් slide එකට යන function එක
const prevSlide = () => {
    currentSlide.value = (currentSlide.value - 1 + slides.value.length) % slides.value.length;
    resetInterval();
};

// Indicator dot එකකින් අදාල slide එකට යන function එක
const goToSlide = (index) => {
    currentSlide.value = index;
    resetInterval();
};

onMounted(() => {
    resetInterval(); // Slideshow එක පටන් ගන්නවා
});

onUnmounted(() => {
    clearInterval(slideInterval);
});

// Debug: Log the categories data
// console.log('Categories received:', props.categories);
</script>

<template>

    <Head title="Welcome to Zavai" />

    <ShopLayout>
        <!-- Home Page Header Start -->
        <div class="relative bg-gray-900 h-[36rem] sm:h-[40rem] lg:h-[44rem] overflow-hidden">
            <TransitionGroup name="fade" tag="div">
                <div v-for="(slide, index) in slides" :key="index" v-show="index === currentSlide"
                    class="absolute inset-0">
                    <img class="h-full w-full object-cover" :src="slide.image" :alt="`Slide ${index + 1}`">
                    <div class="absolute inset-0 bg-gray-700 mix-blend-multiply" aria-hidden="true"></div>
                </div>
            </TransitionGroup>

            <div class="relative mx-auto flex max-w-3xl flex-col items-center px-6 py-32 text-center sm:py-64 lg:px-0">
                <Transition name="fade" mode="out-in">
                    <div :key="currentSlide">
                        <h1 class="text-4xl font-bold tracking-tight text-white sm:text-6xl">{{
                            slides[currentSlide].title }}</h1>
                        <p class="mt-4 text-xl text-white">{{ slides[currentSlide].subtitle }}</p>
                        <div class="mt-8">
                            <Button as="a" :href="slides[currentSlide].buttonLink" size="lg">{{
                                slides[currentSlide].buttonText }}</Button>
                        </div>
                    </div>
                </Transition>
            </div>

            <button @click="prevSlide"
                class="absolute left-0 top-1/2 -translate-y-1/2 ml-4 p-2 rounded-full bg-black/30 hover:bg-black/50 text-white transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button @click="nextSlide"
                class="absolute right-0 top-1/2 -translate-y-1/2 mr-4 p-2 rounded-full bg-black/30 hover:bg-black/50 text-white transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            <div class="absolute bottom-5 left-1/2 -translate-x-1/2 flex space-x-2">
                <button v-for="(slide, index) in slides" :key="`dot-${index}`" @click="goToSlide(index)"
                    class="h-2 w-2 rounded-full transition"
                    :class="index === currentSlide ? 'bg-white' : 'bg-white/50 hover:bg-white'"></button>
            </div>
        </div>
        <!-- Home Page Header End -->
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

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 1.5s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>