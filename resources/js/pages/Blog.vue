<template>
  <section class="space-y-10">
    <div class="rounded-[32px] border border-white/10 bg-[radial-gradient(circle_at_top_left,rgba(79,93,255,0.16),transparent_38%),radial-gradient(circle_at_bottom_right,rgba(34,211,238,0.10),transparent_34%),rgba(255,255,255,0.04)] p-8 md:p-10">
      <div class="max-w-3xl">
        <div class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-medium text-slate-300">
          <DocumentTextIcon class="h-4 w-4" />
          Блог
        </div>

        <h1 class="mt-4 text-3xl font-semibold tracking-tight text-white md:text-5xl">
          Публикации по автоматизации, 1С, сайтам, инфраструктуре и игровым серверам
        </h1>

        <p class="mt-4 text-base leading-8 text-slate-400 md:text-lg">
          Практические материалы, разборы, кейсы и статьи по развитию digital-процессов и IT-систем.
        </p>
      </div>
    </div>

    <div v-if="featured" class="grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
      <router-link
        :to="`/blog/${featured.slug}`"
        class="group relative overflow-hidden rounded-[32px] border border-white/10 bg-slate-950/40 shadow-[0_24px_80px_rgba(2,8,23,0.35)]"
      >
        <img
          :src="buildBlogCover(featured)"
          :alt="featured.title"
          class="absolute inset-0 h-full w-full object-cover transition duration-700 group-hover:scale-[1.04]"
        />

        <div class="absolute inset-0 bg-[linear-gradient(180deg,rgba(2,6,23,0.12)_0%,rgba(2,6,23,0.28)_28%,rgba(2,6,23,0.72)_64%,rgba(2,6,23,0.96)_100%)]" />
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.12),transparent_22%)]" />

        <div class="relative flex min-h-[620px] flex-col justify-between p-6 md:p-8">
          <div class="flex flex-wrap items-start justify-between gap-4">
            <div class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-medium backdrop-blur-md"
                 :class="resolveBlogBadge(featured).className">
              <SparklesIcon class="h-4 w-4" />
              {{ resolveBlogBadge(featured).label }}
            </div>

            <div class="flex items-center gap-2 rounded-full border border-white/10 bg-slate-950/35 px-3 py-1 text-xs text-slate-200 backdrop-blur-md">
              <CalendarDaysIcon class="h-4 w-4" />
              {{ formatDate(featured.published_at || featured.created_at) }}
            </div>
          </div>

          <div class="max-w-4xl">
            <div class="mb-4 flex flex-wrap items-center gap-2 text-xs text-slate-300/90">
              <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1">
                <ClockIcon class="h-4 w-4" />
                {{ estimateReadingTime(featured.content) }}
              </span>

              <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1">
                <ChatBubbleLeftRightIcon class="h-4 w-4" />
                {{ featured.approved_comments_count || 0 }}
              </span>

              <span
                v-for="badge in reactionBadges(featured)"
                :key="badge.key"
                class="inline-flex items-center gap-1 rounded-full border border-white/10 bg-white/5 px-3 py-1"
              >
                {{ badge.emoji }} {{ badge.count }}
              </span>
            </div>

            <h2 class="max-w-4xl text-3xl font-semibold leading-[1.08] tracking-tight text-white md:text-5xl">
              {{ featured.title }}
            </h2>

            <p class="mt-5 max-w-3xl text-base leading-8 text-slate-200/85 md:text-lg">
              {{ featured.excerpt || fallbackExcerpt(featured) }}
            </p>

            <div class="mt-8 inline-flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm font-medium text-white backdrop-blur-md transition group-hover:bg-white/10">
              Читать статью
              <ArrowRightIcon class="h-4 w-4 transition group-hover:translate-x-0.5" />
            </div>
          </div>
        </div>
      </router-link>

      <div class="grid gap-6">
        <router-link
          v-for="item in secondary"
          :key="item.id"
          :to="`/blog/${item.slug}`"
          class="group relative overflow-hidden rounded-[28px] border border-white/10 bg-slate-950/50 shadow-[0_20px_60px_rgba(2,8,23,0.28)]"
        >
          <img
            :src="buildBlogCover(item)"
            :alt="item.title"
            class="absolute inset-0 h-full w-full object-cover transition duration-700 group-hover:scale-[1.05]"
          />
          <div class="absolute inset-0 bg-[linear-gradient(180deg,rgba(2,6,23,0.18)_0%,rgba(2,6,23,0.46)_44%,rgba(2,6,23,0.92)_100%)]" />

          <div class="relative flex min-h-[300px] flex-col justify-between p-5">
            <div class="flex items-start justify-between gap-3">
              <div class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-[11px] font-medium backdrop-blur-md"
                   :class="resolveBlogBadge(item).className">
                {{ resolveBlogBadge(item).label }}
              </div>

              <div class="rounded-full border border-white/10 bg-slate-950/35 px-3 py-1 text-[11px] text-slate-200 backdrop-blur-md">
                {{ formatDate(item.published_at || item.created_at) }}
              </div>
            </div>

            <div>
              <h3 class="line-clamp-3 text-xl font-semibold leading-8 text-white">
                {{ item.title }}
              </h3>

              <p class="mt-3 line-clamp-3 text-sm leading-7 text-slate-300/85">
                {{ item.excerpt || fallbackExcerpt(item) }}
              </p>

              <div class="mt-4 flex flex-wrap items-center gap-2 text-xs text-slate-300/85">
                <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1">
                  <ClockIcon class="h-4 w-4" />
                  {{ estimateReadingTime(item.content) }}
                </span>

                <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1">
                  💬 {{ item.approved_comments_count || 0 }}
                </span>

                <span
                  v-for="badge in reactionBadges(item)"
                  :key="badge.key"
                  class="inline-flex items-center gap-1 rounded-full border border-white/10 bg-white/5 px-3 py-1"
                >
                  {{ badge.emoji }} {{ badge.count }}
                </span>
              </div>
            </div>
          </div>
        </router-link>
      </div>
    </div>

    <div v-if="gridItems.length" class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
      <router-link
        v-for="item in gridItems"
        :key="item.id"
        :to="`/blog/${item.slug}`"
        class="group relative overflow-hidden rounded-[28px] border border-white/10 bg-slate-950/50 shadow-[0_20px_60px_rgba(2,8,23,0.22)]"
      >
        <div class="relative h-60 overflow-hidden border-b border-white/10">
          <img
            :src="buildBlogCover(item)"
            :alt="item.title"
            class="h-full w-full object-cover transition duration-700 group-hover:scale-[1.05]"
          />

          <div class="absolute inset-0 bg-[linear-gradient(180deg,rgba(2,6,23,0.08)_0%,rgba(2,6,23,0.26)_42%,rgba(2,6,23,0.70)_100%)]" />

          <div class="absolute left-4 top-4 inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-medium backdrop-blur-md"
               :class="resolveBlogBadge(item).className">
            <SparklesIcon class="h-4 w-4" />
            {{ resolveBlogBadge(item).label }}
          </div>
        </div>

        <div class="p-6">
          <div class="flex flex-wrap items-center gap-3 text-xs text-slate-500">
            <span class="inline-flex items-center gap-2">
              <CalendarDaysIcon class="h-4 w-4" />
              {{ formatDate(item.published_at || item.created_at) }}
            </span>
            <span class="inline-flex items-center gap-2">
              <ClockIcon class="h-4 w-4" />
              {{ estimateReadingTime(item.content) }}
            </span>
          </div>

          <h2 class="mt-4 text-xl font-semibold leading-8 text-white transition group-hover:text-cyan-100">
            {{ item.title }}
          </h2>

          <p class="mt-3 line-clamp-3 text-sm leading-7 text-slate-400">
            {{ item.excerpt || fallbackExcerpt(item) }}
          </p>

          <div class="mt-4 flex flex-wrap items-center gap-2 text-xs text-slate-400">
            <span
              v-for="badge in reactionBadges(item)"
              :key="badge.key"
              class="inline-flex items-center gap-1 rounded-full border border-white/10 bg-white/[0.04] px-2.5 py-1"
            >
              {{ badge.emoji }} {{ badge.count }}
            </span>

            <span class="inline-flex items-center gap-1 rounded-full border border-white/10 bg-white/[0.04] px-2.5 py-1">
              💬 {{ item.approved_comments_count || 0 }}
            </span>
          </div>

          <div class="mt-6 inline-flex items-center gap-2 text-sm font-medium text-cyan-200 transition group-hover:text-white">
            Читать статью
            <ArrowRightIcon class="h-4 w-4 transition group-hover:translate-x-0.5" />
          </div>
        </div>
      </router-link>
    </div>

    <div v-if="!items.length" class="rounded-[24px] border border-white/10 bg-white/[0.04] p-8 text-center">
      <div class="text-lg font-semibold text-white">Публикаций пока нет</div>
      <div class="mt-2 text-sm text-slate-400">
        Как только статьи будут опубликованы, они появятся здесь.
      </div>
    </div>
  </section>
</template>

<script setup>
import axios from "axios"
import { computed, onMounted, ref } from "vue"
import {
  ArrowRightIcon,
  CalendarDaysIcon,
  ChatBubbleLeftRightIcon,
  ClockIcon,
  DocumentTextIcon,
  SparklesIcon,
} from "@heroicons/vue/24/outline"
import { buildBlogCover, estimateReadingTime, resolveBlogBadge } from "../utils/blogMeta"

const items = ref([])

const featured = computed(() => items.value[0] || null)
const secondary = computed(() => items.value.slice(1, 4))
const gridItems = computed(() => items.value.slice(4))

function formatDate(value) {
  if (!value) return "Без даты"

  return new Intl.DateTimeFormat("ru-RU", {
    day: "2-digit",
    month: "long",
    year: "numeric",
  }).format(new Date(value))
}

function fallbackExcerpt(item) {
  return (
    String(item.content || "")
      .replace(/<[^>]+>/g, " ")
      .replace(/\s+/g, " ")
      .trim()
      .slice(0, 140) + "…"
  )
}

function reactionBadges(item) {
  const summary = item.reactions_summary || {}

  const map = [
    { key: "like", emoji: "👍", count: summary.like || 0 },
    { key: "fire", emoji: "🔥", count: summary.fire || 0 },
    { key: "idea", emoji: "💡", count: summary.idea || 0 },
    { key: "rocket", emoji: "🚀", count: summary.rocket || 0 },
  ]

  return map.filter(i => i.count > 0)
}

onMounted(async () => {
  const res = await axios.get("/api/blog")
  items.value = res.data
})
</script>