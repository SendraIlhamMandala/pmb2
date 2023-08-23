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


// Import DataTables library
DataTable.use(DataTablesLib);

// Define component properties
var props = defineProps(["user"]);
console.log(props.user);

</script>

<template>

<AppHead title="Users" />
<table>
<thead>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <!-- datecreated -->
    <th>date created</th>
    <th>foto</th>
</tr>
</thead>
<tbody>
<tr>
    <td>{{ user.id }}</td>
    <td>{{ user.name }}</td>
    <td>{{ user.email }}</td>
    <!-- datecreated -->
    <td>{{ new Date(user.created_at).toLocaleDateString() }}</td>
    <td> <img :src="'storage/avatar/'+user.data_pribadi.foto" alt="" width="100" > </td>
</tr>
</tbody>

</table>
</template>
<style>
@import "datatables.net-dt";
</style>
