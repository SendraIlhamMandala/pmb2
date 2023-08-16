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
import { useForm, Head, Link } from "@inertiajs/vue3";
import datatablecomponent from "@/components/DataTableComponent.vue";
import LayoutAuthenticated from "@/layouts/LayoutAuthenticated.vue";

import DataTable from "datatables.net-vue3";
import Select from "datatables.net-select";
import DataTablesLib from "datatables.net";
import DataTables from "datatables.net-select";

DataTable.use(DataTablesLib);

var props = defineProps(["games", "gamesEdit"]);

const dataExcel = {
    extend: "excel",
    messageTop: "data Gameee",
    exportOptions: {
        columns: [0, 1, 2, 3, 4],
    },
};

const form = useForm({
    name: "",
    price: "",
});

const formStatusWithHeader = ref(true);

const formStatusCurrent = ref(0);

const formStatusOptions = ["info", "success", "danger", "warning"];

const getFormStatusColor = computed(() => {
    if (form.wasSuccessful) {
        return formStatusOptions[1];
    } else {
        return formStatusOptions[0];
    }
});

const formStatusSubmit = () => {
    form.post("/games", {
        preserveScroll: true,
    });
};

const columns = [
    { data: "id" },
    { data: "name" },
    { data: "price" },
    { data: "created_at.date", title: "Date" },
    { data: "created_at.hour", title: "Hour" },
    {
        title: "action",
        mRender: function (data, type, row) {
            return (
                "<a class='table-edit' data-id='" +
                row.id +
                "' href='/games/" +
                row.id +
                "') >EDIT</a>"
            );
        },
    },
    {
        title: "action",
        mRender: function (data, type, row) {
            return (
                "<a class='table-edit' data-id='" +
                row.id +
                "' onClick=window.alert('You_Deleted" +
                row.id +
                "') >DELETE</a>"
            );
        },
    },
];

console.log(props.gamesEdit[0]);
</script>

<template>
    <LayoutAuthenticated>
        <SectionMain>
            <SectionTitle>Form with status example</SectionTitle>

            <CardBox
                class="md:w-7/12 lg:w-5/12 xl:w-4/12 shadow-2xl md:mx-auto"
                is-form
                is-hoverable
                @submit.prevent="formStatusSubmit"
            >
                <NotificationBarInCard
                    :color="getFormStatusColor"
                    :is-placed-with-header="formStatusWithHeader"
                >
                    <span
                        ><b class="capitalize">{{
                            formStatusOptions[formStatusCurrent]
                        }}</b>
                        state</span
                    >
                </NotificationBarInCard>
                <FormField label="Name">
                    <FormControl
                        v-model="form.name"
                        :icon-left="mdiAccount"
                        help="Game name"
                        placeholder="Game name"
                        required
                    />
                </FormField>

                <FormField label="Price">
                    <FormControl
                        v-model="form.price"
                        :icon-left="mdiAccount"
                        help="Game Price"
                        placeholder="Price"
                        required
                    />
                </FormField>

                <template #footer>
                    <BaseButton label="Trigger" type="submit" color="info" />
                </template>
            </CardBox>
            <div>
                <datatablecomponent
                    :dataExcel="dataExcel"
                    :games="gamesEdit"
                    :form="form"
                    :columns="columns"
                >
                </datatablecomponent>
            </div>
        </SectionMain>
    </LayoutAuthenticated>
</template>
<style>
@import "datatables.net-dt";
</style>
