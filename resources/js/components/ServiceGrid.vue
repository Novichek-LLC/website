<template>
  <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
    <router-link
      v-for="service in services"
      :key="service.slug"
      :to="`/services/${service.slug}`"
      class="grid-card group"
    >
      <div class="flex items-start justify-between gap-4">
        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-500/15 text-2xl text-brand-300">{{ service.icon }}</div>
        <div class="rounded-full border border-white/10 px-3 py-1 text-xs text-slate-400 transition group-hover:text-white">Подробнее</div>
      </div>
      <h3 class="mt-6 text-xl font-semibold text-white">{{ service.title }}</h3>
      <p class="mt-3 text-sm leading-7 text-slate-400">{{ service.teaser }}</p>
      <ul class="mt-5 space-y-2 text-sm text-slate-300">
        <li v-for="bullet in service.bullets" :key="bullet">— {{ bullet }}</li>
      </ul>
    </router-link>
  </div>
</template>

<script setup>
defineProps({ services: Array });
</script>
