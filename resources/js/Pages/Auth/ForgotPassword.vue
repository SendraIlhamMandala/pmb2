<script setup>
import { useForm, Head, Link } from '@inertiajs/vue3'
import { mdiEmail } from '@mdi/js'
import LayoutGuest from '@/layouts/LayoutGuest.vue'
import SectionFullScreen from '@/components/SectionFullScreen.vue'
import CardBox from '@/components/CardBox.vue'
import FormField from '@/components/FormField.vue'
import FormControl from '@/components/FormControl.vue'
import BaseDivider from '@/components/BaseDivider.vue'
import BaseButton from '@/components/BaseButton.vue'
import FormValidationErrors from '@/components/FormValidationErrors.vue'
import NotificationBarInCard from '@/components/NotificationBarInCard.vue'
import BaseLevel from '@/components/BaseLevel.vue'

defineProps({
  status: {
    type: String,
    default: null
  }
})

const form = useForm({
  email: ''
})

const submit = () => {
  form.post(route('password.email'))
}
</script>

<template>
  <LayoutGuest>
    <Head title="Forgot Password" />

    <SectionFullScreen
      v-slot="{ cardClass }"
      bg="purplePink"
    >
      <CardBox
        :class="cardClass"
        is-form
        @submit.prevent="submit"
      >
        <FormValidationErrors />

        <NotificationBarInCard 
          v-if="status"
          color="info"
        >
          {{ status == 'We have emailed your password reset link.' ? 'Email reset password telah dikirim' : status }}
        </NotificationBarInCard>

        <FormField>
          <div class="mb-4 text-sm text-gray-600">
            Lupa kata sandi? Tidak masalah. Beri tahu kami alamat email Anda dan kami akan mengirimkan link reset kata sandi melalui email.
</div>
        </FormField>

        <FormField
          label="Email"
          help="masukkan email "
        >
          <FormControl
            v-model="form.email"
            :icon="mdiEmail"
            autocomplete="email"
            type="email"
            required
          />
        </FormField>

        <BaseDivider />

        <BaseLevel>
          <BaseButton
            type="submit"
            color="info"
            label="Kirim email"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          />
          <Link
            :href="route('login')"
          >
            Kembali login
          </Link>
        </BaseLevel>
      </CardBox>
    </SectionFullScreen>
  </LayoutGuest>
</template>
