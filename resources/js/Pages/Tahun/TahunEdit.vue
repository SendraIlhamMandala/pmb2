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


// Impor library DataTables
DataTable.use(DataTablesLib);

// Mendefinisikan properti untuk komponen
var props = defineProps(["tahun"]);



// Membuat objek form menggunakan hook useForm
const form = useForm({

    tahun: props.tahun.tahun,
    gelombang: props.tahun.gelombang,
    status: props.tahun.status,
    daritgl: props.tahun.daritgl,
    sampaitgl: props.tahun.sampaitgl,

   
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
    form.put(route('tahuns.update', props.tahun.id))
};



</script>

<template>

<AppHead :title="'Edit Tahun '+tahun.id" />
    <LayoutAuthenticated>
        
        <SectionMain>
            <SectionTitle>Form with status example</SectionTitle>

            <CardBox class="md:w-7/12 lg:w-5/12 xl:w-4/12 shadow-2xl md:mx-auto" is-form is-hoverable
                @submit.prevent="formStatusSubmit">
                <NotificationBarInCard :color="getFormStatusColor" :is-placed-with-header="formStatusWithHeader">
                    <span><b class="capitalize">{{
                        formStatusOptions[formStatusCurrent]
                    }}</b>
                        {{form.recentlySuccessful?" Berhasil menambahkan": "Tambah game"}}</span>
                </NotificationBarInCard>
                <FormField label="NameTahun">
                    <FormControl v-model="form.tahun"  :icon-left="mdiAccount" help="Tahun" placeholder="Tahun"
                        required />
                </FormField>
                <FormField label="Gelombang">
                    <FormControl v-model="form.gelombang" :icon-left="mdiBallotOutline" help="Gelombang" placeholder="Gelombang"
                        required />
                </FormField>
                
                <FormField label="status">
                            <FormControl v-model="form.status" :options="['aktif','nonaktif']" />
                </FormField>
                
                <FormField label="Dari Tgl">
                    <FormControl type="date" v-model="form.daritgl" :icon-left="mdiMail" help="Dari Tgl" placeholder="Dari Tgl"
                        required />
                </FormField>
                <FormField label="Sampai Tgl">
                    <FormControl type="date" v-model="form.sampaitgl" :icon-left="mdiMail" help="Sampai Tgl" placeholder="Sampai Tgl"
                        required />
                </FormField>


                <template #footer>
                    <BaseButton label="Trigger" type="submit" color="info" />
                </template>
            </CardBox>
         
        </SectionMain>
    </LayoutAuthenticated>
</template>
<style>
@import "datatables.net-dt";
</style>
