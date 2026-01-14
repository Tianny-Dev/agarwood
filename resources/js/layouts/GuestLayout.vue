<script setup lang="ts">
import ApplicationIconEmail from '@/components/ApplicationIconEmail.vue';
import ApplicationIconPhone from '@/components/ApplicationIconPhone.vue';
import ApplicationLogo from '@/components/ApplicationLogo.vue';
import { login } from '@/routes';
import { Link } from '@inertiajs/vue3';
import { onMounted, onUnmounted, ref, watch } from 'vue';

const isMenuOpen = ref(false);
const isSticky = ref(false);
const activeSection = ref('home'); // Tracks the current active ID

// Prevent scrolling when mobile menu is open
watch(isMenuOpen, (val) => {
    document.body.style.overflow = val ? 'hidden' : 'auto';
});

// Detect scroll position for sticky effect
const handleScroll = () => {
    isSticky.value = window.scrollY > 50;
};

// Intersection Observer for Active State
let observer: IntersectionObserver | null = null;

onMounted(() => {
    window.addEventListener('scroll', handleScroll);

    // Observe sections
    const options = {
        root: null,
        rootMargin: '-20% 0px -70% 0px', // Adjusts when the "active" switch happens
        threshold: 0,
    };

    observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                activeSection.value = entry.target.id || 'home';
            }
        });
    }, options);

    // Sections to watch (ensure these IDs exist in your content)
    const sections = ['about', 'gallery', 'abstract', 'testimonials', 'contact'];
    sections.forEach((id) => {
        const el = document.getElementById(id);
        if (el) observer?.observe(el);
    });

    // Special case for Home (top of page)
    window.addEventListener('scroll', () => {
        if (window.scrollY < 100) activeSection.value = 'home';
    });
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
    observer?.disconnect();
});

const navLinks = [
    { name: 'Home', id: 'home', href: '#' },
    { name: 'About Us', id: 'about', href: '#about' },
    { name: 'Gallery', id: 'gallery', href: '#gallery' },
    { name: 'Abstract', id: 'abstract', href: '#abstract' },
    { name: 'Testimonials', id: 'testimonials', href: '#testimonials' },
    { name: 'Contact Us', id: 'contact', href: '#contact' },
];
</script>

<template>
    <header class="sticky top-0 z-20 w-full bg-light-brown px-5 shadow-sm lg:relative lg:shadow-none">
        <div class="mx-auto w-full max-w-[1200px] pt-4 pb-4 lg:pb-13">
            <div class="flex items-center justify-between">
                <div>
                    <Link href="/">
                        <ApplicationLogo class="h-16 w-auto lg:h-20" />
                    </Link>
                </div>

                <div class="hidden lg:block">
                    <div class="flex items-center gap-8">
                        <div class="flex gap-3 text-medium-brown">
                            <div class="grid h-11 w-11 place-items-center rounded-full bg-white">
                                <ApplicationIconPhone class="h-6 w-auto" />
                            </div>
                            <p class="text-sm/[16px]">
                                Phone Number <br />
                                <span class="text-xl">09175914370</span>
                            </p>
                        </div>

                        <div class="flex gap-3 text-medium-brown">
                            <div class="grid h-11 w-11 place-items-center rounded-full bg-white">
                                <ApplicationIconEmail class="h-5 w-auto" />
                            </div>
                            <p class="text-sm/[16px]">
                                Email Address <br />
                                <span class="text-xl">info@agarwoodhighlandvalley.com</span>
                            </p>
                        </div>

                        <Link :href="login()" class="rounded-3xl bg-medium-brown px-14 py-2 text-xl font-bold text-white">Log in</Link>
                    </div>
                </div>

                <button @click="isMenuOpen = !isMenuOpen" class="z-50 p-2 text-medium-brown focus:outline-none lg:hidden">
                    <i :class="isMenuOpen ? 'fa-solid fa-xmark' : 'fa-solid fa-bars'" class="text-3xl"></i>
                </button>
            </div>
        </div>

        <div v-if="isMenuOpen" class="fixed inset-x-0 top-[95px] bottom-0 z-[99] overflow-y-auto bg-light-brown px-5 pb-10 lg:hidden">
            <div class="flex flex-col gap-6 pt-6">
                <div class="relative w-full">
                    <input
                        class="w-full rounded-full border-0 bg-white px-6 py-3 text-lg text-slate-700 shadow-sm focus:outline-none"
                        placeholder="Search..."
                    />
                    <button class="absolute top-2 right-2 h-10 w-10 rounded-full bg-medium-brown text-white">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
                <nav class="flex flex-col gap-4 text-center">
                    <a
                        v-for="link in navLinks"
                        :key="link.id"
                        :href="link.href"
                        @click="isMenuOpen = false"
                        class="text-xl transition-colors"
                        :class="activeSection === link.id ? 'font-bold text-medium-brown underline' : 'text-medium-brown'"
                    >
                        {{ link.name }}
                    </a>
                </nav>
                <hr class="border-medium-brown/20" />
                <Link :href="login()" class="block w-full rounded-3xl bg-medium-brown py-3 text-center text-xl font-bold text-white">Log in</Link>
            </div>
        </div>
    </header>

    <div class="sticky top-0 z-30 hidden w-full px-5 transition-all duration-300 lg:block">
        <div class="relative mx-auto w-full max-w-[1200px]">
            <div
                class="absolute w-full rounded-md bg-medium-brown px-3 py-2.5 shadow-lg transition-all duration-300 ease-in-out"
                :class="isSticky ? 'top-0 mt-2' : 'top-[-28px]'"
            >
                <div class="flex items-center justify-center gap-10">
                    <div class="w-full max-w-sm min-w-[180px]">
                        <div class="relative">
                            <input
                                class="ease w-full rounded-full border-0 bg-white py-1.5 pr-28 pl-4 text-lg text-slate-700 shadow-sm transition duration-300 placeholder:text-slate-400 focus:outline-none"
                                placeholder="Search."
                            />
                            <button class="absolute top-1 right-1.5 h-8 w-8 place-items-center rounded-full bg-medium-brown text-white" type="button">
                                <i class="fa-solid fa-magnifying-glass text-white"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex justify-center gap-4">
                        <a
                            v-for="link in navLinks"
                            :key="link.id"
                            :href="link.href"
                            class="rounded-sm px-2 py-0 text-lg whitespace-nowrap transition-all duration-300"
                            :class="
                                activeSection === link.id
                                    ? 'scale-105 bg-light-brown text-medium-brown'
                                    : 'bg-medium-brown text-white hover:bg-light-brown/20'
                            "
                        >
                            {{ link.name }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <main>
        <slot />
    </main>
</template>
