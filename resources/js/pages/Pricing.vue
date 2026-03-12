<template>
  <section class="space-y-8">
    <SectionHeader title="Тарифы и план запуска" text="Выберите формат сотрудничества: от точечной задачи до полного аутсорса IT-процессов." />

    <div class="grid gap-4 md:grid-cols-3">
      <div class="card p-6">
        <div class="text-lg font-semibold">Start</div>
        <div class="mt-2 text-3xl font-bold">от 90 000 ₽</div>
        <p class="mt-4 text-sm text-slate-400">Базовый запуск: сайт или конкретная услуга без сложных интеграций.</p>
      </div>

      <div class="card border-indigo-500/40 p-6">
        <div class="text-lg font-semibold">Business</div>
        <div class="mt-2 text-3xl font-bold">от 220 000 ₽</div>
        <p class="mt-4 text-sm text-slate-400">Комплексный контур: CRM, интеграции, аналитика, чат, контент и процессы.</p>
      </div>

      <div class="card p-6">
        <div class="text-lg font-semibold">Enterprise</div>
        <div class="mt-2 text-3xl font-bold">по запросу</div>
        <p class="mt-4 text-sm text-slate-400">Индивидуальная архитектура, регламенты, SLA и выделенная команда.</p>
      </div>
    </div>

    <EstimatorWidget />
  </section>
</template>

<script setup>
import SectionHeader from "../components/SectionHeader.vue"
import EstimatorWidget from "../components/EstimatorWidget.vue"
</script>
