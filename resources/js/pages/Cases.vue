<template>
  <div class="space-y-12">
    <section class="rounded-[32px] border border-white/10 bg-[radial-gradient(circle_at_top_left,rgba(79,93,255,0.18),transparent_34%),radial-gradient(circle_at_bottom_right,rgba(34,211,238,0.10),transparent_32%),rgba(255,255,255,0.04)] p-8 md:p-10 lg:p-12">
      <div class="max-w-4xl">
        <div class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-medium text-slate-300">
          <BriefcaseIcon class="h-4 w-4" />
          Кейсы ООО "НОВИЧЁК"
        </div>

        <h1 class="mt-5 text-4xl font-semibold tracking-tight text-white md:text-6xl">
          Реальные проекты, где результат важнее красивых обещаний
        </h1>

        <p class="mt-5 max-w-3xl text-base leading-8 text-slate-300 md:text-lg">
          Показываем, как решаем задачи бизнеса и digital-проектов: сайты, автоматизация,
          1С, маркировка, инфраструктура и игровые серверы.
        </p>

        <div class="mt-8 flex flex-wrap gap-3">
          <router-link to="/contacts" class="btn-primary">Обсудить похожий проект</router-link>
          <router-link to="/services" class="btn-secondary">Посмотреть услуги</router-link>
        </div>
      </div>
    </section>

    <section class="rounded-[28px] border border-white/10 bg-white/[0.04] p-6 md:p-8">
      <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
          <div class="text-xs uppercase tracking-[0.18em] text-slate-500">
            Каталог кейсов
          </div>
          <h2 class="mt-2 text-2xl font-semibold text-white md:text-3xl">
            Проекты по направлениям
          </h2>
        </div>

        <div class="flex flex-wrap gap-2">
          <button
            v-for="filter in filters"
            :key="filter"
            type="button"
            @click="activeFilter = filter"
            class="rounded-full border px-3 py-2 text-sm transition"
            :class="
              activeFilter === filter
                ? 'border-indigo-400/30 bg-indigo-400/10 text-indigo-200'
                : 'border-white/10 bg-white/5 text-slate-300 hover:bg-white/10'
            "
          >
            {{ filter }}
          </button>
        </div>
      </div>
    </section>

    <section v-if="featuredCase" class="grid gap-6 xl:grid-cols-[1.15fr_0.85fr]">
      <router-link
        :to="`/cases/${featuredCase.slug}`"
        class="group relative overflow-hidden rounded-[32px] border border-white/10 bg-slate-950/50 shadow-[0_24px_80px_rgba(2,8,23,0.35)]"
      >
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(99,102,241,0.24),transparent_30%),radial-gradient(circle_at_bottom_right,rgba(34,211,238,0.16),transparent_30%)]" />
        <div class="relative flex min-h-[420px] flex-col justify-between p-6 md:p-8">
          <div class="flex items-start justify-between gap-4">
            <span class="inline-flex items-center gap-2 rounded-full border border-cyan-400/20 bg-cyan-400/10 px-3 py-1 text-xs font-medium text-cyan-200">
              <SparklesIcon class="h-4 w-4" />
              {{ featuredCase.service || "Кейс" }}
            </span>

            <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs text-slate-300">
              Featured
            </span>
          </div>

          <div>
            <div class="flex flex-wrap items-center gap-2 text-xs text-slate-400">
              <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1">
                <ChartBarIcon class="h-4 w-4" />
                Практический результат
              </span>
              <span
                v-if="featuredCase.seo_title || featuredCase.meta_title"
                class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1"
              >
                <GlobeAltIcon class="h-4 w-4" />
                SEO подготовка
              </span>
            </div>

            <h2 class="mt-5 max-w-4xl text-3xl font-semibold leading-[1.1] tracking-tight text-white md:text-5xl">
              {{ featuredCase.title }}
            </h2>

            <p class="mt-5 max-w-3xl text-base leading-8 text-slate-300 md:text-lg">
              {{ featuredCase.summary || fallbackSummary(featuredCase) }}
            </p>

            <div class="mt-6 flex flex-wrap gap-2">
              <span
                v-for="tag in caseTags(featuredCase)"
                :key="tag"
                class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs text-slate-300"
              >
                {{ tag }}
              </span>
            </div>
          </div>

          <div class="mt-8 inline-flex items-center gap-2 text-sm font-medium text-cyan-200 transition group-hover:text-white">
            Открыть кейс
            <ArrowRightIcon class="h-4 w-4 transition group-hover:translate-x-0.5" />
          </div>
        </div>
      </router-link>

      <div class="grid gap-6">
        <article
          v-for="item in sideCases"
          :key="item.id"
          class="rounded-[28px] border border-white/10 bg-white/[0.04] p-6"
        >
          <div class="flex items-start justify-between gap-4">
            <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-[11px] text-slate-300">
              {{ item.service || "Кейс" }}
            </span>

            <div class="flex h-11 w-11 items-center justify-center rounded-2xl border border-white/10 bg-white/5 text-white">
              <BriefcaseIcon class="h-5 w-5" />
            </div>
          </div>

          <h3 class="mt-5 text-xl font-semibold text-white">
            {{ item.title }}
          </h3>

          <p class="mt-3 text-sm leading-7 text-slate-400">
            {{ item.summary || fallbackSummary(item) }}
          </p>

          <router-link
            :to="`/cases/${item.slug}`"
            class="mt-6 inline-flex items-center gap-2 text-sm font-medium text-cyan-200 transition hover:text-white"
          >
            Открыть кейс
            <ArrowRightIcon class="h-4 w-4" />
          </router-link>
        </article>
      </div>
    </section>

    <section v-if="gridCases.length" class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
      <router-link
        v-for="item in gridCases"
        :key="item.id"
        :to="`/cases/${item.slug}`"
        class="group rounded-[28px] border border-white/10 bg-white/[0.04] p-6 transition hover:-translate-y-1 hover:bg-white/[0.06]"
      >
        <div class="flex items-start justify-between gap-4">
          <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-[11px] text-slate-300">
            {{ item.service || "Кейс" }}
          </span>

          <div class="flex h-11 w-11 items-center justify-center rounded-2xl border border-white/10 bg-white/5 text-white">
            <BriefcaseIcon class="h-5 w-5" />
          </div>
        </div>

        <h3 class="mt-5 text-xl font-semibold text-white transition group-hover:text-cyan-100">
          {{ item.title }}
        </h3>

        <p class="mt-3 text-sm leading-7 text-slate-400">
          {{ item.summary || fallbackSummary(item) }}
        </p>

        <div class="mt-5 flex flex-wrap gap-2">
          <span
            v-for="tag in caseTags(item)"
            :key="tag"
            class="rounded-full border border-white/10 bg-white/[0.04] px-3 py-1 text-xs text-slate-300"
          >
            {{ tag }}
          </span>
        </div>

        <div class="mt-6 inline-flex items-center gap-2 text-sm font-medium text-cyan-200 transition group-hover:text-white">
          Открыть кейс
          <ArrowRightIcon class="h-4 w-4 transition group-hover:translate-x-0.5" />
        </div>
      </router-link>
    </section>

    <section
      v-if="!loading && !filteredItems.length"
      class="rounded-[28px] border border-dashed border-white/10 bg-white/[0.03] p-8 text-center"
    >
      <div class="text-lg font-semibold text-white">Кейсы пока не найдены</div>
      <div class="mt-2 text-sm text-slate-400">
        Для выбранного направления ещё нет опубликованных материалов.
      </div>
    </section>

    <section
      v-if="loading"
      class="rounded-[28px] border border-white/10 bg-white/[0.04] p-8 text-center"
    >
      <div class="text-lg font-semibold text-white">Загружаем кейсы…</div>
      <div class="mt-2 text-sm text-slate-400">
        Подтягиваем опубликованные проекты.
      </div>
    </section>

    <section class="rounded-[28px] border border-white/10 bg-[linear-gradient(135deg,rgba(79,93,255,0.16),rgba(34,211,238,0.10))] p-8 md:p-10">
      <div class="grid gap-6 lg:grid-cols-[1fr_auto] lg:items-center">
        <div>
          <div class="text-xs uppercase tracking-[0.18em] text-slate-300/70">
            Нужен похожий результат
          </div>

          <h2 class="mt-3 text-2xl font-semibold text-white md:text-3xl">
            Разберём вашу задачу и покажем, как собрать решение под ваш контекст
          </h2>

          <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-300/80">
            Можно прийти с существующим хаосом, недоделанным проектом или идеей с нуля —
            поможем определить адекватный маршрут запуска.
          </p>
        </div>

        <router-link to="/contacts" class="btn-primary">
          Обсудить проект
        </router-link>
      </div>
    </section>
  </div>
</template>

<script setup>
import axios from "axios"
import { computed, onMounted, ref } from "vue"
import {
  ArrowRightIcon,
  BriefcaseIcon,
  ChartBarIcon,
  GlobeAltIcon,
  SparklesIcon,
} from "@heroicons/vue/24/outline"

const items = ref([])
const loading = ref(true)
const activeFilter = ref("Все")

const filters = computed(() => {
  const services = items.value
    .map((item) => item.service)
    .filter(Boolean)

  return ["Все", ...new Set(services)]
})

const filteredItems = computed(() => {
  if (activeFilter.value === "Все") return items.value
  return items.value.filter((item) => item.service === activeFilter.value)
})

const featuredCase = computed(() => filteredItems.value[0] || null)
const sideCases = computed(() => filteredItems.value.slice(1, 3))
const gridCases = computed(() => filteredItems.value.slice(3))

function fallbackSummary(item) {
  return (
    String(item.description || item.content || "")
      .replace(/<[^>]+>/g, " ")
      .replace(/\s+/g, " ")
      .trim()
      .slice(0, 160) + "…"
  )
}

function caseTags(item) {
  const tags = []

  if (item.service) tags.push(item.service)
  if (item.seo_title || item.meta_title) tags.push("SEO")
  if (item.seo_description || item.meta_description) tags.push("Контент")
  if (item.result) tags.push("Результат")

  return [...new Set(tags)].slice(0, 3)
}

onMounted(async () => {
  try {
    const res = await axios.get("/api/cases")
    items.value = Array.isArray(res.data) ? res.data : []
  } finally {
    loading.value = false
  }
})
</script>