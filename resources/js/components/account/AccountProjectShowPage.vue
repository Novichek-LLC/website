<template>
  <div class="space-y-6">
    <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
      <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
          <div class="text-sm text-slate-400">Карточка проекта</div>
          <h1 class="mt-2 text-3xl font-semibold">{{ project.name }}</h1>
          <div class="mt-2 text-sm text-slate-400">{{ project.description }}</div>
        </div>

        <div class="flex flex-wrap gap-3">
          <span class="rounded-full bg-emerald-400/15 px-4 py-2 text-sm font-semibold text-emerald-300">
            {{ project.status }}
          </span>
          <button class="rounded-xl bg-cyan-400 px-4 py-2 text-sm font-semibold text-slate-950">
            Оплатить
          </button>
        </div>
      </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-[1.35fr_1fr]">
      <div class="space-y-6">
        <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
          <div class="mb-4 text-lg font-semibold">Основная информация</div>
          <div class="grid gap-4 md:grid-cols-2">
            <InfoCard label="Тариф" :value="project.plan" />
            <InfoCard label="Дата продления" :value="project.renewalAt" />
            <InfoCard label="Ответственный менеджер" :value="project.manager" />
            <InfoCard label="Среда" :value="project.environment" />
          </div>
        </div>

        <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
          <div class="mb-4 text-lg font-semibold">История действий</div>
          <div class="space-y-3">
            <div
              v-for="event in project.timeline"
              :key="event.title"
              class="rounded-2xl border border-white/10 bg-white/5 p-4"
            >
              <div class="font-medium">{{ event.title }}</div>
              <div class="mt-1 text-sm text-slate-400">{{ event.date }}</div>
            </div>
          </div>
        </div>
      </div>

      <div class="space-y-6">
        <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
          <div class="mb-4 text-lg font-semibold">Документы</div>
          <div class="space-y-3">
            <a
              v-for="doc in project.documents"
              :key="doc.name"
              href="#"
              class="block rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-slate-300 transition hover:bg-white/10 hover:text-white"
            >
              {{ doc.name }}
            </a>
          </div>
        </div>

        <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
          <div class="mb-4 text-lg font-semibold">Быстрые действия</div>
          <div class="grid gap-3">
            <RouterLink
              to="/account/tickets"
              class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-slate-300"
            >
              Создать тикет по проекту
            </RouterLink>
            <RouterLink
              to="/account/billing"
              class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-slate-300"
            >
              Открыть биллинг
            </RouterLink>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import InfoCard from '../../components/account/InfoCard.vue'

const project = {
  name: 'Client Cabinet',
  description: 'Личный кабинет клиента с интеграцией биллинга, поддержки и проектного трекинга.',
  status: 'Активен',
  plan: 'Enterprise',
  renewalAt: '20 марта 2026',
  manager: 'Дмитрий',
  environment: 'Production',
  timeline: [
    { title: 'Обновлён модуль оплаты', date: '11 марта 2026' },
    { title: 'Проведено резервное копирование', date: '09 марта 2026' },
    { title: 'Подключены Telegram-уведомления', date: '06 марта 2026' },
  ],
  documents: [
    { name: 'Договор.pdf' },
    { name: 'Акт_март_2026.pdf' },
    { name: 'Счет_Enterprise.pdf' },
  ],
}
</script>