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


// Impor library DataTables
DataTable.use(DataTablesLib);

// Mendefinisikan properti untuk komponen
var props = defineProps(["game", "user" , "errors"]);

const selectOptions = ["Laki - Laki",
     "Perempuan" 
];



// Membuat objek form menggunakan hook useForm
const form = useForm({
    no_ktp: '',
    tempat_lahir: '',
    tanggal_lahir: '',
    jenis_kelamin: selectOptions[0],
    agama: '',
    ig: '',
    facebook: '',
    avatar:null,
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


console.log();
</script>

<template>
    <AppHead :title="'Data Pribadi'" />
    <LayoutAuthenticatedUser>

        <SectionMain>
            <SectionTitle>masukkan data</SectionTitle>

            <!-- <CardBox class="md:w-7/12 lg:w-5/12 xl:w-4/12 shadow-2xl md:mx-auto" is-form is-hoverable  -->
            <CardBox class=" shadow-2xl md:mx-auto" is-form is-hoverable 
                @submit.prevent="formSubmit">
                <NotificationBarInCard :color="getFormStatusColor" :is-placed-with-header="formStatusWithHeader">
                    <span>
                        {{ form.recentlySuccessful ? " Berhasil menambahkan" : "data pribadi" }}</span>
                </NotificationBarInCard>
                <FormField label="No KTP"  >
                    <FormControl v-model="form.no_ktp" type="number" placeholder="No KTP" required />
                    <p>{{ errors.no_ktp }}</p>
                </FormField>

                <FormField label="Tempat Lahir">
                    <FormControl v-model="form.tempat_lahir" placeholder="Tempat Lahir" required />
                    <p>{{ errors.tempat_lahir }}</p>
                </FormField>

                <FormField label="Tanggal Lahir">
                    <FormControl v-model="form.tanggal_lahir" type="date" required />
                    <p>{{ errors.tanggal_lahir }}</p>
                </FormField>

                <FormField label="jenis_kelamin">
                    <FormControl v-model="form.jenis_kelamin" :options="selectOptions" />
                    <p>{{ errors.jenis_kelamin }}</p>
                </FormField>

                <FormField label="Agama">
                    <FormControl v-model="form.agama" placeholder="Agama" required />
                    <p>{{ errors.agama }}</p>
                </FormField>

                <FormField label="Instagram">
                    <FormControl v-model="form.ig" placeholder="Instagram" />
                    <p>{{ errors.ig }}</p>
                </FormField>

                <FormField label="Facebook">
                    <FormControl v-model="form.facebook" placeholder="Facebook" />
                    <p>{{ errors.facebook }}</p>
                </FormField>

                <FormField label="Foto">
                    <FormFilePicker accept=".jpg,.jpeg,.png"  @input="form.avatar = $event.target.files[0]" label="Upload" />
                    <!-- <input type="file" @input="form.avatar = $event.target.files[0]" /> -->
                    <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                    {{ form.progress.percentage }}%
                    </progress>
                    <p>{{ errors.avatar }}</p>
                </FormField>

                <!-- Repeat similar code for other fields -->

                <template #footer>
                    <BaseButton label="Trigger" type="submit" color="info" />
                </template>
            </CardBox>

        </SectionMain>
    </LayoutAuthenticatedUser>
</template>
<style>
@import "datatables.net-dt";
</style>
