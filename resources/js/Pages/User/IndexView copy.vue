<template>
    <section>
        <nav class="relative px-4 py-4 flex justify-between items-center bg-gradient-to-r from-sky-500 to-green-500 ">
            <a class="text-3xl font-bold leading-none" href="#">
                <img src="favicon/logo1.png" class="header-brand-img" width="270" alt="tabler logo">

            </a>

            <ul class="hidden   lg:flex lg:items-center  lg:space-x-2">
                <!-- Menu Items -->
                <li class="transition ease-in-out delay-50 hover:-translate-y-1 hover:scale-110 duration-300">
                    <router-link :to="{ hash: '#services' }">Scroll to Services</router-link>

                    <a class="text-sm text-white  " href="#">Jadwal Pendaftaran</a>
                </li>
                <li class="text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" class="w-4 h-4 current-fill"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 5v0m0 7v0m0 7v0m0-13a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                    </svg>
                </li>
                <li class="transition ease-in-out delay-50 hover:-translate-y-1 hover:scale-110 duration-300">

                    <a class="text-sm text-white " href="#">Petunjuk Pendaftaran</a>
                </li>
                <li class="text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" class="w-4 h-4 current-fill"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 5v0m0 7v0m0 7v0m0-13a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                    </svg>
                </li>

                <li class="transition ease-in-out delay-50 hover:-translate-y-1 hover:scale-110 duration-300">
                    <a class="text-sm text-white " href="#">Jalur Seleksi</a>
                </li>
                <li class="text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" class="w-4 h-4 current-fill"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 5v0m0 7v0m0 7v0m0-13a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                    </svg>
                </li>

                <li class="transition ease-in-out delay-50 hover:-translate-y-1 hover:scale-110 duration-300">
                    <a class="text-sm text-white " href="#">Beasiswa</a>
                </li>
                <li class="text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" class="w-4 h-4 current-fill"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 5v0m0 7v0m0 7v0m0-13a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                    </svg>
                </li>

                <li class="transition ease-in-out delay-50 hover:-translate-y-1 hover:scale-110 duration-300">
                    <a class="text-sm text-white " href="#">Program Studi</a>
                </li>
                <li class="text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" class="w-4 h-4 current-fill"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 5v0m0 7v0m0 7v0m0-13a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                    </svg>
                </li>

                <li class="transition ease-in-out delay-50 hover:-translate-y-1 hover:scale-110 duration-300">
                    <a class="text-sm text-white " href="#">Hasil tes</a>
                </li>
            </ul>

            <div class="lg:flex">

                <a class="hidden lg:inline-block py-2 px-6 mx-6 bg-white text-green-500 hover:bg-green-500 hover:text-white text-sm font-bold rounded-xl transition duration-200"
                    href="#">login</a>
                <a class="hidden lg:inline-block py-2 px-6 border border-white text-white hover:bg-white hover:text-green-500 text-sm font-bold rounded-xl transition duration-200"
                    href="#">Daftar</a>
                <div class="lg:hidden">
                    <button class="navbar-burger flex items-center text-white p-3" @click="toggleMenu">
                        <svg class="block h-4 w-4 fill-current" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <!-- SVG Path -->
                            <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </nav>
        <div v-if="menuVisible" class="navbar-menu relative z-50">
            <div class="navbar-backdrop fixed inset-0 bg-gray-800 opacity-25" @click="toggleMenu"></div>
            <nav
                class="fixed top-0 left-0 bottom-0 flex flex-col w-5/6 max-w-sm py-6 px-6 bg-white border-r overflow-y-auto">
                <!-- Mobile Menu Content -->
                <li class="transition  ease-in-out delay-50 hover:-translate-y-1 hover:scale-110 duration-300 ">
                    <a class="block p-4 text-sm font-semibold  hover:bg-blue-50 hover:text-blue-600 rounded" href="#">Jadwal
                        Pendaftaran</a>
                </li>

                <li class="transition  ease-in-out delay-50 hover:-translate-y-1 hover:scale-110 duration-300 ">

                    <a class="block p-4 text-sm font-semibold  hover:bg-blue-50 hover:text-blue-600 rounded"
                        href="#">Petunjuk Pendaftaran</a>
                </li>


                <li class="transition  ease-in-out delay-50 hover:-translate-y-1 hover:scale-110 duration-300 ">
                    <a class="block p-4 text-sm font-semibold  hover:bg-blue-50 hover:text-blue-600 rounded" href="#">Jalur
                        Seleksi</a>
                </li>

                <li class="transition  ease-in-out delay-50 hover:-translate-y-1 hover:scale-110 duration-300 ">

                    <a class="block p-4 text-sm font-semibold  hover:bg-blue-50 hover:text-blue-600 rounded"
                        href="#">Beasiswa</a>
                </li>


                <li class="transition  ease-in-out delay-50 hover:-translate-y-1 hover:scale-110 duration-300 ">
                    <a class="block p-4 text-sm font-semibold  hover:bg-blue-50 hover:text-blue-600 rounded"
                        href="#">Program Studi</a>
                </li>


                <li class="transition  ease-in-out delay-50 hover:-translate-y-1 hover:scale-110 duration-300 ">
                    <a class="block p-4 text-sm font-semibold  hover:bg-blue-50 hover:text-blue-600 rounded" href="#">Hasil
                        tes</a>
                </li>
            </nav>
        </div>
    </section>


    <section class="py-12 flex justify-center" id="features">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h2 class="display-4 text-center font-semibold">Lorem ipsum dolor sit amet</h2>
                </div>
            </div>
            <div class="grid grid-cols-3 grid-rows-1 gap-4  ">

                <div class="col md:w-10/12  mx-auto my-6">
                    <div class="rounded overflow-hidden">
                        <div class="relative overflow-hidden">
                            <img class=" shadow-lg " src="image/aab.png" alt="phone feature 1" loading="lazy" />
                            <div class="w-full h-full">
                                <div class="z-index:-1 relative">
                                    <div class="absolute bg-blue rounded-full w-[120px] h-[120px] left-[-30px] top-[-10px]">
                                    </div>
                                    <div
                                        class="absolute bg-blue rounded-full w-[140px] h-[140px] right-[-30px] bottom-[80px]">
                                    </div>
                                    <div class="absolute bg-blue rounded-full w-[60px] h-[60px] left-[20%] bottom-[30px]">
                                    </div>
                                </div>
                                <div class="w-full h-full absolute bg-blue-300 z-[-2]"></div>
                            </div>
                        </div>
                        <div class="bg-blue-50">
                            <div class="flex justify-center mb-4">
                                <i class="fa text-3xl fa-globe text-primary my-auto"></i>
                                <h3 class="ml-6">Lorem Ipsum</h3>
                            </div>
                            <p class="py-2 font-semibolder text-center text-muted">Lorem ipsum dolor sit amet, consectetur
                                adipiscing elit. Donec tempus auctor.</p>
                        </div>
                    </div>
                </div>
                <div class="col md:w-10/12  mx-auto my-6">
                    <div class="rounded overflow-hidden">
                        <div class="relative overflow-hidden">
                            <img class=" shadow-lg " src="image/aab.png" alt="phone feature 1" loading="lazy" />
                            <div class="w-full h-full">
                                <div class="z-index:-1 relative">
                                    <div class="absolute bg-blue rounded-full w-[120px] h-[120px] left-[-30px] top-[-10px]">
                                    </div>
                                    <div
                                        class="absolute bg-blue rounded-full w-[140px] h-[140px] right-[-30px] bottom-[80px]">
                                    </div>
                                    <div class="absolute bg-blue rounded-full w-[60px] h-[60px] left-[20%] bottom-[30px]">
                                    </div>
                                </div>
                                <div class="w-full h-full absolute bg-blue-300 z-[-2]"></div>
                            </div>
                        </div>
                        <div class="bg-blue-50">
                            <div class="flex justify-center mb-4">
                                <i class="fa text-3xl fa-globe text-primary my-auto"></i>
                                <h3 class="ml-6">Lorem Ipsum</h3>
                            </div>
                            <p class="py-2 font-semibolder text-center text-muted">Lorem ipsum dolor sit amet, consectetur
                                adipiscing elit. Donec tempus auctor.</p>
                        </div>
                    </div>
                </div>
                <div class="col md:w-10/12  mx-auto my-6">
                    <div class="rounded overflow-hidden">
                        <div class="relative overflow-hidden">
                            <img class=" shadow-lg " src="image/aab.png" alt="phone feature 1" loading="lazy" />
                            <div class="w-full h-full">
                                <div class="z-index:-1 relative">
                                    <div class="absolute bg-blue rounded-full w-[120px] h-[120px] left-[-30px] top-[-10px]">
                                    </div>
                                    <div
                                        class="absolute bg-blue rounded-full w-[140px] h-[140px] right-[-30px] bottom-[80px]">
                                    </div>
                                    <div class="absolute bg-blue rounded-full w-[60px] h-[60px] left-[20%] bottom-[30px]">
                                    </div>
                                </div>
                                <div class="w-full h-full absolute bg-blue-300 z-[-2]"></div>
                            </div>
                        </div>
                        <div class="bg-blue-50">
                            <div class="flex justify-center mb-4">
                                <i class="fa text-3xl fa-globe text-primary my-auto"></i>
                                <h3 class="ml-6">Lorem Ipsum</h3>
                            </div>
                            <p class="py-2 font-semibolder text-center text-muted">Lorem ipsum dolor sit amet, consectetur
                                adipiscing elit. Donec tempus auctor.</p>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>
    <section>

        <div class="bd-example">

        </div>
    </section>


    <footer class="footer">
        <div class="mx-auto max-w-screen-xl px-4 pt-16 pb-8 sm:px-6 lg:px-8 justify-center">
            <div class=" justify-center lg:flex lg:items-start lg:gap-8">


                <div class="mt-8 grid grid-cols-2 gap-8 lg:mt-0 lg:grid-cols-4 lg:gap-y-16">

                    <div class="col-span-2 sm:col-span-1">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3958.3512869616084!2d107.88690587424747!3d-7.200701670684401!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68b0f14a76712d%3A0x5925220d57b5f0b!2sFISIP%20UNIGA!5e0!3m2!1sid!2sid!4v1692775090905!5m2!1sid!2sid" width="250" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <p class="font-medium text-gray-900">Alamat</p>

                        <ul class="mt-6 space-y-4 text-sm">
                            <li>
                                <a href="#" class="text-gray-700 transition hover:opacity-75">
                                    Kampus FISIP - UNIGA
                                    Jl. Cimanuk No. 285A, Simpang Lima
                                    Tarogong Kidul - Garut
                                </a>
                            </li>

                        </ul>
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        <p class="font-medium text-gray-900">Kontak</p>

                        <ul class="mt-6 space-y-4 text-sm">
                            <li>

                                <a href="#" class="text-gray-700 transition hover:opacity-75">
                                    <BaseIcon :path="mdiWhatsapp" class="text-blue-500 " />
                                    +6282219291520
                                </a>
                            </li>

                            <li>
                                <a href="#" class="text-gray-700 transition hover:opacity-75">
                                    <BaseIcon :path="mdiCellphone" class="text-blue-500 " />
                                    +6282219291520
                                </a>
                            </li>

                        
                        </ul>
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        <p class="font-medium text-gray-900">Email</p>

                        <ul class="mt-6 space-y-4 text-sm">
                            <li>

                                <a href="#" class="text-gray-700 transition hover:opacity-75">
                                    <BaseIcon :path="mdiEmail" class="text-blue-500 " />
                                    info@fisip.uniga.ac.id
                                </a>
                            </li>

                            <li>
                                <a href="#" class="text-gray-700 transition hover:opacity-75">
                                    <BaseIcon :path="mdiEmail" class="text-blue-500 " />
                                    admin@fisip.uniga.ac.id
                                </a>
                            </li>

                      
                        </ul>
                    </div>

               

                    <ul class="col-span-2 flex justify-start gap-6 lg:col-span-5 lg:justify-end">
                        <li>
                            <a href="https://www.facebook.com/unigafisip/" rel="noreferrer" target="_blank" class="text-gray-700 transition hover:opacity-75">
                                <span class="sr-only">Facebook</span>

                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </li>

                        <li>
                            <a href="https://www.instagram.com/fisipuniga/" rel="noreferrer" target="_blank" class="text-gray-700 transition hover:opacity-75">
                                <span class="sr-only">Instagram</span>

                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </li>

                 

                        <li>
                            <a href="https://www.youtube.com/channel/UCaTbG5vzuUTP7hHR7ZTuHTg" rel="noreferrer" target="_blank" class="text-gray-700 transition hover:opacity-75">
                                <span class="sr-only">GitHub</span>

                                    <svg class="h-6 w-6"  xmlns="http://www.w3.org/2000/svg" version="1.1" width="512px" height="512px" style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd" xmlns:xlink="http://www.w3.org/1999/xlink">
<g><path style="opacity:1; transform: scale( 0.045);" fill="#000000" d="M 233.5,-0.5 C 248.5,-0.5 263.5,-0.5 278.5,-0.5C 368.144,10.3879 435.644,54.7213 481,132.5C 497.695,163.971 507.861,197.304 511.5,232.5C 511.5,247.5 511.5,262.5 511.5,277.5C 499.016,377.807 447.016,449.307 355.5,492C 330.316,502.296 304.316,508.796 277.5,511.5C 262.5,511.5 247.5,511.5 232.5,511.5C 130.434,498.225 58.6008,444.558 17,350.5C 8.0309,327.127 2.19757,303.127 -0.5,278.5C -0.5,263.167 -0.5,247.833 -0.5,232.5C 9.30698,148.242 49.6403,83.0754 120.5,37C 155.422,15.9704 193.088,3.4704 233.5,-0.5 Z M 166.5,159.5 C 225.834,159.333 285.168,159.5 344.5,160C 369.093,163.925 383.926,178.092 389,202.5C 389.667,237.833 389.667,273.167 389,308.5C 383.926,332.908 369.093,347.075 344.5,351C 285.167,351.667 225.833,351.667 166.5,351C 141.899,347.065 127.065,332.899 122,308.5C 121.333,273.167 121.333,237.833 122,202.5C 127.25,178.081 142.084,163.747 166.5,159.5 Z"/></g>
<g><path style="opacity:1; transform: scale( 0.045);" fill="#000000" d="M 219.5,213.5 C 243.742,227.073 267.742,241.073 291.5,255.5C 267.913,269.878 244.08,283.878 220,297.5C 219.5,269.502 219.333,241.502 219.5,213.5 Z"/></g>
</svg>
                            </a>
                        </li>

                    
                    </ul>
                </div>
            </div>

            <div class="mt-8 border-t border-gray-100 pt-8">
                <div class="sm:flex sm:justify-between">
                    <p class="text-xs text-gray-500">
                        &copy; 2024. Fakultas Ilmu Sosial dan Ilmu Politik Universitas Garut.
                    </p>

                    <ul class="mt-8 flex flex-wrap justify-start gap-4 text-xs sm:mt-0 lg:justify-end">
                       
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    
</template>
  
<script setup>


import { reactive, ref } from "vue";
import BaseIcon from "@/components/BaseIcon.vue";

import { mdiWhatsapp, mdiCellphone, mdiEmail, mdiGithub } from "@mdi/js";

const menuVisible = ref(false);

const toggleMenu = () => {
    menuVisible.value = !menuVisible.value;
};
</script>
  