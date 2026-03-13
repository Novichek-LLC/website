<template>
  <div class="space-y-6">
    <div class="grid gap-4 md:grid-cols-3">
      <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
        <div class="text-sm text-slate-400">Текущий баланс</div>
        <div class="mt-3 text-3xl font-semibold">24 500 ₽</div>
      </div>
      <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
        <div class="text-sm text-slate-400">К оплате</div>
        <div class="mt-3 text-3xl font-semibold">7 900 ₽</div>
      </div>
      <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
        <div class="text-sm text-slate-400">Последняя транзакция</div>
        <div class="mt-3 text-3xl font-semibold">12 000 ₽</div>
      </div>
    </div>

    <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
      <div class="mb-4 text-lg font-semibold">Счета</div>
      <div class="space-y-3">
        <div
          v-for="invoice in invoices"
          :key="invoice.id"
          class="flex flex-col gap-3 rounded-2xl border border-white/10 bg-white/5 p-4 md:flex-row md:items-center md:justify-between"
        >
          <div>
            <div class="font-medium">#{{ invoice.id }} — {{ invoice.title }}</div>
            <div class="mt-1 text-sm text-slate-400">Срок оплаты: {{ invoice.dueAt }}</div>
          </div>
          <div class="flex items-center gap-3">
            <span class="rounded-full px-3 py-1 text-xs font-semibold" :class="invoice.statusClass">
              {{ invoice.status }}
            </span>
            <span class="font-semibold">{{ invoice.amount }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
const invoices = [
  {
    id: 2041,
    title: 'Enterprise plan / март',
    dueAt: '25 марта 2026',
    amount: '7 900 ₽',
    status: 'Ожидает оплаты',
    statusClass: 'bg-amber-400/15 text-amber-300',
  },
  {
    id: 2035,
    title: 'Сопровождение / февраль',
    dueAt: '28 февраля 2026',
    amount: '12 000 ₽',
    status: 'Оплачен',
    statusClass: 'bg-emerald-400/15 text-emerald-300',
  },
]
</script>