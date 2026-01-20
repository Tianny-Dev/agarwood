<template>
    <div class="relative px-5 py-16">
        <div class="core-bg absolute start-0 top-0 h-[45%] w-full bg-cover bg-center bg-no-repeat xl:h-full xl:w-[55%]"></div>
        <div class="absolute end-0 bottom-0 h-[55%] w-full bg-dark-brown xl:h-full xl:w-[45%]"></div>
        <div class="relative mx-auto w-full max-w-[1200px]">
            <div class="grid grid-cols-12 md:gap-7">
                <div class="col-span-12 mb-12 md:col-span-6 xl:col-span-4 xl:mb-0">
                    <div class="relative rounded-2xl bg-light-brown p-5">
                        <div class="absolute start-0 end-0 top-[-15px] mx-auto grid h-30 w-35 place-items-center rounded-b-full bg-medium-brown pt-1">
                            <img src="images/mission.png" class="h-18" alt="" />
                        </div>

                        <h1 class="pt-25 text-center text-4xl font-bold text-dark-brown">Mission</h1>
                        <p class="pt-2 text-lg/6 text-dark-brown">
                            To build a <strong>sustainable partnerships between investors and farmers</strong> by cultivating Agarwood through
                            transparent, eco-friendly, and community-driven agroforestry models that generate long-term value.
                        </p>
                    </div>
                </div>

                <div class="col-span-12 mb-10 md:col-span-6 xl:col-span-4 xl:mb-0">
                    <div class="relative rounded-2xl bg-light-brown p-5">
                        <div class="absolute start-0 end-0 top-[-15px] mx-auto grid h-30 w-35 place-items-center rounded-b-full bg-medium-brown pt-5">
                            <img src="images/vision.png" class="h-13" alt="" />
                        </div>

                        <h1 class="pt-25 text-center text-4xl font-bold text-dark-brown">Vision</h1>
                        <p class="pt-2 text-lg/6 text-dark-brown">
                            To become a <strong>leading model of sustainable Agarwood farming</strong> in the Philippines, empowering farmers,
                            protecting the environment, and connecting local efforts to the global demand for high-value natural products.
                        </p>
                    </div>
                </div>

                <div class="col-span-12 xl:col-span-4">
                    <div class="grid place-items-center">
                        <h1 class="text-4xl font-bold text-white">Core Values</h1>
                        <p class="pt-3 leading-5.5 text-white">
                            <strong>Sustainability</strong> - We prioritize eco-friendly farming and reforestation.
                            <br />
                            <strong>Transparency</strong> - We ensure clear agreements, fair reporting, and accountability.
                            <br />
                            <strong>Empowerment</strong> - We train and support farmers to grow with confidence.
                            <br />
                            <strong>Innovation</strong> - We combine science-based methods with traditional practices.
                            <br />
                            <strong>Community Impact</strong> - We create jobs, income, and opportunities for rural communities.
                            <br />
                            <strong>Integrity</strong> - We build trust through honesty, responsibility, and long-term commitment.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.core-bg {
    background-image: url('/images/mv.jpg');
}
</style>
