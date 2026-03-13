<template>
  <div class="space-y-12">
    <section class="rounded-[34px] border border-white/10 bg-[radial-gradient(circle_at_top_left,rgba(129,140,248,0.22),transparent_34%),radial-gradient(circle_at_bottom_right,rgba(34,211,238,0.16),transparent_28%),rgba(255,255,255,0.05)] p-8 md:p-10 lg:p-12 shadow-[0_24px_80px_rgba(2,8,23,0.32)]">
      <div class="max-w-5xl">
        <div class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/10 px-3 py-1 text-xs font-medium text-slate-200">
          <LightBulbIcon class="h-4 w-4" />
          Решения ООО "НОВИЧЁК"
        </div>
        <h1 class="mt-5 text-4xl font-semibold tracking-tight text-white md:text-6xl">
          Решения под конкретный тип команды и задач, а не просто набор услуг
        </h1>
        <p class="mt-5 max-w-3xl text-base leading-8 text-slate-200 md:text-lg">
          Собрали страницы решений для ритейла, digital-команд, бизнеса и удалённых команд. У каждой — свой контекст, боли и рабочая логика внедрения.
        </p>
      </div>
    </section>

    <section class="grid gap-6 md:grid-cols-2">
      <router-link
        v-for="item in items"
        :key="item.title"
        :to="item.link"
        class="group rounded-[30px] border border-white/10 bg-white/[0.05] p-7 transition hover:-translate-y-1 hover:bg-white/[0.07] shadow-[0_18px_50px_rgba(2,8,23,0.18)]"
      >
        <div class="flex items-start justify-between gap-4">
          <div class="flex h-12 w-12 items-center justify-center rounded-2xl border border-white/10 bg-white/5 text-white">
            <component :is="item.icon" class="h-6 w-6" />
          </div>
          <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-[11px] text-slate-300">{{ item.tag }}</span>
        </div>
        <h2 class="mt-5 text-2xl font-semibold text-white">{{ item.title }}</h2>
        <p class="mt-4 text-sm leading-8 text-slate-400">{{ item.text }}</p>
        <div class="mt-6 inline-flex items-center gap-2 text-sm font-medium text-cyan-200 transition group-hover:text-white">
          Открыть решение
          <ArrowRightIcon class="h-4 w-4" />
        </div>
      </router-link>
    </section>
  </div>
</template>

<script setup>
import { ArrowRightIcon, BriefcaseIcon, BuildingStorefrontIcon, LightBulbIcon, RocketLaunchIcon, WifiIcon } from '@heroicons/vue/24/outline'

const items = [
  { title: 'Решения для ритейла', text: 'Учёт, маркировка, процессы, склад, продажи и управляемость розничного контура.', link: '/solutions/retail', tag: 'Retail', icon: BuildingStorefrontIcon },
  { title: 'Решения для digital-команд', text: 'Сайты, лидоген, коммуникации, UX, автоматизация и контур быстрых запусков.', link: '/solutions/digital-teams', tag: 'Digital', icon: RocketLaunchIcon },
  { title: 'Решения для бизнеса', text: 'Заявки, 1С, процессы, CRM, инфраструктура и системный рост компании.', link: '/solutions/business', tag: 'Business', icon: BriefcaseIcon },
  { title: 'Решения для удалённых команд', text: 'Доступы, роли, VPN, инфраструктура и безопасная распределённая работа.', link: '/solutions/remote-teams', tag: 'Remote', icon: WifiIcon },
]
</script>
