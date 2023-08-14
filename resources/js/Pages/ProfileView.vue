<script setup>
import { computed, reactive, ref } from "vue";
import { useMainStore } from "@/stores/main";
import {
  mdiAccount, // icon for account
  mdiMail, // icon for mail
  mdiAsterisk, // icon for asterisk
  mdiFormTextboxPassword, // icon for password textbox
  mdiGithub, // icon for GitHub
} from "@mdi/js";
import { useForm, Head, Link } from '@inertiajs/vue3'

import SectionMain from "@/components/SectionMain.vue";
import CardBox from "@/components/CardBox.vue";
import BaseDivider from "@/components/BaseDivider.vue";
import FormField from "@/components/FormField.vue";
import FormControl from "@/components/FormControl.vue";
import FormFilePicker from "@/components/FormFilePicker.vue";
import BaseButton from "@/components/BaseButton.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import UserCard from "@/components/UserCard.vue";
import LayoutAuthenticated from "@/layouts/LayoutAuthenticated.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue"; // section title with button component
import InputError from '@/ComponentsBreeze/InputError.vue';
import NotificationBarInCard from "@/components/NotificationBarInCard.vue";


const props = defineProps(
  {
    status: {
        type: String,
        default: null,
    },
    ase: Number,
  }
);


const mainStore = useMainStore();

const profileForm = reactive({
  name: mainStore.userName,
  email: mainStore.userEmail,
});

// const form = reactive({
//   password_current: "",
//   password: "",
//   password_confirmation: "",
// });

const submitProfile = () => {
  mainStore.setUser(profileForm);
};

const form = useForm({
  current_password: '',
  password: '',
  password_confirmation: '',
});

var num = 123;


   const numx = computed(()=>{
      if (form.wasSuccessful) {
      num = num;
      console.log(form.wasSuccessful);
  
    }else{
      console.log(form.wasSuccessful);
      num = 999;
    }});

    const passw = computed(()=>{
      return form.current_password; 
    });




const submitPass = () => {
  form.put(route('password.update'), {
    preserveScroll: true,
    onSuccess: () => form.reset(),

    onError: () => {
      if (form.errors.password) {
        form.reset('password', 'password_confirmation');
        // passwordInput.value.focus();
      }
      if (form.errors.current_password) {
        form.reset('current_password');
        // currentPasswordInput.value.focus();
      }
    },
  });
};
</script>

<template>
  <LayoutAuthenticated>
    <SectionMain>
      <SectionTitleLineWithButton :icon="mdiAccount" title="Profile" main>
        <BaseButton href="https://github.com/justboil/admin-one-vue-tailwind" target="_blank" :icon="mdiGithub"
          label="Star on GitHub" color="contrast" rounded-full small />
      </SectionTitleLineWithButton>

      <UserCard class="mb-6" />

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <CardBox is-form @submit.prevent="submitProfile">
          <FormField label="Avatar" help="Max 500kb">
            <FormFilePicker label="Upload" />
          </FormField>

          <FormField label="Name" help="Required. Your name">
            <FormControl v-model="profileForm.name" :icon="mdiAccount" name="username" required autocomplete="username" />
          </FormField>
          <FormField label="E-mail" help="Required. Your e-mail">
            <FormControl v-model="profileForm.email" :icon="mdiMail" type="email" name="email" required
              autocomplete="email" />
          </FormField>

          <template #footer>
            <BaseButtons>
              <BaseButton color="info" type="submit" label="Submit" />
              <BaseButton color="info" label="Options" outline />
            </BaseButtons>
          </template>
        </CardBox>
        <NotificationBarInCard v-if="status" color="info">
                    {{ status }}
                </NotificationBarInCard>
        <CardBox is-form @submit.prevent="submitPass">
          {{ num }}
          {{ passw }}
          {{ status }}
          {{ numx }}
          {{ form.wasSuccessful }}
          <div v-if="$page.props.flash.message" class="alert">
            {{ $page.props.flash.message }}
          </div>

          <InputError :message="form.wasSuccessful.password" class="mt-2" />

          <FormField label="Current password" help="Required. Your current password">
            <FormControl v-model="form.current_password" :icon="mdiAsterisk" name="current_password" type="password"
              required autocomplete="current-password" />

          </FormField>
          <InputError :message="form.errors.current_password" class="mt-2" />

          <BaseDivider />

          <FormField label="New password" help="Required. New password">
            <FormControl v-model="form.password" :icon="mdiFormTextboxPassword" name="password" type="password" required
              autocomplete="new-password" />

          </FormField>
          <InputError :message="form.errors.password" class="mt-2" />

          <FormField label="Confirm password" help="Required. New password one more time">
            <FormControl v-model="form.password_confirmation" :icon="mdiFormTextboxPassword" name="password_confirmation"
              type="password" required autocomplete="new-password" />

          </FormField>
          <InputError :message="form.errors.password_confirmation" class="mt-2" />

          <template #footer>
            <BaseButtons>
              <BaseButton type="submit" color="info" label="Submit" />
              <BaseButton @click="console.log(status)" color="info" label="Options" outline />
            </BaseButtons>
          </template>
        </CardBox>

      </div>
    </SectionMain>
  </LayoutAuthenticated>
</template>
