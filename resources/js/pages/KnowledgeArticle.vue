<template>
  <div class="space-y-8">
    <div
      class="fixed left-0 right-0 top-0 z-[60] h-[3px] origin-left"
      style="background: linear-gradient(90deg, var(--brand), var(--brand-2));"
      :style="{ transform: `scaleX(${readingProgress})` }"
    ></div>

    <section
      v-if="loading"
      class="knowledge-card p-6 text-sm"
      style="color: var(--text-soft)"
    >
      Загружаем статью...
    </section>

    <template v-else-if="article">
      <section class="knowledge-card p-8 md:p-10">
        <div class="knowledge-meta">
          <router-link to="/knowledge" class="knowledge-chip">База знаний</router-link>
          <router-link
            v-if="article.category?.slug"
            :to="`/knowledge/category/${article.category.slug}`"
            class="knowledge-chip"
          >
            {{ article.category?.name }}
          </router-link>
          <span>{{ levelLabel(article.level) }}</span>
          <span>•</span>
          <span>{{ article.reading_time }} мин чтения</span>
        </div>

        <h1
          class="mt-5 max-w-5xl text-4xl font-semibold tracking-tight md:text-6xl"
          style="color: var(--text)"
        >
          {{ article.title }}
        </h1>

        <p
          class="mt-5 max-w-3xl text-base leading-8 md:text-lg"
          style="color: var(--text-soft)"
        >
          {{ article.excerpt }}
        </p>
      </section>

      <section class="knowledge-layout">
        <article class="knowledge-card p-6 md:p-8">
          <div ref="contentRef" class="knowledge-prose" v-html="article.content"></div>
        </article>

        <aside class="knowledge-sidebar">
          <div class="knowledge-sidebar-scroll space-y-6">
            <section class="knowledge-sidebar-card p-5">
              <div
                class="text-xs uppercase tracking-[0.18em]"
                style="color: var(--text-muted)"
              >
                О статье
              </div>

              <div class="mt-4 space-y-4 text-sm">
                <div>
                  <div style="color: var(--text-muted)">Категория</div>
                  <div class="mt-1 font-medium" style="color: var(--text)">
                    {{ article.category?.name || "Без категории" }}
                  </div>
                </div>

                <div>
                  <div style="color: var(--text-muted)">Сложность</div>
                  <div class="mt-1 font-medium" style="color: var(--text)">
                    {{ levelLabel(article.level) }}
                  </div>
                </div>

                <div>
                  <div style="color: var(--text-muted)">Чтение</div>
                  <div class="mt-1 font-medium" style="color: var(--text)">
                    {{ article.reading_time }} мин
                  </div>
                </div>
              </div>
            </section>

            <section v-if="toc.length" class="knowledge-sidebar-card p-5">
              <div
                class="text-xs uppercase tracking-[0.18em]"
                style="color: var(--text-muted)"
              >
                Содержание
              </div>

              <div class="mt-4 space-y-1">
                <a
                  v-for="item in toc"
                  :key="item.id"
                  :href="`#${item.id}`"
                  class="knowledge-toc-link"
                  :style="{ paddingLeft: item.level === 'h3' ? '22px' : '12px' }"
                >
                  {{ item.text }}
                </a>
              </div>
            </section>

            <section v-if="related.length" class="knowledge-sidebar-card p-5">
              <div
                class="text-xs uppercase tracking-[0.18em]"
                style="color: var(--text-muted)"
              >
                Ещё по теме
              </div>

              <div class="mt-4 space-y-3">
                <router-link
                  v-for="item in related"
                  :key="item.id"
                  :to="`/knowledge/${item.slug}`"
                  class="knowledge-card block p-4"
                >
                  <div class="text-sm font-semibold leading-6" style="color: var(--text)">
                    {{ item.title }}
                  </div>
                  <div class="mt-2 text-xs" style="color: var(--text-muted)">
                    {{ item.reading_time }} мин
                  </div>
                </router-link>
              </div>
            </section>
          </div>
        </aside>
      </section>
    </template>
  </div>
</template>

<script setup>
import axios from "axios"
import { nextTick, onBeforeUnmount, onMounted, ref, watch } from "vue"
import { useRoute } from "vue-router"

const route = useRoute()
const loading = ref(true)
const article = ref(null)
const related = ref([])
const toc = ref([])
const contentRef = ref(null)
const readingProgress = ref(0)

async function loadArticle() {
  loading.value = true
  toc.value = []

  try {
    const { data } = await axios.get(`/api/knowledge/${route.params.slug}`)
    article.value = data.article
    related.value = data.related || []

    await nextTick()
    buildToc()
    window.scrollTo({ top: 0, behavior: "auto" })
    updateReadingProgress()
  } finally {
    loading.value = false
  }
}

function buildToc() {
  toc.value = []

  if (!contentRef.value) return

  const headings = contentRef.value.querySelectorAll("h2, h3")

  headings.forEach((heading, index) => {
    const raw = heading.textContent?.trim() || `section-${index + 1}`
    const id =
      heading.id ||
      raw
        .toLowerCase()
        .replace(/[^a-zа-яё0-9\s-]/gi, "")
        .trim()
        .replace(/\s+/g, "-") +
        `-${index + 1}`

    heading.id = id

    toc.value.push({
      id,
      text: raw,
      level: heading.tagName.toLowerCase(),
    })
  })
}

function updateReadingProgress() {
  const scrollTop = window.scrollY || document.documentElement.scrollTop
  const documentHeight =
    document.documentElement.scrollHeight - document.documentElement.clientHeight

  if (documentHeight <= 0) {
    readingProgress.value = 0
    return
  }

  const value = scrollTop / documentHeight
  readingProgress.value = Math.min(Math.max(value, 0), 1)
}

function levelLabel(value) {
  return {
    base: "Базовый",
    middle: "Средний",
    advanced: "Продвинутый",
  }[value] || value
}

onMounted(() => {
  loadArticle()
  window.addEventListener("scroll", updateReadingProgress, { passive: true })
})

watch(
  () => route.params.slug,
  () => {
    loadArticle()
  }
)

onBeforeUnmount(() => {
  window.removeEventListener("scroll", updateReadingProgress)
})
</script>