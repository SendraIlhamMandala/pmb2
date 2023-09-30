<script setup>
import { ref, computed, onMounted } from "vue";
import { mdiBallotOutline, mdiAccount, mdiInformation, mdiAlert, mdiGithub } from "@mdi/js";
import SectionMain from "@/components/SectionMain.vue";
import CardBox from "@/components/CardBox.vue";
import FormField from "@/components/FormField.vue";
import FormControl from "@/components/FormControl.vue";
import BaseButton from "@/components/BaseButton.vue";
import SectionTitle from "@/components/SectionTitle.vue";
import LayoutAuthenticatedUser from "@/layouts/LayoutAuthenticatedUser.vue";
import NotificationBarInCard from "@/components/NotificationBarInCard.vue";
import { useForm, Link } from "@inertiajs/vue3";
import AppHead from "@/components/AppHead.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import NotificationBar from "@/components/NotificationBar.vue";
import { watch } from "vue";
import FormFilePicker from "@/components/FormFilePicker.vue";
import { router } from '@inertiajs/vue3'


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


// Mendefinisikan properti untuk komponen
var props = defineProps(["shifts", "biaya", "user", "prodi", "errors"]);



var kodeVoucher = ref('');

// Membuat objek form menggunakan hook useForm
const form = useForm({
    name: props.user.name,
    nim: props.user.nim,
    no_rekening: null,
    tanggal_bayar: null,
    jumlah_bayar: null,
    foto_bukti: null,
    kode: null,


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
    form.post(route('uploadVerifikasiPembayaran', props.user.id));
};

const formVoucher = useForm(
    {
        kode: null,
    }
);



watch(kodeVoucher, (newKode) => {
    formVoucher.kode = newKode
    form.kode = newKode
});


const cekVoucher = () => {
    formVoucher.post(route('verifikasiVoucher'), {
        preserveScroll: true,
        onSuccess: () => form.reset('kode'),

    });
};

const getJalur = computed
    (() => {
        if (form.shift) {
            return props.shifts.find((i) => i.name == form.shift).jalur_daftars.map((i) => i.name)
        }
    });

watch(() => form.shift, () => {
    form.jalur = null
    console.log(form.shift);
});


const showForm = ref(false);

const toggleForm = () => {
    showForm.value = !showForm.value;
};

const submitForm = () => {
    // Handle form submission logic here
    console.log('Form submitted');
};

const now = computed(() => Date.now())
const jalurEdit = () => {
    router.get('data-jalur/edit/' + props.user.id);
};
console.log();
</script>

<template>
    <AppHead :title="'Jalur'" />
    <LayoutAuthenticatedUser>

        <SectionMain>
            <SectionTitle class="mt-4">Kirim Bukti Pembayaran</SectionTitle>
            <div class="grid grid-cols-1 md:grid-cols-3 grid-rows-1 gap-4">
                <div class=" md:fixed  md:-translate-y-10 ">
                    <CardBox class="shadow-2xl md:mx-auto mx-auto md:w-3/4 lg:w-80  ">

                        <div class="w-11/12 mx-auto mt-8">

                            <NotificationBarInCard :color="getFormStatusColor"
                                :is-placed-with-header="formStatusWithHeader">
                                <span>
                                    {{ form.recentlySuccessful ? " Berhasil menambahkan" : "Jalur Pendaftaran Anda"
                                    }}</span>
                            </NotificationBarInCard>
                        </div>


                        <FormField mb="mb-0" label="Shift" class="">
                            <FormControl h="h-6" v-model="user.data_daftar.shift" type="text" :disabled="true" />
                            <p class="text-red-500">{{ errors.name }}</p>
                        </FormField>
                        <FormField mb="mb-0" label="Jalur" class="">
                            <FormControl h="h-6" v-model="user.data_daftar.jalur" type="text" :disabled="true" />
                            <p class="text-red-500">{{ errors.name }}</p>
                        </FormField>
                        <FormField mb="mb-0" label="Status" class="">
                            <FormControl h="h-6" v-model="user.data_daftar.status" type="text" :disabled="true" />
                            <p class="text-red-500">{{ errors.name }}</p>
                        </FormField>
                        <FormField mb="mb-0" label="Program Studi" class="">
                            <FormControl h="h-6" v-model="user.data_daftar.program_studi" type="text" :disabled="true" />
                            <p class="text-red-500">{{ errors.name }}</p>
                        </FormField>
                        <div class="flex mt-4 justify-center items-center">
                            <BaseButton @click.prevent="jalurEdit" label="Edit Jalur Daftar" type="submit" color="info" />
                        </div>


                    </CardBox>
                </div>
            
            <div>

            </div>

             <CardBox class=" shadow-2xl md:mx-auto col-span-2" is-form is-hoverable @submit.prevent="formSubmit">
              
              
                <CardBox class=" shadow-2xl mb-4" is-form is-hoverable @submit.prevent="cekVoucher">
                                <label for="voucher" class="block font-bold mb-2">Kode voucher
                                </label>
                                <div class="flex ">
                                    <div class="grow ">
                                        <FormField id="voucher">
                                            <FormControl v-model="kodeVoucher" required />
                                        </FormField>
                                    </div>
                                    <div class="self-center">

                                        <BaseButton label="cek voucher" type="submit" color="info" />
                                    </div>


                                </div>
                                <div>
                                    <p class="text-red-500">{{ errors.kode }}</p>
                                    <p class="text-green-500">{{ errors.success }}</p>
                                </div>

                            </CardBox>
                <NotificationBar class="flex flex-col  " color="info" :icon="mdiInformation">


                    <div class=""><b>Biaya Pendaftaran Sebesar {{ errors.success ? 'Rp.150.000' : biaya[0].biaya }} Dibayarkan Melalui Nomor
                            Rekening (** pilih salah satu):</b></div>
                    <div v-for="biaya_data in biaya" class="">
                        {{ biaya_data.nama_bank }} {{ biaya_data.no_rekening }} {{ biaya_data.atas_nama }}
                    </div>

                    <template #right>

                    </template>
                </NotificationBar>


                <div>

                    <BaseButton @click.prevent="toggleForm" color="info" class=" relative z-50 bg"
                        label="Kirim bukti pembayaran" />

                    <transition name="slide" mode="out-in">
                        <div v-if="showForm" key="form" class=" z-10  p-4 dark:bg-gray-800 bg-white shadow-md rounded-md">
                            <!-- Your form fields go here -->

                            <FormField label="Nama Lengkap" class="">
                                <FormControl v-model="user.name" type="text" :disabled="true" />
                                <p class="text-red-500">{{ errors.name }}</p>
                            </FormField>
                            <FormField label="Nomor peserta" class="mt-8">
                                <FormControl v-model="user.nim" :disabled="true" />
                                <p class="text-red-500">{{ errors.nim }}</p>
                            </FormField>
                            <FormField label="Nomor rekening anda " label2="*" label3=" " class="mt-8">
                                <FormControl v-model="form.no_rekening" required />
                                <p class="text-red-500">{{ errors.no_rekening }}</p>
                            </FormField>
                            <FormField label="tanggal bayar" label2="*" label3=" " class="mt-8">
                                <FormControl v-model="form.tanggal_bayar" type="date" required />
                                <p class="text-red-500">{{ errors.tanggal_bayar }}</p>
                            </FormField>
                            <FormField label="Jumlah bayar" label2="*" label3=" " class="mt-8">
                                <FormControl v-model="form.jumlah_bayar" type="number" required />
                                <p class="text-red-500">{{ errors.jumlah_bayar }}</p>
                            </FormField>


                            <FormField label="Foto bukti bayar" label2="*" label3="" class="mx-auto">
                                <div class="">
                                    <div v-if="previewImage" class="flex justify-center h-40">
                                        <img :src="previewImage" alt="Preview foto" class="h-40" />
                                    </div>
                                    <div v-else class="flex justify-center">
                                    </div>
                                    <div class="grid grid-row-2 gap-4 col-span-2 justify-center">
                                        <FormFilePicker accept=".jpg,.jpeg,.png" @change="handleFileChange"
                                            @input="form.foto_bukti = $event.target.files[0]" label="Upload" class="w-full"
                                            required />

                                        <!-- <input type="file" @input="form.dataPribadi.foto = $event.target.files[0]" /> -->
                                        <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                            {{ form.progress.percentage }}%
                                        </progress>


                                        <NotificationBar v-if="errors.foto_bukti" color="warning" :icon="mdiAlert" :outline="notificationsOutline">
                                            <p>{{ errors.foto_bukti }}</p>
                                            <template #right>
                                                
                                            </template>
                                        </NotificationBar>

                                    </div>
                                </div>

                            </FormField>
                            <CardBox class=" shadow-2xl mb-4" is-form is-hoverable @submit.prevent="cekVoucher">
                                <label for="voucher" class="block font-bold mb-2">Kode voucher
                                </label>
                                <div class="flex ">
                                    <div class="grow ">
                                        <FormField id="voucher">
                                            <FormControl v-model="kodeVoucher" required />
                                        </FormField>
                                    </div>
                                    <div class="self-center">

                                        <BaseButton label="cek voucher" type="submit" color="info" />
                                    </div>


                                </div>
                                <div>
                                    <p class="text-red-500">{{ errors.kode }}</p>
                                    <p class="text-green-500">{{ errors.success }}</p>
                                </div>

                            </CardBox>


                            <BaseButton label="Submit" type="submit" color="info" />
                        </div>
                    </transition>
                </div>

            </CardBox>
        </div>


        </SectionMain>
    </LayoutAuthenticatedUser>
</template>
<style>
@import "datatables.net-dt";
</style>


  

  
<style>
.slide-enter-active,
.slide-leave-active {
    transition: all 0.5s ease;
}

.slide-enter-from,
.slide-leave-to {
    opacity: 0;
    transform: translateY(-5%);
}

.slide-enter-to,
.slide-leave-from {
    transform: translateX(0);
    opacity: 100;
}
</style>
  

