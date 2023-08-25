<script setup>
import { ref, computed, onMounted } from "vue";
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


// Impor library DataTables
DataTable.use(DataTablesLib);

// Mendefinisikan properti untuk komponen
var props = defineProps(["game", "user", "errors"]);

const selectOptions = ["Laki - Laki",
    "Perempuan"
];



// Membuat objek form menggunakan hook useForm
const form = useForm({
    dataPribadi: {
        no_ktp: '',
        nisn: '',
        tempat_lahir: '',
        tanggal_lahir: '',
        jenis_kelamin: selectOptions[0],
        agama: '',
        ig: '',
        facebook: '',
        avatar: null,
        no_hp: '',
    },
    alamat: {
        alamat: '',
        kelurahan: '',
        kecamatan: '',
        kabupaten: '',
        provinsi: '',
        kodepos: '',

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
            $('#avatar')
                .attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

console.log();
</script>

<template>
    <AppHead :title="'Data Pribadi'" />
    <LayoutAuthenticatedUser>

        <SectionMain>
            <SectionTitle>masukkan data</SectionTitle>

            <div className="grid grid-cols-1 grid-rows-1 md:grid-cols-2 md:grid-rows-2   ">

                <div className="grid grid-cols-1 gap-1">

                    <CardBox class=" shadow-2xl md:mx-auto mx-auto w-11/12 h-full " is-form is-hoverable
                        @submit.prevent="formSubmit">
                        <NotificationBarInCard :color="getFormStatusColor" :is-placed-with-header="formStatusWithHeader">
                            <span>
                                {{ form.recentlySuccessful ? " Berhasil menambahkan" : "data pribadi" }}</span>
                        </NotificationBarInCard>
                        <FormField label="Foto">
                            <div class="grid grid-cols-3 gap-4">
                                <div v-if="previewImage">


                                    <img  :src="previewImage" alt="Preview Avatar" />
                                </div>
                                <div v-else  >
                                    <img class="shrink" :src="'https://media.istockphoto.com/vectors/default-profile-picture-avatar-photo-placeholder-vector-illustration-vector-id1223671392?k=6&m=1223671392&s=170667a&w=0&h=zP3l7WJinOFaGb2i1F4g8IS2ylw0FlIaa6x3tP9sebU='"
                                        alt="" />
                                </div>
                                <div class="grid grid-row-2 gap-4 col-span-2 ">
                                    <div class=" text-2xl">{{ user.name[0].toUpperCase() + user.name.slice(1) }}</div>
                                    <FormFilePicker accept=".jpg,.jpeg,.png" @change="handleFileChange"
                                        @input="form.dataPribadi.avatar = $event.target.files[0]" label="Upload"
                                        class="w-full" />

                                    <!-- <input type="file" @input="form.dataPribadi.avatar = $event.target.files[0]" /> -->
                                    <progress v-if="form.dataPribadi.progress" :value="form.dataPribadi.progress.percentage"
                                        max="100">
                                        {{ form.dataPribadi.progress.percentage }}%
                                    </progress>
                                    <p>{{ errors.avatar }}</p>
                                </div>
                            </div>

                        </FormField>
                    </CardBox>
                    <CardBox class=" shadow-2xl md:mx-auto mx-auto w-11/12 mt-4 " is-form is-hoverable
                        @submit.prevent="formSubmit">
                        <NotificationBarInCard :color="getFormStatusColor" :is-placed-with-header="formStatusWithHeader">
                            <span>
                                {{ form.recentlySuccessful ? " Berhasil menambahkan" : "data pribadi" }}</span>
                        </NotificationBarInCard>
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
                            <FormControl v-model="form.dataPribadi.jenis_kelamin" :options="selectOptions" />
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
                            <FormControl v-model="form.dataPribadi.no_hp" type="number" placeholder="No telepon aktif" />
                            <p>{{ errors.no_hp }}</p>
                        </FormField>



                        <!-- Repeat similar code for other fields -->
                    </CardBox>
                </div>



                <CardBox class=" shadow-2xl md:mx-auto mx-auto w-11/12 mt-4" is-form is-hoverable @submit.prevent="formSubmit">
                    <NotificationBarInCard :color="getFormStatusColor" :is-placed-with-header="formStatusWithHeader">
                        <span>
                            {{ form.recentlySuccessful ? " Berhasil menambahkan" : "data alamat" }}</span>
                    </NotificationBarInCard>
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


                    <!-- Repeat similar code for other fields -->

                    <template #footer>
                        <BaseButton label="Trigger" type="submit" color="info" />
                    </template>
                </CardBox>

                <CardBox class=" shadow-2xl md:mx-auto mx-auto w-11/12 mt-4" is-form is-hoverable @submit.prevent="formSubmit">
                    <NotificationBarInCard :color="getFormStatusColor" :is-placed-with-header="formStatusWithHeader">
                        <span>
                            {{ form.recentlySuccessful ? " Berhasil menambahkan" : "data alamat" }}</span>
                    </NotificationBarInCard>
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


                    <!-- Repeat similar code for other fields -->

                    <template #footer>
                        <BaseButton label="Trigger" type="submit" color="info" />
                    </template>
                </CardBox>
            </div>

            <!-- <CardBox class="md:w-7/12 lg:w-5/12 xl:w-4/12 shadow-2xl md:mx-auto" is-form is-hoverable  -->

        </SectionMain>
    </LayoutAuthenticatedUser>
</template>
<style>@import "datatables.net-dt";</style>
