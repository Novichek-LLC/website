<template>
  <div class="container-shell pt-16">
    <SectionHeader eyebrow="Блог" title="Контент-хаб для SEO и экспертного прогрева" description="Здесь можно публиковать статьи по 1С, маркировке, автоматизации, сайтам, чат-ботам и музыкальной дистрибуции." />
    <div class="mt-10 grid gap-6 lg:grid-cols-3">
      <div class="grid-card"><h3 class="text-xl font-semibold">Как подготовиться к маркировке</h3><p class="mt-4 text-sm text-slate-400">Чек-лист для торговых компаний.</p></div>
      <div class="grid-card"><h3 class="text-xl font-semibold">Когда бизнесу нужен чат-бот</h3><p class="mt-4 text-sm text-slate-400">Где бот реально экономит время менеджеров.</p></div>
      <div class="grid-card"><h3 class="text-xl font-semibold">Сайт как инфраструктура продаж</h3><p class="mt-4 text-sm text-slate-400">Почему одного лендинга чаще всего недостаточно.</p></div>
    </div>
  </div>
</template>

<script setup>
import SectionHeader from '@/components/SectionHeader.vue';
</script>
