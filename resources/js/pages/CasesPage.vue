<template>
  <div class="container-shell pt-16">
    <SectionHeader eyebrow="Кейсы" title="Результаты, которые можно превратить в доверие и сделки" description="Этот блок усиливает коммерческую подачу: показывает, что компания решает не абстрактные, а прикладные задачи." />
    <div class="mt-10 grid gap-6 lg:grid-cols-3">
      <div v-for="item in cases" :key="item.title" class="grid-card">
        <h3 class="text-xl font-semibold">{{ item.title }}</h3>
        <p class="mt-4 text-sm leading-7 text-slate-400">{{ item.result }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import SectionHeader from '@/components/SectionHeader.vue';
import { cases } from '@/data';
</script>
