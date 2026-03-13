<template>
  <div class="grid gap-6 xl:grid-cols-[1.1fr_1fr]">
    <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
      <div class="mb-4 text-lg font-semibold">Мои тикеты</div>
      <div class="space-y-3">
        <div
          v-for="ticket in tickets"
          :key="ticket.id"
          class="rounded-2xl border border-white/10 bg-white/5 p-4"
        >
          <div class="flex items-center justify-between gap-3">
            <div class="font-medium">#{{ ticket.id }} — {{ ticket.subject }}</div>
            <span class="rounded-full px-3 py-1 text-xs font-semibold" :class="ticket.statusClass">
              {{ ticket.status }}
            </span>
          </div>
          <div class="mt-2 text-sm text-slate-400">{{ ticket.preview }}</div>
        </div>
      </div>
    </div>

    <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
      <div class="mb-4 text-lg font-semibold">Новый тикет</div>
      <form class="space-y-4">
        <input
          type="text"
          placeholder="Тема обращения"
          class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none placeholder:text-slate-500"
        >
        <textarea
          rows="6"
          placeholder="Опишите проблему или задачу"
          class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none placeholder:text-slate-500"
        />
        <button
          type="button"
          class="rounded-xl bg-cyan-400 px-5 py-3 text-sm font-semibold text-slate-950"
        >
          Отправить тикет
        </button>
      </form>
    </div>
  </div>
</template>

<script setup>
const tickets = [
  {
    id: 101,
    subject: 'Вопрос по выставленному счёту',
    preview: 'Нужно уточнить состав услуг за мартовский период.',
    status: 'new',
    statusClass: 'bg-cyan-400/15 text-cyan-300',
  },
  {
    id: 104,
    subject: 'Доступ к модулю аналитики',
    preview: 'Ожидаем обновление прав для менеджеров проекта.',
    status: 'in_progress',
    statusClass: 'bg-amber-400/15 text-amber-300',
  },
]
</script>