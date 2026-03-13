<template>
  <div class="space-y-8">
    <section
      class="rounded-[36px] border p-8 md:p-10"
      style="background: linear-gradient(135deg, rgba(99,102,241,0.18), rgba(34,211,238,0.10)); border-color: var(--panel-border);"
    >
      <div v-if="loading" class="text-sm" style="color: var(--text-soft)">
        Загружаем кабинет...
      </div>

      <template v-else-if="data">
        <div class="grid gap-8 xl:grid-cols-[1.1fr_0.9fr] xl:items-center">
          <div>
            <div class="text-xs uppercase tracking-[0.18em]" style="color: var(--text-muted)">
              Добро пожаловать
            </div>
            <h1 class="mt-3 text-3xl font-semibold md:text-5xl" style="color: var(--text)">
              {{ data.user.name }}
            </h1>
            <p class="mt-4 max-w-3xl text-base leading-8 md:text-lg" style="color: var(--text-soft)">
              Компания:
              <span style="color: var(--text); font-weight: 600;">{{ data.company.name }}</span>.
              Здесь вы видите активные проекты, ключевые статусы и последние изменения по работе.
            </p>

            <div class="mt-6 flex flex-wrap gap-3">
              <router-link to="/account/projects" class="btn-primary">
                Открыть проекты
              </router-link>
              <router-link to="/contacts" class="btn-secondary">
                Связаться с командой
              </router-link>
            </div>
          </div>

          <div
            class="rounded-[28px] border p-5"
            style="background: var(--panel); border-color: var(--panel-border);"
          >
            <div class="text-xs uppercase tracking-[0.16em]" style="color: var(--text-muted)">
              Краткая сводка
            </div>

            <div class="mt-5 space-y-4">
              <div class="flex items-center justify-between gap-4">
                <span style="color: var(--text-soft)">Контактное лицо</span>
                <span class="font-medium" style="color: var(--text)">{{ data.company.contact_person || "Не указано" }}</span>
              </div>
              <div class="flex items-center justify-between gap-4">
                <span style="color: var(--text-soft)">Email</span>
                <span class="font-medium" style="color: var(--text)">{{ data.company.email || "Не указан" }}</span>
              </div>
              <div class="flex items-center justify-between gap-4">
                <span style="color: var(--text-soft)">Телефон</span>
                <span class="font-medium" style="color: var(--text)">{{ data.company.phone || "Не указан" }}</span>
              </div>
            </div>
          </div>
        </div>
      </template>
    </section>

    <section v-if="data" class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
      <article
        v-for="item in stats"
        :key="item.label"
        class="rounded-[24px] border p-5"
        style="background: var(--panel); border-color: var(--panel-border);"
      >
        <div class="text-sm" style="color: var(--text-muted)">
          {{ item.label }}
        </div>
        <div class="mt-3 text-3xl font-semibold" style="color: var(--text)">
          {{ item.value }}
        </div>
        <div class="mt-2 text-sm" style="color: var(--text-soft)">
          {{ item.text }}
        </div>
      </article>
    </section>

    <section class="grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
      <section
        v-if="data"
        class="rounded-[28px] border p-6 md:p-8"
        style="background: var(--panel); border-color: var(--panel-border);"
      >
        <div class="flex items-center justify-between gap-4">
          <div>
            <div class="text-xs uppercase tracking-[0.16em]" style="color: var(--text-muted)">
              Последние проекты
            </div>
            <h2 class="mt-2 text-2xl font-semibold" style="color: var(--text)">
              Актуальная работа
            </h2>
          </div>

          <router-link to="/account/projects" class="btn-secondary">
            Все проекты
          </router-link>
        </div>

        <div class="mt-6 grid gap-4">
          <router-link
            v-for="project in data.projects"
            :key="project.id"
            :to="`/account/projects/${project.slug}`"
            class="rounded-[24px] border p-5 transition hover:-translate-y-0.5"
            style="background: var(--panel-strong); border-color: var(--panel-border);"
          >
            <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
              <div>
                <div class="text-lg font-semibold" style="color: var(--text)">
                  {{ project.title }}
                </div>
                <div class="mt-1 text-sm" style="color: var(--text-muted)">
                  {{ project.service_type || "Без категории" }}
                </div>
              </div>

              <span class="status-pill" :class="statusClass(project.status)">
                {{ statusLabel(project.status) }}
              </span>
            </div>

            <div class="mt-5 grid gap-3 sm:grid-cols-3 text-sm">
              <div>
                <div style="color: var(--text-muted)">Приоритет</div>
                <div class="mt-1" style="color: var(--text)">
                  {{ priorityLabel(project.priority) }}
                </div>
              </div>
              <div>
                <div style="color: var(--text-muted)">Дедлайн</div>
                <div class="mt-1" style="color: var(--text)">
                  {{ formatDate(project.deadline) }}
                </div>
              </div>
              <div>
                <div style="color: var(--text-muted)">Менеджер</div>
                <div class="mt-1" style="color: var(--text)">
                  {{ project.manager?.name || "Не назначен" }}
                </div>
              </div>
            </div>
          </router-link>
        </div>
      </section>

      <section class="space-y-6">
        <section
          class="rounded-[28px] border p-6"
          style="background: var(--panel); border-color: var(--panel-border);"
        >
          <div class="text-xs uppercase tracking-[0.16em]" style="color: var(--text-muted)">
            Быстрые действия
          </div>
          <div class="mt-5 grid gap-3">
            <router-link to="/account/projects" class="btn-secondary justify-center">
              Перейти к проектам
            </router-link>
            <router-link to="/account/profile" class="btn-secondary justify-center">
              Открыть профиль
            </router-link>
            <router-link to="/contacts" class="btn-secondary justify-center">
              Связаться с нами
            </router-link>
          </div>
        </section>

        <section
          class="rounded-[28px] border p-6"
          style="background: var(--panel); border-color: var(--panel-border);"
        >
          <div class="text-xs uppercase tracking-[0.16em]" style="color: var(--text-muted)">
            Что дальше
          </div>
          <div class="mt-4 space-y-3 text-sm leading-7" style="color: var(--text-soft)">
            <p>Дальше в кабинет можно добавить тикеты, документы, счета, файлы проекта и ленту обновлений.</p>
            <p>Сейчас база уже есть: дашборд, список проектов и детальная карточка проекта.</p>
          </div>
        </section>
      </section>
    </section>
  </div>
</template>

<script setup>
import axios from "axios"
import { computed, onMounted, ref } from "vue"

const loading = ref(true)
const data = ref(null)

const stats = computed(() => {
  if (!data.value) return []

  return [
    {
      label: "Всего проектов",
      value: data.value.stats.total_projects,
      text: "Общее количество проектов компании",
    },
    {
      label: "Активных",
      value: data.value.stats.active_projects,
      text: "Проекты в работе и на проверке",
    },
    {
      label: "Завершённых",
      value: data.value.stats.done_projects,
      text: "Уже завершённые проекты",
    },
    {
      label: "Высокий приоритет",
      value: data.value.stats.high_priority_projects,
      text: "Требуют повышенного внимания",
    },
  ]
})

onMounted(async () => {
  try {
    const response = await axios.get("/api/account/dashboard")
    data.value = response.data
  } finally {
    loading.value = false
  }
})

function formatDate(value) {
  if (!value) return "Не указан"
  return new Date(value).toLocaleDateString("ru-RU")
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