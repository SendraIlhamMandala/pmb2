<script setup>
import { useForm, usePage, Head } from "@inertiajs/vue3";
import { computed } from "vue";
import { mdiAccount, mdiEmail, mdiFormTextboxPassword } from "@mdi/js";
import LayoutGuest from "@/layouts/LayoutGuest.vue";
import SectionFullScreen from "@/components/SectionFullScreen.vue";
import CardBox from "@/components/CardBox.vue";
import FormCheckRadioGroup from "@/components/FormCheckRadioGroup.vue";
import FormField from "@/components/FormField.vue";
import FormControl from "@/components/FormControl.vue";
import BaseDivider from "@/components/BaseDivider.vue";
import BaseButton from "@/components/BaseButton.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import FormValidationErrors from "@/components/FormValidationErrors.vue";


const props = defineProps(["activeTahuns"]);
console.log(props.activeTahuns);
const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    terms: [],
});

const hasTermsAndPrivacyPolicyFeature = computed(
    () => usePage().props.jetstream?.hasTermsAndPrivacyPolicyFeature
);

const submit = () => {
    form.transform((data) => ({
        ...data,
        terms: form.terms && form.terms.length,
    })).post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <LayoutGuest>

        <Head title="Register" />


        <SectionFullScreen v-slot="{ cardClass }" bg="">
            <div class="min-w-screen min-h-screen flex items-center justify-center px-5 py-5">
                <div class="text-gray-500 rounded-3xl shadow-xl w-full overflow-hidden" style="max-width:1000px; max-height:650px">
                    <div class="md:flex w-full">
                        <div class="hidden lg:block w-1/2  ">
                            <img class="" src="/image/3register.jpg" alt="Login" />

                        </div>

                        <CardBox class="w-full lg:w-1/2 py-10 px-5 md:px-10" v-if="activeTahuns" is-form
                            @submit.prevent="submit">
                            <FormValidationErrors />

                            <FormField mb="mb-0" label="Nama lengkap" label-for="name" help="Masukkan nama lengkap anda">
                                <FormControl v-model="form.name" id="name" :icon="mdiAccount" autocomplete="name"
                                    type="text" required />
                            </FormField>

                            <FormField mb="mb-0" label="Email" label-for="email" help="Masukkan email anda">
                                <FormControl v-model="form.email" id="email" :icon="mdiEmail" autocomplete="email"
                                    type="email" required />
                            </FormField>

                            <FormField mb="mb-0" label="Password" label-for="password" help="Masukkan password">
                                <FormControl v-model="form.password" id="password" :icon="mdiFormTextboxPassword"
                                    type="password" autocomplete="new-password" required />
                            </FormField>

                            <FormField mb="mb-0" label="Ulangi password" label-for="password_confirmation" help="Ulangi password">
                                <FormControl v-model="form.password_confirmation" id="password_confirmation"
                                    :icon="mdiFormTextboxPassword" type="password" autocomplete="new-password" required />
                            </FormField>

                            <FormCheckRadioGroup v-if="hasTermsAndPrivacyPolicyFeature" v-model="form.terms" name="remember"
                                :options="{ agree: 'I agree to the Terms' }" />

                            <BaseDivider />

                            <BaseButtons>
                                <BaseButton type="submit" color="info" label="Daftar"
                                    :class="{ 'opacity-25': form.processing }" :disabled="form.processing" />
                                <BaseButton route-name="login" color="info" outline label="Login" />
                            </BaseButtons>
                        </CardBox>
                        <CardBox v-else :class="cardClass" class="my-24" is-form @submit.prevent="submit">
                            <a href="/">
                                <img src="/image/logo-uniga.png" alt="logo" class="w-1/2 mx-auto">
                            </a>
                            <div class="text-center font-bold ">
                                <h1 class="text-2xl">Pendaftaran Belum Dibuka</h1>

                            </div>
                        </CardBox>
                    </div>
                </div>
            </div>
        </SectionFullScreen>
    </LayoutGuest>
</template>
