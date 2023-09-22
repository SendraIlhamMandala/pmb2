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



const isJalurValid = computed(() => {
  const jalur = props.user.data_daftar.jalur;
  console.log(jalur);
  return jalur == 'Prestasi non akademik' ||
         jalur == 'Jalur ranking';
});

console.log(props.user);
</script>

<template>
    <AppHead title="Users" />
    <LayoutAuthenticated>
        <div class="fixed bottom-0 left-0 w-full flex justify-center py-4 z-50">
            <Link
                class="inline-block py-2 px-6 mx-6 bg-white text-green-500 hover:bg-green-200 hover:text-white text-sm font-bold rounded-xl transition duration-200"
                :href="route('verifikasiUser', user.id+','+'terima')">
            Verifikasi
            </Link>
            <a v-if="$page.props.auth.user"
                class="inline-block py-2 px-6 mx-6 bg-white text-green-500 hover:bg-green-200 hover:text-white text-sm font-bold rounded-xl transition duration-200"
                :href="route('verifikasiUser', user.id+','+'tolak')">
                Tolak
            </a>
        </div>
        <SectionMain>
            <SectionTitle>Form with status example</SectionTitle>

            <CardBox class="mt-6 bg-opacity-0  ">

                <div class="grid grid-cols-3 gap-2">
                    <div>

                        <div class="grid grid-cols-1 grid-rows-[200px_minmax(200px,_1fr)_100px] gap-1">
                            <div class="">
                                <CardBox>

                                    <div className="grid grid-cols-2 grid-rows-1 gap-4">
                                        <div class="m-auto">
                                            <img class="h-40 rounded" :src="'/storage/avatar/' + user.data_pribadi.foto"
                                                alt="" />
                                        </div>
                                        <div>
                                            <div class="font-bold">
                                                {{ user.name }}
                                            </div>
                                            <div class=" text-gray-500">
                                                {{ user.nim }}
                                            </div>
                                            <div>
                                                <button>
                                                    <Link href="">
                                                    Edit
                                                    </Link>

                                                </button>
                                            </div>

                                        </div>
                                    </div>

                                </CardBox>
                            </div>
                            <div>
                                <CardBox>

                                    <NotificationBarInCard :color="getFormStatusColor"
                                        :is-placed-with-header="formStatusWithHeader">
                                        <span>
                                            {{ form.recentlySuccessful ? " Berhasil menambahkan" : "Jalur Pendaftaran"
                                            }}</span>
                                    </NotificationBarInCard>
                                    <FormField label="Shift Kelas" class=" mb-1">
                                        <FormControl v-model="user.data_daftar.shift" type="text" :disabled="true" />
                                    </FormField>
                                    <FormField label="Jalur Pendaftaran" class=" mb-1">
                                        <FormControl v-model="user.data_daftar.jalur" type="text" :disabled="true" />
                                    </FormField>
                                    <FormField label="Status Pendaftaran" class=" mb-1">
                                        <FormControl v-model="user.data_daftar.status" type="text" :disabled="true" />
                                    </FormField>
                                    <FormField label="Program Studi" class=" mb-1">
                                        <FormControl v-model="user.data_daftar.program_studi" type="text"
                                            :disabled="true" />
                                    </FormField>

                                </CardBox>
                            </div>
                            <div>

                                <CardBox>
                                    <NotificationBarInCard :color="getFormStatusColor"
                                        :is-placed-with-header="formStatusWithHeader">
                                        <span>
                                            {{ form.recentlySuccessful ? " Berhasil menambahkan" : "Status Pengisian Formulir Pendaftaran" }}</span>
                                    </NotificationBarInCard>
                                    <div class="card-body text-center ">
                                        <a href="formulir.php?id=MjAyNDEwMDE1&&DataDiri"
                                            class="btn my-4 bg-blue-500 rounded-full text-white hover:bg-blue-600 hover:text-white block w-full">Data
                                            Diri</a>
                                        <a href="formulir.php?id=MjAyNDEwMDE1&&DataSekolah"
                                            class="btn my-4 bg-blue-500 rounded-full text-white hover:bg-blue-600 hover:text-white block w-full">Data
                                            Asal Sekolah</a>
                                        <a href="formulir.php?id=MjAyNDEwMDE1&&DataOrangtua"
                                            class="btn my-4 bg-blue-500 rounded-full text-white hover:bg-blue-600 hover:text-white block w-full">Data
                                            Orang Tua Wali</a>
                                        <a v-if="!!user.data_kerja" href="formulir.php?id=MjAyNDEwMDE1&&DataOrangtua"
                                            class="btn my-4 bg-blue-500 rounded-full text-white hover:bg-blue-600 hover:text-white block w-full">Data
                                            Data Pekrjaan</a>
                                        <a href="formulir.php?id=MjAyNDEwMDE1&&DataTambahan"
                                            class="btn my-4 bg-blue-500 rounded-full text-white hover:bg-blue-600 hover:text-white block w-full">Data
                                            Tambahan</a>
                                    </div>
                                </CardBox>


                            </div>
                        </div>



                    </div>
                    <div class="col-span-2  ">
                        <CardBox>
                            <NotificationBarInCard :color="getFormStatusColor"
                                :is-placed-with-header="formStatusWithHeader">
                                <span>
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



                            </div>
                        </CardBox>
                    </div>
                    <div>
                    </div>
                    <div class="col-span-2  ">
                        <CardBox>
                            <NotificationBarInCard :color="getFormStatusColor"
                                :is-placed-with-header="formStatusWithHeader">
                                <span>
                                    {{ form.recentlySuccessful ? " Berhasil menambahkan" : "Data Asal Sekolah" }}</span>
                            </NotificationBarInCard>
                            <div>
                                <FormField label="Asal Sekolah" class="">
                                    <FormControl v-model="user.asal_sekolah.nama_sekolah" type="text" :disabled="true" />
                                </FormField>
                                <FormField label="alamat sekolah" class="">
                                    <FormControl v-model="user.asal_sekolah.alamat_sekolah" type="text" :disabled="true" />
                                </FormField>
                                <FormField label="Tahun Kelulusan" class="">
                                    <FormControl v-model="user.asal_sekolah.tahun_lulus" type="text" :disabled="true" />
                                </FormField>
                                <FormField label="Jurusan Asal" class="">
                                    <FormControl v-model="user.asal_sekolah.jurusan" type="text" :disabled="true" />
                                </FormField>
                                <FormField label="Nilai Skhun" class="">
                                    <FormControl v-model="user.asal_sekolah.nilai_skhun" type="text" :disabled="true" />
                                </FormField>
                                <FormField label="Skhun" class="">
                                    <img :src="'/storage/skhun/' + user.asal_sekolah.skhun" alt="" />
                                </FormField>
                                <FormField label="Ijazah" class="">
                                    <img :src="'/storage/ijazah/' + user.asal_sekolah.ijazah" alt="" />
                                </FormField>



                            </div>
                        </CardBox>
                    </div>
                    <div>
                    </div>
                    <div class="col-span-2  ">
                        <CardBox>
                            <NotificationBarInCard :color="getFormStatusColor"
                                :is-placed-with-header="formStatusWithHeader">
                                <span>
                                    {{ form.recentlySuccessful ? " Berhasil menambahkan" : "Data Orang Tua / Wali (Ayah)"
                                    }}</span>
                            </NotificationBarInCard>
                            <div>


                                <FormField label="Nama Ayah" class="">
                                    <FormControl v-model="user.orangtua.nama_ayah" type="text" :disabled="true" />
                                </FormField>
                                <FormField label="NO.KTP Ayah">
                                    <FormControl v-model="user.orangtua.ktp_ayah" type="text" :disabled="true" />
                                </FormField>
                                <FormField label="Tempat Lahir Ayah">
                                    <FormControl v-model="user.orangtua.tempat_lahir_ayah" type="text" :disabled="true" />
                                </FormField>
                                <FormField label="Tanggal Lahir Ayah">
                                    <FormControl v-model="user.orangtua.tanggal_lahir_ayah" type="text" :disabled="true" />
                                </FormField>
                                <FormField label="Nomor Yang Bisa Dihubungi">
                                    <FormControl v-model="user.orangtua.no_hp_ayah" type="text" :disabled="true" />
                                </FormField>
                                <FormField label="Pekerjaan Ayah">
                                    <FormControl v-model="user.orangtua.pekerjaan_ayah" type="text" :disabled="true" />
                                </FormField>
                                <FormField label="Penghasilan Ayah">
                                    <FormControl v-model="user.orangtua.penghasilan_ayah" type="text" :disabled="true" />
                                </FormField>


                            </div>
                        </CardBox>
                    </div>
                    <div>
                    </div>
                    <div class="col-span-2  ">
                        <CardBox>
                            <NotificationBarInCard :color="getFormStatusColor"
                                :is-placed-with-header="formStatusWithHeader">
                                <span>
                                    {{ form.recentlySuccessful ? " Berhasil menambahkan" : "Data Orang Tua / Wali (Ibu)"
                                    }}</span>
                            </NotificationBarInCard>
                            <div>

                                <FormField label="Nama ibu" class="">
                                    <FormControl v-model="user.orangtua.nama_ibu" type="text" :disabled="true" />
                                </FormField>
                                <FormField label="NO.KTP ibu">
                                    <FormControl v-model="user.orangtua.ktp_ibu" type="text" :disabled="true" />
                                </FormField>
                                <FormField label="Tempat Lahir ibu">
                                    <FormControl v-model="user.orangtua.tempat_lahir_ibu" type="text" :disabled="true" />
                                </FormField>
                                <FormField label="Tanggal Lahir ibu">
                                    <FormControl v-model="user.orangtua.tanggal_lahir_ibu" type="text" :disabled="true" />
                                </FormField>
                                <FormField label="Nomor Yang Bisa Dihubungi">
                                    <FormControl v-model="user.orangtua.no_hp_ibu" type="text" :disabled="true" />
                                </FormField>
                                <FormField label="Pekerjaan ibu">
                                    <FormControl v-model="user.orangtua.pekerjaan_ibu" type="text" :disabled="true" />
                                </FormField>
                                <FormField label="Penghasilan ibu">
                                    <FormControl v-model="user.orangtua.penghasilan_ibu" type="text" :disabled="true" />
                                </FormField>

                            </div>
                        </CardBox>
                    </div>
                    <div v-if="!!user.tambahan">
                    </div>
                    <div v-if="!!user.tambahan" class="col-span-2  ">
                        <CardBox >
                            <NotificationBarInCard :color="getFormStatusColor"
                                :is-placed-with-header="formStatusWithHeader">
                                <span>
                                    {{ form.recentlySuccessful ? " Berhasil menambahkan" : "Data Tambahan" }}</span>
                            </NotificationBarInCard>
                            <div>

                                <FormField label="Keterangan ">
                                    <FormControl v-model="user.tambahan.isi_data" type="text" :disabled="true" />
                                </FormField>
                                <FormField v-if="isJalurValid" label="pdf">
                                <!-- <FormField v-if="user.data_daftar.jalur=='Prestasi non akademik' || user.data_daftar.jalur=='Jalur ranking' || user.data_daftar.jalur=='Undangan'" label="pdf" class=""> -->
                                    <embed :src="'/storage/pdf/' + user.tambahan.pdf" class="w-full " height="500" />

                                </FormField>
                                <FormField label="Foto Keterangan " class="">
                                    <img :src="'/storage/foto_bukti/' + user.tambahan.foto_bukti" alt="" />
                                </FormField>


                            </div>
                        </CardBox>
                    </div>
                    <div v-if="!!user.tambahan">
                    </div>
                    <div v-if="!!user.tambahan&&!!user.tambahan.survey" class="col-span-2  ">
                        <CardBox >
                            <NotificationBarInCard :color="getFormStatusColor"
                                :is-placed-with-header="formStatusWithHeader">
                                <span>
                                    {{ form.recentlySuccessful ? " Berhasil menambahkan" : "Data Survey" }}</span>
                            </NotificationBarInCard>
                            <div>

                                <FormField label="Darimana Anda Memperoleh Informasi Mengenai Penerimaan Mahasiswa Baru FISIP - UNIGA ? ">
                                    <FormControl v-model="user.tambahan.survey" type="text" :disabled="true" />
                                </FormField>
                            


                            </div>
                        </CardBox>
                    </div>
                    <div v-if="!!user.pindahan">
                    </div>
                    <div v-if="!!user.pindahan" class="col-span-2  ">
                        <CardBox>
                            <NotificationBarInCard :color="getFormStatusColor"
                                :is-placed-with-header="formStatusWithHeader">
                                <span>
                                    {{ form.recentlySuccessful ? " Berhasil menambahkan" : "Perguruan Tinggi Asal" }}</span>
                            </NotificationBarInCard>
                            <div>

                                <FormField label="Asal Perguruan Tinggi ">
                                    <FormControl v-model="user.pindahan.perguruan_tinggi" type="text" :disabled="true" />
                                </FormField>
                                <FormField label="Program studi ">
                                    <FormControl v-model="user.pindahan.program_studi" type="text" :disabled="true" />
                                </FormField>
                            
                                <FormField label="Nomor Induk Mahasiswa ">
                                    <FormControl v-model="user.pindahan.nomor_induk_mahasiswa" type="text" :disabled="true" />
                                </FormField>


                            </div>
                        </CardBox>
                    </div>

                    <div v-if="!!user.pekerjaan">
                    </div>
                    <div v-if="!!user.pekerjaan" class="col-span-2  ">
                        <CardBox>
                            <NotificationBarInCard :color="getFormStatusColor"
                                :is-placed-with-header="formStatusWithHeader">
                                <span>
                                    {{ form.recentlySuccessful ? " Berhasil menambahkan" : "Pekerjaan" }}</span>
                            </NotificationBarInCard>
                            <div>

                                <FormField label="Pekerjaan ">
                                    <FormControl v-model="user.pekerjaan.nama_pekerjaan" type="text" :disabled="true" />
                                </FormField>
                                <FormField label="Program studi ">
                                    <FormControl v-model="user.pekerjaan.nama_instansi" type="text" :disabled="true" />
                                </FormField>
                            

                            </div>
                        </CardBox>
                    </div>
                </div>

            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>
<style>@import "datatables.net-dt";</style>
