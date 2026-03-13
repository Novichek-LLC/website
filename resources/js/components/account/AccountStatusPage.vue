<template>
  <div class="space-y-4">
    <div
      v-for="service in services"
      :key="service.name"
      class="rounded-3xl border border-white/10 bg-white/5 p-5"
    >
      <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
          <div class="text-lg font-semibold">{{ service.name }}</div>
          <div class="mt-2 text-sm text-slate-400">{{ service.description }}</div>
        </div>

        <div class="flex items-center gap-4">
          <div class="text-sm text-slate-400">Uptime: {{ service.uptime }}</div>
          <span class="rounded-full bg-emerald-400/15 px-4 py-2 text-sm font-semibold text-emerald-300">
            {{ service.status }}
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
const services = [
  {
    name: 'Личный кабинет',
    description: 'Клиентский интерфейс и API доступа',
    uptime: '99.96%',
    status: 'Operational',
  },
  {
    name: 'Платёжный модуль',
    description: 'Выставление счетов и обработка оплат',
    uptime: '99.91%',
    status: 'Operational',
  },
  {
    name: 'Сервис уведомлений',
    description: 'Email и Telegram уведомления',
    uptime: '99.98%',
    status: 'Operational',
  },
]
</script>