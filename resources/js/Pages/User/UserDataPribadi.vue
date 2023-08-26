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

// Impor library DataTables
DataTable.use(DataTablesLib);

// Mendefinisikan properti untuk komponen
var props = defineProps(["game", "user", "errors"]);

const selectOptionsKelamin = ["Laki - Laki", "Perempuan"];
const selectOptionsPekerjaan = ["PNS", "TNI / Polri", "BUMN / BUMD ", "Wiraswasta", "lainnya"];

var pilihan_pekerjaan_ibu = ref();
var pilihan_pekerjaan_ayah = ref();

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
console.log();
</script>

<template>
    <AppHead :title="'Data Pribadi'" />
    <LayoutAuthenticatedUser>

        <SectionMain>
            <SectionTitle>masukkan data</SectionTitle>



            <CardBox class=" shadow-2xl md:mx-auto mx-auto h-full " is-form is-hoverable @submit.prevent="formSubmit">

                <div className="grid md:grid-cols-2  gap-8">
                    <div class="row-span-2">
                        <div class="w-11/12 mx-auto mt-8">

                            <NotificationBarInCard :color="getFormStatusColor"
                                :is-placed-with-header="formStatusWithHeader">
                                <span>
                                    {{ form.recentlySuccessful ? " Berhasil menambahkan" : "data pribadi" }}</span>
                            </NotificationBarInCard>
                        </div>
                        <FormField label="Foto">
                            <div class="grid grid-cols-3 gap-4">
                                <div v-if="previewImage">


                                    <img :src="previewImage" alt="Preview foto" />
                                </div>
                                <div v-else>
                                    <img class="shrink"
                                        :src="'https://media.istockphoto.com/vectors/default-profile-picture-foto-photo-placeholder-vector-illustration-vector-id1223671392?k=6&m=1223671392&s=170667a&w=0&h=zP3l7WJinOFaGb2i1F4g8IS2ylw0FlIaa6x3tP9sebU='"
                                        alt="" />
                                </div>
                                <div class="grid grid-row-2 gap-4 col-span-2 ">
                                    <div class=" text-2xl">{{ user.name[0].toUpperCase() + user.name.slice(1) }}</div>
                                    <FormFilePicker accept=".jpg,.jpeg,.png" @change="handleFileChange"
                                        @input="form.dataPribadi.foto = $event.target.files[0]" label="Upload"
                                        class="w-full" />

                                    <!-- <input type="file" @input="form.dataPribadi.foto = $event.target.files[0]" /> -->
                                    <progress v-if="form.dataPribadi.progress" :value="form.dataPribadi.progress.percentage"
                                        max="100">
                                        {{ form.dataPribadi.progress.percentage }}%
                                    </progress>
                                    <p>{{ errors.foto }}</p>
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
                            <p>{{ errors.no_ktp }}</p>
                        </FormField>

                        <FormField label="NISN (Nomor Induk Siswa Nasional)">
                            <FormControl v-model="form.dataPribadi.nisn" type="number" placeholder="NISN" required />
                            <p>{{ errors.nisn }}</p>
                        </FormField>

                        <FormField label="Tempat Lahir">
                            <FormControl v-model="form.dataPribadi.tempat_lahir" placeholder="Tempat Lahir" required />
                            <p>{{ errors.tempat_lahir }}</p>
                        </FormField>

                        <FormField label="Tanggal Lahir">
                            <FormControl v-model="form.dataPribadi.tanggal_lahir" type="date" required />
                            <p>{{ errors.tanggal_lahir }}</p>
                        </FormField>

                        <FormField label="jenis_kelamin">
                            <FormControl v-model="form.dataPribadi.jenis_kelamin" :options="selectOptionsKelamin" />
                            <p>{{ errors.jenis_kelamin }}</p>
                        </FormField>

                        <FormField label="Agama">
                            <FormControl v-model="form.dataPribadi.agama" placeholder="Agama" required />
                            <p>{{ errors.agama }}</p>
                        </FormField>

                        <FormField label="Instagram">
                            <FormControl v-model="form.dataPribadi.ig" placeholder="Instagram" />
                            <p>{{ errors.ig }}</p>
                        </FormField>

                        <FormField label="Facebook">
                            <FormControl v-model="form.dataPribadi.facebook" placeholder="Facebook" />
                            <p>{{ errors.facebook }}</p>
                        </FormField>

                        <FormField label="No telepon aktif">
                            <FormControl v-model="form.dataPribadi.no_hp" type="number" placeholder="No telepon aktif"
                                required />
                            <p>{{ errors.no_hp }}</p>
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
                            <p>{{ errors.alamat }}</p>
                        </FormField>

                        <FormField label="Kelurahan">
                            <FormControl v-model="form.alamat.kelurahan" type="text" placeholder="Kelurahan" required />
                            <p>{{ errors.kelurahan }}</p>
                        </FormField>

                        <FormField label="Kecamatan">
                            <FormControl v-model="form.alamat.kecamatan" type="text" placeholder="Kecamatan" required />
                            <p>{{ errors.kecamatan }}</p>
                        </FormField>

                        <FormField label="Kabupaten">
                            <FormControl v-model="form.alamat.kabupaten" type="text" placeholder="Kabupaten" required />
                            <p>{{ errors.kabupaten }}</p>
                        </FormField>

                        <FormField label="Provinsi">
                            <FormControl v-model="form.alamat.provinsi" type="text" placeholder="Provinsi" required />
                            <p>{{ errors.provinsi }}</p>
                        </FormField>

                        <FormField label="Kode pos">
                            <FormControl v-model="form.alamat.kodepos" type="text" placeholder="Kode pos" required />
                            <p>{{ errors.kodepos }}</p>
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
                            <p>{{ errors.nama_sekolah }}</p>
                        </FormField>

                        <FormField label="Alamat sekolah">
                            <FormControl v-model="form.sekolah.alamat_sekolah" type="text" placeholder="alamat sekolah"
                                required />
                            <p>{{ errors.alamat_sekolah }}</p>
                        </FormField>

                        <FormField label="Tahun lulus">
                            <FormControl v-model="form.sekolah.tahun_lulus" type="text" placeholder="Tahun lulus"
                                required />
                            <p>{{ errors.tahun_lulus }}</p>
                        </FormField>

                        <FormField label="Jurusan">
                            <FormControl v-model="form.sekolah.jurusan" type="text" placeholder="jurusan" required />
                            <p>{{ errors.jurusan }}</p>
                        </FormField>

                        <!-- <FormField label="SKHUN (Sertifikat Hasil Ujian Nasional)">
                            <FormControl v-model="form.sekolah.nilai_skhun" type="text" placeholder="nilai_skhun" required />
                            <p>{{ errors.nilai_skhun }}</p>
                        </FormField> -->

                        <FormField label="Nilai SKHUN (sertifkat hasil ujian nasional) ">
                            <FormControl v-model="form.sekolah.nilai_skhun" type="text" placeholder="nilai_skhun"
                                required />
                            <p>{{ errors.nilai_skhun }}</p>
                        </FormField>
                        <div class="flex gap-4 " >

                        <FormField label="SKHUN" class=" justify-center ">

                            <div class="">
                                <FormFilePicker accept=".jpg,.jpeg,.png" @change="handleFileChangeSKHUN"
                                    @input="form.sekolah.skhun = $event.target.files[0]" label="Upload"
                                    class="w-full" />
                                <progress v-if="form.sekolah.progress" :value="form.sekolah.progress.percentage" max="100">
                                    {{ form.sekolah.progress.percentage }}%
                                </progress>
                                <p>{{ errors.foto }}</p>
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
                                <progress v-if="form.sekolah.progress" :value="form.sekolah.progress.percentage" max="100">
                                    {{ form.sekolah.progress.percentage }}%
                                </progress>
                                <p>{{ errors.foto }}</p>
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
                                    {{ form.recentlySuccessful ? " Berhasil menambahkan" : "data orangtua / wali (ayah)"
                                    }}</span>
                            </NotificationBarInCard>
                        </div>
                        <FormField label="Nama Ayah">
                            <FormControl v-model="form.orangtua.nama_ayah" type="text" placeholder="Nama Ayah" required />
                            <p>{{ errors.nama_ayah }}</p>
                        </FormField>

                        <FormField label="KTP Ayah">
                            <FormControl v-model="form.orangtua.ktp_ayah" type="text" placeholder="KTP Ayah" required />
                            <p>{{ errors.ktp_ayah }}</p>
                        </FormField>

                        <FormField label="Tempat Lahir Ayah">
                            <FormControl v-model="form.orangtua.tempat_lahir_ayah" type="text"
                                placeholder="Tempat Lahir Ayah" required />
                            <p>{{ errors.tempat_lahir_ayah }}</p>
                        </FormField>

                        <FormField label="Tanggal Lahir Ayah">
                            <FormControl v-model="form.orangtua.tanggal_lahir_ayah" type="date"
                                placeholder="Tanggal Lahir Ayah" required />
                            <p>{{ errors.tanggal_lahir_ayah }}</p>
                        </FormField>

                        <FormField label="No. HP Ayah">
                            <FormControl v-model="form.orangtua.no_hp_ayah" type="tel" placeholder="No. HP Ayah" required />
                            <p>{{ errors.no_hp_ayah }}</p>
                        </FormField>

                        <FormField label="Pekerjaan ayah">
                            <FormControl v-model="pilihan_pekerjaan_ayah" :options="selectOptionsPekerjaan" required />
                        </FormField>

                        <FormField v-if="pilihan_pekerjaan_ayah == 'lainnya'" label="Pekerjaan ayah">
                            <FormControl v-model="form.orangtua.pekerjaan_ayah" type="text" placeholder="Pekerjaan ayah"
                                required />
                            <p>{{ errors.pekerjaan_ayah }}</p>
                        </FormField>

                        <FormField label="Penghasilan Ayah">
                            <FormControl v-model="form.orangtua.penghasilan_ayah" type="number"
                                placeholder="Penghasilan Ayah" required />
                            <p>{{ errors.penghasilan_ayah }}</p>
                        </FormField>



                    </div>
                    <div>

                        <!-- Repeat similar code for other fields -->

                        <div class="w-11/12 mx-auto mt-8">

                            <NotificationBarInCard :color="getFormStatusColor"
                                :is-placed-with-header="formStatusWithHeader">
                                <span>
                                    {{ form.recentlySuccessful ? " Berhasil menambahkan" : "data orangtua / wali (ibu)"
                                    }}</span>
                            </NotificationBarInCard>
                        </div>

                        <FormField label="Nama Ibu">
                            <FormControl v-model="form.orangtua.nama_ibu" type="text" placeholder="Nama Ibu" required />
                            <p>{{ errors.nama_ibu }}</p>
                        </FormField>

                        <FormField label="KTP Ibu">
                            <FormControl v-model="form.orangtua.ktp_ibu" type="text" placeholder="KTP Ibu" required />
                            <p>{{ errors.ktp_ibu }}</p>
                        </FormField>

                        <FormField label="Tempat Lahir Ibu">
                            <FormControl v-model="form.orangtua.tempat_lahir_ibu" type="text" placeholder="Tempat Lahir Ibu"
                                required />
                            <p>{{ errors.tempat_lahir_ibu }}</p>
                        </FormField>

                        <FormField label="Tanggal Lahir Ibu">
                            <FormControl v-model="form.orangtua.tanggal_lahir_ibu" type="date"
                                placeholder="Tanggal Lahir Ibu" required />
                            <p>{{ errors.tanggal_lahir_ibu }}</p>
                        </FormField>

                        <FormField label="No. HP Ibu">
                            <FormControl v-model="form.orangtua.no_hp_ibu" type="tel" placeholder="No. HP Ibu" required />
                            <p>{{ errors.no_hp_ibu }}</p>
                        </FormField>


                        <FormField label="Pekerjaan Ibu">
                            <FormControl v-model="pilihan_pekerjaan_ibu" :options="selectOptionsPekerjaan" required />
                        </FormField>

                        <FormField v-if="pilihan_pekerjaan_ibu == 'lainnya'" label="Pekerjaan Ibu">
                            <FormControl v-model="form.orangtua.pekerjaan_ibu" type="text" placeholder="Pekerjaan Ibu"
                                required />
                            <p>{{ errors.pekerjaan_ibu }}</p>
                        </FormField>



                        <FormField label="Penghasilan Ibu">
                            <FormControl v-model="form.orangtua.penghasilan_ibu" type="number" placeholder="Penghasilan Ibu"
                                required />
                            <p>{{ errors.penghasilan_ibu }}</p>
                        </FormField>



                    </div>
                    <div>11</div>
                </div>





                <!-- Repeat similar code for other fields -->

                <template #footer>
                    <BaseButton label="Trigger" type="submit" color="info" />
                </template>
            </CardBox>

            <!-- <CardBox class="md:w-7/12 lg:w-5/12 xl:w-4/12 shadow-2xl md:mx-auto" is-form is-hoverable  -->

        </SectionMain>
    </LayoutAuthenticatedUser>
</template>
<style>@import "datatables.net-dt";</style>
