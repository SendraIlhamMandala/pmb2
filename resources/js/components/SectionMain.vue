<script setup>
import { containerMaxW } from "@/config.js";
</script>

<template>
  <section class="px-4 py-8 mx-auto max-w-screen" :class="containerMaxW">
    <slot />
  </section>
</template>
