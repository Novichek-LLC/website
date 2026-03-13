<template>
  <div class="space-y-10">
    <section class="rounded-[32px] border border-white/10 bg-[radial-gradient(circle_at_top_left,rgba(99,102,241,0.16),transparent_34%),radial-gradient(circle_at_bottom_right,rgba(34,211,238,0.10),transparent_32%),rgba(255,255,255,0.04)] p-8 md:p-10 lg:p-12">
      <div class="max-w-4xl">
        <div class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-medium text-slate-300">
          <DocumentTextIcon class="h-4 w-4" />
          Документы Общества с ограниченной ответственностью "НОВИЧЁК"
        </div>

        <h1 class="mt-5 text-4xl font-semibold tracking-tight text-white md:text-6xl">
          Документы, реквизиты и юридическая информация
        </h1>

        <p class="mt-5 max-w-3xl text-base leading-8 text-slate-300 md:text-lg">
          Здесь собраны основные документы компании, юридическая информация и страницы,
          связанные с обработкой персональных данных и использованием сайта.
        </p>
      </div>
    </section>

    <section class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
      <router-link
        v-for="item in items"
        :key="item.title"
        :to="item.link"
        class="group rounded-[28px] border border-white/10 bg-white/[0.04] p-6 transition hover:-translate-y-1 hover:bg-white/[0.06]"
      >
        <div class="flex h-12 w-12 items-center justify-center rounded-2xl border border-white/10 bg-white/5 text-white">
          <component :is="item.icon" class="h-6 w-6" />
        </div>

        <h2 class="mt-5 text-xl font-semibold text-white">
          {{ item.title }}
        </h2>

        <p class="mt-3 text-sm leading-7 text-slate-400">
          {{ item.text }}
        </p>

        <div class="mt-6 inline-flex items-center gap-2 text-sm font-medium text-cyan-200 transition group-hover:text-white">
          Открыть
          <ArrowRightIcon class="h-4 w-4" />
        </div>
      </router-link>
    </section>
  </div>
</template>

<script setup>
import {
  ArrowRightIcon,
  DocumentCheckIcon,
  DocumentTextIcon,
  IdentificationIcon,
  LockClosedIcon,
  ShieldCheckIcon,
  RectangleGroupIcon,
} from "@heroicons/vue/24/outline"

const items = [
  {
    title: "Публичная оферта",
    text: "Порядок оказания услуг, оплаты, ответственности сторон и иные существенные условия работы.",
    link: "/offer",
    icon: DocumentTextIcon,
  },
  {
    title: "Политика конфиденциальности",
    text: "Общая информация о защите данных пользователей и подходе к конфиденциальности на сайте.",
    link: "/privacy",
    icon: ShieldCheckIcon,
  },
  {
    title: "Согласие на обработку персональных данных",
    text: "Документ о согласии пользователя на обработку персональных данных при отправке формы и обращениях.",
    link: "/consent-personal-data",
    icon: DocumentCheckIcon,
  },
  {
    title: "Политика cookies",
    text: "Информация об использовании cookie-файлов, технических данных и аналитических механизмов сайта.",
    link: "/cookie-policy",
    icon: RectangleGroupIcon,
  },
  {
    title: "Реквизиты компании",
    text: "Юридические данные компании, регистрационная информация и основные реквизиты.",
    link: "/requisites",
    icon: IdentificationIcon,
  },
  {
    title: "Контакты компании",
    text: "Официальные способы связи, адрес и информация для обращений по услугам и документам.",
    link: "/contacts",
    icon: LockClosedIcon,
  },
]
</script>