<template>
  <div class="min-h-screen bg-[#07111f] text-white">
    <div class="flex min-h-screen">
      <aside class="hidden w-[280px] shrink-0 border-r border-white/10 bg-[#0b1728] lg:flex lg:flex-col">
        <div class="border-b border-white/10 px-6 py-6">
          <div class="text-xs uppercase tracking-[0.35em] text-cyan-300/80">
            ООО «НОВИЧЁК»
          </div>
          <div class="mt-2 text-2xl font-semibold">
            Личный кабинет
          </div>
          <div class="mt-2 text-sm text-slate-400">
            Панель управления клиентскими проектами
          </div>
        </div>

        <nav class="flex-1 space-y-2 px-4 py-6">
          <RouterLink
            v-for="item in navItems"
            :key="item.to"
            :to="item.to"
            class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition"
            :class="isActive(item.to)
              ? 'bg-cyan-400/15 text-cyan-300 shadow-[0_0_0_1px_rgba(34,211,238,0.18)]'
              : 'text-slate-300 hover:bg-white/5 hover:text-white'"
          >
            <span class="inline-block h-2 w-2 rounded-full bg-current opacity-80"></span>
            <span>{{ item.label }}</span>
          </RouterLink>
        </nav>
      </aside>

      <div class="flex min-w-0 flex-1 flex-col">
        <header class="sticky top-0 z-20 border-b border-white/10 bg-[#07111f]/85 backdrop-blur">
          <div class="flex items-center justify-between gap-4 px-4 py-4 lg:px-8">
            <div>
              <div class="text-xs uppercase tracking-[0.3em] text-slate-500">
                Client control panel
              </div>
              <div class="mt-1 text-lg font-semibold lg:text-2xl">
                {{ pageTitle }}
              </div>
            </div>

            <div class="flex items-center gap-3 rounded-2xl border border-white/10 bg-white/5 px-3 py-2">
              <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-cyan-400/15 text-sm font-semibold text-cyan-300">
                ДН
              </div>
              <div class="hidden sm:block">
                <div class="text-sm font-medium">Данил</div>
                <div class="text-xs text-slate-400">Клиентский аккаунт</div>
              </div>
            </div>
          </div>
        </header>

        <main class="flex-1 px-4 py-6 lg:px-8 lg:py-8">
          <RouterView />
        </main>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()

const navItems = [
  { label: 'Дашборд', to: '/account' },
  { label: 'Проекты', to: '/account/projects' },
  { label: 'Биллинг', to: '/account/billing' },
  { label: 'Тикеты', to: '/account/tickets' },
  { label: 'Профиль', to: '/account/profile' },
  { label: 'Статус сервисов', to: '/account/status' },
]

const pageTitle = computed(() => {
  const map = {
    'account.dashboard': 'Обзор аккаунта',
    'account.projects': 'Мои проекты',
    'account.projects.show': 'Карточка проекта',
    'account.billing': 'Счета и оплаты',
    'account.tickets': 'Поддержка',
    'account.profile': 'Профиль клиента',
    'account.status': 'Статус сервисов',
  }

  return map[String(route.name)] || 'Личный кабинет'
})

function isActive(path) {
  if (path === '/account') {
    return route.path === '/account'
  }

  return route.path.startsWith(path)
}
</script>