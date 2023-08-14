<script setup>
import {  ref, computed,onMounted } from "vue";
import { mdiBallotOutline, mdiAccount, mdiMail, mdiGithub } from "@mdi/js";
import SectionMain from "@/components/SectionMain.vue";
import CardBox from "@/components/CardBox.vue";
import FormCheckRadioGroup from "@/components/FormCheckRadioGroup.vue";
import FormFilePicker from "@/components/FormFilePicker.vue";
import FormField from "@/components/FormField.vue";
import FormControl from "@/components/FormControl.vue";
import BaseDivider from "@/components/BaseDivider.vue";
import BaseButton from "@/components/BaseButton.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import SectionTitle from "@/components/SectionTitle.vue";
import LayoutAuthenticated from "@/layouts/LayoutAuthenticated.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import NotificationBarInCard from "@/components/NotificationBarInCard.vue";
import { useForm, Head, Link } from '@inertiajs/vue3'


import DataTable from 'datatables.net-vue3'
import Select from 'datatables.net-select';
import Scroller from 'datatables.net-scroller';
import Responsive from 'datatables.net-responsive';

DataTable.use(Scroller);

defineProps(['games']);

const datas = [
  [1, 2],
  [3, 4],
];





const form = useForm({
  name: '',
  price: '',

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
  form.post('/games', {
    preserveScroll: true,
  })
};



</script>

<template>
  <LayoutAuthenticated>



    <SectionMain>


      <div>
       
        <DataTable ref="table" class="display" :options="{
          select: true,
          deferRender: true,
          scrollCollapse: true,
          order : [],
          // scrollY: 200,
          // scroller: true,
          scrollX: true,
        }">
          <!-- Table headers -->
          <thead>
            <tr class="bg-gray-100">
              <th class="py-2 px-4">Name</th>
              <th class="py-2 px-4">Price</th>
            </tr>
          </thead>
          <!-- Table body -->
          <tbody>
            <tr v-for="(game, index) in games" :key="index">
              <td class="py-2 px-4">{{ game.name }}</td>
              <td class="py-2 px-4">{{ game.price }}</td>

            </tr>
          </tbody>
        </DataTable>
        <div>
    <table class="min-w-full border border-gray-300 overflow-x-auto">
      <!-- Table headers -->
      <thead>
        <tr class="bg-gray-100">
          <th class="py-2 px-4">Name</th>
          <th class="py-2 px-4">price</th>
        </tr>
      </thead>
      <!-- Table body -->
      <tbody>
        <tr v-for="(game, index) in games" :key="index">
          <td class="py-2 px-4">{{ game.name }}</td>
          <td class="py-2 px-4">{{ game.price }}</td>
        </tr>
      </tbody>
    </table>
  </div>
      </div>

      <SectionTitle>Form with status example</SectionTitle>

      <CardBox class="md:w-7/12 lg:w-5/12 xl:w-4/12 shadow-2xl md:mx-auto" is-form is-hoverable
        @submit.prevent="formStatusSubmit">
        <NotificationBarInCard :color="getFormStatusColor" :is-placed-with-header="formStatusWithHeader">
          <span><b class="capitalize">{{
            formStatusOptions[formStatusCurrent]
          }}</b>
            state</span>
        </NotificationBarInCard>
        <FormField label="Name">
          <FormControl v-model="form.name" :icon-left="mdiAccount" help="Game name" placeholder="Game name" />
        </FormField>

        <FormField label="Price">
          <FormControl v-model="form.price" :icon-left="mdiAccount" help="Game Price" placeholder="Price" />
        </FormField>

        <template #footer>
          <BaseButton label="Trigger" type="submit" color="info" />
        </template>
      </CardBox>
    </SectionMain>
  </LayoutAuthenticated>
</template>
<style>
@import 'datatables.net-dt';
</style>