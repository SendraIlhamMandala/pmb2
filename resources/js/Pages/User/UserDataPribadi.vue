<script setup>
import { ref, computed, watch, onMounted } from "vue";
import { mdiBallotOutline, mdiAccount, mdiMail, mdiGithub } from "@mdi/js";
import SectionMain from "@/components/SectionMain.vue";
import CardBox from "@/components/CardBox.vue";
import FormField from "@/components/FormField.vue";
import FormControl from "@/components/FormControl.vue";
import BaseButton from "@/components/BaseButton.vue";
import SectionTitle from "@/components/SectionTitle.vue";
import LayoutAuthenticatedUser from "@/layouts/LayoutAuthenticatedUser.vue";
import NotificationBarInCard from "@/components/NotificationBarInCard.vue";
import { useForm, Link } from "@inertiajs/vue3";
import datatablecomponent from "@/components/DataTableComponent.vue";
import LayoutAuthenticated from "@/layouts/LayoutAuthenticated.vue";
import AppHead from "@/components/AppHead.vue";
import FormFilePicker from "@/components/FormFilePicker.vue";

import DataTable from "datatables.net-vue3";
import Select from "datatables.net-select";
import DataTablesLib from "datatables.net";
import DataTables from "datatables.net-select";
import NotificationBar from "@/components/NotificationBar.vue";
import { router } from '@inertiajs/vue3'


const previewImage = ref('');

const handleFileChange = (event) => {
    const selectedFile = event.target.files[0];
    if (selectedFile) {
        const reader = new FileReader();
        reader.onload = (e) => {
            previewImage.value = e.target.result;
        };
        reader.readAsDataURL(selectedFile);
    }
};


const previewImageSKHUN = ref('');

const handleFileChangeSKHUN = (event) => {
    const selectedFile = event.target.files[0];
    if (selectedFile) {
        const reader = new FileReader();
        reader.onload = (e) => {
            previewImageSKHUN.value = e.target.result;
        };
        reader.readAsDataURL(selectedFile);
    }
};




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



const previewImageRanking = ref('');

const handleFileChangeRanking = (event) => {
    const selectedFile = event.target.files[0];
    if (selectedFile) {
        const reader = new FileReader();
        reader.onload = (e) => {
            previewImageRanking.value = e.target.result;
        };
        reader.readAsDataURL(selectedFile);
    }
};

// Impor library DataTables
DataTable.use(DataTablesLib);

// Mendefinisikan properti untuk komponen
var props = defineProps(["user", "cat" , "errors"]);

const selectOptionsKelamin = ["Laki - Laki", "Perempuan"];
const selectOptionsPekerjaan = ["PNS", "TNI / Polri", "BUMN / BUMD ", "Wiraswasta", "lainnya"];
const selectOptionsSurvey = ["Teman di FISIP UNIGA", "Medsos (IG, Facebook)", "Brosur/ Spanduk ", "Iklan Radio", "Guru BK / Sekolah", "Roadshow" , "Lainnya"];
const selectOptionsPenghasilan = ["< Rp.500.000", "Rp.500.000 - Rp.999.999", "Rp.1000.000 - Rp.1.999.999", "Rp.2.000.000 - Rp.4.999.999", "Rp.5.000.000 - Rp.20.000.000", "> 20.000.000"];

var pilihan_pekerjaan_ibu = ref();
var pilihan_pekerjaan_ayah = ref();
var pilihan_pekerjaan_anda = ref();

// Membuat objek form menggunakan hook useForm
const form = useForm({
    dataPribadi: {
        no_ktp: '',
        nisn: '',
        tempat_lahir: '',
        tanggal_lahir: '',
        jenis_kelamin: selectOptionsKelamin[0],
        agama: '',
        ig: '',
        facebook: '',
        foto: null,
        no_hp: '',
    },
    alamat: {
        alamat: '',
        kelurahan: '',
        kecamatan: '',
        kabupaten: '',
        provinsi: '',
        kodepos: '',

    },
    sekolah: {
        nama_sekolah: '',
        alamat_sekolah: '',
        tahun_lulus: '',
        jurusan: '',
        nilai_skhun: '',
    },
    orangtua: {
        nama_ayah: '',
        ktp_ayah: '',
        tempat_lahir_ayah: '',
        tanggal_lahir_ayah: '',
        no_hp_ayah: '',
        pekerjaan_ayah: '',
        penghasilan_ayah: '',
        nama_ibu: '',
        ktp_ibu: '',
        tempat_lahir_ibu: '',
        tanggal_lahir_ibu: '',
        no_hp_ibu: '',
        pekerjaan_ibu: '',
        penghasilan_ibu: '',

    },
    pindahan: {
        perguruan_tinggi: '',
        program_studi: '',
        nomor_induk_mahasiswa: '',
    },
    tambahan: {

        isi_data: '',
        foto_bukti: '',
        pdf: '',

    },
    pekerjaan: {
        nama_pekerjaan: '',
        nama_instansi: '',
    }

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
const formSubmit = () => {
    form.post(route('user.set-data-pribadi', props.user.id));
};
const jalurEdit = () => {
    router.get('data-jalur/edit/' + props.user.id);
};

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#foto')
                .attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}
watch(pilihan_pekerjaan_ibu, (newCount) => {
    // yes, console.log() is a side effect
    if (newCount != 'lainnya') {

        form.orangtua.pekerjaan_ibu = newCount
    } else {
        form.orangtua.pekerjaan_ibu = ''
    }

    console.log(`new pilihan pekerjaan ibu is: ${newCount}`)
})

watch(pilihan_pekerjaan_ayah, (newCount) => {
    // yes, console.log() is a side effect
    if (newCount != 'lainnya') {

        form.orangtua.pekerjaan_ayah = newCount
    } else {
        form.orangtua.pekerjaan_ayah = ''
    }

    console.log(`new pilihan pekerjaan ayah is: ${newCount}`)
})

watch(pilihan_pekerjaan_anda, (newCount) => {
    // yes, console.log() is a side effect
    if (newCount != 'lainnya') {

        form.pekerjaan.nama_pekerjaan = newCount
    } else {
        form.pekerjaan.nama_pekerjaan = ''
    }

    console.log(`new pilihan pekerjaan ayah is: ${newCount}`)
})

console.log(props.user);
</script>

<template>
    <AppHead :title="'Data Pribadi'" />
    <LayoutAuthenticatedUser>

        <SectionMain>
            <SectionTitle class="mt-4">Masukkan Data </SectionTitle>

            <div class=" grid grid-cols-1 md:grid-cols-3 grid-rows-1 gap-4">

                <div  class=" md:fixed  md:-translate-y-10 ">
                    <CardBox class="shadow-2xl md:mx-auto mx-auto md:w-3/4 lg:w-80  ">

                        <div class="w-11/12 mx-auto mt-8">

                            <NotificationBarInCard :color="getFormStatusColor"
                                :is-placed-with-header="formStatusWithHeader">
                                <span>
                                    {{ form.recentlySuccessful ? " Berhasil menambahkan" : "Jalur Pendaftaran Anda"
                                    }}</span>
                            </NotificationBarInCard>
                        </div>


                        <FormField mb="mb-0" label="Shift" class="">
                            <FormControl h="h-6" v-model="user.data_daftar.shift" type="text" :disabled="true" />
                            <p class="text-red-500">{{ errors.name }}</p>
                        </FormField>
                        <FormField mb="mb-0" label="Jalur" class="">
                            <FormControl h="h-6" v-model="user.data_daftar.jalur" type="text" :disabled="true" />
                            <p class="text-red-500">{{ errors.name }}</p>
                        </FormField>
                        <FormField mb="mb-0" label="Status" class="">
                            <FormControl h="h-6" v-model="user.data_daftar.status" type="text" :disabled="true" />
                            <p class="text-red-500">{{ errors.name }}</p>
                        </FormField>
                        <FormField mb="mb-0" label="Program Studi" class="">
                            <FormControl h="h-6" v-model="user.data_daftar.program_studi" type="text" :disabled="true" />
                            <p class="text-red-500">{{ errors.name }}</p>
                        </FormField>
                        <div v-if="!cat" class="flex mt-4 justify-center items-center">
                            <BaseButton @click.prevent="jalurEdit" label="Edit Jalur Daftar" type="submit" color="info" />
                        </div>
                        <div v-else class="flex mt-4 justify-center items-center">
                            <BaseButton @click.prevent="" label="Sudah mengikuti ujian" type="submit" color="success" />
                        </div>

                    </CardBox>
                </div>
                <div></div>
                <div className="col-span-2">
                    <CardBox class=" shadow-2xl md:mx-auto mx-auto h-full " is-form is-hoverable
                        @submit.prevent="formSubmit">

                        <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="md:col-span-2">
                                <div class="w-11/12 mx-auto mt-8">

                                    <NotificationBarInCard :color="getFormStatusColor"
                                        :is-placed-with-header="formStatusWithHeader">
                                        <span>
                                            {{ form.recentlySuccessful ? " Berhasil menambahkan" : "data pribadi" }}</span>
                                    </NotificationBarInCard>
                                </div>
                                <FormField label="Foto" class="mx-auto">
                                    <div class="">
                                        <div v-if="previewImage" class="flex justify-center h-40">
                                            <img :src="previewImage" alt="Preview foto" class="h-40" />
                                        </div>
                                        <div v-else class="flex justify-center h-40">
                                            <img :src="'/image/profile.png'" alt="" />
                                        </div>
                                        <div class="grid grid-row-2 gap-4 col-span-2 justify-center">
                                            <div class=" text-2xl justify-center mx-auto ">{{ user.name[0].toUpperCase() +
                                                user.name.slice(1) }}</div>
                                            <FormFilePicker accept=".jpg,.jpeg,.png" @change="handleFileChange"
                                                @input="form.dataPribadi.foto = $event.target.files[0]" label="Upload"
                                                class="w-full" required />

                                            <!-- <input type="file" @input="form.dataPribadi.foto = $event.target.files[0]" /> -->
                                            <progress v-if="form.dataPribadi.progress"
                                                :value="form.dataPribadi.progress.percentage" max="100">
                                                {{ form.dataPribadi.progress.percentage }}%
                                            </progress>
                                            <NotificationBar color="warning" v-if="errors.foto" :icon="mdiAlert"
                                                :outline="notificationsOutline">
                                                <b>Warning</b>.{{ errors.foto }} <template #right>

                                                </template>
                                            </NotificationBar>

                                        </div>
                                    </div>

                                </FormField>

                                <div class="w-11/12 mx-auto mt-8">

                                    <NotificationBarInCard :color="getFormStatusColor"
                                        :is-placed-with-header="formStatusWithHeader">
                                        <span>
                                            {{ form.recentlySuccessful ? " Berhasil menambahkan" : "data pribadi" }}</span>
                                    </NotificationBarInCard>
                                </div>
                                <FormField label="No KTP">
                                    <FormControl v-model="form.dataPribadi.no_ktp" type="number" class=" appearance-none"
                                        placeholder="No KTP" required />
                                    <NotificationBar color="warning" v-if="errors.no_ktp" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.no_ktp }} <template #right>

                                        </template>
                                    </NotificationBar>

                                </FormField>

                                <FormField label="NISN (Nomor Induk Siswa Nasional)">
                                    <FormControl v-model="form.dataPribadi.nisn" type="number" placeholder="NISN"
                                        required />
                                    <NotificationBar color="warning" v-if="errors.nisn" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.nisn }} <template #right>

                                        </template>
                                    </NotificationBar>

                                </FormField>

                                <FormField label="Tempat Lahir">
                                    <FormControl v-model="form.dataPribadi.tempat_lahir" placeholder="Tempat Lahir"
                                        required />
                                    <NotificationBar color="warning" v-if="errors.tempat_lahir" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.tempat_lahir }} <template #right>

                                        </template>
                                    </NotificationBar>

                                </FormField>

                                <FormField label="Tanggal Lahir">
                                    <FormControl v-model="form.dataPribadi.tanggal_lahir" type="date" required />
                                    <NotificationBar color="warning" v-if="errors.tanggal_lahir" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.tanggal_lahir }} <template #right>

                                        </template>
                                    </NotificationBar>

                                </FormField>

                                <FormField label="jenis_kelamin">
                                    <FormControl v-model="form.dataPribadi.jenis_kelamin" :options="selectOptionsKelamin" />
                                    <NotificationBar color="warning" v-if="errors.jenis_kelamin" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.jenis_kelamin }} <template #right>

                                        </template>
                                    </NotificationBar>

                                </FormField>

                                <FormField label="Agama">
                                    <FormControl v-model="form.dataPribadi.agama" placeholder="Agama" required />
                                    <NotificationBar color="warning" v-if="errors.agama" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.agama }} <template #right>

                                        </template>
                                    </NotificationBar>

                                </FormField>

                                <FormField label="Instagram">
                                    <FormControl v-model="form.dataPribadi.ig" placeholder="Instagram" />
                                    <NotificationBar color="warning" v-if="errors.ig" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.ig }} <template #right>

                                        </template>
                                    </NotificationBar>

                                </FormField>

                                <FormField label="Facebook">
                                    <FormControl v-model="form.dataPribadi.facebook" placeholder="Facebook" />
                                    <NotificationBar color="warning" v-if="errors.facebook" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.facebook }} <template #right>

                                        </template>
                                    </NotificationBar>

                                </FormField>

                                <FormField label="No telepon aktif">
                                    <FormControl v-model="form.dataPribadi.no_hp" type="number"
                                        placeholder="No telepon aktif" required />
                                    <NotificationBar color="warning" v-if="errors.no_hp" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.no_hp }} <template #right>

                                        </template>
                                    </NotificationBar>

                                </FormField>
                            </div>
                            <div>
                                <!-- Repeat similar code for other fields -->
                                <div class="w-11/12 mx-auto mt-8">

                                    <NotificationBarInCard :color="getFormStatusColor"
                                        :is-placed-with-header="formStatusWithHeader">
                                        <span>
                                            {{ form.recentlySuccessful ? " Berhasil menambahkan" : "data Alamat" }}</span>
                                    </NotificationBarInCard>
                                </div>
                                <FormField label="Alamat">
                                    <FormControl v-model="form.alamat.alamat" type="text" placeholder="Alamat" required />
                                    <NotificationBar color="warning" v-if="errors.alamat" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.alamat }} <template #right>

                                        </template>
                                    </NotificationBar>

                                </FormField>

                                <FormField label="Kelurahan">
                                    <FormControl v-model="form.alamat.kelurahan" type="text" placeholder="Kelurahan"
                                        required />
                                    <NotificationBar color="warning" v-if="errors.kelurahan" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.kelurahan }} <template #right>

                                        </template>
                                    </NotificationBar>

                                </FormField>

                                <FormField label="Kecamatan">
                                    <FormControl v-model="form.alamat.kecamatan" type="text" placeholder="Kecamatan"
                                        required />
                                    <NotificationBar color="warning" v-if="errors.kecamatan" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.kecamatan }} <template #right>

                                        </template>
                                    </NotificationBar>

                                </FormField>

                                <FormField label="Kabupaten">
                                    <FormControl v-model="form.alamat.kabupaten" type="text" placeholder="Kabupaten"
                                        required />
                                    <NotificationBar color="warning" v-if="errors.kabupaten" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.kabupaten }} <template #right>

                                        </template>
                                    </NotificationBar>

                                </FormField>

                                <FormField label="Provinsi">
                                    <FormControl v-model="form.alamat.provinsi" type="text" placeholder="Provinsi"
                                        required />
                                    <NotificationBar color="warning" v-if="errors.provinsi" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.provinsi }} <template #right>

                                        </template>
                                    </NotificationBar>

                                </FormField>

                                <FormField label="Kode pos">
                                    <FormControl v-model="form.alamat.kodepos" type="text" placeholder="Kode pos"
                                        required />
                                    <NotificationBar color="warning" v-if="errors.kodepos" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.kodepos }} <template #right>

                                        </template>
                                    </NotificationBar>

                                </FormField>

                            </div>
                            <div>

                                <!-- Repeat similar code for other fields -->

                                <div class="w-11/12 mx-auto mt-8">

                                    <NotificationBarInCard :color="getFormStatusColor"
                                        :is-placed-with-header="formStatusWithHeader">
                                        <span>
                                            {{ form.recentlySuccessful ? " Berhasil menambahkan" : "data sekolah" }}</span>
                                    </NotificationBarInCard>
                                </div>
                                <FormField label="Nama Sekolah">
                                    <FormControl v-model="form.sekolah.nama_sekolah" type="text" placeholder="nama sekolah"
                                        required />
                                    <NotificationBar color="warning" v-if="errors.nama_sekolah" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.nama_sekolah }} <template #right>

                                        </template>
                                    </NotificationBar>

                                </FormField>

                                <FormField label="Alamat sekolah">
                                    <FormControl v-model="form.sekolah.alamat_sekolah" type="text"
                                        placeholder="alamat sekolah" required />
                                    <NotificationBar color="warning" v-if="errors.alamat_sekolah" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.alamat_sekolah }} <template #right>

                                        </template>
                                    </NotificationBar>

                                </FormField>

                                <FormField label="Tahun lulus">
                                    <FormControl v-model="form.sekolah.tahun_lulus" type="text" placeholder="Tahun lulus"
                                        required />
                                    <NotificationBar color="warning" v-if="errors.tahun_lulus" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.tahun_lulus }} <template #right>

                                        </template>
                                    </NotificationBar>

                                </FormField>

                                <FormField label="Jurusan">
                                    <FormControl v-model="form.sekolah.jurusan" type="text" placeholder="jurusan"
                                        required />
                                    <NotificationBar color="warning" v-if="errors.jurusan" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.jurusan }} <template #right>

                                        </template>
                                    </NotificationBar>

                                </FormField>

                                <!-- <FormField label="SKHUN (Sertifikat Hasil Ujian Nasional)">
            <FormControl v-model="form.sekolah.nilai_skhun" type="text" placeholder="nilai_skhun" required />
            <NotificationBar color="warning" v-if="errors" :icon="mdiAlert" :outline="notificationsOutline">
                <b>Warning</b>.{{ errors.nilai_skhun }}    <template #right>
                    
                </template>
            </NotificationBar>
            
        </FormField> -->

                                <FormField label="Nilai SKHUN (sertifkat hasil ujian nasional) ">
                                    <FormControl v-model="form.sekolah.nilai_skhun" type="text" placeholder="nilai_skhun"
                                        required />
                                    <NotificationBar color="warning" v-if="errors.nilai_skhun" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.nilai_skhun }} <template #right>

                                        </template>
                                    </NotificationBar>

                                </FormField>
                                <div class="flex gap-4 ">

                                    <FormField label="SKHUN" class=" justify-center ">

                                        <div class="">
                                            <FormFilePicker accept=".jpg,.jpeg,.png" @change="handleFileChangeSKHUN"
                                                @input="form.sekolah.skhun = $event.target.files[0]" label="Upload"
                                                class="w-full" />
                                            <progress v-if="form.sekolah.progress" :value="form.sekolah.progress.percentage"
                                                max="100">
                                                {{ form.sekolah.progress.percentage }}%
                                            </progress>
                                            <NotificationBar color="warning" v-if="errors.skhun" :icon="mdiAlert"
                                                :outline="notificationsOutline">
                                                <b>Warning</b>.{{ errors.skhun }} <template #right>

                                                </template>
                                            </NotificationBar>

                                        </div>
                                        <div v-if="previewImageSKHUN">
                                            <img width="100" height="100" :src="previewImageSKHUN" alt="Preview foto" />
                                        </div>
                                        <div v-else>
                                        </div>

                                    </FormField>

                                    <FormField label="Ijazah" class=" justify-center ">

                                        <div class="">
                                            <FormFilePicker accept=".jpg,.jpeg,.png" @change="handleFileChangeIjazah"
                                                @input="form.sekolah.ijazah = $event.target.files[0]" label="Upload"
                                                class="w-full" />
                                            <progress v-if="form.sekolah.progress" :value="form.sekolah.progress.percentage"
                                                max="100">
                                                {{ form.sekolah.progress.percentage }}%
                                            </progress>
                                            <NotificationBar color="warning" v-if="errors.ijazah" :icon="mdiAlert"
                                                :outline="notificationsOutline">
                                                <b>Warning</b>.{{ errors.ijazah }} <template #right>

                                                </template>
                                            </NotificationBar>

                                        </div>
                                        <div v-if="previewImageIjazah">
                                            <img width="100" height="100" :src="previewImageIjazah" alt="Preview foto" />
                                        </div>
                                        <div v-else>
                                        </div>

                                    </FormField>
                                </div>


                            </div>
                            <div>

                                <!-- Repeat similar code for other fields -->

                                <div class="w-11/12 mx-auto mt-8">

                                    <NotificationBarInCard :color="getFormStatusColor"
                                        :is-placed-with-header="formStatusWithHeader">
                                        <span>
                                            {{ form.recentlySuccessful ? " Berhasil menambahkan" : "data orangtua / wali(ayah)"
                                            }}</span>
                                    </NotificationBarInCard>
                                </div>
                                <FormField label="Nama Ayah">
                                    <FormControl v-model="form.orangtua.nama_ayah" type="text" placeholder="Nama Ayah"
                                        required />
                                    <NotificationBar color="warning" v-if="errors.nama_ayah" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.nama_ayah }} <template #right>

                                        </template>
                                    </NotificationBar>

                                </FormField>

                                <FormField label="KTP Ayah">
                                    <FormControl v-model="form.orangtua.ktp_ayah" type="text" placeholder="KTP Ayah"
                                        required />
                                    <NotificationBar color="warning" v-if="errors.ktp_ayah" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.ktp_ayah }} <template #right>

                                        </template>
                                    </NotificationBar>

                                </FormField>

                                <FormField label="Tempat Lahir Ayah">
                                    <FormControl v-model="form.orangtua.tempat_lahir_ayah" type="text"
                                        placeholder="Tempat Lahir Ayah" required />
                                    <NotificationBar color="warning" v-if="errors.tempat_lahir_ayah" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.tempat_lahir_ayah }} <template #right>

                                        </template>
                                    </NotificationBar>

                                </FormField>

                                <FormField label="Tanggal Lahir Ayah">
                                    <FormControl v-model="form.orangtua.tanggal_lahir_ayah" type="date"
                                        placeholder="Tanggal Lahir Ayah" required />
                                    <NotificationBar color="warning" v-if="errors.tanggal_lahir_ayah" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.tanggal_lahir_ayah }} <template #right>

                                        </template>
                                    </NotificationBar>

                                </FormField>

                                <FormField label="No. HP Ayah">
                                    <FormControl v-model="form.orangtua.no_hp_ayah" type="tel" placeholder="No. HP Ayah"
                                        required />
                                    <NotificationBar color="warning" v-if="errors.no_hp_ayah" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.no_hp_ayah }} <template #right>

                                        </template>
                                    </NotificationBar>

                                </FormField>

                                <FormField label="Pekerjaan ayah">
                                    <FormControl v-model="pilihan_pekerjaan_ayah" :options="selectOptionsPekerjaan"
                                        required />
                                    <NotificationBar color="warning" v-if="errors.pekerjaan_ayah" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.pekerjaan_ayah }} <template #right>

                                        </template>
                                    </NotificationBar>


                                </FormField>

                                <FormField v-if="pilihan_pekerjaan_ayah == 'lainnya'" label="Pekerjaan ayah">
                                    <FormControl v-model="form.orangtua.pekerjaan_ayah" type="text"
                                        placeholder="Pekerjaan ayah" required />
                                    <NotificationBar color="warning" v-if="errors.pekerjaan_ayah" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.pekerjaan_ayah }} <template #right>

                                        </template>
                                    </NotificationBar>

                                </FormField>


                                <FormField label="Penghasilan Ayah">
                                    <FormControl v-model="form.orangtua.penghasilan_ayah"
                                        :options="selectOptionsPenghasilan" required />
                                    <NotificationBar color="warning" v-if="errors.penghasilan_ayah" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.penghasilan_ayah }} <template #right>

                                        </template>
                                    </NotificationBar>

                                </FormField>
                                <!-- 
        <FormField label="Penghasilan Ayah">
            <FormControl v-model="form.orangtua.penghasilan_ayah" type="number"
                placeholder="Penghasilan Ayah" required />
            <NotificationBar color="warning" v-if="errors" :icon="mdiAlert" :outline="notificationsOutline">
                <b>Warning</b>.{{ errors.penghasilan_ayah }}    <template #right>
                    
                </template>
            </NotificationBar>
            
        </FormField> -->



                            </div>
                            <div>

                                <!-- Repeat similar code for other fields -->

                                <div class="w-11/12 mx-auto mt-8">

                                    <NotificationBarInCard :color="getFormStatusColor"
                                        :is-placed-with-header="formStatusWithHeader">
                                        <span>
                                            {{ form.recentlySuccessful ? " Berhasil menambahkan" : "data orangtua / wali(ibu)"
                                            }}</span>
                                    </NotificationBarInCard>
                                </div>

                                <FormField label="Nama Ibu">
                                    <FormControl v-model="form.orangtua.nama_ibu" type="text" placeholder="Nama Ibu"
                                        required />
                                    <NotificationBar color="warning" v-if="errors.nama_ibu" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.nama_ibu }} <template #right>

                                        </template>
                                    </NotificationBar>

                                </FormField>

                                <FormField label="KTP Ibu">
                                    <FormControl v-model="form.orangtua.ktp_ibu" type="text" placeholder="KTP Ibu"
                                        required />
                                    <NotificationBar color="warning" v-if="errors.ktp_ibu" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.ktp_ibu }} <template #right>

                                        </template>
                                    </NotificationBar>

                                </FormField>

                                <FormField label="Tempat Lahir Ibu">
                                    <FormControl v-model="form.orangtua.tempat_lahir_ibu" type="text"
                                        placeholder="Tempat Lahir Ibu" required />
                                    <NotificationBar color="warning" v-if="errors.tempat_lahir_ibu" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.tempat_lahir_ibu }} <template #right>

                                        </template>
                                    </NotificationBar>

                                </FormField>

                                <FormField label="Tanggal Lahir Ibu">
                                    <FormControl v-model="form.orangtua.tanggal_lahir_ibu" type="date"
                                        placeholder="Tanggal Lahir Ibu" required />
                                    <NotificationBar color="warning" v-if="errors.tanggal_lahir_ibu" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.tanggal_lahir_ibu }} <template #right>

                                        </template>
                                    </NotificationBar>

                                </FormField>

                                <FormField label="No. HP Ibu">
                                    <FormControl v-model="form.orangtua.no_hp_ibu" type="tel" placeholder="No. HP Ibu"
                                        required />
                                    <NotificationBar color="warning" v-if="errors.no_hp_ibu" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.no_hp_ibu }} <template #right>

                                        </template>
                                    </NotificationBar>

                                </FormField>


                                <FormField label="Pekerjaan Ibu">
                                    <FormControl v-model="pilihan_pekerjaan_ibu" :options="selectOptionsPekerjaan"
                                        required />
                                    <NotificationBar color="warning" v-if="errors.pekerjaan_ibu" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.pekerjaan_ibu }} <template #right>

                                        </template>
                                    </NotificationBar>

                                </FormField>

                                <FormField v-if="pilihan_pekerjaan_ibu == 'lainnya'" label="Pekerjaan Ibu">
                                    <FormControl v-model="form.orangtua.pekerjaan_ibu" type="text"
                                        placeholder="Pekerjaan Ibu" required />
                                    <NotificationBar color="warning" v-if="errors.pekerjaan_ibu" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.pekerjaan_ibu }} <template #right>

                                        </template>
                                    </NotificationBar>

                                </FormField>


                                <FormField label="Penghasilan Ibu">
                                    <FormControl v-model="form.orangtua.penghasilan_ibu" :options="selectOptionsPenghasilan"
                                        required />

                                    <NotificationBar color="warning" v-if="errors.penghasilan_ibu" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.penghasilan_ibu }}
                                        <template #right>

                                        </template>
                                    </NotificationBar>

                                </FormField>




                            </div>

                            <div v-if="user.data_daftar.status == 'Pindahan'">

                                <!-- Repeat similar code for other fields -->

                                <div class="w-11/12 mx-auto mt-8">

                                    <NotificationBarInCard :color="getFormStatusColor"
                                        :is-placed-with-header="formStatusWithHeader">
                                        <span>
                                            {{ form.recentlySuccessful ? " Berhasil menambahkan" : "Data Pindahan Perguruan Tinggi"
                                            }}</span>
                                    </NotificationBarInCard>
                                </div>

                                <FormField label="Perguruan tinggi ">
                                    <FormControl v-model="form.pindahan.perguruan_tinggi" type="text"
                                        placeholder="Perguruan tinggi" required />
                                    <NotificationBar color="warning" v-if="errors.perguruan_tinggi" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.perguruan_tinggi }} <template #right>

                                        </template>
                                    </NotificationBar>

                                </FormField>

                                <FormField label="Program Studi ">
                                    <FormControl v-model="form.pindahan.program_studi" type="text"
                                        placeholder="program studi" required />
                                    <NotificationBar color="warning" v-if="errors.program_studi" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.program_studi }} <template #right>

                                        </template>
                                    </NotificationBar>

                                </FormField>

                                <FormField label="Nomor Induk Siswa (NIM)">
                                    <FormControl v-model="form.pindahan.nomor_induk_mahasiswa" type="text"
                                        placeholder="nomor induk mahasiswa" required />
                                    <NotificationBar color="warning" v-if="errors.nomor_induk_mahasiswa" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.nomor_induk_mahasiswa }} <template #right>

                                        </template>
                                    </NotificationBar>

                                </FormField>


                            </div>



                            <div v-if="user.data_daftar.jalur == 'Jalur ranking'">

                                <!-- Repeat similar code for other fields -->

                                <div class="w-11/12 mx-auto mt-8">

                                    <NotificationBarInCard :color="getFormStatusColor"
                                        :is-placed-with-header="formStatusWithHeader">
                                        <span>
                                            {{ form.recentlySuccessful ? " Berhasil menambahkan" : "Data Ranking"
                                            }}</span>

                                    </NotificationBarInCard>
                                </div>
                                <FormField label="Foto Surat Keterangan Ranking" class=" justify-center ">
                                    <div class="">
                                        <FormFilePicker accept=".jpg,.jpeg,.png" @change="handleFileChangeRanking"
                                            @input="form.tambahan.foto_bukti = $event.target.files[0]" label="Upload"
                                            class="w-full" />
                                        <progress v-if="form.tambahan.progress" :value="form.tambahan.progress.percentage"
                                            max="100">
                                            {{ form.tambahan.progress.percentage }}%
                                        </progress>
                                        <NotificationBar color="warning" v-if="errors.foto_bukti" :icon="mdiAlert"
                                            :outline="notificationsOutline">
                                            <b>Warning</b>.{{ errors.foto_bukti }} <template #right>

                                            </template>
                                        </NotificationBar>

                                    </div>
                                    <div v-if="previewImageRanking">
                                        <img width="100" height="100" :src="previewImageRanking" alt="Preview foto" />
                                    </div>
                                    <div v-else>
                                    </div>

                                </FormField>


                                <FormField label="PDF Surat Keterangan" label2="*"
                                    label3="jika surat lebih dari satu buat semua surat keterangan menjadi satu file PDF"
                                    class=" justify-center ">
                                    <div class="">
                                        <FormFilePicker accept=".pdf" @input="form.tambahan.pdf = $event.target.files[0]"
                                            label="Upload" class="w-full" />
                                        <progress v-if="form.tambahan.progress" :value="form.tambahan.progress.percentage"
                                            max="100">
                                            {{ form.tambahan.progress.percentage }}%
                                        </progress>
                                        <NotificationBar color="warning" v-if="errors.pdf" :icon="mdiAlert"
                                            :outline="notificationsOutline">
                                            <b>Warning</b>.{{ errors.pdf }} <template #right>

                                            </template>
                                        </NotificationBar>

                                    </div>

                                </FormField>

                                <FormField label="keterangan ranking ">
                                    <FormControl v-model="form.tambahan.isi_data" type="text" placeholder="Keterangan"
                                        required />
                                    <NotificationBar color="warning" v-if="errors.tambahan" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.tambahan }} <template #right>

                                        </template>
                                    </NotificationBar>

                                </FormField>



                            </div>



                            <div v-if="user.data_daftar.jalur == 'Prestasi non akademik'">

                                <!-- Repeat similar code for other fields -->

                                <div class="w-11/12 mx-auto mt-8">

                                    <NotificationBarInCard :color="getFormStatusColor"
                                        :is-placed-with-header="formStatusWithHeader">
                                        <span>
                                            {{ form.recentlySuccessful ? " Berhasil menambahkan" : "Data Prestasi non Akademik"}}</span>
                                    </NotificationBarInCard>
                                </div>
                                <FormField label="Foto Surat Keterangan Prestasi non Akademik" class=" justify-center ">
                                    <div class="">
                                        <FormFilePicker accept=".jpg,.jpeg,.png" @change="handleFileChangeRanking"
                                            @input="form.tambahan.foto_bukti = $event.target.files[0]" label="Upload"
                                            class="w-full" />
                                        <progress v-if="form.tambahan.progress" :value="form.tambahan.progress.percentage"
                                            max="100">
                                            {{ form.tambahan.progress.percentage }}%
                                        </progress>
                                        <NotificationBar color="warning" v-if="errors.foto_bukti" :icon="mdiAlert"
                                            :outline="notificationsOutline">
                                            <b>Warning</b>.{{ errors.foto_bukti }} <template #right>

                                            </template>
                                        </NotificationBar>

                                    </div>
                                    <div v-if="previewImageRanking">
                                        <img width="100" height="100" :src="previewImageRanking" alt="Preview foto" />
                                    </div>
                                    <div v-else>
                                    </div>

                                </FormField>


                                <FormField label="PDF Surat Keterangan Prestasi non Akademik" label2="*"
                                    label3="jika surat lebih dari satu buat semua surat keterangan menjadi satu file PDF"
                                    class=" justify-center ">
                                    <div class="">
                                        <FormFilePicker accept=".pdf" @input="form.tambahan.pdf = $event.target.files[0]"
                                            label="Upload" class="w-full" />
                                        <progress v-if="form.tambahan.progress" :value="form.tambahan.progress.percentage"
                                            max="100">
                                            {{ form.tambahan.progress.percentage }}%
                                        </progress>
                                        <NotificationBar color="warning" v-if="errors.pdf" :icon="mdiAlert"
                                            :outline="notificationsOutline">
                                            <b>Warning</b>.{{ errors.pdf }} <template #right>

                                            </template>
                                        </NotificationBar>

                                    </div>

                                </FormField>

                                <FormField label="Keterangan Prestasi non Akademik ">
                                    <FormControl v-model="form.tambahan.isi_data" type="text" placeholder="Keterangan"
                                        required />
                                    <NotificationBar color="warning" v-if="errors.tambahan" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.tambahan }} <template #right>

                                        </template>
                                    </NotificationBar>

                                </FormField>



                            </div>


                            <div v-if="user.data_daftar.jalur == 'Undangan'">

                                <!-- Repeat similar code for other fields -->

                                <div class="w-11/12 mx-auto mt-8">

                                    <NotificationBarInCard :color="getFormStatusColor"
                                        :is-placed-with-header="formStatusWithHeader">
                                        <span>
                                            {{ form.recentlySuccessful ? " Berhasil menambahkan" : "Data Tambahan Undangan"
                                            }}</span>
                                    </NotificationBarInCard>
                                </div>
                                <FormField label="Foto Bukti Keterangan Undangan " class=" justify-center ">
                                    <div class="">
                                        <FormFilePicker accept=".jpg,.jpeg,.png" @change="handleFileChangeRanking"
                                            @input="form.tambahan.foto_bukti = $event.target.files[0]" label="Upload"
                                            class="w-full" />
                                        <progress v-if="form.tambahan.progress" :value="form.tambahan.progress.percentage"
                                            max="100">
                                            {{ form.tambahan.progress.percentage }}%
                                        </progress>
                                        <NotificationBar color="warning" v-if="errors.foto_bukti" :icon="mdiAlert"
                                            :outline="notificationsOutline">
                                            <b>Warning</b>.{{ errors.foto_bukti }} <template #right>

                                            </template>
                                        </NotificationBar>

                                    </div>
                                    <div v-if="previewImageRanking">
                                        <img width="100" height="100" :src="previewImageRanking" alt="Preview foto" />
                                    </div>
                                    <div v-else>
                                    </div>

                                </FormField>


                                <FormField label="keterangan ">
                                    <FormControl v-model="form.tambahan.isi_data" type="text" placeholder="Keterangan"
                                        required />
                                    <NotificationBar color="warning" v-if="errors.tambahan" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.tambahan }} <template #right>

                                        </template>
                                    </NotificationBar>

                                </FormField>

                            </div>

                            <div v-if="user.data_daftar.shift == 'Hybrid'">

                                <!-- Repeat similar code for other fields -->

                                <div class="w-11/12 mx-auto mt-8">

                                    <NotificationBarInCard :color="getFormStatusColor"
                                        :is-placed-with-header="formStatusWithHeader">
                                        <span>
                                            {{ form.recentlySuccessful ? " Berhasil menambahkan" : "Data Pekerjaan"
                                            }}</span>
                                    </NotificationBarInCard>
                                </div>

                                <FormField label="Pekerjaan Anda">
                                    <FormControl v-model="pilihan_pekerjaan_anda" :options="selectOptionsPekerjaan"
                                        required />
                                    <NotificationBar color="warning" v-if="errors.nama_pekerjaan" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.nama_pekerjaan }} <template #right>

                                        </template>
                                    </NotificationBar>

                                </FormField>

                                <FormField v-if="pilihan_pekerjaan_anda == 'lainnya'" label="Pekerjaan Anda">
                                    <FormControl v-model="form.pekerjaan.nama_pekerjaan" type="text"
                                        placeholder="Masukkan Pekerjaan Anda" required />
                                    <NotificationBar color="warning" v-if="errors.nama_pekerjaan" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.nama_pekerjaan }} <template #right>

                                        </template>
                                    </NotificationBar>

                                </FormField>

                                <FormField label="Instansi Pekerjaan Anda">
                                    <FormControl v-model="form.pekerjaan.nama_instansi" type="text"
                                        placeholder="Masukkan Instansi Pekerjaan Anda" required />
                                    <NotificationBar color="warning" v-if="errors.nama_instansi" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.nama_instansi }} <template #right>

                                        </template>
                                    </NotificationBar>

                                </FormField>
                            </div>

                            <div >

                                <!-- Repeat similar code for other fields -->

                                <div class="w-11/12 mx-auto mt-8">

                                    <NotificationBarInCard :color="getFormStatusColor"
                                        :is-placed-with-header="formStatusWithHeader">
                                        <span>
                                            {{ form.recentlySuccessful ? " Berhasil menambahkan" : "Data Survey"
                                            }}</span>
                                    </NotificationBarInCard>
                                </div>
                             

                                <FormField label="Darimana Anda Memperoleh Informasi Mengenai Penerimaan Mahasiswa Baru FISIP - UNIGA ? ">
                                    <FormControl v-model="form.tambahan.survey" type="select" :options="selectOptionsSurvey" placeholder="Keterangan"
                                        required />
                                    <NotificationBar color="warning" v-if="errors.tambahan" :icon="mdiAlert"
                                        :outline="notificationsOutline">
                                        <b>Warning</b>.{{ errors.tambahan }} <template #right>

                                        </template>
                                    </NotificationBar>

                                </FormField>

                            </div>




                        </div>





                        <!-- Repeat similar code for other fields -->

                        <template #footer>
                            <BaseButton label="Kirim" type="submit" color="info" />
                        </template>
                    </CardBox>
                </div>
            </div>



            <!-- <CardBox class="md:w-7/12 lg:w-5/12 xl:w-4/12 shadow-2xl md:mx-auto" is-form is-hoverable  -->

    </SectionMain>
</LayoutAuthenticatedUser></template>
<style>@import "datatables.net-dt";</style>
