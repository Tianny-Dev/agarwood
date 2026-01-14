<script setup lang="ts">
import About from '@/components/landing/About.vue';
import Abstract from '@/components/landing/Abstract.vue';
import Banner from '@/components/landing/Banner.vue';
import Contact from '@/components/landing/Contact.vue';
import Core from '@/components/landing/Core.vue';
import Financial from '@/components/landing/Financial.vue';
import Footer from '@/components/landing/Footer.vue';
import Gallery from '@/components/landing/Gallery.vue';
import Map from '@/components/landing/Map.vue';
import Marketing from '@/components/landing/Marketing.vue';
import Project from '@/components/landing/Project.vue';
import Purpose from '@/components/landing/Purpose.vue';
import Technical from '@/components/landing/Technical.vue';
import Testimonials from '@/components/landing/Testimonials.vue';

import GuestLayout from '@/layouts/GuestLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Home" />
    <GuestLayout>
        <!-- Banner Start -->
        <Banner />
        <!-- Banner End -->

        <!-- about us start -->
        <About />
        <!-- about us end -->

        <!-- core values start -->
        <Core />
        <!-- core values end -->

        <!-- gallery start -->
        <Gallery />
        <!-- gallery end -->

        <!-- abstract start -->
        <Abstract />
        <!-- abstract end -->

        <!-- project overview start -->
        <Project />
        <!-- project overview end -->

        <!-- purpose & Objectives start -->
        <Purpose />
        <!-- purpose & Objectives end -->

        <!-- marketing potential start -->
        <Marketing />
        <!-- marketing potential end -->

        <!-- Financial Plan start -->
        <Financial />
        <!-- Financial Plan end -->

        <!-- Technical Feasibility start -->
        <Technical />
        <!-- Technical Feasibility end -->

        <!-- Testimonials start -->
        <Testimonials />
        <!-- Testimonials end -->

        <!-- contact us start -->
        <Contact />
        <!-- contact us start -->

        <!-- map start -->
        <Map />
        <!-- map start -->

        <!-- footer start -->
        <Footer />
        <!-- footer end -->
    </GuestLayout>
</template>
