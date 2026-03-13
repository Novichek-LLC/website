<template>
  <div class="space-y-10">
    <section v-if="loading" class="knowledge-card p-6 text-sm" style="color: var(--text-soft)">
      Загружаем категорию...
    </section>

    <template v-else-if="category">
      <section class="knowledge-hero p-8 md:p-10 lg:p-12">
        <div class="max-w-4xl">
          <div class="knowledge-meta">
            <router-link to="/knowledge" class="knowledge-chip">База знаний</router-link>
            <span>{{ articles.length }} материалов на странице</span>
          </div>

          <h1 class="mt-5 text-4xl font-semibold tracking-tight md:text-6xl" style="color: var(--text)">
            {{ category.name }}
          </h1>

          <p class="mt-5 max-w-3xl text-base leading-8 md:text-lg" style="color: var(--text-soft)">
            {{ category.description || "Материалы, инструкции и практические статьи по этому направлению." }}
          </p>
        </div>
      </section>

      <section v-if="articles.length" class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
        <router-link
          v-for="item in articles"
          :key="item.id"
          :to="`/knowledge/${item.slug}`"
          class="knowledge-card p-5"
        >
          <div class="knowledge-meta">
            <span>{{ levelLabel(item.level) }}</span>
            <span>•</span>
            <span>{{ item.reading_time }} мин</span>
          </div>

          <h3 class="mt-4 text-xl font-semibold leading-tight" style="color: var(--text)">
            {{ item.title }}
          </h3>

          <p class="mt-3 line-clamp-3 text-sm leading-7" style="color: var(--text-soft)">
            {{ item.excerpt || "Откройте материал, чтобы изучить подробный разбор." }}
          </p>

          <div class="mt-5 text-sm font-medium" style="color: var(--brand)">
            Читать материал
          </div>
        </router-link>
      </section>

      <section v-else class="knowledge-empty p-8 text-center">
        <div class="text-2xl font-semibold" style="color: var(--text)">Пока пусто</div>
        <p class="mt-3 text-sm leading-7">
          В этой категории ещё нет опубликованных материалов.
        </p>
      </section>
    </template>
  </div>
</template>

<script setup>
import axios from "axios"
import { onMounted, ref } from "vue"
import { useRoute } from "vue-router"

const route = useRoute()
const loading = ref(true)
const category = ref(null)
const articles = ref([])

async function loadCategory() {
  loading.value = true

  try {
    const { data } = await axios.get(`/api/knowledge/category/${route.params.slug}`)
    category.value = data.category
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

onMounted(loadCategory)
</script>