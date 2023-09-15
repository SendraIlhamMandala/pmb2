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
var props = defineProps(["user", "usersWithPassword", "password", "usersEdit"]);

// Configuration for exporting data to Excel
const dataExcel = {
    extend: "excel",
    messageTop: "Data Gameee",
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

// Array of form status options
const formStatusOptions = ["info", "success", "danger", "warning"];

// Computed property for form status color based on success
const getFormStatusColor = computed(() => {
    if (form.recentlySuccessful) {
        return formStatusOptions[1]; // Return success status color
    } else {
        return formStatusOptions[0]; // Return info status color
    }
});

function exportHTML() {

    // axios.get('/gethtmlpage').then(response => {
    //     var sourceHTML = '';
    //     sourceHTML = response.data;
    //     console.log(response.data);
    //     var fileDownload = document.createElement("a");
    //     var source = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(sourceHTML);

    //     document.body.appendChild(fileDownload);
    //     fileDownload.href = source;
    //     fileDownload.download = 'document.doc';
    //     fileDownload.click();
    // })

    axios.get('/gethtmlpage').then(response => {
        var sourceHTML = response.data;

        // Convert the HTML content to a PDF document definition
        var documentDefinition = {
            content: [
                htmlToPdfmake(sourceHTML)
            ]
        };

        console.log(htmlToPdfmake(sourceHTML));
        // Create the PDF
        var pdf = pdfMake.createPdf(documentDefinition);

        // Download the PDF file
        pdf.download('document.pdf');
    });


}




// Function to handle form submission
const formStatusSubmit = () => {
    form.post("/users", {
        preserveScroll: true,
    });
};

// Define columns for the data table
console.log(props.usersWithPassword);
const columns = [
    { data: "id" },
    { data: "name" },
    { data: "email" },
    { data: "done_setup" },
    { data: "password" },
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
            window.open('/gethtmlpage', '_blank');

        }
    }
];
console.log(props.user);
</script>

<template>
    <AppHead title="Users" />
    <LayoutAuthenticated>

        <SectionMain>
            <SectionTitle>Form with status example</SectionTitle>

            <CardBox hasTable="false" class="mt-6">

                <div class="grid grid-cols-3 grid-rows-1 gap-2">
                    <div>

                        <div class="grid grid-cols-1 grid-rows-3 gap-1">
                            <div>
                                <CardBox hasTable="false">
                                    {{ user.name }}

                                </CardBox>
                            </div>
                            <div>
                                <CardBox hasTable="false">
                                    
                                    <div class=" font-bold mb-2" >
                                        Jalur Pendaftaran anda
                                    </div>
                                   
                                    <FormField label="Shift Kelas" class="">
                                        <FormControl v-model="user.data_daftar.shift" type="text" :disabled="true" />
                                    </FormField>
                                    <FormField label="Jalur Pendaftaran" class="">
                                        <FormControl v-model="user.data_daftar.jalur" type="text" :disabled="true" />
                                    </FormField>
                                    <FormField label="Status Pendaftaran" class="">
                                        <FormControl v-model="user.data_daftar.status" type="text" :disabled="true" />
                                    </FormField>
                                    <FormField label="Program Studi" class="">
                                        <FormControl v-model="user.data_daftar.program_studi" type="text" :disabled="true" />
                                    </FormField>

                                </CardBox>
                            </div>
                            <div>3</div>
                        </div>

                        <CardBox hasTable="false">
                            {{ user }}

                        </CardBox>

                    </div>
                    <div class="col-span-2  ">
                        <CardBox>
                            <NotificationBarInCard :color="getFormStatusColor"
                                :is-placed-with-header="formStatusWithHeader">
                                <span><b class="capitalize">{{
                                    formStatusOptions[formStatusCurrent]
                                }}</b>
                                    {{ form.recentlySuccessful ? " Berhasil menambahkan" : "Data Diri User" }}</span>
                            </NotificationBarInCard>
                            <div>
                                <FormField label="Nama" class="">
                                        <FormControl v-model="user.name" type="text" :disabled="true" />
                                    </FormField>
                                <FormField label="Nomor Peserta" class="">
                                        <FormControl v-model="user.nim" type="text" :disabled="true" />
                                    </FormField>
                                <FormField label="Nomor KTP" class="">
                                        <FormControl v-model="user.data_pribadi.no_ktp" type="text" :disabled="true" />
                                    </FormField>
                                <FormField label="Tempat Lahir" class="">
                                        <FormControl v-model="user.data_pribadi.tempat_lahir" type="text" :disabled="true" />
                                    </FormField>
                                    <FormField label="Tanggal Lahir" class="">
                                        <FormControl v-model="user.data_pribadi.tanggal_lahir" type="text" :disabled="true" />
                                    </FormField>
                                <FormField label="Jenis Kelamin" class="">
                                        <FormControl v-model="user.data_pribadi.jenis_kelamin" type="text" :disabled="true" />
                                    </FormField>
                                <FormField label="Agama" class="">
                                        <FormControl v-model="user.data_pribadi.agama" type="text" :disabled="true" />
                                    </FormField>
                                <FormField label="Alamat" class="">
                                        <FormControl v-model="user.alamat.alamat" type="text" :disabled="true" />
                                    </FormField>
                                <FormField label="Email" class="">
                                        <FormControl v-model="user.email" type="text" :disabled="true" />
                                    </FormField>
                                <FormField label="Facebook" class="">
                                        <FormControl v-model="user.data_pribadi.facebook" type="text" :disabled="true" />
                                    </FormField>    
                                <FormField label="Instagram" class="">
                                        <FormControl v-model="user.data_pribadi.ig" type="text" :disabled="true" />
                                    </FormField>
                            
                            
                                <div class=" flex">
                                    <div class=" w-1/2">
                                        Nama
                                    </div>
                                    <div>
                                        : {{ user.name }}
                                    </div>
                                </div>
                                <div class=" flex">
                                    <div class=" w-1/2">
                                        Nomor Peserta
                                    </div>
                                    <div>
                                        : {{ user.nim }}
                                    </div>
                                </div>
                                <div class=" flex">
                                    <div class=" w-1/2">
                                        Nomor KTP
                                    </div>
                                    <div>
                                        : {{ user.data_pribadi.no_ktp }}
                                    </div>
                                </div>
                                <div class=" flex">
                                    <div class=" w-1/2">
                                        Tempat Lahir
                                    </div>
                                    <div>
                                        : {{ user.data_pribadi.tempat_lahir }}
                                    </div>
                                </div>
                                <div class=" flex">
                                    <div class=" w-1/2">
                                        Tanggal Lahir
                                    </div>
                                    <div>
                                        : {{ user.data_pribadi.tanggal_lahir }}
                                    </div>
                                </div>
                                <div class=" flex">
                                    <div class=" w-1/2">
                                        Jenis Kelamin
                                    </div>
                                    <div>
                                        : {{ user.data_pribadi.jenis_kelamin }}
                                    </div>
                                </div>
                                <div class=" flex">
                                    <div class=" w-1/2">
                                        Agama
                                    </div>
                                    <div>
                                        : {{ user.data_pribadi.agama }}
                                    </div>
                                </div>
                                <div class=" flex">
                                    <div class=" w-1/2">
                                        Alamat
                                    </div>
                                    <div>
                                        : {{ user.alamat.alamat }}
                                    </div>
                                </div>

                                <div class=" flex">
                                    <div class=" w-1/2">
                                        kelurahan
                                    </div>
                                    <div>
                                        : {{ user.alamat.kelurahan }}
                                    </div>
                                </div>
                                <div class=" flex">
                                    <div class=" w-1/2">
                                        kecamatan
                                    </div>
                                    <div>
                                        : {{ user.alamat.kecamatan }}
                                    </div>
                                </div>
                                <div class=" flex">
                                    <div class=" w-1/2">
                                        kabupaten
                                    </div>
                                    <div>
                                        : {{ user.alamat.kabupaten }}
                                    </div>

                                </div>
                                <div class=" flex">
                                    <div class=" w-1/2">
                                        provinsi
                                    </div>
                                    <div>
                                        : {{ user.alamat.provinsi }}
                                    </div>
                                </div>
                                <div class=" flex">
                                    <div class=" w-1/2">
                                        kode_pos
                                    </div>
                                    <div>
                                        : {{ user.alamat.kodepos }}
                                    </div>
                                </div>
                                <div class=" flex">
                                    <div class=" w-1/2">
                                        no_hp
                                    </div>
                                    <div>
                                        : {{ user.data_pribadi.no_hp }}
                                    </div>
                                </div>
                                <div class=" flex">
                                    <div class=" w-1/2">
                                        email
                                    </div>
                                    <div>
                                        : {{ user.email }}
                                    </div>
                                </div>
                                <div class=" flex">
                                    <div class=" w-1/2">
                                        fb
                                    </div>
                                    <div>
                                        : {{ user.data_pribadi.facebook }}
                                    </div>
                                </div>
                                <div class=" flex">
                                    <div class=" w-1/2">
                                        ig
                                    </div>
                                    <div>
                                        : {{ user.data_pribadi.ig }}
                                    </div>
                                </div>

                            </div>
                        </CardBox>
                    </div>
                </div>

                <datatablecomponent :buttons_data="buttons_data" routeTo="users" :dataFrom="usersWithPassword" :form="form"
                    :columns="columns">
                </datatablecomponent>
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>
<style>
@import "datatables.net-dt";
</style>
