<script setup>
import { Head, Link } from '@inertiajs/vue3';
import ShopLayout from '../../Layouts/ShopLayout.vue';
import Button from '../../Components/ui/Button.vue';
import { Separator } from '../../Components/ui/separator';
import { Badge } from '../../Components/ui/badge';
import { Card, CardContent, CardHeader, CardTitle } from '../../Components/ui/card';
import { ref, onMounted, onUnmounted, computed } from 'vue';

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

// Wishlist functionality
const wishlist = ref(new Set());

const toggleWishlist = (productId) => {
    if (wishlist.value.has(productId)) {
        wishlist.value.delete(productId);
    } else {
        wishlist.value.add(productId);
    }
};

const isInWishlist = (productId) => {
    return wishlist.value.has(productId);
};

// Quick add to cart functionality
const addToCart = (productId, event) => {
    event.preventDefault();
    event.stopPropagation();
    // Add to cart logic here
    console.log('Adding to cart:', productId);
};

// Generate random ratings for demo
const getRandomRating = () => {
    return (Math.random() * 2 + 3).toFixed(1); // 3.0 to 5.0
};

// Check if product is on sale
const isOnSale = () => {
    return Math.random() > 0.7; // 30% chance of being on sale
};

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
                            <Button as-child size="lg" class="bg-white text-gray-900 hover:bg-gray-100 border-0 shadow-lg">
                                <Link :href="route('products.index')" class="font-semibold">
                                    {{ slides[currentSlide].buttonText }}
                                </Link>
                            </Button>
                        </div>
                    </div>
                </Transition>
            </div>

            <Button @click="prevSlide" variant="ghost" size="icon"
                class="absolute left-0 top-1/2 -translate-y-1/2 ml-4 bg-black/30 hover:bg-black/50 text-white border-0 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </Button>
            <Button @click="nextSlide" variant="ghost" size="icon"
                class="absolute right-0 top-1/2 -translate-y-1/2 mr-4 bg-black/30 hover:bg-black/50 text-white border-0 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </Button>

            <div class="absolute bottom-5 left-1/2 -translate-x-1/2 flex space-x-2">
                <Button v-for="(slide, index) in slides" :key="`dot-${index}`" @click="goToSlide(index)"
                    variant="ghost" size="icon"
                    class="h-2 w-2 rounded-full p-0 border-0 transition-all duration-300"
                    :class="index === currentSlide ? 'bg-white scale-110' : 'bg-white/50 hover:bg-white hover:scale-105'">
                </Button>
            </div>
        </div>
        <!-- Home Page Header End -->
        <!-- Debug: Show categories count -->
        <div v-if="!categories || categories.length === 0" class="bg-white py-16 text-center">
            <p class="text-gray-500">No categories with products found.</p>
            <p class="text-sm text-gray-400 mt-2">Categories count: {{ categories ? categories.length : 'undefined' }}
            </p>
        </div>

        <div v-for="(category, categoryIndex) in categories" :key="category.id" class="bg-white">
            <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
                <!-- Category Header with Enhanced Styling -->
                <div class="mb-8">
                    <div class="flex items-center gap-4 mb-2">
                        <h2 class="text-3xl font-bold tracking-tight text-gray-900">
                            {{ category.name }}
                        </h2>
                        <Badge variant="secondary" class="text-sm px-3 py-1">
                            {{ category.products?.length || 0 }} items
                        </Badge>
                    </div>
                    <Link :href="route('products.index', { category: category.slug })" 
                          class="text-sm text-indigo-600 hover:text-indigo-800 hover:underline transition-colors duration-200">
                        View All →
                    </Link>
                </div>

                <!-- Enhanced Product Grid with Better Responsive Design -->
                <div class="grid grid-cols-1 gap-4 sm:gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5">

                    <div v-for="product in category.products" :key="product.id" class="group">
                        <Card class="overflow-hidden transition-all duration-300 hover:shadow-2xl hover:scale-105 border-0 shadow-md relative">
                            <!-- Sale Badge -->
                            <div v-if="isOnSale()" class="absolute top-3 left-3 z-10">
                                <Badge variant="destructive" class="bg-red-500 text-white shadow-lg">
                                    Sale
                                </Badge>
                            </div>
                            
                            <!-- Wishlist Button -->
                            <Button 
                                @click="toggleWishlist(product.id)" 
                                variant="ghost" 
                                size="icon"
                                class="absolute top-3 right-3 z-10 bg-white/90 hover:bg-white shadow-lg transition-all duration-300"
                                :class="isInWishlist(product.id) ? 'text-red-500' : 'text-gray-400'"
                            >
                                <svg v-if="isInWishlist(product.id)" class="h-5 w-5 fill-current" viewBox="0 0 24 24">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                </svg>
                                <svg v-else class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </Button>

                            <!-- Product Image with Enhanced Effects -->
                            <Link :href="route('products.show', product.id)">
                                <div class="relative aspect-square w-full overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100">
                                    <img v-if="product.image_path" 
                                         :src="'/storage/' + product.image_path" 
                                         :alt="product.name"
                                         class="h-full w-full object-cover object-center group-hover:scale-110 transition-transform duration-700 ease-out" />
                                    <div v-else class="h-full w-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                                        <div class="text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span class="text-sm text-gray-500 mt-2">No Image</span>
                                        </div>
                                    </div>
                                    <!-- Hover Overlay -->
                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-all duration-300"></div>
                                </div>
                            </Link>
                            
                            <!-- Enhanced Product Info -->
                            <CardContent class="p-5">
                                <Link :href="route('products.show', product.id)">
                                    <CardTitle class="text-lg font-semibold tracking-tight text-gray-900 line-clamp-2 mb-3 group-hover:text-indigo-600 transition-colors duration-200">
                                        {{ product.name }}
                                    </CardTitle>
                                </Link>
                                
                                <!-- Rating Stars -->
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="flex items-center">
                                        <template v-for="star in 5" :key="star">
                                            <svg 
                                                class="h-4 w-4" 
                                                :class="star <= Math.floor(getRandomRating()) ? 'text-yellow-400 fill-current' : 'text-gray-300'"
                                                viewBox="0 0 24 24"
                                            >
                                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                            </svg>
                                        </template>
                                    </div>
                                    <span class="text-sm text-gray-500">{{ getRandomRating() }}</span>
                                    <span class="text-sm text-gray-400">({{ Math.floor(Math.random() * 100) + 10 }})</span>
                                </div>
                                
                                <!-- Price and Action Section -->
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex flex-col">
                                        <div class="flex items-center gap-2">
                                            <p class="text-xl font-bold text-gray-900">
                                                Rs. {{ product.price }}
                                            </p>
                                            <p v-if="isOnSale()" class="text-sm text-gray-500 line-through">
                                                Rs. {{ Math.floor(product.price * 1.3) }}
                                            </p>
                                        </div>
                                        <p class="text-sm text-gray-500">Free shipping</p>
                                    </div>
                                </div>
                                
                                <!-- Quick Add to Cart Button -->
                                <Button 
                                    @click="addToCart(product.id, $event)"
                                    variant="default" 
                                    size="sm" 
                                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white transition-all duration-300"
                                >
                                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01" />
                                    </svg>
                                    Add to Cart
                                </Button>
                            </CardContent>
                        </Card>
                    </div>

                </div>
                
                <!-- Category Separator -->
                <div v-if="categoryIndex < categories.length - 1" class="mt-16">
                    <Separator class="mx-auto max-w-2xl" />
                </div>
            </div>
        </div>
        
        <!-- Final Section Separator -->
        <div class="bg-white">
            <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                <Separator />
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

/* Enhanced Product Card Styles */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Smooth hover transitions */
.group:hover .group-hover\:scale-110 {
    transform: scale(1.1);
}

.group:hover .group-hover\:text-indigo-600 {
    color: rgb(79 70 229);
}

/* Enhanced shadow effects */
.hover\:shadow-2xl:hover {
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

/* Gradient backgrounds */
.bg-gradient-to-br {
    background-image: linear-gradient(to bottom right, var(--tw-gradient-stops));
}
</style>