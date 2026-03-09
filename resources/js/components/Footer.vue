<template>
  <footer class="mt-20 border-t border-slate-800">
    <div class="container-page grid gap-8 py-10 md:grid-cols-4">
      <div><div class="text-lg font-semibold">NOVICHEK</div><p class="mt-3 text-sm text-slate-400">Автоматизация, 1С, маркировка, сайты, чат-боты и digital для бизнеса.</p></div>
      <div><div class="font-semibold">Услуги</div><ul class="mt-3 space-y-2 text-sm text-slate-400"><li><router-link to="/services/1c">1С</router-link></li><li><router-link to="/services/marking">Маркировка</router-link></li><li><router-link to="/services/sites">Сайты</router-link></li><li><router-link to="/services/automation">Автоматизация</router-link></li></ul></div>
      <div><div class="font-semibold">Компания</div><ul class="mt-3 space-y-2 text-sm text-slate-400"><li><router-link to="/about">О нас</router-link></li><li><router-link to="/cases">Кейсы</router-link></li><li><router-link to="/blog">Блог</router-link></li></ul></div>
      <div><div class="font-semibold">Документы</div><ul class="mt-3 space-y-2 text-sm text-slate-400"><li><router-link to="/privacy">Политика конфиденциальности</router-link></li><li><router-link to="/offer">Публичная оферта</router-link></li></ul></div>
    </div>
  </footer>
</template>
