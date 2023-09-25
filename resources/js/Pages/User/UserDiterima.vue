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
var props = defineProps(["game", "user", "token", "errors"]);




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
      <SectionTitle>

        <div @click="toggleScale" :class="{ 'scaled': isScaled }" class=" relative mx-auto rounded-lg overflow-hidden">
          <img src="/image/tes_online.png" alt="Image with Bounce Effect" />
        </div>

      </SectionTitle>




      <CardBox class=" shadow-2xl justify-center md:mx-auto mx-auto h-full " is-form is-hoverable
        @submit.prevent="formSubmit">

        <div class="text-center">

          Dimohon Untuk Segera Lakukan Tes Online, Dengan Login Akun:

          <br>
          <br>

          <div class="flex text-left  mx-0 md:mx-auto grid grid-cols-2 md:grid-cols-2 md:w-1/4">
            <div class="text-right md:text-left" >Username</div>
            <div >: {{ user.nim }}</div>
            <div class="text-right md:text-left">Password</div>
            <div >: {{ user.nim }}</div>
            <div class="text-right md:text-left">Token</div>
            <div >: {{token}}</div>


          </div>
        </div>

        <!-- Repeat similar code for other fields -->
        <div class="text-center my-4" >

          <a href="http://cat.fisipuniga.ac.id"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Test Online
          </a>
        </div>
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
  