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
import FormCheckRadioGroup from "@/components/FormCheckRadioGroup.vue";


// Impor library DataTables
DataTable.use(DataTablesLib);

// Mendefinisikan properti untuk komponen
var props = defineProps(["shift", "jalurs",]);



// Membuat objek form menggunakan hook useForm
// Membuat objek form menggunakan hook useForm
const form = useForm({
    shift:{ name: props.shift.name },
   jalur:{   id: props.shift.jalurdaftars.map((data)=>{
    return data.id
   }), },

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
    form.put(route('shifts.update', props.shift.id))
};

const result = props.jalurs.reduce((obj, jalur) => {
  obj[jalur.id] = jalur.name;
  return obj;
}, {});


</script>

<template>

<AppHead :title="'Edit shift '+shift.id" />
    <LayoutAuthenticated>
        
        <SectionMain>
            <SectionTitle>Edit Shift</SectionTitle>

            <CardBox class="md:w-7/12 lg:w-5/12 xl:w-4/12 shadow-2xl md:mx-auto" is-form is-hoverable
                @submit.prevent="formStatusSubmit">
                <NotificationBarInCard :color="getFormStatusColor" :is-placed-with-header="formStatusWithHeader">
                    <span>
                        {{form.recentlySuccessful?" Berhasil menambahkan": "Edit Shift"}}</span>
                </NotificationBarInCard>
                <FormField label="shift">
                    <FormControl v-model="form.shift.name"  :icon-left="mdiAccount" help="Shift" placeholder="Shift"
                        required />
                </FormField>
                <FormField label="Jalur">
          <FormCheckRadioGroup
            v-model="form.jalur.id"
            name="sample-checkbox"
            :options="result"
          />
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
