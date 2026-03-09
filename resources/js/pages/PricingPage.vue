<template>
  <div class="container-shell pt-16">
    <SectionHeader eyebrow="Тарифы" title="Пакеты для быстрого старта и сложных внедрений" description="Стоимость можно адаптировать под реальные коммерческие предложения. Сейчас это дизайн-основа для упаковки услуг." />
    <div class="mt-10 grid gap-6 lg:grid-cols-3">
      <div class="grid-card">
        <div class="text-sm text-slate-400">Start</div>
        <div class="mt-4 text-4xl font-semibold">от 25 000 ₽</div>
        <ul class="mt-6 space-y-3 text-sm text-slate-300"><li>— Консультация и аудит</li><li>— Базовая настройка</li><li>— Поддержка запуска</li></ul>
      </div>
      <div class="grid-card border-brand-400/30 bg-brand-500/10">
        <div class="text-sm text-brand-200">Business</div>
        <div class="mt-4 text-4xl font-semibold">от 90 000 ₽</div>
        <ul class="mt-6 space-y-3 text-sm text-slate-100"><li>— Внедрение под ключ</li><li>— Интеграции и кастомизация</li><li>— Контроль качества и обучение</li></ul>
      </div>
      <div class="grid-card">
        <div class="text-sm text-slate-400">Enterprise</div>
        <div class="mt-4 text-4xl font-semibold">Индивидуально</div>
        <ul class="mt-6 space-y-3 text-sm text-slate-300"><li>— Большие проекты</li><li>— SLA и поддержка</li><li>— Развитие и аналитика</li></ul>
      </div>
    </div>
  </div>
</template>

<script setup>
import SectionHeader from '@/components/SectionHeader.vue';
</script>
