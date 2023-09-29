<template>
    <form @submit.prevent="submit">
        <div>
            <div id="app">
                <ckeditor name="isi" :editor="editor" v-model="form.isi" :config="editorConfig"  ></ckeditor>
            </div>

            <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }">
                Submit
            </PrimaryButton>
        </div>
    </form>

    <div v-if="articles" v-for="article in articles" >
        <div>
            {{ article.tipe }}
        </div>
        <div v-html="article.isi" >            
        </div>
    </div>
</template>

<script setup>

import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref } from 'vue';
import CKEditor from '@ckeditor/ckeditor5-vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import { Head, Link, useForm } from '@inertiajs/vue3';

//props article
const props = defineProps({
    articles: { type: Object },

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
    tipe: 'a',
    isi: ''
});


const submit = () => {
    form.post(route('posttest'));
};
</script>


<style>
@import 'ckeditor-tailwind-reset/ckeditor-tailwind-reset';
table {
  border: 1px solid black;
  margin-left: auto;
    margin-right: auto;
  border-collapse: collapse; /* Add this line */
}

.table {
    display: block;
    margin-left: auto;
    margin-right: auto;
}

td, th {
  border: 1px solid black;
}
img {
    max-width: 500px;
    display: block;
    margin-left: auto;
    margin-right: auto;
}

</style>