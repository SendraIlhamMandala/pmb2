<script setup>
import { ref, computed, watch, onMounted } from "vue";
import { mdiPrinter, mdiFileWord } from "@mdi/js";
import SectionMain from "@/components/SectionMain.vue";
import CardBox from "@/components/CardBox.vue";
import FormField from "@/components/FormField.vue";
import FormControl from "@/components/FormControl.vue";
import BaseButton from "@/components/BaseButton.vue";
import SectionTitle from "@/components/SectionTitle.vue";
import LayoutAuthenticatedUser from "@/layouts/LayoutAuthenticatedUser.vue";
import NotificationBarInCard from "@/components/NotificationBarInCard.vue";

import AppHead from "@/components/AppHead.vue";
import axios from "axios";


const isScaled = ref(false);

const toggleScale = () => {
  isScaled.value = !isScaled.value;
};

// Mendefinisikan properti untuk komponen
var props = defineProps(["game", "user", "errors"]);




// Membuat referensi reaktif untuk status form dengan header
const formStatusWithHeader = ref(true);


// Mendefinisikan fungsi untuk menangani pengiriman form
const formSubmit = () => {
  form.post(route('user.set-data-pribadi', props.user.id));
};

const printDocument = () => {
  window.open('/print', '_blank');
};

function exportDOCX() {

axios.get('/gethtmlpage').then(response => {
    var sourceDOCX = '';
    sourceDOCX = response.data;
    console.log(response.data);
    var fileDownload = document.createElement("a");
    var source = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(sourceDOCX);
    // console.log(source);
    document.body.appendChild(fileDownload);
    fileDownload.href = source;
    fileDownload.download = 'Formulir Pendaftaran FISIP UNIGA '+ props.user.name.charAt(0).toUpperCase() + props.user.name.slice(1) +'.doc';
    fileDownload.click();
})
}


</script>

<template>
  <AppHead :title="'Data Pribadi'" />
  <LayoutAuthenticatedUser>

    <SectionMain>
      <SectionTitle>

        <div @click="toggleScale" :class="{ 'scaled': isScaled }" class=" relative mx-auto rounded-lg overflow-hidden">
          <img src="/image/1selesai_BLU.png" alt="Image with Bounce Effect" />
        </div>

      </SectionTitle>




      <CardBox class=" shadow-2xl md:mx-auto mx-auto h-full " is-form is-hoverable @submit.prevent="formSubmit">

        <div class="text-center">

          <p>

            Selamat!!! Pendaftaran Anda Selesai.
          </p>
          <p>
            Silahkan Cetak Formulir Pendaftaran dan Bawa Formulir Pendaftaran beserta Persyaratan yang tertera pada
            formulir, ke sekretariat Pendaftaran PMB FISIP-UNIGA. Terimakasih
          </p>

          <p>


            <BaseButton class=" mx-2" color="success" label="Cetak Formulir" :icon="mdiPrinter" :small="buttonsSmall" :outline="buttonsOutline"
              :disabled="buttonsDisabled" :rounded-full="buttonsRounded" @click="printDocument" />


              <BaseButton class=" mx-2" color="info" label="Simpan" :icon="mdiFileWord" :small="buttonsSmall" :outline="buttonsOutline"
              :disabled="buttonsDisabled" :rounded-full="buttonsRounded" @click="exportDOCX" />
              



          </p>
        </div>

        <!-- Repeat similar code for other fields -->


      </CardBox>

      <!-- <CardBox class="md:w-7/12 lg:w-5/12 xl:w-4/12 shadow-2xl md:mx-auto" is-form is-hoverable  -->

    </SectionMain>
  </LayoutAuthenticatedUser>
</template>
<style>
@import "datatables.net-dt";
</style>

  
<style scoped>
div {
  transition: transform 0.5s cubic-bezier(0.5, -0.55, 0.27, 1.55);
  /* Add a bouncing transition effect */

}

.scaled {
  transform: scale(1.15);
  transition: transform 0.5s cubic-bezier(0.5, -0.55, 0.27, 1.55);
  /* Add a bouncing transition effect */

}
</style>
  