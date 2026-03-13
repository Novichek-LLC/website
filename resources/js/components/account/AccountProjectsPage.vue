<template>
  <div class="space-y-6">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
      <div>
        <h1 class="text-2xl font-semibold">Мои проекты</h1>
        <p class="mt-2 text-sm text-slate-400">
          Управление проектами, текущими статусами и клиентской документацией.
        </p>
      </div>

      <div class="flex flex-col gap-3 sm:flex-row">
        <input
          v-model="search"
          type="text"
          placeholder="Поиск проекта..."
          class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none placeholder:text-slate-500 focus:border-cyan-400/40 sm:w-[260px]"
        >
        <select
          v-model="status"
          class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none focus:border-cyan-400/40"
        >
          <option value="">Все статусы</option>
          <option value="active">Активен</option>
          <option value="warning">Требует внимания</option>
          <option value="paused">Приостановлен</option>
        </select>
      </div>
    </div>

    <div class="grid gap-4 xl:grid-cols-2">
      <div
        v-for="project in filteredProjects"
        :key="project.slug"
        class="rounded-3xl border border-white/10 bg-white/5 p-5"
      >
        <div class="flex items-start justify-between gap-4">
          <div>
            <div class="text-lg font-semibold">{{ project.name }}</div>
            <div class="mt-1 text-sm text-slate-400">{{ project.type }}</div>
          </div>

          <span class="rounded-full px-3 py-1 text-xs font-semibold" :class="statusClass(project.status)">
            {{ project.statusLabel }}
          </span>
        </div>

        <div class="mt-5 grid gap-3 sm:grid-cols-3">
          <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
            <div class="text-xs uppercase tracking-[0.2em] text-slate-500">Тариф</div>
            <div class="mt-2 font-medium">{{ project.plan }}</div>
          </div>
          <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
            <div class="text-xs uppercase tracking-[0.2em] text-slate-500">Продление</div>
            <div class="mt-2 font-medium">{{ project.renewal_at }}</div>
          </div>
          <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
            <div class="text-xs uppercase tracking-[0.2em] text-slate-500">Ответственный</div>
            <div class="mt-2 font-medium">{{ project.manager }}</div>
          </div>
        </div>

        <div class="mt-5 flex flex-wrap gap-3">
          <RouterLink
            :to="`/account/projects/${project.slug}`"
            class="rounded-xl bg-cyan-400 px-4 py-2 text-sm font-semibold text-slate-950"
          >
            Открыть карточку
          </RouterLink>
          <RouterLink
            to="/account/tickets"
            class="rounded-xl border border-white/10 px-4 py-2 text-sm text-slate-300"
          >
            Написать в поддержку
          </RouterLink>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue'

const search = ref('')
const status = ref('')

const projects = ref([
  {
    slug: 'crm-platform',
    name: 'CRM Platform',
    type: 'Корпоративный проект',
    status: 'active',
    statusLabel: 'Активен',
    plan: 'Business',
    renewal_at: '28 марта 2026',
    manager: 'Ирина',
  },
  {
    slug: 'client-cabinet',
    name: 'Client Cabinet',
    type: 'Личный кабинет',
    status: 'warning',
    statusLabel: 'Требует внимания',
    plan: 'Enterprise',
    renewal_at: '20 марта 2026',
    manager: 'Дмитрий',
  },
  {
    slug: 'knowledge-base',
    name: 'Knowledge Base',
    type: 'База знаний',
    status: 'paused',
    statusLabel: 'Приостановлен',
    plan: 'Standard',
    renewal_at: '15 апреля 2026',
    manager: 'Анна',
  },
])

const filteredProjects = computed(() => {
  return projects.value.filter((project) => {
    const matchSearch = `${project.name} ${project.type}`
      .toLowerCase()
      .includes(search.value.toLowerCase())

    const matchStatus = status.value ? project.status === status.value : true

    return matchSearch && matchStatus
  })
})

function statusClass(value) {
  if (value === 'active') {
    return 'bg-emerald-400/15 text-emerald-300'
  }

  if (value === 'warning') {
    return 'bg-amber-400/15 text-amber-300'
  }

  return 'bg-slate-400/15 text-slate-300'
}
</script>