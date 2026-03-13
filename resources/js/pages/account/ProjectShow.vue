<template>
  <div class="space-y-8">
    <section
      v-if="loading"
      class="rounded-[28px] border p-6"
      style="background: var(--panel); border-color: var(--panel-border); color: var(--text-soft);"
    >
      Загружаем проект...
    </section>

    <template v-else-if="project">
      <section
        class="rounded-[36px] border p-8 md:p-10"
        style="background: linear-gradient(135deg, rgba(99,102,241,0.18), rgba(34,211,238,0.10)); border-color: var(--panel-border);"
      >
        <div class="flex flex-col gap-4 xl:flex-row xl:items-start xl:justify-between">
          <div>
            <div class="text-xs uppercase tracking-[0.18em]" style="color: var(--text-muted)">
              Карточка проекта
            </div>
            <h1 class="mt-2 text-3xl font-semibold md:text-5xl" style="color: var(--text)">
              {{ project.title }}
            </h1>
            <p class="mt-4 max-w-3xl text-base leading-8 md:text-lg" style="color: var(--text-soft)">
              {{ project.description || "Описание проекта пока не заполнено." }}
            </p>
          </div>

          <span class="status-pill" :class="statusClass(project.status)">
            {{ statusLabel(project.status) }}
          </span>
        </div>
      </section>

      <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
        <article
          v-for="item in infoCards"
          :key="item.label"
          class="rounded-[24px] border p-5"
          style="background: var(--panel); border-color: var(--panel-border);"
        >
          <div class="text-sm" style="color: var(--text-muted)">{{ item.label }}</div>
          <div class="mt-3 text-lg font-semibold" style="color: var(--text)">{{ item.value }}</div>
        </article>
      </section>

      <section class="grid gap-6 xl:grid-cols-[1fr_0.9fr]">
        <section
          class="rounded-[28px] border p-6 md:p-8"
          style="background: var(--panel); border-color: var(--panel-border);"
        >
          <div class="text-xs uppercase tracking-[0.18em]" style="color: var(--text-muted)">
            Компания
          </div>
          <h2 class="mt-2 text-2xl font-semibold" style="color: var(--text)">
            {{ project.company?.name }}
          </h2>

          <div class="mt-6 grid gap-4 md:grid-cols-2">
            <div>
              <div class="text-sm" style="color: var(--text-muted)">Email</div>
              <div class="mt-1 text-sm" style="color: var(--text)">
                {{ project.company?.email || "Не указан" }}
              </div>
            </div>
            <div>
              <div class="text-sm" style="color: var(--text-muted)">Телефон</div>
              <div class="mt-1 text-sm" style="color: var(--text)">
                {{ project.company?.phone || "Не указан" }}
              </div>
            </div>
          </div>
        </section>

        <section
          class="rounded-[28px] border p-6 md:p-8"
          style="background: var(--panel); border-color: var(--panel-border);"
        >
          <div class="text-xs uppercase tracking-[0.18em]" style="color: var(--text-muted)">
            Следующие шаги
          </div>
          <div class="mt-5 space-y-3 text-sm leading-7" style="color: var(--text-soft)">
            <p>На следующем этапе сюда можно добавить ленту обновлений проекта, документы, файлы и согласования.</p>
            <p>Сейчас эта страница уже даёт заказчику понятную карточку проекта со статусом, сроками и ответственным.</p>
          </div>
        </section>
      </section>
    </template>
  </div>
</template>

<script setup>
import axios from "axios"
import { computed, onMounted, ref } from "vue"
import { useRoute } from "vue-router"

const route = useRoute()
const loading = ref(true)
const project = ref(null)

const infoCards = computed(() => {
  if (!project.value) return []

  return [
    { label: "Тип услуги", value: project.value.service_type || "Не указан" },
    { label: "Приоритет", value: priorityLabel(project.value.priority) },
    { label: "Дата старта", value: formatDate(project.value.start_date) },
    { label: "Дедлайн", value: formatDate(project.value.deadline) },
    { label: "Бюджет", value: formatBudget(project.value.budget, project.value.currency) },
    { label: "Менеджер", value: project.value.manager?.name || "Не назначен" },
  ]
})

onMounted(async () => {
  try {
    const response = await axios.get(`/api/account/projects/${route.params.slug}`)
    project.value = response.data
  } finally {
    loading.value = false
  }
})

function formatDate(value) {
  if (!value) return "Не указано"
  return new Date(value).toLocaleDateString("ru-RU")
}

function formatBudget(value, currency = "RUB") {
  if (!value) return "Не указан"
  return new Intl.NumberFormat("ru-RU", {
    style: "currency",
    currency,
    maximumFractionDigits: 0,
  }).format(value)
}

function statusLabel(value) {
  return {
    new: "Новый",
    in_progress: "В работе",
    waiting_client: "Ждёт клиента",
    review: "На проверке",
    done: "Завершён",
    paused: "На паузе",
  }[value] || value
}

function priorityLabel(value) {
  return {
    low: "Низкий",
    medium: "Средний",
    high: "Высокий",
    critical: "Критический",
  }[value] || value
}

function statusClass(value) {
  if (value === "done") return "status-pill--open"
  if (value === "in_progress" || value === "review") return "status-pill--progress"
  return "status-pill--closed"
}
</script>