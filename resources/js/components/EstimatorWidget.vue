<template>
  <section class="card p-6 md:p-8">
    <div class="flex flex-wrap items-end justify-between gap-4">
      <div>
        <h3 class="text-2xl font-semibold text-white">Калькулятор проекта</h3>
        <p class="muted mt-2 text-sm">Оцените бюджет и сроки за 30 секунд.</p>
      </div>
      <div class="rounded-xl border border-indigo-400/30 bg-indigo-500/10 px-4 py-2 text-sm font-medium text-indigo-200">
        {{ packageTitle }}
      </div>
    </div>

    <div class="mt-6 grid gap-4 md:grid-cols-2">
      <label class="text-sm text-slate-300">
        Тип проекта
        <select v-model="state.projectType" class="input mt-2">
          <option value="website">Корпоративный сайт / лендинг</option>
          <option value="automation">Автоматизация и CRM</option>
          <option value="hybrid">Сайт + автоматизация + интеграции</option>
        </select>
      </label>

      <label class="text-sm text-slate-300">
        Нагрузка (сотрудники / пользователи)
        <input v-model.number="state.users" type="number" min="1" max="1000" class="input mt-2" />
      </label>

      <label class="text-sm text-slate-300">
        Нужна интеграция с 1С
        <select v-model="state.has1C" class="input mt-2">
          <option :value="true">Да</option>
          <option :value="false">Нет</option>
        </select>
      </label>

      <label class="text-sm text-slate-300">
        Срочность
        <select v-model="state.urgency" class="input mt-2">
          <option value="normal">Стандартный запуск</option>
          <option value="fast">Ускоренный запуск</option>
        </select>
      </label>
    </div>

    <div class="mt-6 grid gap-4 md:grid-cols-3">
      <div class="rounded-2xl border border-white/10 bg-white/[0.02] p-4">
        <div class="text-xs uppercase tracking-wider text-slate-500">Оценка бюджета</div>
        <div class="mt-2 text-2xl font-bold text-white">{{ totalPrice.toLocaleString('ru-RU') }} ₽</div>
      </div>
      <div class="rounded-2xl border border-white/10 bg-white/[0.02] p-4">
        <div class="text-xs uppercase tracking-wider text-slate-500">Оценка сроков</div>
        <div class="mt-2 text-2xl font-bold text-white">{{ timelineWeeks }} нед.</div>
      </div>
      <div class="rounded-2xl border border-white/10 bg-white/[0.02] p-4">
        <div class="text-xs uppercase tracking-wider text-slate-500">Рекомендуемый формат</div>
        <div class="mt-2 text-lg font-semibold text-white">{{ packageTitle }}</div>
      </div>
    </div>

    <router-link
      class="btn-primary mt-6"
      :to="{ path: '/contacts', query: { service: recommendedService, message: leadMessage } }"
    >
      Получить детальный план и смету
    </router-link>
  </section>
</template>

<script setup>
import { computed, reactive } from 'vue'

const state = reactive({
  projectType: 'hybrid',
  users: 15,
  has1C: true,
  urgency: 'normal',
})

const projectPrices = {
  website: 90000,
  automation: 140000,
  hybrid: 220000,
}

const recommendedService = computed(() => {
  if (state.projectType === 'website') return 'sites'
  if (state.projectType === 'automation') return 'automation'
  return '1c'
})

const totalPrice = computed(() => {
  const base = projectPrices[state.projectType]
  const usersFee = Math.max(0, state.users - 5) * 2500
  const oneCFee = state.has1C ? 35000 : 0
  const urgencyFee = state.urgency === 'fast' ? 50000 : 0

  return base + usersFee + oneCFee + urgencyFee
})

const timelineWeeks = computed(() => {
  const base = state.projectType === 'hybrid' ? 9 : 6
  const load = state.users > 50 ? 3 : state.users > 20 ? 2 : 1
  const speedAdjustment = state.urgency === 'fast' ? -1 : 0

  return Math.max(3, base + load + speedAdjustment)
})

const packageTitle = computed(() => {
  if (totalPrice.value < 180000) return 'Start'
  if (totalPrice.value < 350000) return 'Business'
  return 'Enterprise'
})

const leadMessage = computed(() => (
  `Хочу расчёт: ${state.projectType}, пользователей: ${state.users}, 1С: ${state.has1C ? 'да' : 'нет'}, срочность: ${state.urgency}, оценка: ${totalPrice.value} ₽`
))
</script>
