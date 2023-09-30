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
import { watch } from "vue";


// Impor library DataTables
DataTable.use(DataTablesLib);

// Mendefinisikan properti untuk komponen
var props = defineProps(["shifts", "user","prodi", "errors"]);

const selectOptionsStatus = [
    "Baru",
    "Pindahan"
];
const selectOptionsShift = [
    props.shifts
];
const selectOptionsJalur = [
    ["Jalur 1",
    "Jalur 2"],
    ["Jalur A",
    "Jalur B",
    "Jalur C"]
];

const selectOptionsProgramStudi = [
    "Prodi 1",
    "Prodi 2"
];




// Membuat objek form menggunakan hook useForm
const form = useForm({
    status: null,
    shift: null,
    jalur: null,
    program_studi: null,
    
    
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
    form.post(route('user.update-data-jalur', props.user.id));
};

const getJalur = computed
(() => {
    if (form.shift) {
    return props.shifts.find((i)=>i.name==form.shift).jalur_daftars.map((i)=> i.name)}
});

watch(() => form.shift, () => {
    form.jalur = null
    console.log(form.shift);
});


console.log(selectOptionsShift,props.shifts);
</script>

<template>
    <AppHead :title="'Jalur'" />
    <LayoutAuthenticatedUser>

        <SectionMain>
            <SectionTitle class="mt-4">Edit Jalur Daftar</SectionTitle>

            <!-- <CardBox class="md:w-7/12 lg:w-5/12 xl:w-4/12 shadow-2xl md:mx-auto" is-form is-hoverable  -->
            <CardBox class=" shadow-2xl md:mx-auto md:w-7/12 lg:w-5/12 xl:w-4/12 " is-form is-hoverable @submit.prevent="formSubmit">
                <NotificationBarInCard :color="getFormStatusColor" :is-placed-with-header="formStatusWithHeader">
                    <span>
                        {{ form.recentlySuccessful ? " Berhasil menambahkan" : "data pribadi" }}</span>
                </NotificationBarInCard>

                <FormField label="Status" label2="*" label3=" pilih salah satu">
                    <FormControl v-model="form.status" :options="selectOptionsStatus" required />
                    <p class="text-red-500" >{{ errors.status }}</p>
                </FormField>

                <FormField label="Shift" label2="*" label3=" pilih salah satu">
                    <FormControl v-model="form.shift" :options="shifts.map((i)=>i.name)" />
                    <p class="text-red-500" >{{ errors.shift }}</p>
                </FormField>

                <FormField label="Jalur" label2="*" label3=" pilih salah satu">
                    <FormControl v-model="form.jalur" :options="getJalur" />
                    <p class="text-red-500" >{{ errors.jalur }}</p>
                </FormField>


                <FormField label="program studi" label2="*" label3=" pilih salah satu">
                    <FormControl v-model="form.program_studi" :options="prodi.map((i)=>i.name)" />
                    <p class="text-red-500" >{{ errors.program_studi }}</p>
                </FormField>


                <!-- Repeat similar code for other fields -->

                <template #footer>
                    <BaseButton label="Update" type="submit" color="info" />
                </template>
            </CardBox>

        </SectionMain>
    </LayoutAuthenticatedUser>
</template>
<style>
@import "datatables.net-dt";
</style>
