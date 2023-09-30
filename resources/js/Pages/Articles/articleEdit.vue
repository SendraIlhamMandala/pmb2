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
import PrimaryButton from '@/Components/PrimaryButton.vue';
import CKEditor from '@ckeditor/ckeditor5-vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import { Head } from '@inertiajs/vue3';

//props article
const props = defineProps({
    article: { type: Object },

});


// Use the <ckeditor> component in this view.
const ckeditor = CKEditor.component;
const editor = ref(ClassicEditor);
const editorData = ref('<p>Content of the editor.</p>');
const editorConfig = {
  mediaEmbed: {
    previewsInData: true
  }
};


const form = useForm({
    tipe: props.article.tipe,
    isi: props.article.isi,
});


const submit = () => {
    form.put(route('articles.update', props.article.id));
};

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



</script>

<template>

<AppHead :title="'Edit '+article.tipe" />
    <LayoutAuthenticated>

        <SectionMain>
            <SectionTitle>Edit {{ article.tipe }}</SectionTitle>

            <CardBox class="shadow-2xl md:mx-auto" is-form is-hoverable
                @submit.prevent="submit">
                <NotificationBarInCard :color="getFormStatusColor" :is-placed-with-header="formStatusWithHeader">
                    <span>
                        {{form.recentlySuccessful?" Berhasil menambahkan": "Edit"}}</span>
                </NotificationBarInCard>
                <form @submit.prevent="submit">
        <div>
            <div id="app">
                <ckeditor name="isi" :editor="editor" v-model="form.isi" :config="editorConfig"  ></ckeditor>
            </div>

           
        </div>
    </form>

                <template #footer>
             <div class="flex justify-center items-center">
               <PrimaryButton class="mx-auto" :class="{ 'opacity-25': form.processing }">
                 Simpan
               </PrimaryButton>
             </div>
                </template>
            </CardBox>
         
        </SectionMain>
    </LayoutAuthenticated>
</template>
<style>
@import "datatables.net-dt";

@import 'ckeditor-tailwind-reset/ckeditor-tailwind-reset';
</style>
