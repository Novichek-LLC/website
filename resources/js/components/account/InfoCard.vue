<template>
  <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
    <div class="text-xs uppercase tracking-[0.2em] text-slate-500">{{ label }}</div>
    <div class="mt-2 text-base font-medium text-white">{{ value }}</div>
  </div>
</template>

<script setup>
defineProps({
  label: {
    type: String,
    required: true,
  },
  value: {
    type: String,
    required: true,
  },
})
</script>