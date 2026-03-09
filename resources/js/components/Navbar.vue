<template>
  <header class="sticky top-0 z-40 border-b border-slate-800/80 bg-slate-950/80 backdrop-blur">
    <div class="container-page flex items-center justify-between py-4">
      <router-link to="/" class="text-xl font-bold tracking-tight">NOVICHEK</router-link>
      <nav class="hidden md:flex items-center gap-6 text-sm text-slate-300">
        <router-link to="/">Главная</router-link>
        <router-link to="/services">Услуги</router-link>
        <router-link to="/cases">Кейсы</router-link>
        <router-link to="/blog">Блог</router-link>
        <router-link to="/pricing">Тарифы</router-link>
        <router-link to="/contacts">Контакты</router-link>
      </nav>
      <div class="flex items-center gap-3">
        <router-link class="btn-secondary hidden md:inline-flex" to="/admin/dashboard">Админка</router-link>
        <router-link class="btn-primary" to="/contacts">Оставить заявку</router-link>
      </div>
    </div>
  </header>
</template>
