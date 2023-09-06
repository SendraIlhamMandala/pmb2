<script setup>
import { computed } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm, Head, Link } from "@inertiajs/vue3";
import LayoutGuest from "@/layouts/LayoutGuest.vue";
import SectionFullScreen from "@/components/SectionFullScreen.vue";
import CardBox from "@/components/CardBox.vue";
import FormField from "@/components/FormField.vue";
import BaseDivider from "@/components/BaseDivider.vue";
import BaseButton from "@/components/BaseButton.vue";
import FormValidationErrors from "@/components/FormValidationErrors.vue";
import NotificationBarInCard from "@/components/NotificationBarInCard.vue";
import BaseLevel from "@/components/BaseLevel.vue";
import NotificationBar from "@/components/NotificationBar.vue";
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




const props = defineProps({
    status: {
        type: String,
    },
  user: {
    type: Object,
    default: null,
  }
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
console.log(props.user);
</script>


<template>
  
    <LayoutGuest>
    <Head title="Email Verification" />

    <SectionFullScreen v-slot="{ cardClass }" bg="purplePink">
      <CardBox :class="cardClass" is-form @submit.prevent="submit">
        <FormValidationErrors />

        <NotificationBarInCard v-if="verificationLinkSent" color="success">
          Link verifikasi baru telah dikirimkan ke {{ user.email }}
        </NotificationBarInCard>

        <FormField>
          <div class="mb-4 text-sm text-gray-600">
          <p>
            <b>
              
              Halo {{ user.name  }} !
            </b>
          </p>
          <br>

            Terima kasih telah mendaftar! Sebelum memulai,
            bisakah Kamu melakukan verifikasi dengan menekan link yang baru saja kami kirimkan ke  <b> {{ user.email }}</b> ?
            Jika Kamu tidak menerima email tersebut, kami akan dengan senang hati mengirimkannya lagi.
          </div>

          <NotificationBar
        color="info"
        :icon="mdiAlert"
        :outline="notificationsOutline"
      >
        <b>Perhatian.</b> Cek folder <b>SPAM</b> di email Kamu jika kamu tidak menerima email dari kami 
        <template #right>
        </template>
      </NotificationBar>


        </FormField>

        <BaseDivider />

        <BaseLevel>
          <BaseButton
            type="submit"
            color="info"
            label="Kirim ulang Email Verifikasi"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          />
          <Link :href="route('logout')" method="post" as="button">
            Logout
          </Link>
        </BaseLevel>
      </CardBox>
    </SectionFullScreen>
  </LayoutGuest>
</template>
