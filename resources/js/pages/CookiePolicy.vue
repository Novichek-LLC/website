<template>
  <div class="space-y-10">
    <section class="rounded-[32px] border border-white/10 bg-[radial-gradient(circle_at_top_left,rgba(99,102,241,0.16),transparent_34%),radial-gradient(circle_at_bottom_right,rgba(34,211,238,0.10),transparent_32%),rgba(255,255,255,0.04)] p-8 md:p-10 lg:p-12">
      <div class="max-w-4xl">
        <div class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-medium text-slate-300">
          <RectangleGroupIcon class="h-4 w-4" />
          Политика cookies
        </div>

        <h1 class="mt-5 text-4xl font-semibold tracking-tight text-white md:text-6xl">
          Политика использования cookie-файлов
        </h1>

        <p class="mt-5 max-w-3xl text-base leading-8 text-slate-300 md:text-lg">
          На сайте могут использоваться cookie-файлы и иные технические идентификаторы,
          необходимые для корректной работы сайта, анализа пользовательского поведения,
          сохранения настроек и повышения удобства использования.
        </p>
      </div>
    </section>

    <section class="grid gap-6 md:grid-cols-2">
      <article
        v-for="item in items"
        :key="item.title"
        class="rounded-[28px] border border-white/10 bg-white/[0.04] p-6"
      >
        <h2 class="text-2xl font-semibold text-white">
          {{ item.title }}
        </h2>

        <div class="mt-4 space-y-4 text-sm leading-8 text-slate-300 md:text-base">
          <p v-for="paragraph in item.paragraphs" :key="paragraph">
            {{ paragraph }}
          </p>
        </div>
      </article>
    </section>
  </div>
</template>

<script setup>
import { RectangleGroupIcon } from "@heroicons/vue/24/outline"

const items = [
  {
    title: "1. Что такое cookie",
    paragraphs: [
      "Cookie-файлы — это небольшие фрагменты данных, которые браузер сохраняет на устройстве пользователя при посещении сайта.",
      "Они могут использоваться для сохранения технических настроек, статистики, авторизационных признаков, предпочтений пользователя и иных служебных целей."
    ]
  },
  {
    title: "2. Для чего мы их используем",
    paragraphs: [
      "Cookie могут использоваться для корректной работы сайта, обеспечения безопасности, сохранения пользовательских настроек, анализа посещаемости и улучшения пользовательского опыта.",
      "Также могут применяться технические и аналитические инструменты, позволяющие понимать, какие страницы востребованы и как пользователи взаимодействуют с сайтом."
    ]
  },
  {
    title: "3. Управление cookie",
    paragraphs: [
      "Пользователь может изменить настройки использования cookie через параметры своего браузера, включая ограничение, блокировку или удаление отдельных файлов.",
      "При полном отключении части cookie некоторые функции сайта могут работать некорректно либо быть недоступны."
    ]
  },
  {
    title: "4. Дополнительные положения",
    paragraphs: [
      "Использование сайта означает согласие пользователя с применением cookie и иных технических механизмов в объёме, необходимом для функционирования сайта.",
      "Перед публикацией страницы рекомендуется дополнительно проверить фактический набор аналитических и технических сервисов, которые используются на вашем сайте."
    ]
  },
]
</script>