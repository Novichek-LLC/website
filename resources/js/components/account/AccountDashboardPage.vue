<template>
  <div class="space-y-6">
    <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
      <div
        v-for="card in stats"
        :key="card.label"
        class="rounded-3xl border border-white/10 bg-white/5 p-5"
      >
        <div class="text-sm text-slate-400">{{ card.label }}</div>
        <div class="mt-4 text-3xl font-semibold">{{ card.value }}</div>
        <div class="mt-3 text-xs" :class="card.metaClass">{{ card.meta }}</div>
      </div>
    </section>

    <section class="grid gap-6 xl:grid-cols-[1.5fr_1fr]">
      <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
        <div class="mb-4 flex items-center justify-between">
          <div>
            <div class="text-lg font-semibold">Мои проекты</div>
            <div class="text-sm text-slate-400">Последние активные проекты клиента</div>
          </div>

          <RouterLink
            to="/account/projects"
            class="rounded-xl border border-white/10 px-4 py-2 text-sm text-slate-300 transition hover:bg-white/5 hover:text-white"
          >
            Все проекты
          </RouterLink>
        </div>

        <div class="space-y-3">
          <div
            v-for="project in projects"
            :key="project.slug"
            class="flex items-center justify-between rounded-2xl border border-white/10 bg-white/5 px-4 py-4"
          >
            <div>
              <div class="font-medium">{{ project.name }}</div>
              <div class="mt-1 text-sm text-slate-400">{{ project.type }}</div>
            </div>

            <RouterLink
              :to="`/account/projects/${project.slug}`"
              class="rounded-xl bg-cyan-400 px-4 py-2 text-sm font-semibold text-slate-950"
            >
              Открыть
            </RouterLink>
          </div>
        </div>
      </div>

      <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
        <div class="text-lg font-semibold">Быстрые действия</div>

        <div class="mt-4 grid gap-3">
          <RouterLink
            to="/account/tickets"
            class="rounded-2xl border border-white/10 bg-white/5 px-4 py-4 text-sm text-slate-200 transition hover:bg-white/10"
          >
            Создать обращение
          </RouterLink>

          <RouterLink
            to="/account/billing"
            class="rounded-2xl border border-white/10 bg-white/5 px-4 py-4 text-sm text-slate-200 transition hover:bg-white/10"
          >
            Посмотреть счета
          </RouterLink>

          <RouterLink
            to="/account/profile"
            class="rounded-2xl border border-white/10 bg-white/5 px-4 py-4 text-sm text-slate-200 transition hover:bg-white/10"
          >
            Открыть профиль
          </RouterLink>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
const stats = [
  {
    label: 'Активные проекты',
    value: '06',
    meta: '+1 за месяц',
    metaClass: 'text-emerald-300',
  },
  {
    label: 'Открытые тикеты',
    value: '03',
    meta: '1 требует ответа',
    metaClass: 'text-amber-300',
  },
  {
    label: 'Неоплаченные счета',
    value: '02',
    meta: 'до 25 марта',
    metaClass: 'text-rose-300',
  },
  {
    label: 'Uptime сервисов',
    value: '99.96%',
    meta: 'стабильно',
    metaClass: 'text-cyan-300',
  },
]

const projects = [
  {
    slug: 'crm-platform',
    name: 'CRM Platform',
    type: 'Корпоративный проект',
  },
  {
    slug: 'support-portal',
    name: 'Support Portal',
    type: 'Портал поддержки',
  },
  {
    slug: 'client-cabinet',
    name: 'Client Cabinet',
    type: 'Личный кабинет',
  },
]
</script>