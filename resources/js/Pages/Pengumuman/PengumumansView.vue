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
import DataTables from "datatables.net-select";
import FormFilePicker from "@/components/FormFilePicker.vue";


// Impor library DataTables
DataTable.use(DataTablesLib);

// Mendefinisikan properti untuk komponen
var props = defineProps(["pengumuman", "pengumumanEdit"]);

// Mendefinisikan konfigurasi untuk mengekspor data ke Excel
const dataExcel = {
    extend: "excel",
    messageTop: "data Pengumuman",
    exportOptions: {
        columns: [0, 1, 2, 3, 4],
    },
};

// Membuat objek form menggunakan hook useForm
const form = useForm({
    judul: "",
    isi: "",
    gambar: "",
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
    form.post("/pengumumans", {
        preserveScroll: true,
    });
};

// Mendefinisikan kolom-kolom untuk tabel data

const columns = [
    { data: "id" },
    { data: "judul" },
    { data: "isi" },
    { data: "gambar" },
    { data: "created_at", render: data => new Date(data).getFullYear() + "/" + (new Date(data).getMonth() + 1) + "/" + new Date(data).getDate() },
    {
        title: "aksi",
        render: function (data, type, row) {
            // Render tautan aksi edit dengan ID baris
            return (
                "<a class='table-edit' data-id='" + row.id + "' href='/pengumumans/" + row.id + "/edit' >EDIT</a>"
            );
        },
    },
    {
        title: "aksi",
        render: function (data, type, row) {
            // Render tautan aksi hapus dengan ID baris
            return (
                "<a class='table-edit' href='pengumumans/delete/" + row.id + "'' method='delete' ) >HAPUS</a>"
            );
        },
    },
];

const buttons_data = ['copy', dataExcel, 'pdf',
    {
        text: 'Toggle action',
        action: function (e, dt, node, config) {
            dt.column(-2).visible(!dt.column(-2).visible());
            dt.column(-1).visible(!dt.column(-1).visible());
        }
    }
];


const previewImageIjazah = ref('');

const handleFileChangeIjazah = (event) => {
    const selectedFile = event.target.files[0];
    if (selectedFile) {
        const reader = new FileReader();
        reader.onload = (e) => {
            previewImageIjazah.value = e.target.result;
        };
        reader.readAsDataURL(selectedFile);
    }
};

</script>

<template>
    <AppHead title="Pengumuman" />
    <LayoutAuthenticated>

        <SectionMain>
            <SectionTitle>Pengumuman</SectionTitle>

            <CardBox is-form is-hoverable @submit.prevent="formStatusSubmit">
                <NotificationBarInCard :color="getFormStatusColor" :is-placed-with-header="formStatusWithHeader">
                    <span>
                        {{ form.recentlySuccessful ? " Berhasil menambahkan" : "Tambah Pengumuman" }}</span>
                </NotificationBarInCard>
                <FormField label="judul">
                    <FormControl v-model="form.judul" :icon-left="mdiAccount" help="Pengumuman judul"
                        placeholder="Pengumuman judul" required />
                </FormField>
                <FormField label="isi">
                    <FormControl v-model="form.isi" :icon-left="mdiAccount" help="Pengumuman isi"
                        placeholder="Pengumuman isi" required />
                </FormField>

                <FormField label="Gambar" class=" justify-center ">

                    <div class="">
                        <FormFilePicker accept=".jpg,.jpeg,.png" @change="handleFileChangeIjazah"
                            @input="form.gambar = $event.target.files[0]" label="Upload" class="w-full" />
                        <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                            {{ form.progress.percentage }}%
                        </progress>
                        <NotificationBar color="warning" v-if="errors" :icon="mdiAlert"
                            :outline="notificationsOutline">
                            <b>Warning</b>.{{ errors }} <template #right>

                            </template>
                        </NotificationBar>

                    </div>
                    <div v-if="previewImageIjazah">
                        <img width="100" height="100" :src="previewImageIjazah" alt="Preview foto" />
                    </div>
                    <div v-else>
                    </div>

                </FormField>



                <template #footer>
                    <BaseButton label="Tambah" type="submit" color="info" />
                </template>
            </CardBox>
            <CardBox class="mt-6">

                <NotificationBarInCard :color="getFormStatusColor" :is-placed-with-header="formStatusWithHeader">
                    <span>Tabel Pengumuman</span>
                </NotificationBarInCard>
                <datatablecomponent :buttons_data="buttons_data" routeTo="pengumumans" :dataFrom="pengumuman" :form="form"
                    :columns="columns">
                </datatablecomponent>
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>
<style>
@import "datatables.net-dt";
</style>
