<script setup>
import { ref, computed, onMounted } from "vue";
import { mdiBallotOutline, mdiAccount, mdiMail, mdiGithub } from "@mdi/js";
import SectionMain from "@/components/SectionMain.vue";
import CardBox from "@/components/CardBox.vue";
import FormField from "@/components/FormField.vue";
import FormControl from "@/components/FormControl.vue";
import BaseButton from "@/components/BaseButton.vue";
import SectionTitle from "@/components/SectionTitle.vue";
import LayoutGuest from "@/layouts/LayoutGuest.vue";
import NotificationBarInCard from "@/components/NotificationBarInCard.vue";
import { useForm, Link } from "@inertiajs/vue3";
import datatablecomponent from "@/components/DataTableComponent.vue";
import LayoutAuthenticated from "@/layouts/LayoutAuthenticated.vue";
import AppHead from "@/components/AppHead.vue";

import DataTable from "datatables.net-vue3";
import Select from "datatables.net-select";
import DataTablesLib from "datatables.net";
import pdfFonts from "pdfmake/build/vfs_fonts";


// Impor library DataTables
DataTable.use(DataTablesLib);




import "datatables.net-select";
import "datatables.net-buttons";
import "datatables.net-buttons/js/buttons.html5";
import jszip from "jszip";
import pdfmake from "pdfmake";
import axios from "axios";
import { router } from '@inertiajs/vue3'


DataTable.use(DataTablesLib);
DataTablesLib.Buttons.jszip(jszip);
// pdfMake.vfs = pdfFonts.pdfMake.vfs;
DataTablesLib.Buttons.pdfMake(pdfmake);

const options = {
    dom: "Bftip",
    select: true,
    buttons: ["copy", "excel", "pdf"],
};

let props = defineProps({
    users: Object,
    user_verified: Object,
    tahun: Object,
    form: Object,
    routeTo: String,
    dataFrom: Object,
    columns: Object,
    buttons_data: Object,
});

function exportHTML() {


    axios.get('/gethtmlpage').then(response => {
        var sourceHTML = '';
        sourceHTML = response.data;
        console.log(response.data);
        var fileDownload = document.createElement("a");
        var source = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(sourceHTML);

        document.body.appendChild(fileDownload);
        fileDownload.href = source;
        fileDownload.download = 'document.doc';
        fileDownload.click();
    })

}

let dt;
const table = ref();

onMounted(function () {
    dt = table.value.dt;
});



// Mendefinisikan konfigurasi untuk mengekspor data ke Excel
const dataExcel = {
    extend: "excel",
    messageTop: "data Gameee",
    exportOptions: {

    },
};

// Membuat objek form menggunakan hook useForm
const form = useForm({
    verifikasi: ""
});


// Membuat referensi reaktif untuk status form dengan header
const formStatusWithHeader = ref(true);

// Membuat referensi reaktif untuk status form saat ini
const formStatusCurrent = ref(0);

// Mendefinisikan array opsi status form
const formStatusOptions = ["info", "success", "danger", "warning"];

// Membuat properti terhitung untuk mendapatkan warna status form berdasarkan keberhasilan form
const getFormStatusColor = computed(() => {
    if (form.recentlySuccessful) {
        return formStatusOptions[1]; // Mengembalikan warna status sukses
    } else {
        return formStatusOptions[0]; // Mengembalikan warna status info
    }
});

// Mendefinisikan fungsi untuk menangani pengiriman form
const formStatusSubmit = () => {
    form.post("/users", {
        preserveScroll: true,
    });
};

// Mendefinisikan kolom-kolom untuk tabel data
const buttons_data = ['copy', dataExcel, 'pdf',
    {
        text: 'Toggle action',
        action: function (e, dt, node, config) {
            dt.column(-2).visible(!dt.column(-2).visible());
            dt.column(-1).visible(!dt.column(-1).visible());
        }
    }, {
        text: 'Export doc',
        action: function () {
            exportHTML();
        }
    }
];
const isModalOpen = ref(false);
const modalData = ref([]);
const openModal = (data) => {
    isModalOpen.value = true;
    modalData.value = data;
};

const closeModal = () => {
    isModalOpen.value = false;
};

document.onkeydown = (evt) => {
    evt = evt || window.event;
    const isEscape = evt.key === 'Escape' || evt.key === 'Esc' || evt.keyCode === 27;

    if (isEscape && isModalOpen.value) {
        closeModal();
    }
};

// Close modal when clicking outside of it
document.addEventListener('mousedown', (event) => {
    const modal = document.querySelector('.modal-container');
    if (modal && !modal.contains(event.target)) {
        closeModal();
    }
});

console.log(props.users);


const verifikasiPembayaranUser = (id, request) => {
    // Add your code here
    form.verifikasi = request;
    form.post(route('verifikasiPembayaranUser', id));

    // Example: 
    console.log(request, id);
};


</script>

<template>
    <AppHead title="Verifikasi Pembayaran User" />
    <LayoutAuthenticated>

        <SectionMain>
            <SectionTitle>Form with status example</SectionTitle>


            <CardBox class="mt-6">

                <NotificationBarInCard :color="getFormStatusColor" :is-placed-with-header="formStatusWithHeader">
                    <span>Tabel verifikasi user</span>
                </NotificationBarInCard>

                <DataTable ref="table" class="display table" width="100%" :options="{
                    dom: 'Bfrtip',
                    select: true,
                    scrollX: true,
                    order: [],
                    buttons: buttons_data,

                }">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>NIM</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Pakai voucher</th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="data in users">
                            <td>{{ data.name }}</td>
                            <td>{{ data.nim }}</td>
                            <td>{{ new Date(data.created_at).getFullYear() + "-" + new Date(data.created_at).getMonth() +
                                "-" + new Date(data.created_at).getDate() }}</td>
                            <td>
                                <BaseButton v-if="data.faktur.validasi == 1" color="success" :small="true"
                                    :rounded-full="true" :label="'sudah di verifikasi'" />
                                <BaseButton v-else-if="data.faktur.validasi == 2" color="danger" :small="true"
                                    :rounded-full="true" :label="'di tolak'" />
                                <BaseButton v-else color="warning" :small="true" :rounded-full="true"
                                    :label="'belum di verifikasi'" />
                            </td>
                            <td>
                                <BaseButton v-if="!!data.faktur && data.faktur.pakai_voucher" color="success" :small="true"
                                    :rounded-full="true" :label="data.faktur.pakai_voucher ? 'ya' : 'tidak'" />
                                <BaseButton v-else-if="!!data.faktur && !data.faktur.pakai_voucher" color="warning"
                                    :small="true" :rounded-full="true"
                                    :label="data.faktur.pakai_voucher ? 'ya' : 'tidak'" />
                            </td>
                            <td>
                                <BaseButton @click="openModal(data)" color="info" :small="true" label="lihat data" />
                            </td>

                        </tr>

                    </tbody>
                </DataTable>
            </CardBox>


            <CardBox class="mt-6">

                <NotificationBarInCard :color="getFormStatusColor" :is-placed-with-header="formStatusWithHeader">
                    <span>Tabel verifikasi user</span>
                </NotificationBarInCard>

                <DataTable ref="table" class="display table" width="100%" :options="{
                    dom: 'Bfrtip',
                    select: true,
                    scrollX: true,
                    order: [],
                    buttons: buttons_data,

                }">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>NIM</th>
                            <th>done_setup</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Pakai voucher</th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="data in user_verified">
                            <td>{{ data.name }}</td>
                            
                            <td>{{ data.nim }}</td>
                            <td>{{ data.done_setup }}</td>
                            <td>{{ new Date(data.created_at).getFullYear() + "-" + new Date(data.created_at).getMonth() +
                                "-" + new Date(data.created_at).getDate() }}</td>
                            <td>
                                <BaseButton v-if="data.faktur.validasi == 1" color="success" :small="true"
                                    :rounded-full="true" :label="'sudah di verifikasi'" />
                                <BaseButton v-else-if="data.faktur.validasi == 2" color="danger" :small="true"
                                    :rounded-full="true" :label="'di tolak'" />
                                <BaseButton v-else color="warning" :small="true" :rounded-full="true"
                                    :label="'belum di verifikasi'" />
                            </td>
                            <td>
                                <BaseButton v-if="!!data.faktur && data.faktur.pakai_voucher" color="success" :small="true"
                                    :rounded-full="true" :label="data.faktur.pakai_voucher ? 'ya' : 'tidak'" />
                                <BaseButton v-else-if="!!data.faktur && !data.faktur.pakai_voucher" color="warning"
                                    :small="true" :rounded-full="true"
                                    :label="data.faktur.pakai_voucher ? 'ya' : 'tidak'" />
                            </td>
                            <td>
                                <BaseButton @click="openModal(data)" color="info" :small="true" label="lihat data" />
                            </td>

                        </tr>

                    </tbody>
                </DataTable>







            </CardBox>



            <div>


                <!-- Modal -->
                <transition name="pop" mode="out-in">

                    <div v-if="isModalOpen"
                        class="modal bg-gray-900 opacity-50 pointer-events-auto fixed w-full h-full top-0 left-0 flex items-center justify-center">
                    </div>
                </transition>
                <transition name="slide" mode="out-in">
                    <div v-if="isModalOpen"
                        class="modal opacity-100 pointer-events-auto fixed w-full h-full top-0 left-0 flex items-center justify-center dark:text-slate-400">

                        <div class="modal-container bg-white  mx-auto rounded shadow-lg z-50 overflow-y-auto">


                            <div class=" py-4 text-left px-6 dark:bg-gray-800">
                                <!--Title-->
                                <div class="flex justify-between items-center pb-3">
                                    <p class="text-2xl font-bold">Pembayaran Computer Assisted Test</p>
                                    <div @click="closeModal" class="modal-close cursor-pointer z-50">
                                        <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18"
                                            height="18" viewBox="0 0 18 18">
                                            <path
                                                d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>

                                <!--Body-->
                                <p>Nomor rekening : {{ modalData.faktur.no_rekening }}</p>
                                <p>Pakai voucher : {{ modalData.faktur.pakai_voucher ? 'Ya' : 'Tidak' }}</p>
                                <p>Tanggal bayar : {{ modalData.faktur.tanggal_bayar }}</p>
                                <p>Jumlah bayar : {{ modalData.faktur.jumlah_bayar }}</p>
                                <p>foto bukti : {{ modalData.faktur.foto_bukti }}</p>
                                <a :href="'storage/foto_bukti/' + modalData.faktur.foto_bukti" target="_blank">
                                    <img v-if="modalData.faktur ?? false"
                                        :src="'storage/foto_bukti/' + modalData.faktur.foto_bukti" width="200" alt="">
                                </a>

                                <!--Footer-->
                                <div class="flex justify-end pt-2">
                                    <button @click="verifikasiPembayaranUser(modalData.id, 'terima')"
                                        class="px-4 bg-green-500 p-3 rounded-lg text-white hover:bg-green-400 hover:text-white mr-2">Verifikasi
                                        Pembayaran</button>
                                    <button @click="verifikasiPembayaranUser(modalData.id, 'tolak')"
                                        class="px-4 bg-red-500 p-3 rounded-lg text-white hover:bg-red-400 hover:text-white mr-2">Tolak
                                        Pembayaran</button>
                                    <button @click="closeModal"
                                        class="px-4 bg-gray-500 p-3 rounded-lg text-white hover:bg-gray-400">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </transition>
            </div>
        </SectionMain>
    </LayoutAuthenticated>
</template>
<style>
@import "datatables.net-dt";
</style>

 
<style>
.slide-enter-active,
.slide-leave-active {
    transition: all 0.5s ease;
}

.slide-enter-from,
.slide-leave-to {
    opacity: 0;
    transform: translateY(-5%);
}

.slide-enter-to,
.slide-leave-from {
    transform: translateX(0);
    opacity: 100;
}

.pop-enter-active,
.pop-leave-active {
    transition: all 0.5s ease;
}

.pop-enter-from,
.pop-leave-to {
    opacity: 0;

}

.pop-enter-to,
.pop-leave-from {

    opacity: 50%;
}
</style>
    