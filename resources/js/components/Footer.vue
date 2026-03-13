<template>
  <footer class="border-t border-white/10 bg-[#0a1120]">
    <div class="mx-auto max-w-[1280px] px-4 py-14 sm:px-6 lg:px-8">
      <section class="mb-12 rounded-[28px] border border-white/10 bg-[linear-gradient(135deg,rgba(99,102,241,0.18),rgba(34,211,238,0.10))] p-6 md:p-8">
        <div class="grid gap-6 lg:grid-cols-[1fr_auto] lg:items-center">
          <div>
            <div class="text-xs uppercase tracking-[0.18em] text-slate-300/70">
              NOVICHEK
            </div>
            <h2 class="mt-3 text-2xl font-semibold text-white md:text-3xl">
              Соберём рабочую систему для бизнеса, digital-проекта или инфраструктуры
            </h2>
            <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-300/80">
              Если у вас уже есть хаос в процессах, заявках, 1С, маркировке, сайте,
              автоматизации или удалённой работе команды — разложим задачу по шагам и
              предложим понятный маршрут запуска.
            </p>
          </div>

          <div class="flex flex-wrap gap-3">
            <router-link to="/contacts" class="btn-primary">
              Обсудить проект
            </router-link>
            <router-link to="/services" class="btn-secondary">
              Посмотреть услуги
            </router-link>
          </div>
        </div>
      </section>

      <div class="grid gap-10 md:grid-cols-2 xl:grid-cols-5">
        <div class="xl:col-span-2">
          <div class="flex items-center gap-3">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-[#0a1120]">
              <span class="text-sm font-extrabold">N</span>
            </div>
            <div>
              <div class="text-[13px] font-bold uppercase tracking-[0.2em] text-white">
                ООО "НОВИЧЁК"
              </div>
              <div class="text-[11px] text-slate-400">
                Automation • Digital • Infrastructure
              </div>
            </div>
          </div>

          <p class="mt-5 max-w-md text-sm leading-7 text-slate-400">
            ООО "НОВИЧЁК" объединяет технические и digital-направления в единую систему услуг
            для бизнеса. Работаем на стыке 1С, маркировки, сайтов, автоматизации,
            инфраструктуры, дизайна, сопровождения и игровых серверов.
          </p>
        </div>

        <div>
          <div class="text-sm font-semibold text-white">Услуги</div>
          <div class="mt-4 space-y-3 text-sm text-slate-400">
            <router-link to="/services/1c" class="block hover:text-white">1С: установка и настройка</router-link>
            <router-link to="/services/marking" class="block hover:text-white">Маркировка товаров</router-link>
            <router-link to="/services/sites" class="block hover:text-white">Создание сайтов</router-link>
            <router-link to="/services/bots-automation" class="block hover:text-white">Чат-боты и автоматизация</router-link>
            <router-link to="/services/design" class="block hover:text-white">Дизайн</router-link>
            <router-link to="/services/vpn-infrastructure" class="block hover:text-white">VPN и инфраструктура</router-link>
            <router-link to="/services/music-distribution" class="block hover:text-white">Музыкальная дистрибуция</router-link>
            <router-link to="/services/sandblast" class="block hover:text-white">Пескоструйные работы</router-link>
            <router-link to="/services/support-integrations" class="block hover:text-white">Сопровождение и интеграции</router-link>
          </div>
        </div>

        <div>
          <div class="text-sm font-semibold text-white">Решения и материалы</div>
          <div class="mt-4 space-y-3 text-sm text-slate-400">
            <router-link to="/solutions" class="block hover:text-white">Все решения</router-link>
            <router-link to="/solutions/retail" class="block hover:text-white">Для ритейла</router-link>
            <router-link to="/solutions/business" class="block hover:text-white">Для бизнеса</router-link>
            <router-link to="/solutions/digital-teams" class="block hover:text-white">Для digital-команд</router-link>
            <router-link to="/solutions/remote-teams" class="block hover:text-white">Для удалённых команд</router-link>
            <router-link to="/cases" class="block hover:text-white">Кейсы</router-link>
            <router-link to="/blog" class="block hover:text-white">Блог</router-link>
            <router-link to="/faq" class="block hover:text-white">FAQ</router-link>
            <router-link to="/license-center" class="block hover:text-white">Центр лицензирования</router-link>
          </div>
        </div>

        <div>
          <div class="text-sm font-semibold text-white">Документы и контакты</div>

          <div class="mt-4 space-y-4 text-sm text-slate-400">
            <div>
              <div class="text-xs uppercase tracking-[0.14em] text-slate-500">ПРАВОВЫЕ ДОКУМЕНТЫ</div>
              <div class="mt-2 space-y-2">
                <router-link to="/documents" class="block text-slate-300 hover:text-white">Все документы</router-link>
                <router-link to="/offer" class="block hover:text-white">Публичная оферта</router-link>
                <router-link to="/privacy" class="block hover:text-white">Политика конфиденциальности</router-link>
                <router-link to="/consent-personal-data" class="block hover:text-white">Согласие на обработку персональных данных</router-link>
                <router-link to="/cookie-policy" class="block hover:text-white">Политика cookies</router-link>
                <router-link to="/requisites" class="block hover:text-white">Реквизиты компании</router-link>
              </div>
            </div>

            <div>
              <div class="text-xs uppercase tracking-[0.14em] text-slate-500">Связь</div>
              <div class="mt-2 leading-7">
                Основной канал — форма заявки на сайте<br />
                <router-link to="/contacts" class="text-slate-300 hover:text-white">
                  Перейти к контактам
                </router-link>
              </div>
            </div>
     </div>
   </div>
 </div>
      <div class="mt-10 border-t border-white/10 pt-6">
        <div class="flex flex-col gap-4 text-sm text-slate-500 lg:flex-row lg:items-center lg:justify-between">
          <div>
            © {{ year }} Общество с ограниченной ответственностью "НОВИЧЁК". Все права защищены.
          </div>

          <div class="flex flex-wrap items-center gap-4">
            <router-link to="/documents" class="hover:text-white">Документы</router-link>
            <router-link to="/offer" class="hover:text-white">Оферта</router-link>
            <router-link to="/privacy" class="hover:text-white">Конфиденциальность</router-link>
            <router-link to="/faq" class="hover:text-white">FAQ</router-link>
            <router-link to="/blog" class="hover:text-white">Блог</router-link>
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>

<script setup>
const year = new Date().getFullYear()
</script>