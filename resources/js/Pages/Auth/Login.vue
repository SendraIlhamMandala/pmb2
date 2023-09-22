<script setup>
import { useForm, Head, Link } from "@inertiajs/vue3";
import { mdiAccount, mdiAsterisk } from "@mdi/js";
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
import NotificationBarInCard from "@/components/NotificationBarInCard.vue";
import BaseLevel from "@/components/BaseLevel.vue";

const props = defineProps({
    canResetPassword: Boolean,
    status: {
        type: String,
        default: null,
    },
});

const form = useForm({
    email: "",
    password: "",
    remember: [],
});

const submit = () => {
    form.transform((data) => ({
        ...data,
        remember: form.remember && form.remember.length ? "on" : "",
    })).post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <LayoutGuest>

        <Head title="Login" />
        
        <SectionFullScreen v-slot="{ cardClass }" bg="purplePink">
            <div class="min-w-screen min-h-screen flex items-center justify-center px-5 py-5">
            <div class="text-gray-500 rounded-3xl shadow-xl w-full overflow-hidden" style="max-width:1000px">
                <div class="md:flex w-full">
                    <div class="hidden md:block w-1/2  ">
                        <img class="" src="/image/2login.png" alt="Login" />

                    </div>
                    <CardBox class="w-full md:w-1/2 py-10 px-5 md:px-10" is-form @submit.prevent="submit">
                        <FormValidationErrors />

                        <NotificationBarInCard v-if="status" color="info">
                            {{ status }}
                        </NotificationBarInCard>

                        <FormField label="Email" label-for="email" help="Masukkan alamat email anda">
                            <FormControl v-model="form.email" :icon="mdiAccount" id="email" autocomplete="email"
                                type="email" required />
                        </FormField>

                        <FormField label="Password" label-for="password" help="Masukkan kata sandi anda">
                            <FormControl v-model="form.password" :icon="mdiAsterisk" type="password" id="password"
                                autocomplete="current-password" required />
                        </FormField>

                        <FormCheckRadioGroup v-model="form.remember" name="remember" :options="{ remember: 'Remember' }" />

                        <BaseDivider />

                        <BaseLevel>
                            <BaseButtons>
                                <BaseButton type="submit" color="info" label="Login"
                                    :class="{ 'opacity-25': form.processing }" :disabled="form.processing" />
                                <BaseButton v-if="canResetPassword" route-name="password.request" color="info" outline
                                    label="Lupa Password" />
                            </BaseButtons>
                            <Link :href="route('register')"> Daftar </Link>
                        </BaseLevel>
                    </CardBox>
                </div>
            </div>
        </div>

    </SectionFullScreen>
</LayoutGuest></template>
