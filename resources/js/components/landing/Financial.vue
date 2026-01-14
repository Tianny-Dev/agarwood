<template>
    <div id="Financial" class="relative scroll-mt-20 bg-light-brown px-4 py-10 lg:scroll-mt-14">
        <img src="images/bf.png" class="absolute start-0 bottom-0 w-[90%]" alt="" />
        <img src="images/tf.png" class="absolute end-0 top-0 w-[90%]" alt="" />

        <div class="relative mx-auto w-full max-w-[1200px]">
            <div class="mx-auto mb-7 w-fit rounded-4xl bg-white px-4 py-2 text-center sm:mb-10 sm:w-[80%]">
                <h1 class="text-4xl font-bold whitespace-nowrap text-medium-brown">Financial Plan</h1>
            </div>

            <div class="w-full bg-white p-2 shadow-black/20 shadow-lg sm:rounded-2xl sm:p-10">
                <table class="w-full border-collapse border border-medium-brown/30 text-xl text-medium-brown">
                    <thead>
                        <tr class="bg-medium-brown text-white">
                            <th colspan="2" class="py-4 text-center font-bold">Category</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-medium-brown/20">
                            <td colspan="2" class="px-3 py-4 sm:px-6">Cost of 10 Agarwood Seedlings</td>
                        </tr>
                        <tr class="border-b border-medium-brown/20">
                            <td colspan="2" class="px-3 py-4 sm:px-6">Labor and Maintenance (5 years)</td>
                        </tr>
                        <tr class="border-b border-medium-brown/20">
                            <td colspan="2" class="px-3 py-4 sm:px-6">Soil Preparation & Farm Inputs</td>
                        </tr>
                        <tr class="border-b border-medium-brown/20">
                            <td colspan="2" class="px-3 py-4 sm:px-6">Monitoring/Reporting/Admin Costs</td>
                        </tr>
                        <tr class="hidden bg-medium-brown/5 sm:block">
                            <td class="py-4 ps-6 font-bold whitespace-nowrap">Total Project Cost:</td>
                            <td class="w-full py-4 pe-6 text-end font-bold">₱150,000</td>
                        </tr>

                        <tr class="block bg-medium-brown/5 sm:hidden">
                            <td colspan="2" class="py-4 ps-3 font-bold">Total Project Cost: ₱150,000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
