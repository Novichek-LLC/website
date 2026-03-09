<template>
  <div>
    <section class="container-shell pt-14 md:pt-20">
      <div class="grid items-center gap-8 lg:grid-cols-[1.2fr,0.8fr]">
        <div>
          <div class="inline-flex rounded-full border border-brand-400/30 bg-brand-500/10 px-4 py-2 text-sm text-brand-200">
            IT, digital и автоматизация для бизнеса
          </div>
          <h1 class="mt-6 max-w-4xl text-5xl font-semibold tracking-tight md:text-7xl">
            Современный сайт и сильные сервисные страницы для <span class="text-brand-300">ООО «НОВИЧЁК»</span>
          </h1>
          <p class="mt-6 max-w-3xl text-lg leading-8 text-slate-300">
            Помогаем компаниям автоматизировать процессы, запускать сайты, внедрять 1С, маркировку,
            выстраивать цифровую инфраструктуру и продавать услуги через понятный, дорогой интерфейс.
          </p>
          <div class="mt-8 flex flex-wrap gap-4">
            <router-link to="/services" class="btn-primary">Смотреть услуги</router-link>
            <router-link to="/cases" class="btn-secondary">Кейсы и результаты</router-link>
          </div>
          <div class="mt-10 grid gap-4 sm:grid-cols-3">
            <div class="grid-card"><div class="text-3xl font-semibold">9+</div><div class="mt-2 text-sm text-slate-400">Ключевых направлений</div></div>
            <div class="grid-card"><div class="text-3xl font-semibold">24/7</div><div class="mt-2 text-sm text-slate-400">Поддержка и коммуникация</div></div>
            <div class="grid-card"><div class="text-3xl font-semibold">B2B</div><div class="mt-2 text-sm text-slate-400">Фокус на бизнес-задачах</div></div>
          </div>
        </div>
        <div class="glass rounded-4xl p-6">
          <div class="rounded-3xl border border-white/10 bg-slate-950/80 p-6">
            <div class="flex items-center justify-between text-sm text-slate-400">
              <span>Панель роста</span>
              <span>v1.0</span>
            </div>
            <div class="mt-6 space-y-4">
              <div class="rounded-3xl bg-white/5 p-4">
                <div class="text-sm text-slate-400">Лидогенерация</div>
                <div class="mt-2 text-2xl font-semibold">Сайт + чат + формы + CRM</div>
              </div>
              <div class="rounded-3xl bg-white/5 p-4">
                <div class="text-sm text-slate-400">Технический контур</div>
                <div class="mt-2 text-2xl font-semibold">1С • Маркировка • VPN • Автоматизация</div>
              </div>
              <div class="rounded-3xl bg-white/5 p-4">
                <div class="text-sm text-slate-400">Креативный блок</div>
                <div class="mt-2 text-2xl font-semibold">Дизайн • Сайты • Музыкальный лейбл</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="container-shell mt-24">
      <SectionHeader eyebrow="Услуги" title="Все направления упакованы в сильные продающие страницы" description="Каждая страница спроектирована как самостоятельная точка входа для SEO, рекламы и прямых заявок." />
      <div class="mt-10">
        <ServiceGrid :services="services" />
      </div>
    </section>

    <section class="container-shell mt-24">
      <SectionHeader eyebrow="Почему мы" title="Нормальная бизнес-логика, а не просто красивый экран" description="Проект совмещает презентационный слой, лидогенерацию и основу под внутренние процессы." />
      <div class="mt-10 grid gap-6 lg:grid-cols-3">
        <div class="grid-card"><h3 class="text-xl font-semibold">Архитектура продаж</h3><p class="mt-4 text-sm leading-7 text-slate-400">CTA, формы, квизы, чат-виджет, пакеты услуг и прогрев через кейсы.</p></div>
        <div class="grid-card"><h3 class="text-xl font-semibold">Технологическая база</h3><p class="mt-4 text-sm leading-7 text-slate-400">Laravel API, Vue SPA, Tailwind-дизайн система и расширяемая админка.</p></div>
        <div class="grid-card"><h3 class="text-xl font-semibold">Реальная польза</h3><p class="mt-4 text-sm leading-7 text-slate-400">Чат, лиды, документы, контентные страницы и фундамент под SEO и автоматизацию.</p></div>
      </div>
    </section>

    <section class="container-shell mt-24">
      <SectionHeader eyebrow="Отзывы" title="Что ценят клиенты" description="Формулировки-заглушки, которые можно заменить на реальные отзывы и логотипы." />
      <div class="mt-10 grid gap-6 lg:grid-cols-3">
        <div v-for="item in testimonials" :key="item.company" class="grid-card">
          <div class="text-lg font-semibold">{{ item.company }}</div>
          <p class="mt-4 text-sm leading-7 text-slate-400">{{ item.text }}</p>
        </div>
      </div>
    </section>

    <LeadForm />
  </div>
</template>

<script setup>
import SectionHeader from '@/components/SectionHeader.vue';
import ServiceGrid from '@/components/ServiceGrid.vue';
import LeadForm from '@/components/LeadForm.vue';
import { services, testimonials } from '@/data';
</script>
