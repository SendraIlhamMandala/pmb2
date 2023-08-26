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
var props = defineProps(["user", "users"]);
console.log(props.user);
console.log(props.users);

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
                <td> <img v-if="!!user.data_pribadi" :src="'storage/avatar/' + user.data_pribadi.foto" alt="" width="100">
                </td>
            </tr>
        </tbody>

    </table>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <!-- datecreated -->
                <th>date created</th>
                <th>foto</th>
                <th>no ktp</th>
                <th>nisn</th>
                <th>tempat lahir</th>
                <th>tanggal lahir</th>
                <th>jenis kelamin</th>
                <th>agama</th>
                <th>ig</th>
                <th>facebook</th>
                <th>ijazah</th>
                <th>SKHUN</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="user2 in users" >
                <td>{{ user2.id }}</td>
                <td>{{ user2.name }}</td>
                <td>{{ user2.email }}</td>
                <!-- datecreated -->
                <td>{{ new Date(user2.created_at).toLocaleDateString() }}</td>
                <td> <img v-if="!!user2.data_pribadi" :src="'storage/avatar/' + user2.data_pribadi.foto" alt="" width="100"> </td>
                <td>{{ user2.data_pribadi != null ? user2.data_pribadi.no_ktp : ''  }}</td>
                <td>{{ user2.data_pribadi != null ? user2.data_pribadi.nisn : ''  }}</td>
                <td>{{ user2.data_pribadi != null ? user2.data_pribadi.tempat_lahir : ''  }}</td>
                <td>{{ user2.data_pribadi != null ? user2.data_pribadi.tanggal_lahir : ''  }}</td>
                <td>{{ user2.data_pribadi != null ? user2.data_pribadi.jenis_kelamin : ''  }}</td>
                <td>{{ user2.data_pribadi != null ? user2.data_pribadi.agama : ''  }}</td>
                <td>{{ user2.data_pribadi != null ? user2.data_pribadi.ig : ''  }}</td>
                <td>{{ user2.data_pribadi != null ? user2.data_pribadi.facebook : ''  }}</td>
                <td> <img v-if="!!user2.asal_sekolah" :src="'storage/ijazah/' + user2.asal_sekolah.ijazah" alt="" width="100"> </td>
                <td> <img v-if="!!user2.asal_sekolah" :src="'storage/skhun/' + user2.asal_sekolah.skhun" alt="" width="100"> </td>

            </tr>
        </tbody>

    </table>
</template>
<style>
@import "datatables.net-dt";
</style>
