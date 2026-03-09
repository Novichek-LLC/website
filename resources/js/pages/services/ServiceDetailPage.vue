<template>
  <div class="container-shell pt-16" v-if="service">
    <div class="glass rounded-4xl p-8 md:p-10">
      <div class="flex flex-wrap items-start justify-between gap-6">
        <div class="max-w-4xl">
          <div class="text-sm font-semibold uppercase tracking-[0.3em] text-brand-300">Услуга</div>
          <h1 class="mt-4 text-4xl font-semibold md:text-6xl">{{ service.title }}</h1>
          <p class="mt-6 max-w-3xl text-lg leading-8 text-slate-300">{{ description }}</p>
        </div>
        <div class="flex h-20 w-20 items-center justify-center rounded-3xl bg-brand-500/15 text-4xl text-brand-300">{{ service.icon }}</div>
      </div>

      <div class="mt-10 grid gap-6 lg:grid-cols-3">
        <div class="grid-card"><div class="text-sm text-slate-400">Что делаем</div><ul class="mt-4 space-y-3 text-sm text-slate-200"><li v-for="bullet in service.bullets" :key="bullet">— {{ bullet }}</li></ul></div>
        <div class="grid-card"><div class="text-sm text-slate-400">Для кого</div><p class="mt-4 text-sm leading-7 text-slate-200">Малый и средний бизнес, торговля, услуги, производство, digital-команды, артисты и проектные компании.</p></div>
        <div class="grid-card"><div class="text-sm text-slate-400">Результат</div><p class="mt-4 text-sm leading-7 text-slate-200">Быстрое внедрение, понятный процесс работ, прозрачная коммуникация и цифровая база для роста.</p></div>
      </div>
    </div>

    <section class="mt-16 grid gap-6 lg:grid-cols-2">
      <div class="grid-card">
        <h2 class="text-2xl font-semibold">Как строится работа</h2>
        <ol class="mt-6 space-y-4 text-sm leading-7 text-slate-300">
          <li>1. Бриф, аудит и фиксация задачи.</li>
          <li>2. Проектирование решения и согласование этапов.</li>
          <li>3. Реализация, тестирование и запуск.</li>
          <li>4. Поддержка, улучшения и масштабирование.</li>
        </ol>
      </div>
      <div class="grid-card">
        <h2 class="text-2xl font-semibold">Что усилить дальше</h2>
        <p class="mt-6 text-sm leading-7 text-slate-300">
          На этой странице можно добавить FAQ, тарифы по направлению, отраслевые кейсы, сертификаты,
          SEO-блоки, фото работ и калькулятор стоимости.
        </p>
      </div>
    </section>

    <LeadForm />
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { services } from '@/data';
import LeadForm from '@/components/LeadForm.vue';

const props = defineProps({ slug: String });
const service = computed(() => services.find((item) => item.slug === props.slug));
const description = computed(() => service.value?.teaser || '');
</script>
