<script setup>
import { computed, useSlots } from "vue";

defineProps({
  label: {
    type: String,
    default: null,
  },

  label2: {
    type: String,
    default: '',
  },
  label3: {
    type: String,
    default: '',
  },
  labelFor: {
    type: String,
    default: null,
  },
  help: {
    type: String,
    default: null,
  },
  mb: {
    type: String,
    default: 'mb-6',
  }
});

const slots = useSlots();

const wrapperClass = computed(() => {
  const base = [];
  const slotsLength = slots.default().length;

  if (slotsLength > 1) {
    base.push("grid grid-cols-1 gap-3");
  }

  if (slotsLength === 2) {
    base.push("md:grid-cols-1");
  }

  return base;
});
</script>

<template>
  <div class="last:mb-0" :class="mb" >
    <label v-if="label" :for="labelFor" class="block font-bold mb-2">{{
      label 
    }} <span class="text-red-500 dark:text-slate-400" >{{ label2 }}</span> <span class="text-sm text-gray-400 dark:text-slate-400"> {{ label3 }}</span>  </label>
    <div :class="wrapperClass">
      <slot />
    </div>
    <div v-if="help" class="text-xs text-gray-500 dark:text-slate-400 mt-1">
      {{ help }}
    </div>
  </div>
</template>
