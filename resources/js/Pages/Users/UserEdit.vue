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
var props = defineProps(["user"]);



// Membuat objek form menggunakan hook useForm
const form = useForm({
    name: props.user.name,
    email:  props.user.email,
    status: props.user.status,
    done_setup: props.user.done_setup,
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
    form.put(route('users.update', props.user.id))
};



</script>

<template>

<AppHead :title="'Edit user '+user.id" />
    <LayoutAuthenticated>
        
        <SectionMain>
            <SectionTitle>Edit user {{ user.id }}</SectionTitle>

            <CardBox class="md:w-7/12 lg:w-5/12 xl:w-4/12 shadow-2xl md:mx-auto" is-form is-hoverable
                @submit.prevent="formStatusSubmit">
                <NotificationBarInCard :color="getFormStatusColor" :is-placed-with-header="formStatusWithHeader">
                    <span><b class="capitalize">{{
                        formStatusOptions[formStatusCurrent]
                    }}</b>
                        {{form.recentlySuccessful?" Berhasil menambahkan": "Tambah user"}}</span>
                </NotificationBarInCard>
                <FormField label="Name">
                    <FormControl v-model="form.name"  :icon-left="mdiAccount" help="user name" placeholder="user name"
                        required />
                </FormField>

                <FormField label="Email">
                    <FormControl v-model="form.email" :icon-left="mdiAccount" help="user email" placeholder="email"
                        required />
                </FormField>

                <FormField label="done_setup">
                    <FormControl v-model="form.done_setup" :icon-left="mdiAccount" help="user done_setup" placeholder="done_setup"
                        required />
                </FormField>

                <FormField label="status">
                    <FormControl v-model="form.status" :icon-left="mdiAccount" help="user status" placeholder="status"
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
