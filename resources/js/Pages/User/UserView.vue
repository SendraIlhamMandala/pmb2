<script setup>



import AppHead from "@/components/AppHead.vue";

import DataTable from "datatables.net-vue3";
import DataTablesLib from "datatables.net";
import { ref, computed } from "vue";
import { useStyleStore } from "@/stores/style.js";
import {
    mdiContrastCircle,
    mdiInformation,
    mdiCheckCircle,
    mdiAlert,
    mdiAlertCircle,
    mdiOpenInNew,
    mdiClose,
    mdiReload,
    mdiTrendingUp,
} from "@mdi/js";
import SectionMain from "@/components/SectionMain.vue";
import CardBox from "@/components/CardBox.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import BaseButton from "@/components/BaseButton.vue";
import NotificationBar from "@/components/NotificationBar.vue";
import BaseDivider from "@/components/BaseDivider.vue";
import CardBoxModal from "@/components/CardBoxModal.vue";
import SectionTitle from "@/components/SectionTitle.vue";
import FormField from "@/components/FormField.vue";
import FormCheckRadioGroup from "@/components/FormCheckRadioGroup.vue";
import LayoutAuthenticatedUser from "@/layouts/LayoutAuthenticatedUser.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import CardBoxComponentEmpty from "@/components/CardBoxComponentEmpty.vue";
import CardBoxComponentTitle from "@/components/CardBoxComponentTitle.vue";
import PillTag from "@/components/PillTag.vue";

// Import DataTables library
DataTable.use(DataTablesLib);

// Define component properties
var props = defineProps(["user", "users"]);
console.log(props.user);
console.log(props.users);

</script>

<template>
    <LayoutAuthenticatedUser>

        <AppHead title="Users" />


        <SectionTitle>Cards</SectionTitle>

        <SectionMain>
            <div class="grid grid-cols-1 gap-6 mb-6 lg:grid-cols-2">
                <CardBox class="overflow-auto" >
                    <CardBoxComponentTitle title="Data pribadi">
                        <BaseButton :icon="mdiReload" color="whiteDark" rounded-full />
                    </CardBoxComponentTitle>

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
                                <td> <img v-if="!!user.data_pribadi" :src="'storage/avatar/' + user.data_pribadi.foto"
                                        alt="" width="100">
                                </td>
                            </tr>
                        </tbody>


                    </table>



                </CardBox>

                <CardBox class="overflow-auto" >
                    <CardBoxComponentTitle title="Data dAFTAR">
                        <BaseButton :icon="mdiReload" color="whiteDark" rounded-full />
                    </CardBoxComponentTitle>


                    <table v-if="!!user.asal_sekolah">
                        <thead>
                            <tr>
                                <th>Data daftar ID</th>
                                <th>shift</th>
                                <th>jalur</th>
                                <th>program studi</th>
                                <th>status</th>
                                <th>setup</th>
                                <th>date created</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ user.data_daftar.id }}</td>
                                <td>{{ user.data_daftar.shift }}</td>
                                <td>{{ user.data_daftar.jalur }}</td>
                                <td>{{ user.data_daftar.program_studi }}</td>
                                <td>{{ user.status}}</td>
                                <td>{{ user.done_setup}}</td>
                                <td>{{ new Date(user.data_daftar.created_at).toLocaleDateString() }}</td>
                            

                            </tr>
                        </tbody>

                    </table>





                </CardBox>


                <CardBox class="overflow-auto" >
                    <CardBoxComponentTitle title="Data Sekolah">
                        <BaseButton :icon="mdiReload" color="whiteDark" rounded-full />
                    </CardBoxComponentTitle>


                    <table v-if="!!user.asal_sekolah">
                        <thead>
                            <tr>
                                <th>Sekolah ID</th>
                                <th>Name</th>
                                <th>alamat</th>
                                <th>tahun lulus</th>
                                <th>jurusan</th>
                                <th>date created</th>
                                <th>ijazah</th>
                                <th>skhun</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ user.asal_sekolah.id }}</td>
                                <td>{{ user.asal_sekolah.nama_sekolah }}</td>
                                <td>{{ user.asal_sekolah.alamat_sekolah }}</td>
                                <td>{{ user.asal_sekolah.tahun_lulus }}</td>
                                <td>{{ user.asal_sekolah.jurusan }}</td>
                                <td>{{ new Date(user.asal_sekolah.created_at).toLocaleDateString() }}</td>
                                <td> <img v-if="!!user.asal_sekolah" :src="'storage/ijazah/' + user.asal_sekolah.ijazah"
                                        alt="" width="100">
                                </td>
                                <td> <img v-if="!!user.asal_sekolah" :src="'storage/skhun/' + user.asal_sekolah.skhun"
                                        alt="" width="100">
                                </td>

                            </tr>
                        </tbody>

                    </table>





                </CardBox>




                <CardBox class="overflow-auto" >
                    <CardBoxComponentTitle title="Data Orangtua">
                        <BaseButton :icon="mdiReload" color="whiteDark" rounded-full />
                    </CardBoxComponentTitle>




                    <table v-if="!!user.orangtua">
                        <thead>
                            <tr>
                                <th>Orangtua ID</th>
                                <th>nama ayah</th>
                                <th>nama ibu</th>
                                <th>no ktp ayah</th>
                                <th>no ktp ibu</th>
                                <th>tempat lahir ayah</th>
                                <th>tempat lahir ibu</th>
                                <th>tanggal lahir ayah</th>
                                <th>tanggal lahir ibu</th>
                                <th>no hp ayah</th>
                                <th>no hp ibu</th>
                                <th>pekerjaan ayah</th>
                                <th>pekerjaan ibu</th>
                                <th>penghasilan ayah</th>
                                <th>penghasilan ibu</th>
                                <th>date created</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ user.orangtua.id }}</td>
                                <td>{{ user.orangtua.nama_ayah }}</td>
                                <td>{{ user.orangtua.nama_ibu }}</td>
                                <td>{{ user.orangtua.ktp_ayah }}</td>
                                <td>{{ user.orangtua.ktp_ibu }}</td>
                                <td>{{ user.orangtua.tempat_lahir_ayah }}</td>
                                <td>{{ user.orangtua.tempat_lahir_ibu }}</td>
                                <td>{{ user.orangtua.tanggal_lahir_ayah }}</td>
                                <td>{{ user.orangtua.tanggal_lahir_ibu }}</td>
                                <td>{{ user.orangtua.no_hp_ayah }}</td>
                                <td>{{ user.orangtua.no_hp_ibu }}</td>
                                <td>{{ user.orangtua.pekerjaan_ayah }}</td>
                                <td>{{ user.orangtua.pekerjaan_ibu }}</td>
                                <td>{{ user.orangtua.penghasilan_ayah }}</td>
                                <td>{{ user.orangtua.penghasilan_ibu }}</td>
                                <td>{{ new Date(user.orangtua.created_at).toLocaleDateString() }}</td>

                            </tr>
                        </tbody>

                    </table>






                </CardBox>


                <CardBox class="overflow-auto" >
                    <CardBoxComponentTitle title="Data alamat">
                        <BaseButton :icon="mdiReload" color="whiteDark" rounded-full />
                    </CardBoxComponentTitle>


                    <table v-if="!!user.alamat" >
                        <thead>
                            <tr>
                                <th>alamat ID</th>
                                <th>alamat</th>
                                <th>kelurahan</th>
                                <th>kecamatan</th>
                                <th>kabupaten</th>
                                <th>provinsi</th>
                                <th>kodepos</th>
                                <th>date created</th>


                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ user.alamat.id }}</td>
                                <td>{{ user.alamat.alamat }}</td>
                                <td>{{ user.alamat.kelurahan }}</td>
                                <td>{{ user.alamat.kecamatan }}</td>
                                <td>{{ user.alamat.kabupaten }}</td>
                                <td>{{ user.alamat.provinsi }}</td>
                                <td>{{ user.alamat.kodepos }}</td>
                                <td>{{ new Date(user.alamat.created_at).toLocaleDateString() }}</td>

                            </tr>
                        </tbody>

                    </table>







                </CardBox>

                <CardBox class="overflow-auto" >
                    <CardBoxComponentTitle title="Data pindahan">
                        <BaseButton :icon="mdiReload" color="whiteDark" rounded-full />
                    </CardBoxComponentTitle>


                    <table v-if="!!user.pindahan" >
                        <thead>
                            <tr>
                                <th>pindahan ID</th>
                                <th>perguruan tinggi</th>
                                <th>program studi</th>
                                <th>nomor induk mahasiswa</th>
                                <th>date created</th>


                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ user.pindahan.id }}</td>
                                <td>{{ user.pindahan.perguruan_tinggi }}</td>
                                <td>{{ user.pindahan.program_studi }}</td>
                                <td>{{ user.pindahan.nomor_induk_mahasiswa }}</td>
                                <td>{{ new Date(user.pindahan.created_at).toLocaleDateString() }}</td>

                            </tr>
                        </tbody>

                    </table>







                </CardBox>

                <CardBox class="overflow-auto" >
                    <CardBoxComponentTitle title="Data tambahan">
                        <BaseButton :icon="mdiReload" color="whiteDark" rounded-full />
                    </CardBoxComponentTitle>


                    <table v-if="!!user.tambahan" >
                        <thead>
                            <tr>
                                <th>tambahan ID</th>
                                <th>keterangan </th>
                                <th>surat keterangan</th>
                                <th>date created</th>


                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ user.tambahan.id }}</td>
                                <td>{{ user.tambahan.isi_data }}</td>
                                <td> <img v-if="!!user.tambahan" :src="'storage/foto_bukti/' + user.tambahan.foto_bukti"
                                        alt="" width="100">
                                </td>
                                <td>{{ new Date(user.alamat.created_at).toLocaleDateString() }}</td>

                            </tr>
                        </tbody>

                    </table>







                </CardBox>
                

            
            </div>


           
        </SectionMain>




<div class="overflow-x-auto" >

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>nim</th>
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
                <tr v-for="user2 in users">
                    <td>{{ user2.id }}</td>
                    <td>{{ user2.nim }}</td>
                    <td>{{ user2.name }}</td>
                    <td>{{ user2.email }}</td>
                    <!-- datecreated -->
                    <td>{{ new Date(user2.created_at).toLocaleDateString() }}</td>
                    <td> <img v-if="!!user2.data_pribadi" :src="'storage/avatar/' + user2.data_pribadi.foto" alt=""
                            width="100">
                    </td>
                    <td>{{ user2.data_pribadi != null ? user2.data_pribadi.no_ktp : '' }}</td>
                    <td>{{ user2.data_pribadi != null ? user2.data_pribadi.nisn : '' }}</td>
                    <td>{{ user2.data_pribadi != null ? user2.data_pribadi.tempat_lahir : '' }}</td>
                    <td>{{ user2.data_pribadi != null ? user2.data_pribadi.tanggal_lahir : '' }}</td>
                    <td>{{ user2.data_pribadi != null ? user2.data_pribadi.jenis_kelamin : '' }}</td>
                    <td>{{ user2.data_pribadi != null ? user2.data_pribadi.agama : '' }}</td>
                    <td>{{ user2.data_pribadi != null ? user2.data_pribadi.ig : '' }}</td>
                    <td>{{ user2.data_pribadi != null ? user2.data_pribadi.facebook : '' }}</td>
                    <td> <img v-if="!!user2.asal_sekolah" :src="'storage/ijazah/' + user2.asal_sekolah.ijazah" alt=""
                            width="100"> </td>
                    <td> <img v-if="!!user2.asal_sekolah" :src="'storage/skhun/' + user2.asal_sekolah.skhun" alt=""
                            width="100">
                    </td>

                </tr>
            </tbody>

        </table>
    </div>

    </LayoutAuthenticatedUser>
</template>
<style>
@import "datatables.net-dt";
</style>
