<script setup>
import { ref, computed, onMounted, watch } from "vue";
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
import DataTables from "datatables.net-select";


// Impor library DataTables
DataTable.use(DataTablesLib);

// Mendefinisikan properti untuk komponen
var props = defineProps(["tahun", "tahunEdit"]);

// Mendefinisikan konfigurasi untuk mengekspor data ke Excel
const dataExcel = {
    extend: "excel",
    messageTop: "data Gameee",
    exportOptions: {
        columns: [0, 1, 2, 3, 4],
    },
};
const selectOptionsGelombang = ["1","2","3","4","5","6","7","8","9","10"];

// Membuat objek form menggunakan hook useForm
const form = useForm({
    gelombang: selectOptionsGelombang[0],
    tahun: "",
    status: "aktif",
    daritgl: "",
    sampaitgl: "",

    
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
    } else if (form.hasErrors) {
        return formStatusOptions[3]; // Mengembalikan warna status gagal
    } else {
        return formStatusOptions[0]; // Mengembalikan warna status info
    }
});

// Mendefinisikan fungsi untuk menangani pengiriman form
const formStatusSubmit = () => {
    form.post("/tahuns", {
        preserveScroll: true,
    });
};

// Mendefinisikan kolom-kolom untuk tabel data

const columns = [
    { data: "id" },
    { data: "no_utama" },
    { data: "tahun" },
    { data: "gelombang"},
    { data: "status" , render: data => data == "aktif" ? `<button class="bg-blue-500 text-white px-4 w-28  rounded">`+data+`</button>`: `<button class="bg-red-500 text-white px-4 w-28 rounded">`+data+`</button>`},

    { data: "daritgl" },
    { data: "sampaitgl" },
    { data: "created_at", render: data => new Date(data).getFullYear()+"-"+(new Date(data).getMonth()+1)+"-"+new Date(data).getDate()},
    {
        title: "aksi",
        render: function (data, type, row) {
            // Render tautan aksi edit dengan ID baris
            return (
                "<a class='bg-blue-500 text-white px-4  rounded'" + row.id + "' href='/tahuns/" + row.id + "/edit' >EDIT</a>"
            );
        },
    },
    {
        title: "aksi",
        render: function (data, type, row) {
            // Render tautan aksi hapus dengan ID baris
            return (
                "<a class='bg-red-500 text-white px-4  rounded' href='tahuns/delete/" + row.id + "'' method='delete' ) >HAPUS</a>"
            );
        },
    },
];

const buttons_data =  ['copy', dataExcel, 'pdf',
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


        


const showForm = ref(false);

const toggleForm = () => {
    showForm.value = !showForm.value;
};

const submitForm = () => {
    // Handle form submission logic here
    console.log('Form submitted');
};


// Menampilkan elemen pertama dari properti gamesEdit ke konsol
console.log(props.tahun);

</script>

<template>

<AppHead title="Game" />
    <LayoutAuthenticated>
        
        <SectionMain>
            <SectionTitle>Tahun Penerimaan</SectionTitle>
            <BaseButton @click.prevent="toggleForm" color="info" class=" relative z-50 bg"
                        label="Tambah Tahun Penerimaan" />
            <transition name="slide" mode="out-in">

            <CardBox v-if="showForm" key="form" is-form is-hoverable
                @submit.prevent="formStatusSubmit">
                <NotificationBarInCard :color="getFormStatusColor" :is-placed-with-header="formStatusWithHeader">
                    <span>
                        {{form.recentlySuccessful?" Berhasil menambahkan": form.hasErrors?" data telah ada":  "Tambah Tahun Penerimaan"}}
                    </span>
                </NotificationBarInCard>
                <FormField label="Tahun">
                    <FormControl v-model="form.tahun" :icon-left="mdiAccount" help="Tahun" placeholder="Tahun" type="number"
                        required />
                </FormField>
             

                <FormField label="gelombang">
                            <FormControl v-model="form.gelombang" :options="selectOptionsGelombang" />
                </FormField>

                <FormField label="status">
                            <FormControl v-model="form.status" :options="['aktif','nonaktif']" />
                </FormField>
                
                <FormField label="dari tanggal">
                    <FormControl v-model="form.daritgl" :icon-left="mdiAccount" help="daritgl" placeholder="daritgl" type="date"
                        required />
                </FormField>

                <FormField label="sampai tanggal">
                    <FormControl v-model="form.sampaitgl" :icon-left="mdiAccount" help="sampaitgl" placeholder="sampaitgl" type="date"
                        required />
                </FormField>

                <template #footer>
                    <BaseButton label="Tambah" type="submit" color="info" />
                </template>
            </CardBox>
            </transition>
            <CardBox class="mt-6">

                <NotificationBarInCard :color="getFormStatusColor" :is-placed-with-header="formStatusWithHeader">
                    <span>
                        Tahun penerimaan
                     
                    </span>

                </NotificationBarInCard>
                <datatablecomponent :buttons_data="buttons_data" routeTo="tahun"  :dataFrom="tahun" :form="form" :columns="columns">
                </datatablecomponent>
            </CardBox>
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
</style>
  