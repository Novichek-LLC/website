<template>
  <div class="space-y-8">
    <section
      class="rounded-[28px] border p-6 md:p-8"
      style="background: var(--panel); border-color: var(--panel-border);"
    >
      <div class="flex flex-col gap-5 xl:flex-row xl:items-end xl:justify-between">
        <div>
          <div class="text-xs uppercase tracking-[0.18em]" style="color: var(--text-muted)">
            Проекты
          </div>
          <h1 class="mt-2 text-3xl font-semibold md:text-4xl" style="color: var(--text)">
            Мои проекты
          </h1>
          <p class="mt-3 max-w-3xl text-sm leading-7 md:text-base" style="color: var(--text-soft)">
            Здесь собраны все проекты вашей компании, их статусы, сроки и основная информация.
          </p>
        </div>

        <div class="grid gap-3 md:grid-cols-2">
          <input
            v-model="search"
            type="text"
            class="input"
            placeholder="Поиск по проектам"
          />

          <select v-model="statusFilter" class="input">
            <option value="">Все статусы</option>
            <option value="new">Новый</option>
            <option value="in_progress">В работе</option>
            <option value="waiting_client">Ждёт клиента</option>
            <option value="review">На проверке</option>
            <option value="done">Завершён</option>
            <option value="paused">На паузе</option>
          </select>
        </div>
      </div>
    </section>

    <section v-if="loading" class="text-sm" style="color: var(--text-soft)">
      Загружаем проекты...
    </section>

    <section v-else class="grid gap-4 xl:grid-cols-2">
      <router-link
        v-for="project in filteredProjects"
        :key="project.id"
        :to="`/account/projects/${project.slug}`"
        class="rounded-[26px] border p-6 transition hover:-translate-y-0.5"
        style="background: var(--panel); border-color: var(--panel-border);"
      >
        <div class="flex items-start justify-between gap-4">
          <div>
            <div class="text-xl font-semibold" style="color: var(--text)">
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

        <p class="mt-4 text-sm leading-7" style="color: var(--text-soft)">
          {{ project.description || "Описание проекта пока не заполнено." }}
        </p>

        <div class="mt-5 grid gap-3 sm:grid-cols-3 text-sm">
          <div>
            <div style="color: var(--text-muted)">Приоритет</div>
            <div class="mt-1" style="color: var(--text)">{{ priorityLabel(project.priority) }}</div>
          </div>
          <div>
            <div style="color: var(--text-muted)">Старт</div>
            <div class="mt-1" style="color: var(--text)">{{ formatDate(project.start_date) }}</div>
          </div>
          <div>
            <div style="color: var(--text-muted)">Дедлайн</div>
            <div class="mt-1" style="color: var(--text)">{{ formatDate(project.deadline) }}</div>
          </div>
        </div>
      </router-link>
    </section>

    <section
      v-if="!loading && !filteredProjects.length"
      class="rounded-[28px] border p-8 text-center"
      style="background: var(--panel); border-color: var(--panel-border);"
    >
      <div class="text-xl font-semibold" style="color: var(--text)">
        Ничего не найдено
      </div>
      <p class="mt-3 text-sm leading-7" style="color: var(--text-soft)">
        Попробуйте изменить фильтры или поисковый запрос.
      </p>
    </section>
  </div>
</template>

<script setup>
import axios from "axios"
import { computed, onMounted, ref } from "vue"

const loading = ref(true)
const projects = ref([])
const search = ref("")
const statusFilter = ref("")

const filteredProjects = computed(() => {
  return projects.value.filter((project) => {
    const matchesSearch =
      !search.value ||
      `${project.title} ${project.service_type || ""} ${project.description || ""}`
        .toLowerCase()
        .includes(search.value.toLowerCase())

    const matchesStatus = !statusFilter.value || project.status === statusFilter.value

    return matchesSearch && matchesStatus
  })
})

onMounted(async () => {
  try {
    const response = await axios.get("/api/account/projects")
    projects.value = response.data
  } finally {
    loading.value = false
  }
})

function formatDate(value) {
  if (!value) return "Не указано"
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