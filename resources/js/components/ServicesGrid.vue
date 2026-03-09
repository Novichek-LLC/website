<template>
  <section>
    <div class="mb-8 flex items-end justify-between">
      <div><h2 class="section-title">Ключевые направления</h2><p class="muted mt-3">Комплексные услуги для операционной эффективности и роста.</p></div>
      <router-link class="btn-secondary hidden md:inline-flex" to="/services">Все услуги</router-link>
    </div>
    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
      <router-link v-for="item in items" :key="item.to" :to="item.to" class="card p-6 transition hover:-translate-y-1 hover:border-indigo-500/40">
        <div class="text-lg font-semibold">{{ item.title }}</div>
        <p class="mt-3 text-sm text-slate-400">{{ item.text }}</p>
      </router-link>
    </div>
  </section>
</template>
<script setup>
const items = [
  { title: '1С', text: 'Внедрение, настройка, обновление, интеграции.', to: '/services/1c' },
  { title: 'Маркировка', text: 'Контур.Маркировка, честный знак, товарный учёт.', to: '/services/marking' },
  { title: 'Сайты', text: 'Laravel + Vue, корпоративные сайты и SaaS интерфейсы.', to: '/services/sites' },
  { title: 'Чат-боты', text: 'Telegram-боты, автоворонки, интеграции с CRM.', to: '/services/bots' },
  { title: 'Автоматизация', text: 'CRM-процессы, API, кабинет оператора и аналитика.', to: '/services/automation' },
  { title: 'Дизайн', text: 'UI/UX, бренд-лендинги, контент и визуальная система.', to: '/services/design' }
]
</script>
