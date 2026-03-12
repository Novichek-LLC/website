<template>
  <section class="space-y-8">
    <div class="card p-7 md:p-10">
      <p class="text-xs uppercase tracking-[0.16em] text-slate-500">Решение для сегмента</p>
      <h1 class="mt-2 text-3xl font-semibold text-white md:text-4xl">{{ title }}</h1>
      <p class="muted mt-4 max-w-3xl text-base leading-8">{{ description }}</p>

      <div class="mt-6 grid gap-3 sm:grid-cols-2">
        <div v-for="benefit in benefits" :key="benefit" class="rounded-2xl border border-white/10 bg-white/[0.03] p-4 text-sm text-slate-200">
          {{ benefit }}
        </div>
      </div>

      <router-link
        class="btn-primary mt-6"
        :to="{ path: '/contacts', query: { service, message: `Нужна консультация по направлению: ${title}` } }"
      >
        Запросить решение
      </router-link>
    </div>

    <div class="grid gap-4 md:grid-cols-3">
      <div v-for="(step, index) in steps" :key="step.title" class="card p-5">
        <div class="text-sm text-slate-500">Этап {{ index + 1 }}</div>
        <div class="mt-1 font-semibold text-white">{{ step.title }}</div>
        <div class="mt-2 text-sm leading-7 text-slate-400">{{ step.text }}</div>
      </div>
    </div>

    <EstimatorWidget />
  </section>
</template>

<script setup>
import EstimatorWidget from '../EstimatorWidget.vue'

defineProps({
  title: { type: String, required: true },
  description: { type: String, required: true },
  service: { type: String, required: true },
  benefits: { type: Array, required: true },
  steps: { type: Array, required: true },
})
</script>
