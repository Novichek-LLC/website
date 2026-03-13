<template>
  <section v-if="item" class="space-y-8">
    <div class="overflow-hidden rounded-[28px] border border-white/10 bg-white/[0.04]">
      <div class="relative h-[280px] overflow-hidden border-b border-white/10 md:h-[380px]">
        <img :src="buildBlogCover(item)" :alt="item.title" class="h-full w-full object-cover" />

        <div
          class="absolute left-5 top-5 inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-medium backdrop-blur-md"
          :class="resolveBlogBadge(item).className"
        >
          <SparklesIcon class="h-4 w-4" />
          {{ resolveBlogBadge(item).label }}
        </div>
      </div>

      <div class="p-6 md:p-10">
        <div class="flex flex-wrap items-center gap-3 text-sm text-slate-400">
          <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1">
            <CalendarDaysIcon class="h-4 w-4" />
            {{ formatDate(item.published_at || item.created_at) }}
          </span>

          <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1">
            <ClockIcon class="h-4 w-4" />
            {{ estimateReadingTime(item.content) }}
          </span>
        </div>

        <h1 class="mt-5 max-w-4xl text-3xl font-semibold leading-tight tracking-tight text-white md:text-5xl">
          {{ item.title }}
        </h1>

        <p v-if="item.excerpt" class="mt-5 max-w-3xl text-base leading-8 text-slate-300 md:text-lg">
          {{ item.excerpt }}
        </p>
      </div>
    </div>

    <div class="rounded-[28px] border border-white/10 bg-white/[0.04] p-6 md:p-10">
      <div class="blog-prose" v-html="item.content"></div>

      <div class="mt-10 rounded-[24px] border border-white/10 bg-white/[0.03] p-5 md:p-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
          <div>
            <div class="text-lg font-semibold text-white">Как вам материал?</div>
            <div class="mt-1 text-sm text-slate-400">
              Можно оставить реакцию — это видно и внутри статьи, и в списке блога.
            </div>
          </div>

          <div class="text-sm text-slate-400">
            Всего реакций: {{ totalReactions }}
          </div>
        </div>

        <div class="mt-5 grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
          <button
            v-for="reaction in reactionButtons"
            :key="reaction.key"
            class="reaction-button"
            :class="{ 'reaction-button--active': myReactions.includes(reaction.key) }"
            @click="toggleReaction(reaction.key)"
            :disabled="reactionSending"
          >
            <span class="text-xl">{{ reaction.emoji }}</span>
            <span class="text-sm font-medium text-white">{{ reaction.label }}</span>
            <span class="rounded-full border border-white/10 bg-white/5 px-2 py-1 text-xs text-slate-300">
              {{ reactionsSummary[reaction.key] || 0 }}
            </span>
          </button>
        </div>

        <div v-if="reactionError" class="mt-3 text-sm text-rose-300">
          {{ reactionError }}
        </div>
      </div>
    </div>

    <div v-if="related.length" class="space-y-6">
      <div>
        <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Ещё из блога</div>
        <h2 class="mt-2 text-2xl font-semibold text-white md:text-3xl">
          Похожие публикации
        </h2>
      </div>

      <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
        <router-link
          v-for="post in related"
          :key="post.id"
          :to="`/blog/${post.slug}`"
          class="group rounded-[24px] border border-white/10 bg-white/[0.04] p-6 transition hover:bg-white/[0.06]"
        >
          <div class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-medium"
               :class="resolveBlogBadge(post).className">
            {{ resolveBlogBadge(post).label }}
          </div>

          <h3 class="mt-5 text-lg font-semibold leading-7 text-white">
            {{ post.title }}
          </h3>

          <p class="mt-3 line-clamp-3 text-sm leading-7 text-slate-400">
            {{ fallbackExcerpt(post) }}
          </p>

          <div class="mt-4 flex flex-wrap items-center gap-2 text-xs text-slate-400">
            <span class="reaction-preview" v-for="badge in reactionBadges(post)" :key="badge.key">
              {{ badge.emoji }} {{ badge.count }}
            </span>
            <span class="reaction-preview">
              💬 {{ post.approved_comments_count || 0 }}
            </span>
          </div>
        </router-link>
      </div>
    </div>

    <section class="rounded-[28px] border border-white/10 bg-white/[0.04] p-6 md:p-8">
      <div class="flex items-center justify-between gap-4">
        <div>
          <h2 class="text-2xl font-semibold text-white">Комментарии</h2>
          <p class="mt-2 text-sm text-slate-400">
            Вопросы, мысли и обсуждение материала.
          </p>
        </div>

        <div class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-sm text-slate-300">
          {{ comments.length }}
        </div>
      </div>

      <form class="mt-6 rounded-[24px] border border-white/10 bg-white/[0.03] p-4 md:p-5" @submit.prevent="submitComment">
        <div class="grid gap-4 md:grid-cols-2">
          <input v-model="commentForm.author_name" class="input !mb-0" placeholder="Ваше имя" />
          <input v-model="commentForm.author_email" class="input !mb-0" placeholder="Email (необязательно)" />
        </div>

        <textarea
          v-model="commentForm.content"
          rows="5"
          class="input !mb-0 mt-4"
          placeholder="Поделитесь мнением или задайте вопрос..."
        />

        <div class="mt-4 flex flex-wrap items-center gap-3">
          <button class="btn-primary" :disabled="commentSending">
            {{ commentSending ? "Отправка..." : "Отправить комментарий" }}
          </button>

          <span v-if="commentSuccess" class="text-sm text-emerald-300">
            {{ commentSuccess }}
          </span>

          <span v-if="commentError" class="text-sm text-rose-300">
            {{ commentError }}
          </span>
        </div>
      </form>

      <div class="mt-8 space-y-4">
        <div
          v-for="comment in comments"
          :key="comment.id"
          class="rounded-[22px] border border-white/10 bg-white/[0.03] p-5"
        >
          <div class="flex items-start gap-4">
            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full border border-white/10 bg-white/5 text-sm font-semibold text-white">
              {{ initials(comment.author_name) }}
            </div>

            <div class="min-w-0 flex-1">
              <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                <div class="text-base font-semibold text-white">
                  {{ comment.author_name }}
                </div>
                <div class="text-xs text-slate-500">
                  {{ formatDate(comment.created_at) }}
                </div>
              </div>

              <div class="mt-3 whitespace-pre-line text-sm leading-7 text-slate-300">
                {{ comment.content }}
              </div>
            </div>
          </div>
        </div>

        <div v-if="!comments.length" class="rounded-[22px] border border-dashed border-white/10 bg-white/[0.02] p-5 text-sm text-slate-400">
          Пока нет комментариев. Будьте первым.
        </div>
      </div>
    </section>

    <div class="rounded-[28px] border border-white/10 bg-[linear-gradient(135deg,rgba(79,93,255,0.16),rgba(34,211,238,0.10))] p-8 md:p-10">
      <div class="grid gap-6 lg:grid-cols-[1fr_auto] lg:items-center">
        <div>
          <div class="text-xs uppercase tracking-[0.18em] text-slate-300/70">Полезные материалы</div>
          <h2 class="mt-3 text-2xl font-semibold text-white md:text-3xl">
            Следи за новыми публикациями и практическими разборами
          </h2>
          <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-300/80">
            В блоге появляются материалы по автоматизации, внедрению 1С, сайтам, инфраструктуре и игровым серверам.
          </p>
        </div>

        <router-link to="/contacts" class="btn-primary">
          Обсудить проект
        </router-link>
      </div>
    </div>
  </section>
</template>

<script setup>
import axios from "axios"
import { computed, onMounted, ref } from "vue"
import { useRoute } from "vue-router"
import {
  CalendarDaysIcon,
  ClockIcon,
  SparklesIcon,
} from "@heroicons/vue/24/outline"
import { buildBlogCover, estimateReadingTime, resolveBlogBadge } from "../utils/blogMeta"

const route = useRoute()
const item = ref(null)
const allPosts = ref([])
const comments = ref([])

const commentSending = ref(false)
const commentError = ref("")
const commentSuccess = ref("")

const reactionSending = ref(false)
const reactionError = ref("")
const reactionsSummary = ref({
  like: 0,
  fire: 0,
  idea: 0,
  rocket: 0,
})
const myReactions = ref([])

const commentForm = ref({
  author_name: "",
  author_email: "",
  content: "",
})

const reactionButtons = [
  { key: "like", emoji: "👍", label: "Полезно" },
  { key: "fire", emoji: "🔥", label: "Сильно" },
  { key: "idea", emoji: "💡", label: "Есть идея" },
  { key: "rocket", emoji: "🚀", label: "Хочу так же" },
]

const related = computed(() =>
  allPosts.value
    .filter(post => post.slug !== route.params.slug)
    .slice(0, 3)
)

const totalReactions = computed(() =>
  Object.values(reactionsSummary.value).reduce((sum, value) => sum + Number(value || 0), 0)
)

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

function initials(name) {
  return String(name || "?")
    .trim()
    .split(/\s+/)
    .slice(0, 2)
    .map(part => part.charAt(0).toUpperCase())
    .join("")
}

function getVisitorToken() {
  let token = localStorage.getItem("blog_visitor_token")

  if (!token) {
    token = `${Date.now()}-${Math.random().toString(36).slice(2)}`
    localStorage.setItem("blog_visitor_token", token)
  }

  return token
}

async function loadComments() {
  const res = await axios.get(`/api/blog/${route.params.slug}/comments`)
  comments.value = res.data
}

async function loadReactions() {
  const token = getVisitorToken()

  const res = await axios.get(`/api/blog/${route.params.slug}/reactions`, {
    params: { visitor_token: token },
  })

  reactionsSummary.value = res.data.summary || reactionsSummary.value
  myReactions.value = res.data.my_reactions || []
}

async function toggleReaction(reactionKey) {
  reactionError.value = ""
  reactionSending.value = true

  try {
    const res = await axios.post(`/api/blog/${route.params.slug}/reactions/toggle`, {
      reaction_key: reactionKey,
      visitor_token: getVisitorToken(),
    })

    reactionsSummary.value = res.data.summary || reactionsSummary.value
    myReactions.value = res.data.my_reactions || []
  } catch (e) {
    reactionError.value = "Не удалось сохранить реакцию"
  } finally {
    reactionSending.value = false
  }
}

async function submitComment() {
  commentError.value = ""
  commentSuccess.value = ""

  if (!commentForm.value.author_name.trim()) {
    commentError.value = "Укажите имя"
    return
  }

  if (!commentForm.value.content.trim()) {
    commentError.value = "Введите текст комментария"
    return
  }

  commentSending.value = true

  try {
    const res = await axios.post(`/api/blog/${route.params.slug}/comments`, {
      author_name: commentForm.value.author_name.trim(),
      author_email: commentForm.value.author_email.trim() || null,
      content: commentForm.value.content.trim(),
    })

    commentSuccess.value = res.data.message || "Комментарий отправлен"
    commentForm.value = {
      author_name: "",
      author_email: "",
      content: "",
    }
  } catch (e) {
    const response = e.response?.data
    const errors = response?.errors || {}
    const firstError = Object.values(errors)?.flat?.()[0]

    commentError.value =
      firstError ||
      response?.message ||
      "Не удалось отправить комментарий"
  } finally {
    commentSending.value = false
  }
}

onMounted(async () => {
  const [postRes, listRes] = await Promise.all([
    axios.get(`/api/blog/${route.params.slug}`),
    axios.get(`/api/blog`),
  ])

  item.value = postRes.data
  allPosts.value = listRes.data

  await Promise.all([loadComments(), loadReactions()])
})
</script>