<script setup>
import { mdiForwardburger, mdiBackburger, mdiMenu } from "@mdi/js";
import { ref , watch } from "vue";
// import { useRouter } from "vue-router";
import { router } from "@inertiajs/vue3";

import menuAside from "@/menuAside.js";
import menuNavBar from "@/menuNavBarUser.js";
import { useMainStore } from "@/stores/main.js";
import { useStyleStore } from "@/stores/style.js";
import BaseIcon from "@/components/BaseIcon.vue";
import FormControl from "@/components/FormControl.vue";
import NavBar from "@/components/NavBar.vue";
import NavBarItemPlain from "@/components/NavBarItemPlain.vue";
import AsideMenu from "@/components/AsideMenu.vue";
import FooterBar from "@/components/FooterBar.vue";

const styleStore = useStyleStore();
const layoutAsidePadding = "xl:pl-60";

const isAsideMobileExpanded = ref(false);
const isAsideLgActive = ref(false);
const menuClick = (event, item) => {
  // ...
  if (item.isToggleLightDark) {
    styleStore.setDarkMode();
  }

  if (item.isLogout) {
    // Add:
    router.post(route("logout"));
  }
};

const emit = defineEmits(['expanded'])

// emit with argument
watch(isAsideMobileExpanded, (val) => {
console.log(val);
  
})


</script>

<template>
    <NavBar
        :menu="menuNavBar"
        class="bg-gradient-to-r from-sky-500 to-emerald-300 "
        @menu-click="menuClick"
        bg="bg-gradient-to-r from-sky-500 to-emerald-300"
      >
       
       
        <NavBarItemPlain use-margin>
      
          
          <img src="/favicon/logo1.png" class="header-brand-img" width="270" alt="tabler logo">


        </NavBarItemPlain>
      </NavBar>
  <div :class="{ dark: styleStore.darkMode }">
    <div class="bg-gray-50 dark:bg-slate-800 dark:text-slate-100">
      <slot />
    </div>
  </div>
</template>
