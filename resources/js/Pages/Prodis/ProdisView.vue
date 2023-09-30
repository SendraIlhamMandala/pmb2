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
import axios from "axios";

import DataTable from "datatables.net-vue3";
import Select from "datatables.net-select";
import DataTablesLib from "datatables.net";
import DataTables from "datatables.net-select";


// Impor library DataTables
DataTable.use(DataTablesLib);

// Mendefinisikan properti untuk komponen
var props = defineProps(["prodis", "prodisEdit"]);

// Mendefinisikan konfigurasi untuk mengekspor data ke Excel
const dataExcel = {
    extend: "excel",
    messageTop: "data Program Studi",
    exportOptions: {
        columns: [0, 1, 2, 3, 4],
    },
};

// Membuat objek form menggunakan hook useForm
const form = useForm({
    name: ""
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
    form.post("/prodis", {
        preserveScroll: true,
    });
};

// Mendefinisikan kolom-kolom untuk tabel data

const columns = [
    { data: "id" },
    { data: "name" , render: data => data.toUpperCase() },
    { data: "created_at", render: data => new Date(data).getFullYear() },
    {
        title: "aksi",
        render: function (data, type, row) {
            // Render tautan aksi edit dengan ID baris
            return (
                "<a class='table-edit' data-id='" + row.id + "' href='/prodis/" + row.id + "/edit' >EDIT</a>"
            );
        },
    },
    {
        title: "aksi",
        render: function (data, type, row) {
            // Render tautan aksi hapus dengan ID baris
            return (
                "<a class='table-edit' href='prodis/delete/" + row.id + "'' method='delete' ) >HAPUS</a>"
            );
        },
    },
];
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


</script>

<template>

<AppHead title="Program Studi" />
    <LayoutAuthenticated>
        
        <SectionMain>
            <SectionTitle>Program Studi</SectionTitle>

            <CardBox is-form is-hoverable
                @submit.prevent="formStatusSubmit">
                <NotificationBarInCard :color="getFormStatusColor" :is-placed-with-header="formStatusWithHeader">
                    <span><b class="capitalize">{{
                        formStatusOptions[formStatusCurrent]
                    }}</b>
                        {{form.recentlySuccessful?" Berhasil menambahkan": "Tambah Program study"}}</span>
                </NotificationBarInCard>
                <FormField label="Name">
                    <FormControl v-model="form.name" :icon-left="mdiAccount" help="Program study name" placeholder="Program study name"
                        required />
                </FormField>

            

                <template #footer>
                    <BaseButton label="Tambah" type="submit" color="info" />
                </template>
            </CardBox>
            <CardBox class="mt-6">

                <NotificationBarInCard :color="getFormStatusColor" :is-placed-with-header="formStatusWithHeader">
                    <span>Tabel Prodi</span>
                </NotificationBarInCard>
                <datatablecomponent :buttons_data="buttons_data" routeTo="prodis"  :dataFrom="prodis" :form="form" :columns="columns">
                </datatablecomponent>
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>
<style>
@import "datatables.net-dt";
</style>
