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

// Set the font files for pdfMake
// pdfMake.vfs = pdfFonts.pdfMake.vfs;


// Import DataTables library
DataTable.use(DataTablesLib);

// Define component properties
var props = defineProps(["users", "filteredTahuns", "tahuns", "password", "usersEdit"]);

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
            // window.open('/gethtmlpage', '_blank');
            exportHTML();

        }
    }
];
</script>

<template>
    <AppHead title="Users" />
    <LayoutAuthenticated>

        <SectionMain>
            <SectionTitle>Users</SectionTitle>

            <CardBox class="mt-6">

                <data-table 
                :options="{
                            order: [],
                        }" >
                    <thead>
                        <tr>
                            <th>Tahun</th>
                            <th>Gelombang</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(tahun, i) in filteredTahuns">
                            <!-- <td>{{ i + 1 }}</td> -->
                            <td>{{ tahun.tahun }}</td>
                            <td>

                        <tr v-for="(tahun, i) in tahuns.filter(item => item.tahun == tahun.tahun)" :key="i">
                            <td><span class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">{{
                                tahun.gelombang }}</span> 
                                <a  :href="'/users/tahun/' + tahun.id" target="_blank" rel="noopener noreferrer"
                                    class=" ms-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    lihat data
                                </a>
                            </td>
                        </tr>

                        </td>
                        </tr>

                    </tbody>
                </data-table>



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
