<template>
  <footer class="border-t border-white/10 bg-[#0a1120]">
    <div class="mx-auto max-w-[1240px] px-4 py-14 sm:px-6 lg:px-8">
      <div class="grid gap-10 md:grid-cols-2 xl:grid-cols-4">
        <div>
          <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-[#0a1120]">
              <span class="text-sm font-extrabold">N</span>
            </div>
            <div>
              <div class="text-[13px] font-bold uppercase tracking-[0.2em] text-white">NOVICHEK</div>
              <div class="text-[11px] text-slate-400">Automation & Digital</div>
            </div>
          </div>

          <p class="mt-5 max-w-sm text-sm leading-7 text-slate-400">
            Внедрение 1С, маркировка, сайты, чат-боты, дизайн, VPN, автоматизация и digital-сопровождение бизнеса.
          </p>
        </div>

        <div>
          <div class="text-sm font-semibold text-white">Услуги</div>
          <div class="mt-4 space-y-3 text-sm text-slate-400">
            <router-link to="/services/1c" class="block hover:text-white">1С</router-link>
            <router-link to="/services/marking" class="block hover:text-white">Маркировка</router-link>
            <router-link to="/services/sites" class="block hover:text-white">Сайты</router-link>
            <router-link to="/services/bots" class="block hover:text-white">Чат-боты</router-link>
          </div>
        </div>

        <div>
          <div class="text-sm font-semibold text-white">Компания</div>
          <div class="mt-4 space-y-3 text-sm text-slate-400">
            <router-link to="/about" class="block hover:text-white">О компании</router-link>
            <router-link to="/cases" class="block hover:text-white">Кейсы</router-link>
            <router-link to="/blog" class="block hover:text-white">Блог</router-link>
            <router-link to="/contacts" class="block hover:text-white">Контакты</router-link>
            <router-link to="/faq" class="block hover:text-white">FAQ</router-link>
          </div>
        </div>

        <div>
          <div class="text-sm font-semibold text-white">Контакты</div>
          <div class="mt-4 space-y-3 text-sm text-slate-400">
            <div>novichek.su</div>
            <div>info@novichek.su</div>
            <div>Telegram: @novichek</div>
          </div>
        </div>
      </div>

      <div class="mt-10 border-t border-white/10 pt-6 text-sm text-slate-500">
        © 2026 NOVICHEK. Все права защищены.
      </div>
    </div>
  </footer>
</template>