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
import axios from "axios";
import pdfMake from 'pdfmake/build/pdfmake';
import pdfFonts from 'pdfmake/build/vfs_fonts';
import htmlToPdfmake from 'html-to-pdfmake';
import jszip from "jszip";

// Set the font files for pdfMake
// pdfMake.vfs = pdfFonts.pdfMake.vfs;

DataTable.use(DataTablesLib);
DataTablesLib.Buttons.jszip(jszip);
// pdfMake.vfs = pdfFonts.pdfMake.vfs;


// Define component properties
var props = defineProps(["users", "filteredTahuns", "tahun", "password", "usersEdit"]);

// Configuration for exporting data to Excel
const dataExcel = {
    extend: "excel",
    messageTop: "Data User",
    exportOptions: {
        columns: [0, 1, 2, 3, 4, 5],
    },
};

// Create form object using useForm hook
const form = useForm({
    name: "",
    email: "",
    password: "abc",
});

// Reactive reference for form status with header
const formStatusWithHeader = ref(true);

// Reactive reference for current form status
const formStatusCurrent = ref(0);


function exportHTML() {

    axios.get('/gethtmlpage').then(response => {
        var sourceHTML = '';
        sourceHTML = response.data;
        console.log(response.data);
        var fileDownload = document.createElement("a");
        var source = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(sourceHTML);
        // console.log(source);
        document.body.appendChild(fileDownload);
        fileDownload.href = source;
        fileDownload.download = 'document.doc';
        fileDownload.click();
    })

    // axios.get('/gethtmlpage').then(response => {
    //     var sourceHTML = response.data;

    //     // Convert the HTML content to a PDF document definition
    //     var documentDefinition = {
    //         content: [
    //             htmlToPdfmake(sourceHTML)
    //         ]
    //     };

    //     console.log(htmlToPdfmake(sourceHTML));
    //     // Create the PDF
    //     var pdf = pdfMake.createPdf(documentDefinition);

    //     // Download the PDF file
    //     pdf.download('document.pdf');
    // });


}




// Function to handle form submission
const formStatusSubmit = () => {
    form.post("/users", {
        preserveScroll: true,
    });
};

// Define columns for the data table
console.log(props.users);
const columns = [
    { data: "id" },
    { data: "tahun" },
    { data: "gelombang" },
    { data: "status" },
    { data: "daritgl" },
    { data: "sampaitgl" },
    {
        data: "created_at",
        render: (data) =>
            new Date(data).getDate() +
            "-" +
            (new Date(data).getMonth() + 1) +
            "-" +
            new Date(data).getFullYear(),
        title: "Tanggal Daftar",
    },
    {
        data: "created_at",
        render: (data) =>
            new Date(data).getHours() + ":" + new Date(data).getMinutes(),
        title: "Jam Daftar",
    },
    {
        title: "Aksi",
        mRender: function (data, type, row) {
            // Render edit action link with row ID
            return (
                "<a class='table-edit' data-id='" +
                row.id +
                "' href='/users/" +
                row.id +
                "/edit') >EDIT</a>"
            );
        },
    },
    {
        title: "Aksi",
        mRender: function (data, type, row) {
            // Render delete action link with row ID
            return (
                "<a class='table-edit' href='users/deleteone/" +
                row.id +
                "'' method='delete' ) >HAPUS</a>"
            );
        },
    },
];

const buttons_data = ['copy', dataExcel , 'pdf',
   {
        text: 'Export doc',
        action: function () {
            // window.open('/gethtmlpage', '_blank');
            exportHTML();

        }
    }
];

import { router } from '@inertiajs/vue3'

const navigateToShowUser = (data) => {
    router.get("/lihat-user/noedit/" + data);
}
</script>

<template>
    <AppHead title="Users" />
    <LayoutAuthenticated>

        <SectionMain>
            <SectionTitle>Pendaftar Tahun {{ tahun.tahun }} gelombang {{ tahun.gelombang }}</SectionTitle>

            <CardBox class="mt-6">

         

                <DataTable ref="table" class="display table" width="100%" :options="{
                            dom: 'Bfrtip',
                            select: true,
                            scrollX: true,
                            order: [],
                            buttons: buttons_data,

                        }">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No.Peserta</th>
                                    <th>Nama Peserta</th>
                                    <th>Asal Sekolah</th>
                                    <th>Jalur Pendaftaran</th>
                                    <th>Status Pendaftar</th>
                                    <th>Pilih</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(data, index) in users">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ data.nim }}</td>
                                    <td>{{ data.name }}</td>
                                    <td>{{ !!data.asal_sekolah ? data.asal_sekolah.nama_sekolah : 'belum mengisi' }}</td>
                                    <td>{{ data.data_daftar.jalur }}</td>

                                    <td>
                                        <BaseButton v-if="data.status == 'menunggu verifikasi'" color="warning" :small="true" :rounded-full="true" :label="'menunggu verifikasi'" />
                                        <BaseButton v-else-if="data.status == 'sudah'" color="success" :small="true" :rounded-full="true" :label="data.status" />
                                        <BaseButton v-else-if="data.status == 'belum'" color="contrast" :small="true" :rounded-full="true" :label="data.status" />
                                        <BaseButton v-else color="contrast" :small="true" :rounded-full="true" :label="data.status" />
                                    </td>



                                    <td>
                                        <BaseButton v-if="data.status == 'menunggu verifikasi' || data.status == 'sudah'|| data.status == 'tolak'" color="info" :small="true" label="lihat data"
                                            @click="navigateToShowUser(data.id)" />
                                    </td>

                                </tr>

                            </tbody>
                        </DataTable>

                <!-- <NotificationBarInCard color="info" :is-placed-with-header="formStatusWithHeader">
                    <span>Tabel User</span>
                </NotificationBarInCard> -->
                <!-- <datatablecomponent :buttons_data="buttons_data" routeTo="users" :dataFrom="tahuns" :form="form" :columns="columns">
                </datatablecomponent> -->
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>
<style>@import "datatables.net-dt";</style>
