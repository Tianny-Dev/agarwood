<template>
    <div id="contact" class="scroll-mt-18 bg-light-brown px-5 py-12 lg:scroll-mt-14">
        <div class="mx-auto w-full max-w-[1200px]">
            <div class="rounded-2xl bg-white p-4 shadow-black sm:p-10">
                <div class="grid grid-cols-12 sm:gap-7">
                    <div class="col-span-12 mb-7 sm:mb-0 md:col-span-6">
                        <div class="rounded-xl bg-medium-brown p-5 sm:p-6">
                            <div>
                                <label for="" class="ps-4 text-white">Your Name</label> <br />
                                <input type="text" placeholder="Name" class="w-full rounded-full bg-white px-5 py-1.5 text-2xl" />
                            </div>

                            <div class="pt-4">
                                <label for="" class="ps-4 text-white">Your Email</label> <br />
                                <input type="email" placeholder="Email" class="w-full rounded-full bg-white px-5 py-1.5 text-2xl" />
                            </div>

                            <div class="pt-4">
                                <label for="" class="ps-4 text-white">About</label> <br />
                                <input type="text" placeholder="About" class="w-full rounded-full bg-white px-5 py-1.5 text-2xl" />
                            </div>

                            <button class="relative mt-10 w-full rounded-full bg-white px-5 py-2 text-2xl text-medium-brown">
                                Send
                                <div class="absolute end-1 top-1 grid h-10 w-10 place-items-center rounded-full bg-medium-brown">
                                    <i class="fa-regular fa-paper-plane text-white"></i>
                                </div>
                            </button>
                        </div>
                    </div>

                    <div class="col-span-12 grid place-items-center md:col-span-6">
                        <div class="w-full text-medium-brown">
                            <h1 class="text-4xl font-bold">Contact Us</h1>
                            <p class="pt-5 text-lg">
                                We’d love to hear from you, whether you’re an investor, a farmer, or just curious. Reach out using any of the options
                                below.
                            </p>

                            <div class="grid gap-6 pt-7">
                                <div class="flex gap-3 text-medium-brown">
                                    <div class="grid h-11 w-11 place-items-center rounded-full bg-white shadow-brown">
                                        <ApplicationIconPhone class="h-6 w-auto" />
                                    </div>
                                    <p class="text-sm/[16px]">
                                        Phone Number <br />
                                        <span class="text-xl">09175914370</span>
                                    </p>
                                </div>

                                <div class="flex gap-3 text-medium-brown">
                                    <div>
                                        <div class="grid h-11 w-11 place-items-center rounded-full bg-white shadow-brown">
                                            <ApplicationIconEmail class="h-5 w-auto" />
                                        </div>
                                    </div>
                                    <p class="text-sm/[16px]">
                                        Email Address <br />
                                        <span class="text-xl break-all">info@agarwoodhighlandvalley.com</span>
                                    </p>
                                </div>

                                <div class="flex gap-3 text-medium-brown">
                                    <div>
                                        <div class="grid h-11 w-11 place-items-center rounded-full bg-white shadow-brown">
                                            <img src="images/location.png" class="h-7 w-auto" alt="" />
                                        </div>
                                    </div>
                                    <p class="text-sm/[16px]">
                                        Location <br />
                                        <span class="text-xl">Aborlan, Palawan, Philippines</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
