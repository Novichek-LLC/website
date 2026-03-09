<template>
  <div class="max-w-3xl">
    <div v-if="eyebrow" class="mb-3 text-sm font-semibold uppercase tracking-[0.3em] text-brand-300">{{ eyebrow }}</div>
    <h2 class="section-title">{{ title }}</h2>
    <p v-if="description" class="section-subtitle">{{ description }}</p>
  </div>
</template>

<script setup>
defineProps({
  eyebrow: String,
  title: String,
  description: String,
});
</script>
