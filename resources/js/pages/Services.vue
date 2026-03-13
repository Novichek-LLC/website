<template>
  <div class="space-y-12">
    <section class="rounded-[34px] border border-white/10 bg-[radial-gradient(circle_at_top_left,rgba(129,140,248,0.22),transparent_34%),radial-gradient(circle_at_bottom_right,rgba(34,211,238,0.16),transparent_28%),rgba(255,255,255,0.05)] p-8 md:p-10 lg:p-12 shadow-[0_24px_80px_rgba(2,8,23,0.32)]">
      <div class="max-w-5xl">
        <div class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/10 px-3 py-1 text-xs font-medium text-slate-200">
          <Squares2X2Icon class="h-4 w-4" />
          Услуги ООО "НОВИЧЁК"
        </div>
        <h1 class="mt-5 text-4xl font-semibold tracking-tight text-white md:text-6xl">
          Системные услуги для бизнеса, digital-проектов, инфраструктуры и профильных направлений
        </h1>
        <p class="mt-5 max-w-3xl text-base leading-8 text-slate-200 md:text-lg">
          Собрали все основные направления в одной странице: 1С, маркировка, чат-боты и автоматизация, сайты, дизайн, сопровождение, инфраструктура, музыкальная дистрибуция и пескоструйные работы.
        </p>
      </div>
    </section>

    <section class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
      <router-link
        v-for="item in services"
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
        <ul class="mt-5 space-y-2 text-sm text-slate-300">
          <li v-for="point in item.points" :key="point" class="flex items-start gap-2">
            <CheckIcon class="mt-0.5 h-4 w-4 shrink-0 text-cyan-300" />
            <span>{{ point }}</span>
          </li>
        </ul>
        <div class="mt-6 inline-flex items-center gap-2 text-sm font-medium text-cyan-200 transition group-hover:text-white">
          Подробнее
          <ArrowRightIcon class="h-4 w-4" />
        </div>
      </router-link>
    </section>

    <section class="rounded-[28px] border border-white/10 bg-[linear-gradient(135deg,rgba(99,102,241,0.18),rgba(34,211,238,0.12))] p-8 md:p-10">
      <div class="grid gap-6 lg:grid-cols-[1fr_auto] lg:items-center">
        <div>
          <div class="text-xs uppercase tracking-[0.18em] text-slate-300/70">Решения</div>
          <h2 class="mt-3 text-2xl font-semibold text-white md:text-3xl">Нужны не отдельные услуги, а готовая схема под вашу команду?</h2>
          <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-300/80">
            Тогда переходите в раздел решений: для ритейла, digital-команд, бизнеса и удалённых команд.
          </p>
        </div>
        <router-link to="/solutions" class="btn-primary">Открыть решения</router-link>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ArrowRightIcon, CheckIcon, ChatBubbleLeftRightIcon, CircleStackIcon, CpuChipIcon, GlobeAltIcon, MusicalNoteIcon, PaintBrushIcon, QrCodeIcon, Squares2X2Icon, WrenchScrewdriverIcon } from '@heroicons/vue/24/outline'

const services = [
  { title: '1С: установка и настройка', tag: 'ERP / Учёт', text: 'Установка, внедрение, роли, процессы, обмены и сопровождение под реальные сценарии компании.', link: '/services/1c', icon: CircleStackIcon, points: ['Установка и старт', 'Внедрение под процессы', 'Интеграции и поддержка'] },
  { title: 'Чат-боты и автоматизация', tag: 'Automation', text: 'Боты, уведомления, CRM-сценарии и меньше ручной рутины в операционной работе.', link: '/services/bots-automation', icon: ChatBubbleLeftRightIcon, points: ['Лид-боты', 'Уведомления', 'Связка с CRM и сайтом'] },
  { title: 'Музыкальная дистрибуция', tag: 'Music / Digital', text: 'Цифровой контур релиза, упаковка, материалы и поддержка релизного процесса.', link: '/services/music-distribution', icon: MusicalNoteIcon, points: ['Подготовка релиза', 'Метаданные', 'Цифровая упаковка'] },
  { title: 'Маркировка товаров', tag: 'Retail / Compliance', text: 'Запуск и стабилизация маркировки в связке с учётом, документами и складом.', link: '/services/marking', icon: QrCodeIcon, points: ['Маршрут товара', 'Связка с 1С', 'Поддержка после запуска'] },
  { title: 'VPN и инфраструктура', tag: 'Security / Remote', text: 'Безопасный доступ, роли, контур удалённой работы и инфраструктурная логика под РФ.', link: '/services/vpn-infrastructure', icon: CpuChipIcon, points: ['VPN-контур', 'Права доступа', 'Сопровождение'] },
  { title: 'Пескоструйные работы', tag: 'Industrial', text: 'Очистка и подготовка поверхностей под технологическую задачу и следующий этап работ.', link: '/services/sandblast', icon: WrenchScrewdriverIcon, points: ['Оценка объекта', 'Очистка', 'Подготовка под дальнейшие работы'] },
  { title: 'Создание сайтов', tag: 'Web / Sales', text: 'Корпоративные сайты, посадочные и digital-платформы, которые помогают продавать.', link: '/services/sites', icon: GlobeAltIcon, points: ['Структура', 'Дизайн', 'Интеграции и SEO-база'] },
  { title: 'Дизайн', tag: 'UI / UX', text: 'Интерфейсы, визуальная система и digital-подача, которая усиливает продукт и бренд.', link: '/services/design', icon: PaintBrushIcon, points: ['UX-логика', 'UI-система', 'Подготовка к внедрению'] },
  { title: 'Сопровождение и интеграции', tag: 'Support', text: 'Поддержка после запуска, развитие проекта и связка систем в единый контур.', link: '/services/support-integrations', icon: WrenchScrewdriverIcon, points: ['Поддержка', 'Интеграции', 'Рост проекта'] },
]
</script>
