<template>
    <div class="bg-medium-brown px-5 py-10">
        <div class="mx-auto w-full max-w-[1200px]">
            <div class="grid grid-cols-12 gap-4 text-white">
                <div class="col-span-12 md:col-span-5 xl:col-span-3">
                    <h1 class="text-xl/5.5 font-bold">AGARWOOD HIGHLAND VALLEY INC.</h1>
                    <p class="pt-2"><i>“Connecting Farmers and Investors for a Greener Future.”</i></p>
                </div>

                <div class="col-span-5 md:col-span-3 xl:col-span-2">
                    <h1 class="text-xl font-bold text-white">Navigation</h1>
                    <div class="grid gap-1 pt-3">
                        <a
                            v-for="link in [
                                { name: 'Home', href: '#' },
                                { name: 'About Us', href: '#about' },
                                { name: 'Gallery', href: '#gallery' },
                                { name: 'Testimonials', href: '#testimonials' },
                                { name: 'Contact Us', href: '#contact' },
                            ]"
                            :key="link.name"
                            :href="link.href"
                            class="group relative w-fit"
                        >
                            {{ link.name }}
                            <span class="absolute -bottom-0.5 left-0 h-[2px] w-0 bg-white transition-all duration-300 group-hover:w-full"></span>
                        </a>
                    </div>
                </div>

                <div class="col-span-7 md:col-span-3 xl:col-span-2">
                    <h1 class="text-xl font-bold text-white">Quick Links</h1>
                    <div class="grid gap-1 pt-3">
                        <a
                            v-for="link in [
                                { name: 'Abstract', href: '#abstract' },
                                { name: 'Purpose & Objectives', href: '#Purpose' },
                                { name: 'Marketing Potential', href: '#Marketing' },
                                { name: 'Financial Plan', href: '#Financial' },
                                { name: 'Technical Feasibility', href: '#Technical' },
                            ]"
                            :key="link.name"
                            :href="link.href"
                            class="group relative w-fit"
                        >
                            {{ link.name }}
                            <span class="absolute -bottom-0.5 left-0 h-[2px] w-0 bg-white transition-all duration-300 group-hover:w-full"></span>
                        </a>
                    </div>
                </div>

                <div class="col-span-12 xl:col-span-5">
                    <h1 class="text-xl font-bold">Feedback</h1>
                    <div class="grid gap-3 pt-2 text-black">
                        <input type="text" placeholder="Your Name" class="w-full rounded-lg bg-white px-5 py-1.5 text-xl" />
                        <input type="text" placeholder="Your Occupation" class="w-full rounded-lg bg-white px-5 py-1.5 text-xl" />
                        <div class="relative">
                            <textarea
                                placeholder="Feedback"
                                class="h-[100px] w-full resize-none rounded-lg border border-medium-brown/20 bg-white py-3 pr-20 pl-5 text-xl focus:ring-2 focus:ring-medium-brown/50 focus:outline-none"
                            ></textarea>

                            <button
                                class="hover:bg-opacity-90 absolute end-3 bottom-4 rounded-lg bg-medium-brown px-5 py-0.5 text-white transition active:scale-95"
                            >
                                Send
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white px-5">
        <div class="mx-auto flex w-full max-w-[1350px] flex-wrap justify-between gap-2 py-3 text-sm">
            <div>&copy; 2026 <a href="#" class="font-bold text-medium-brown">Agarwood Highland Valley Inc.</a> - All Rights Reserved</div>
            <div>
                Designed & Developed by
                <a href="https://bb88advertising.com/" target="_blank" class="font-bold text-medium-brown"
                    >BB 88 Advertising and Digital Solutions Inc.</a
                >
            </div>
        </div>
    </div>
</template>
