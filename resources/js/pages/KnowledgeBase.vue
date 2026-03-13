<template>
  <div class="space-y-10">
    <section class="knowledge-hero p-8 md:p-10 lg:p-12">
      <div class="max-w-4xl">
        <div class="knowledge-chip">
          <span class="inline-block h-2 w-2 rounded-full bg-emerald-400"></span>
          База знаний NOVICHEK
        </div>

        <h1 class="mt-5 text-4xl font-semibold tracking-tight md:text-6xl" style="color: var(--text)">
          Полезные материалы, инструкции и практические разборы
        </h1>

        <p class="mt-5 max-w-3xl text-base leading-8 md:text-lg" style="color: var(--text-soft)">
          Собираем сильную базу знаний по автоматизации, 1С, сайтам, инфраструктуре, маркировке,
          digital-процессам и игровым серверам — так, чтобы это было приятно читать и удобно изучать.
        </p>

        <div class="mt-8 grid gap-4 lg:grid-cols-[minmax(0,1fr)_180px]">
          <input
            v-model="search"
            class="input"
            type="text"
            placeholder="Поиск по базе знаний"
            @keyup.enter="loadData"
          />

          <button class="btn-primary justify-center" @click="loadData">
            Найти
          </button>
        </div>

        <div class="mt-8 flex flex-wrap gap-3">
          <div class="knowledge-chip">
            <span>{{ categories.length }}</span>
            <span>категорий</span>
          </div>
          <div class="knowledge-chip">
            <span>{{ articles.length }}</span>
            <span>материалов на странице</span>
          </div>
          <div class="knowledge-chip">
            <span>{{ featured.length }}</span>
            <span>избранных статей</span>
          </div>
        </div>
      </div>
    </section>

    <section v-if="categories.length" class="space-y-5">
      <div>
        <div class="text-xs uppercase tracking-[0.18em]" style="color: var(--text-muted)">
          Навигация по темам
        </div>
        <h2 class="mt-2 text-3xl font-semibold" style="color: var(--text)">
          Категории базы знаний
        </h2>
      </div>

      <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <router-link
          v-for="item in categories"
          :key="item.id"
          :to="`/knowledge/category/${item.slug}`"
          class="knowledge-card p-5"
        >
          <div class="knowledge-meta">
            <span>{{ item.articles_count }} материалов</span>
          </div>

          <h3 class="mt-4 text-xl font-semibold" style="color: var(--text)">
            {{ item.name }}
          </h3>

          <p class="mt-3 text-sm leading-7" style="color: var(--text-soft)">
            {{ item.description || "Подборка статей и инструкций по этому направлению." }}
          </p>

          <div class="mt-5 text-sm font-medium" style="color: var(--brand)">
            Открыть категорию
          </div>
        </router-link>
      </div>
    </section>

    <section v-if="featured.length" class="space-y-5">
      <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
        <div>
          <div class="text-xs uppercase tracking-[0.18em]" style="color: var(--text-muted)">
            Рекомендуем начать
          </div>
          <h2 class="mt-2 text-3xl font-semibold" style="color: var(--text)">
            Избранные материалы
          </h2>
        </div>

        <router-link to="/knowledge" class="btn-secondary">
          Вся база знаний
        </router-link>
      </div>

      <div class="grid gap-4 lg:grid-cols-2">
        <router-link
          v-for="item in featured"
          :key="item.id"
          :to="`/knowledge/${item.slug}`"
          class="knowledge-card p-6"
        >
          <div class="knowledge-meta">
            <span>{{ item.category?.name }}</span>
            <span>•</span>
            <span>{{ levelLabel(item.level) }}</span>
            <span>•</span>
            <span>{{ item.reading_time }} мин</span>
          </div>

          <h3 class="mt-4 text-2xl font-semibold leading-tight" style="color: var(--text)">
            {{ item.title }}
          </h3>

          <p class="mt-3 text-sm leading-7" style="color: var(--text-soft)">
            {{ item.excerpt || "Откройте материал, чтобы изучить подробный разбор по теме." }}
          </p>

          <div class="mt-5 text-sm font-medium" style="color: var(--brand)">
            Читать материал
          </div>
        </router-link>
      </div>
    </section>

    <section class="space-y-5">
      <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
        <div>
          <div class="text-xs uppercase tracking-[0.18em]" style="color: var(--text-muted)">
            Последние публикации
          </div>
          <h2 class="mt-2 text-3xl font-semibold" style="color: var(--text)">
            Все материалы
          </h2>
        </div>

        <button class="btn-secondary" @click="loadData">
          Обновить
        </button>
      </div>

      <div v-if="loading" class="knowledge-card p-6 text-sm" style="color: var(--text-soft)">
        Загружаем материалы...
      </div>

      <div v-else-if="!articles.length" class="knowledge-empty p-8 text-center">
        <div class="text-2xl font-semibold" style="color: var(--text)">Ничего не найдено</div>
        <p class="mt-3 text-sm leading-7">
          Попробуйте изменить поисковый запрос или добавьте первые материалы в админке.
        </p>
      </div>

      <div v-else class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
        <router-link
          v-for="item in articles"
          :key="item.id"
          :to="`/knowledge/${item.slug}`"
          class="knowledge-card p-5"
        >
          <div class="knowledge-meta">
            <span>{{ item.category?.name }}</span>
            <span>•</span>
            <span>{{ levelLabel(item.level) }}</span>
            <span>•</span>
            <span>{{ item.reading_time }} мин</span>
          </div>

          <h3 class="mt-4 text-xl font-semibold leading-tight" style="color: var(--text)">
            {{ item.title }}
          </h3>

          <p class="mt-3 line-clamp-3 text-sm leading-7" style="color: var(--text-soft)">
            {{ item.excerpt || "Откройте материал, чтобы изучить полный текст статьи." }}
          </p>

          <div class="mt-5 text-sm font-medium" style="color: var(--brand)">
            Читать
          </div>
        </router-link>
      </div>
    </section>
  </div>
</template>

<script setup>
import axios from "axios"
import { onMounted, ref } from "vue"

const loading = ref(true)
const search = ref("")
const categories = ref([])
const featured = ref([])
const articles = ref([])

async function loadData() {
  loading.value = true

  try {
    const { data } = await axios.get("/api/knowledge", {
      params: { search: search.value || undefined },
    })

    categories.value = data.categories || []
    featured.value = data.featured || []
    articles.value = data.articles?.data || []
  } finally {
    loading.value = false
  }
}

function levelLabel(value) {
  return {
    base: "Базовый",
    middle: "Средний",
    advanced: "Продвинутый",
  }[value] || value
}

onMounted(loadData)
</script>