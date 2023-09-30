<script setup>
import { ref, computed, watch, onMounted } from "vue";
import { mdiBallotOutline, mdiAccount, mdiMail, mdiGithub } from "@mdi/js";
import SectionMain from "@/components/SectionMain.vue";
import CardBox from "@/components/CardBox.vue";
import FormField from "@/components/FormField.vue";
import FormControl from "@/components/FormControl.vue";
import BaseButton from "@/components/BaseButton.vue";
import SectionTitle from "@/components/SectionTitle.vue";
import LayoutAuthenticatedUser from "@/layouts/LayoutAuthenticatedUser.vue";
import NotificationBarInCard from "@/components/NotificationBarInCard.vue";

import AppHead from "@/components/AppHead.vue";



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

</script>

<template>
  <AppHead :title="'Data Pribadi'" />
  <LayoutAuthenticatedUser>

    <SectionMain>
      <SectionTitle class="mt-4">

        <div @click="toggleScale" :class="{ 'scaled': isScaled }" class=" relative mx-auto rounded-lg overflow-hidden">
          <img src="/image/tunggu_verfif.png" alt="Image with Bounce Effect" />
        </div>

      </SectionTitle>




      <CardBox class=" shadow-2xl md:mx-auto mx-auto h-full " is-form is-hoverable @submit.prevent="formSubmit">

        <div class="text-center">

          Dimohon Untuk Menunggu Verifikasi Pembayaran dalam 1 x 24 Jam
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
  