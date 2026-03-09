<template>
  <div>
    <header class="sticky top-0 z-40 border-b border-white/10 bg-slate-950/70 backdrop-blur-xl">
      <div class="container-shell flex h-20 items-center justify-between gap-6">
        <router-link to="/" class="flex items-center gap-3">
          <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-brand-500 font-bold text-white shadow-soft">Н</div>
          <div>
            <div class="text-sm font-semibold tracking-[0.2em] text-brand-300">NOVICHEK</div>
            <div class="text-xs text-slate-400">Digital • IT • Automation</div>
          </div>
        </router-link>

        <nav class="hidden items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-2 lg:flex">
          <router-link v-for="item in menu" :key="item.to" :to="item.to" class="rounded-full px-4 py-2 text-sm text-slate-300 transition hover:bg-white/10 hover:text-white">
            {{ item.label }}
          </router-link>
        </nav>

        <div class="flex items-center gap-3">
          <a href="#lead-form" class="btn-secondary hidden sm:inline-flex">Оставить заявку</a>
          <router-link to="/contacts" class="btn-primary">Связаться</router-link>
        </div>
      </div>
    </header>

    <main>
      <slot />
    </main>

    <footer class="mt-24 border-t border-white/10 py-10">
      <div class="container-shell grid gap-10 md:grid-cols-4">
        <div class="md:col-span-2">
          <div class="text-xl font-semibold">ООО «НОВИЧЁК»</div>
          <p class="mt-4 max-w-xl text-sm leading-7 text-slate-400">
            Комплексные digital- и IT-услуги: 1С, маркировка, музыкальный лейбл, пескоструйные работы,
            VPN, дизайн, сайты, чат-боты и автоматизация.
          </p>
        </div>
        <div>
          <div class="text-sm font-semibold text-white">Навигация</div>
          <div class="mt-4 space-y-3 text-sm text-slate-400">
            <router-link to="/services" class="block hover:text-white">Услуги</router-link>
            <router-link to="/cases" class="block hover:text-white">Кейсы</router-link>
            <router-link to="/pricing" class="block hover:text-white">Тарифы</router-link>
            <router-link to="/blog" class="block hover:text-white">Блог</router-link>
          </div>
        </div>
        <div>
          <div class="text-sm font-semibold text-white">Документы</div>
          <div class="mt-4 space-y-3 text-sm text-slate-400">
            <router-link to="/privacy" class="block hover:text-white">Политика</router-link>
            <router-link to="/offer" class="block hover:text-white">Оферта</router-link>
            <router-link to="/admin/chat" class="block hover:text-white">Админка чата</router-link>
          </div>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
const menu = [
  { label: 'Услуги', to: '/services' },
  { label: 'Кейсы', to: '/cases' },
  { label: 'Тарифы', to: '/pricing' },
  { label: 'О компании', to: '/about' },
  { label: 'Контакты', to: '/contacts' },
];
</script>
