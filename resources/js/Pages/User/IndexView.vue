  
<script setup>


import BaseIcon from "@/components/BaseIcon.vue";

import { mdiWhatsapp, mdiCellphone, mdiEmail, mdiGithub } from "@mdi/js";
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted, onBeforeUnmount } from 'vue';
import AppHead from "@/components/AppHead.vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    }
});

console.log(props.canLogin);
const screenWidth = ref(window.innerWidth);
const screenHeight = ref(window.innerHeight);

const updateScreenSize = () => {
    screenWidth.value = window.innerWidth;
    screenHeight.value = window.innerHeight;
    console.log(screenWidth.value);
};

onMounted(() => {
    window.addEventListener('resize', updateScreenSize);
});

onBeforeUnmount(() => {
    window.removeEventListener('resize', updateScreenSize);
});
const menuVisible = ref(false);



const toggleMenu2 = (e) => {
    menuVisible.value = !menuVisible.value;
};

const toggleMenu = (e) => {
    e.stopPropagation(); // Prevent click event from propagating to document click handler
    menuVisible.value = !menuVisible.value;
};

const closeMenuOnOutsideClick = (e) => {
    if (menuVisible.value && !e.target.closest('.navbar-menu')) {
        menuVisible.value = false;
    }
};

onMounted(() => {
    document.addEventListener('click', closeMenuOnOutsideClick);
});

onUnmounted(() => {
    document.removeEventListener('click', closeMenuOnOutsideClick);
});


const footer = ref(null);
const jadwal = ref(null);
const petunjuk = ref(null);
const jalur = ref(null);
const beasiswa = ref(null);
const prodi = ref(null);

var sect = { 'footer': footer, 'jadwal': jadwal, 'petunjuk': petunjuk, 'jalur': jalur, 'beasiswa': beasiswa, 'prodi': prodi };

console.log(sect);
const scrollToSection = (key) => {

    if (screenWidth.value < 768) {

        toggleMenu2();
    }
    window.scrollTo({
        top: sect[key].value.offsetTop - 200,
        behavior: 'smooth',
    });
};

</script>

<template>
    <AppHead title="Penerimaan Mahasiswa Baru FISIP UNIGA" />

    <div class="bg-gray-50">


        <section id="nav">

            <nav
                class="fixed inset-x-0 z-50  px-4 py-4 flex justify-between items-center bg-gradient-to-r from-sky-500 to-emerald-300 ">
                <a class="text-3xl font-bold leading-none" href="#">
                    <img src="favicon/logo1.png" class="header-brand-img" width="270" alt="tabler logo">

                </a>

                <ul class="hidden   lg:flex lg:items-center  lg:space-x-2">
                    <!-- Menu Items -->
                    <li class="transition ease-in-out delay-50 hover:-translate-y-1 hover:scale-110 duration-300">
                        <a class="text-sm text-white select-none " @click="scrollToSection('jadwal')">
                            <p align="center"> Jadwal Pendaftaran</p>
                        </a>


                    </li>
                    <li class="text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                            class="w-4 h-4 current-fill" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 5v0m0 7v0m0 7v0m0-13a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                        </svg>
                    </li>
                    <li class="transition ease-in-out delay-50 hover:-translate-y-1 hover:scale-110 duration-300">

                        <a class="text-sm text-white select-none " @click="scrollToSection('petunjuk')">
                            <p align="center">Petunjuk Pendaftaran</p>
                        </a>
                    </li>
                    <li class="text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                            class="w-4 h-4 current-fill" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 5v0m0 7v0m0 7v0m0-13a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                        </svg>
                    </li>

                    <li class="transition ease-in-out delay-50 hover:-translate-y-1 hover:scale-110 duration-300">
                        <a class="text-sm text-white select-none " @click="scrollToSection('jalur')">
                            <p align="center">Jalur Seleksi</p>
                        </a>
                    </li>
                    <li class="text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                            class="w-4 h-4 current-fill" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 5v0m0 7v0m0 7v0m0-13a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                        </svg>
                    </li>

                    <li class="transition ease-in-out delay-50 hover:-translate-y-1 hover:scale-110 duration-300">
                        <a class="text-sm text-white select-none " @click="scrollToSection('beasiswa')">
                            <p align="center">Beasiswa</p>
                        </a>
                    </li>
                    <li class="text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                            class="w-4 h-4 current-fill" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 5v0m0 7v0m0 7v0m0-13a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                        </svg>
                    </li>

                    <li class="transition ease-in-out delay-50 hover:-translate-y-1 hover:scale-110 duration-300">
                        <a class="text-sm text-white select-none " @click="scrollToSection('prodi')">
                            <p align="center">Program Studi</p>
                        </a>
                    </li>
                    <li class="text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                            class="w-4 h-4 current-fill" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 5v0m0 7v0m0 7v0m0-13a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                        </svg>
                    </li>

                    <li class="transition ease-in-out delay-50 hover:-translate-y-1 hover:scale-110 duration-300">
                        <a class="text-sm text-white select-none " href="#">
                            <p align="center">Hasil tes</p>
                        </a>
                    </li>
                </ul>


                <div class="lg:flex">
                    <div v-if="canLogin" class="">

                        <!-- Fixed links container at the bottom-center -->
                        <div v-if="screenWidth < 1024" class="fixed bottom-0 left-0 w-full flex justify-center py-4">
                            <a v-if="$page.props.auth.user"
                                class="inline-block py-2 px-6 mx-6 bg-white text-emerald-500 hover:bg-emerald-200 hover:text-white text-sm font-bold rounded-xl transition duration-200"
                                href="/dashboard">
                                Dashboard
                            </a>
                            <a v-if="$page.props.auth.user"
                                class="inline-block py-2 px-6 mx-6 bg-white text-emerald-500 hover:bg-emerald-200 hover:text-white text-sm font-bold rounded-xl transition duration-200"
                                @click.prevent="router.post(route('logout'))">
                                Logout
                            </a>
                        </div>
                        <div v-if="screenWidth < 1024" class="fixed bottom-0 left-0 w-full flex justify-center py-4">
                            <a v-if="!$page.props.auth.user" class="inline-block py-2 px-6 mx-6 bg-white text-emerald-500 hover:bg-emerald-200 hover:text-white text-sm font-bold rounded-xl transition duration-200"
                                href="/login">login</a>
                            <a v-if="!$page.props.auth.user" class="inline-block py-2 px-6 border bg-emerald-400 border-white text-white hover:bg-white hover:text-emerald-500 text-sm font-bold rounded-xl transition duration-200"
                                href="/register">Daftar</a>
                        </div>


                        <div class="flex" v-if="!$page.props.auth.user">
                            <a class="hidden lg:inline-block py-2 px-6 mx-6 bg-white text-emerald-500 hover:bg-emerald-200 hover:text-white text-sm font-bold rounded-xl transition duration-200"
                                href="/login">login</a>
                            <a class="hidden lg:inline-block py-2 px-6 border bg-emerald-400 border-white text-white hover:bg-white hover:text-emerald-500 text-sm font-bold rounded-xl transition duration-200"
                                href="/register">Daftar</a>
                        </div>
                        <div class="flex" v-else-if="screenWidth > 1024">

                            <a v-if="$page.props.auth.user"
                                class="inline-block py-2 px-6 mx-6 bg-white text-emerald-500 hover:bg-emerald-200 hover:text-white text-sm font-bold rounded-xl transition duration-200"
                                href="/dashboard">
                                Dashboard
                            </a>
                            <a v-if="$page.props.auth.user"
                                class="inline-block py-2 px-6 mx-6 bg-white text-emerald-500 hover:bg-emerald-200 hover:text-white text-sm font-bold rounded-xl transition duration-200"
                                @click.prevent="router.post(route('logout'))">
                                Logout
                            </a>

                        </div>
                    </div>

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



            <transition name="slide" mode="out-in">
                <div v-if="menuVisible" class="navbar-menu fixed inset-x-0 z-50">

                    <div style="height:100%;"
                        class="fixed inset-x-0 flex flex-col w-5/6 max-w-sm py-6 px-6 bg-white border-r overflow-y-auto">
                        <!-- Mobile Menu Content -->
                        <div class=" ">
                            <a class="block p-4 text-sm font-semibold  hover:bg-blue-50 hover:text-blue-600 rounded"
                                @click="scrollToSection('jadwal')">Jadwal Pendaftaran</a>
                        </div>

                        <div class=" ">

                            <a class="block p-4 text-sm font-semibold  hover:bg-blue-50 hover:text-blue-600 rounded"
                                @click="scrollToSection('petunjuk')">Petunjuk Pendaftaran</a>
                        </div>


                        <div class=" ">
                            <a class="block p-4 text-sm font-semibold  hover:bg-blue-50 hover:text-blue-600 rounded"
                                @click="scrollToSection('jalur')">Jalur
                                Seleksi</a>
                        </div>

                        <div class=" ">

                            <a class="block p-4 text-sm font-semibold  hover:bg-blue-50 hover:text-blue-600 rounded"
                                @click="scrollToSection('beasiswa')">Beasiswa</a>
                        </div>


                        <div class=" ">
                            <a class="block p-4 text-sm font-semibold  hover:bg-blue-50 hover:text-blue-600 rounded"
                                @click="scrollToSection('prodi')">Program Studi</a>
                        </div>


                        <div class=" ">
                            <a class="block p-4 text-sm font-semibold  hover:bg-blue-50 hover:text-blue-600 rounded"
                                href="#">Hasil
                                tes</a>
                        </div>
                    </div>
                </div>
            </transition>
        </section>


        <section class="pt-24 pb-12 flex items-stretch justify-center  " id="pengumuman">
            <div class="container">


                <div class="row">
                    <div class="col">
                        <!-- <h2 class="display-4 text-center font-semibold">Lorem ipsum dolor sit amet</h2> -->
                    </div>
                </div>
                <div class="grid w-5/6 lg:w-2/2 justify-center mx-auto flex items-stretch grid-cols-1   ">

                    <div class="  mx-auto ">
                        <div class="rounded overflow-hidden">
                            <div class="relative mx-auto overflow-hidden">
                                <img class=" mx-auto shadow-lg md:hidden " src="image/splash_m.png" alt="phone feature 1"
                                    loading="lazy" />
                                <img class=" mx-auto shadow-lg hidden md:block  " src="image/splash.png"
                                    alt="phone feature 1" loading="lazy" />
                                <div class="w-full h-full">

                                    <div class="w-full h-full absolute bg-blue-300 z-[-2]"></div>
                                </div>
                            </div>

                        </div>
                    </div>



                </div>
                <div
                    class="grid w-5/6 lg:w-2/2 justify-center mx-auto flex items-stretch grid-cols-1 lg:grid-cols-3 grid-rows-1 gap-4  ">

                    <div class="col md:w-10/12  mx-auto my-6">
                        <div class="rounded overflow-hidden">
                            <div class="relative overflow-hidden">
                                <img class=" shadow-lg " src="image/aab.png" alt="phone feature 1" loading="lazy" />
                                <div class="w-full h-full">
                                    <div class="z-index:-1 relative">
                                        <div
                                            class="absolute bg-blue rounded-full w-[120px] h-[120px] left-[-30px] top-[-10px]">
                                        </div>
                                        <div
                                            class="absolute bg-blue rounded-full w-[140px] h-[140px] right-[-30px] bottom-[80px]">
                                        </div>
                                        <div
                                            class="absolute bg-blue rounded-full w-[60px] h-[60px] left-[20%] bottom-[30px]">
                                        </div>
                                    </div>
                                    <div class="w-full h-full absolute bg-blue-300 z-[-2]"></div>
                                </div>
                            </div>
                            <div class="bg-blue-50">
                                <div class="flex justify-center mb-4">
                                    <i class="fa text-3xl fa-globe text-primary my-auto"></i>
                                    <h3 class="">Pengumuman</h3>
                                </div>
                                <p class="py-2 font-semibolder text-center text-muted">pengumuman penerimaan mahasiswa baru.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col md:w-10/12 self-auto mx-auto my-6">
                        <div class="rounded overflow-hidden">
                            <div class="relative overflow-hidden">
                                <img class=" shadow-lg " src="image/aab.png" alt="phone feature 1" loading="lazy" />
                                <div class="w-full h-full">
                                    <div class="z-index:-1 relative">
                                        <div
                                            class="absolute bg-blue rounded-full w-[120px] h-[120px] left-[-30px] top-[-10px]">
                                        </div>
                                        <div
                                            class="absolute bg-blue rounded-full w-[140px] h-[140px] right-[-30px] bottom-[80px]">
                                        </div>
                                        <div
                                            class="absolute bg-blue rounded-full w-[60px] h-[60px] left-[20%] bottom-[30px]">
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
                                <p class="py-2 font-semibolder text-center text-muted">Lorem ipsum dolor sit amet,
                                    consectetur
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
                                        <div
                                            class="absolute bg-blue rounded-full w-[120px] h-[120px] left-[-30px] top-[-10px]">
                                        </div>
                                        <div
                                            class="absolute bg-blue rounded-full w-[140px] h-[140px] right-[-30px] bottom-[80px]">
                                        </div>
                                        <div
                                            class="absolute bg-blue rounded-full w-[60px] h-[60px] left-[20%] bottom-[30px]">
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
                                <p class="py-2 font-semibolder text-center text-muted">Lorem ipsum dolor sit amet,
                                    consectetur
                                    adipiscing elit. Donec tempus auctor.</p>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </section>

        <section id="jadwal" ref="jadwal">

            <div class="w-5/6 justify-start    mx-auto ">
                <div class="mb-10 overflow-hidden justify-center rounded-lg bg-white">
                    <img src="image/jadwal.png" alt="image" class="w-full" />
                    <div class="p-2 text-center sm:p-9 md:p-7 xl:p-9">
                        <div class="card-body">
                            <div class="text-wrap p-lg-6">
                                <h5 class=" uppercase font-bold text-blue-500">Jadwal Pendaftaran</h5>
                                <hr class="border-0 h-1 bg-gradient-to-r from-gray-200 via-gray-500 to-gray-200">
                                <br>
                                <p class="text-left"><strong>Gelombang 1</strong> : 1 Februari 2023 - 31 Maret 2023</p>
                                <p class="text-left"><strong>Gelombang 2</strong> : 1 April 2023 - 31 Mei 2023</p>
                                <p class="text-left"><strong>Gelombang 3</strong> : 1 Juni 2023 - 31 Juli 2023</p>
                                <p class="text-left"><strong>Gelombang 4</strong> : 1 Agustus 2023 - 30 September 2023</p>
                            </div>
                        </div>

                        <a href="javascript:void(0)"
                            class="text-body-color hover:border-primary hover:bg-primary inline-block rounded-full border border-[#E5E7EB] py-2 px-7 text-base font-medium transition hover:text-white">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section id="petunjuk" ref="petunjuk">

            <div class="w-5/6 justify-start    mx-auto ">
                <div class="mb-10 overflow-hidden justify-center rounded-lg bg-white">
                    <img src="image/petunjuk.jpg" alt="image" class="w-full" />
                    <div class="p-2 text-center sm:p-9 md:p-7 xl:p-9">
                        <h3>
                            <a href="javascript:void(0)"
                                class="text-dark justify-start  hover:text-primary mb-4 block text-xl font-semibold sm:text-[22px] md:text-xl lg:text-[22px] xl:text-xl 2xl:text-[22px]">

                            </a>
                        </h3>
                        <img src="image/petunjuk_daftar.jpg" alt="image" class="w-full" />
                        <a href="javascript:void(0)"
                            class="text-body-color hover:border-primary hover:bg-primary inline-block rounded-full border border-[#E5E7EB] py-2 px-7 text-base font-medium transition hover:text-white">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        </section>


        <section id="jalur" ref="jalur">

            <div class="w-5/6 justify-start    mx-auto ">
                <div class="mb-10 overflow-hidden justify-center rounded-lg bg-white">
                    <img src="image/petunjuk.jpg" alt="image" class="w-full" />
                    <div class="p-2 text-center sm:p-9 md:p-7 xl:p-9">
                        <div class="text-wrap p-6">
                            <h5 class="text-center text-uppercase font-bold text-blue-500">Jalur Seleksi Pendaftaran</h5>
                            <hr class="border-0 h-1 bg-gradient-to-r from-gray-300 via-gray-600 to-gray-300">

                            <ol class="pl-6">
                                <li class="text-justify">
                                    <br>
                                    <h4 class="text-justify font-bold">Jalur Rangking</h4>
                                    Jalur Rapor yaitu jalur pendaftaran yang terbuka bagi siswa/siswi tingkat SMA/SMK/MA
                                    kelas XII berlaku untuk semua jurusan, tanpa harus mengikuti tes ujian saringan masuk,
                                    sesuai dengan kriteria yang ditentukan berdasarkan penilaian dari prestasi akademik.
                                    Syarat:
                                    <br>
                                    <ol class="list-disc pl-6">
                                        <li>Lulusan baru SMA, SMK, MA / sederajat untuk semua jurusan.</li>
                                        <li>Berkelakuan baik, tidak terlibat pengedaran dan pemakaian Narkoba (NAPZA),
                                            dengan surat keterangan dari pihak yang berwenang, yang dipenuhi setelah calon
                                            dinyatakan lulus seleksi.</li>
                                        <li>Rata-rata nilai raport pada sem. 3, 4, 5, 6 dengan rata-rata nilai rapot minimal
                                            7,5.</li>
                                    </ol>
                                </li>

                                <li class="text-justify">
                                    <br>
                                    <h4 class="text-justify font-bold">Jalur Bidikmisi</h4>
                                    Jalur Bidikmisi merupakan bantuan biaya pendidikan bagi calon mahasiswa tidak mampu
                                    secara ekonomi dan memiliki potensi akademik baik untuk menempuh pendidikan di perguruan
                                    tinggi pada program studi unggulan sampai lulus tepat waktu. Syarat dan Pendaftaran
                                    langsung melalui website <a href="https://bidikmisi.belmawa.ristekdikti.go.id/"
                                        class="text-blue-500 hover:underline">https://bidikmisi.belmawa.ristekdikti.go.id/</a>
                                </li>

                                <li class="text-justify">
                                    <br>
                                    <h4 class="text-justify font-bold">Jalur Undangan</h4>
                                    Jalur Undangan merupakan jalur yang diperuntukan bagi siswa-siswi terbaik di Sekolah
                                    untuk mengikuti seleksi masuk PTN tanpa ujian tertulis. Seleksi didasarkan pada prestasi
                                    yang dimiliki siswa. Syarat:
                                    <br>
                                    <ol class="list-disc pl-6">
                                        <li>Lulusan baru SMA, SMK, MA / sederajat untuk semua jurusan.</li>
                                        <li>Berkelakuan baik, tidak terlibat pengedaran dan pemakaian Narkoba (NAPZA),
                                            dengan surat keterangan dari pihak yang berwenang, yang dipenuhi setelah calon
                                            dinyatakan lulus seleksi.</li>
                                        <li>Memiliki surat rekomendasi dari Fakultas Ilmu Sosial dan Ilmu Politik -
                                            Universitas Garut.</li>
                                    </ol>
                                </li>

                                <li class="text-justify">
                                    <br>
                                    <h4 class="text-justify font-bold">Prestasi Non Akademik</h4>
                                    Prestasi Non Akademik merupakan jalur yang diperuntukan bagi siswa/i yang berprestasi
                                    dibidang olahraga dan seni tanpa harus mengikuti tes ujian saringan masuk. Syarat:
                                    <br>
                                    <ol class="list-disc pl-6">
                                        <li>Lulusan baru SMA, SMK, MA / sederajat untuk semua jurusan.</li>
                                        <li>Berkelakuan baik, tidak terbatas pengedaran dan pemakaian Narkoba (NAPZA),
                                            dengan surat keterangan dari pihak yang berwenang, yang dipenuhi setelah calon
                                            dinyatakan lulus seleksi.</li>
                                        <li>Memiliki sertifikat atau prestasi Olahraga dan Seni, baik tingkat regional,
                                            nasional maupun internasional.</li>
                                    </ol>
                                </li>

                                <li class="text-justify">
                                    <br>
                                    <h4 class="text-justify font-bold">Tes Potensi Akademik</h4>
                                    Tes Potensi Akademik merupakan kegiatan seleksi berupa ujian tertulis untuk menentukan
                                    kemampuan potensi akademik para calon mahasiswa sesuai dengan kriteria yang berlaku di
                                    Fakultas Ilmu Sosial dan Ilmu Politik - Universitas Garut.
                                </li>

                                <li class="text-justify">
                                    <br>
                                    <h4 class="text-justify font-bold">Jalur Aparatur Desa</h4>
                                    Jalur Aparatur Desa merupakan jalur khusus yang diperuntukan untuk pegawai Desa. Syarat
                                    :
                                    <br>
                                    <ol class="list-disc pl-6">
                                        <li>Mempunyai Surat Rekomendasi dari Desa</li>
                                        <li>Surat Keterangan Sehat (Maksimal 2 minggu)</li>
                                        <li>Berkelakuan baik, tidak terbatas pengedaran dan pemakaian Narkoba (NAPZA),
                                            dengan surat keterangan dari pihak yang berwenang.</li>
                                    </ol>
                                </li>

                                <li class="text-justify">
                                    <br>
                                    <h4 class="text-justify font-bold">Jalur Family Program</h4>
                                    "Bring Your Family to Join Us". Memberikan kesempatan bagi calon mahasiswa baru untuk
                                    mendaftar dengan rekomendasi keluarga/kerabat yang telah menjadi mahasiswa atau alumni
                                    FISIP - Universitas Garut.
                                </li>
                            </ol>

                            <p class="mt-4">&nbsp;</p>
                            <p class="mt-4">&nbsp;</p>
                            <p class="mt-4">&nbsp;</p>
                        </div>

                        <a href="javascript:void(0)"
                            class="text-body-color hover:border-primary hover:bg-primary inline-block rounded-full border border-[#E5E7EB] py-2 px-7 text-base font-medium transition hover:text-white">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section id="beasiswa" ref="beasiswa">

            <div class="w-5/6 justify-start    mx-auto ">
                <div class="mb-10 overflow-hidden justify-center rounded-lg bg-white">
                    <img src="image/petunjuk.jpg" alt="image" class="w-full" />
                    <div class="p-2 text-center sm:p-9 md:p-7 xl:p-9">
                        <div class="text-wrap p-6">
                            <h5 class="text-center uppercase font-semibold text-blue-500">Beasiswa</h5>

                            <hr class="border-0 h-1 bg-gradient-to-r from-gray-300 via-gray-600 to-gray-300">
                            <br>
                            <h4 class="text-lg font-semibold text-left">Jenis - Jenis Beasiswa di Lingkungan FISIP -
                                Universitas Garut:</h4>

                            <h4 class="font-semibold text-left">1. Beasiswa Yayasan</h4>
                            <p class="text-left">Beasiswa dari Yayasan Universitas Garut, yang terdiri dari beasiswa PPA
                                (untuk mahasiswa berprestasi dibidang akademik) dan BBM (untuk mahasiswa yang kurang mampu).
                            </p>

                            <h4 class="font-semibold text-left">2. Beasiswa Kabupaten</h4>

                            <h4 class="font-semibold text-left">3. Beasiswa Provinsi</h4>
                        </div>


                        <a href="javascript:void(0)"
                            class="text-body-color hover:border-primary hover:bg-primary inline-block rounded-full border border-[#E5E7EB] py-2 px-7 text-base font-medium transition hover:text-white">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section id="prodi" ref="prodi">

            <div class="w-5/6 justify-start    mx-auto ">
                <div class="mb-10 overflow-hidden justify-center rounded-lg bg-white">
                    <img src="image/petunjuk.jpg" alt="image" class="w-full" />
                    <div class="p-2 text-center sm:p-9 md:p-7 xl:p-9">
                        <div class="text-wrap p-6">
                            <h5 class="text-center uppercase font-semibold text-blue-500">Program Studi</h5>
                            <hr class="border-0 h-1 bg-gradient-to-r from-gray-300 via-gray-600 to-gray-300">
                            <br>
                            <p class="text-left">Fakultas Ilmu Sosial dan Ilmu Politik (FISIP) - Universitas Garut,
                                mempunyai 1 Program Studi, dengan 3 Konsentrasi, diantaranya:</p>

                            <p class="font-semibold text-left">Program Studi: Ilmu Administrasi Negara (S1)</p>

                            <p class="font-semibold text-left">Konsentrasi:</p>
                            <ul class="list-disc list-inside text-left">
                                <li>Kebijakan Publik</li>
                                <li>Manajemen Publik</li>
                                <li>Manajemen Keuangan Publik</li>
                            </ul>
                        </div>
                        <a href="javascript:void(0)"
                            class="text-body-color hover:border-primary hover:bg-primary inline-block rounded-full border border-[#E5E7EB] py-2 px-7 text-base font-medium transition hover:text-white">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <footer class="footer" ref="footer">
            <div class="mx-auto max-w-screen-xl px-4 pt-16 pb-8 sm:px-6 lg:px-8 justify-center">
                <div class=" justify-center lg:flex lg:items-start lg:gap-2">

                    <div class="mt-8 grid grid-cols-2 gap-2 lg:mt-0 lg:grid-cols-4 lg:gap-y-16">

                        <div class="col-span-2 md:mt-8 sm:col-span-1">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3958.3512869616084!2d107.88690587424747!3d-7.200701670684401!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68b0f14a76712d%3A0x5925220d57b5f0b!2sFISIP%20UNIGA!5e0!3m2!1sid!2sid!4v1692775090905!5m2!1sid!2sid"
                                width="250" height="300" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                        <div class="col-span-2 mt-8 sm:col-span-1">
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

                        <div class="col-span-2 mt-8 sm:col-span-1">
                            <p class="font-medium text-gray-900">Kontak</p>

                            <ul class="mt-6 space-y-4 text-sm">
                                <li>

                                    <a href="#" class="text-gray-700 transition hover:opacity-75">
                                        <BaseIcon :path="mdiWhatsapp" class="text-emerald-500 " />
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

                        <div class="col-span-2 mt-8 sm:col-span-1">
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



                        <ul class="col-span-2 mt-8 flex justify-start gap-6 lg:col-span-5 lg:justify-end">
                            <li>
                                <a href="https://www.facebook.com/unigafisip/" rel="noreferrer" target="_blank"
                                    class="text-gray-700 transition hover:opacity-75">
                                    <span class="sr-only">Facebook</span>

                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </li>

                            <li>
                                <a href="https://www.instagram.com/fisipuniga/" rel="noreferrer" target="_blank"
                                    class="text-gray-700 transition hover:opacity-75">
                                    <span class="sr-only">Instagram</span>

                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </li>



                            <li>
                                <a href="https://www.youtube.com/channel/UCaTbG5vzuUTP7hHR7ZTuHTg" rel="noreferrer"
                                    target="_blank" class="text-gray-700 transition hover:opacity-75">
                                    <span class="sr-only">GitHub</span>

                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" version="1.1" width="512px"
                                        height="512px"
                                        style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
                                        xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <g>
                                            <path style="opacity:1; transform: scale( 0.045);" fill="#000000"
                                                d="M 233.5,-0.5 C 248.5,-0.5 263.5,-0.5 278.5,-0.5C 368.144,10.3879 435.644,54.7213 481,132.5C 497.695,163.971 507.861,197.304 511.5,232.5C 511.5,247.5 511.5,262.5 511.5,277.5C 499.016,377.807 447.016,449.307 355.5,492C 330.316,502.296 304.316,508.796 277.5,511.5C 262.5,511.5 247.5,511.5 232.5,511.5C 130.434,498.225 58.6008,444.558 17,350.5C 8.0309,327.127 2.19757,303.127 -0.5,278.5C -0.5,263.167 -0.5,247.833 -0.5,232.5C 9.30698,148.242 49.6403,83.0754 120.5,37C 155.422,15.9704 193.088,3.4704 233.5,-0.5 Z M 166.5,159.5 C 225.834,159.333 285.168,159.5 344.5,160C 369.093,163.925 383.926,178.092 389,202.5C 389.667,237.833 389.667,273.167 389,308.5C 383.926,332.908 369.093,347.075 344.5,351C 285.167,351.667 225.833,351.667 166.5,351C 141.899,347.065 127.065,332.899 122,308.5C 121.333,273.167 121.333,237.833 122,202.5C 127.25,178.081 142.084,163.747 166.5,159.5 Z" />
                                        </g>
                                        <g>
                                            <path style="opacity:1; transform: scale( 0.045);" fill="#000000"
                                                d="M 219.5,213.5 C 243.742,227.073 267.742,241.073 291.5,255.5C 267.913,269.878 244.08,283.878 220,297.5C 219.5,269.502 219.333,241.502 219.5,213.5 Z" />
                                        </g>
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
    </div>
</template>
<style>
.slide-enter-active,
.slide-leave-active {
    height: 100%;
    transition: all 0.5s ease;
}

.slide-enter-from,
.slide-leave-to {
    height: 100%;
    opacity: 0;
    transform: translateX(-50%);
}

.slide-enter-to,
.slide-leave-from {
    height: 100%;
    transform: translateX(0%);
    opacity: 100;
}
</style>
  

