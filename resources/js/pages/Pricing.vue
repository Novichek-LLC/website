<template>
  <div class="space-y-12">
    <section class="rounded-[32px] border border-white/10 bg-[radial-gradient(circle_at_top_left,rgba(79,93,255,0.16),transparent_34%),radial-gradient(circle_at_bottom_right,rgba(34,211,238,0.10),transparent_32%),rgba(255,255,255,0.04)] p-8 md:p-10 lg:p-12">
      <div class="max-w-4xl">
        <div class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-medium text-slate-300">
          <BanknotesIcon class="h-4 w-4" />
          Форматы работы и стоимость
        </div>

        <h1 class="mt-5 text-4xl font-semibold tracking-tight text-white md:text-6xl">
          Понятные модели запуска, сопровождения и роста проекта
        </h1>

        <p class="mt-5 max-w-3xl text-base leading-8 text-slate-300 md:text-lg">
          Работаем как по фиксированным задачам, так и в формате сопровождения. Ниже —
          ориентиры, от которых удобно отталкиваться перед стартом.
        </p>

        <div class="mt-8 flex flex-wrap gap-3">
          <router-link to="/contacts" class="btn-primary">Запросить расчёт</router-link>
          <router-link to="/services" class="btn-secondary">Посмотреть услуги</router-link>
        </div>
      </div>
    </section>

    <section class="grid gap-6 xl:grid-cols-3">
      <article
        v-for="plan in plans"
        :key="plan.title"
        class="rounded-[28px] border border-white/10 bg-white/[0.04] p-6"
        :class="plan.featured ? 'border-indigo-400/30 bg-[linear-gradient(180deg,rgba(99,102,241,0.10),rgba(255,255,255,0.04))]' : ''"
      >
        <div class="flex items-center justify-between gap-4">
          <div class="text-xl font-semibold text-white">{{ plan.title }}</div>
          <span
            class="rounded-full border px-3 py-1 text-xs"
            :class="plan.featured ? 'border-indigo-400/30 bg-indigo-400/10 text-indigo-200' : 'border-white/10 bg-white/5 text-slate-300'"
          >
            {{ plan.badge }}
          </span>
        </div>

        <div class="mt-5 text-3xl font-semibold text-white">
          {{ plan.price }}
        </div>

        <p class="mt-3 text-sm leading-7 text-slate-400">
          {{ plan.text }}
        </p>

        <ul class="mt-6 space-y-3 text-sm text-slate-300">
          <li
            v-for="point in plan.points"
            :key="point"
            class="flex items-start gap-2"
          >
            <CheckIcon class="mt-0.5 h-4 w-4 shrink-0 text-cyan-300" />
            <span>{{ point }}</span>
          </li>
        </ul>

        <div class="mt-8">
          <router-link
            to="/contacts"
            class="inline-flex items-center gap-2 rounded-2xl px-4 py-3 text-sm font-medium transition"
            :class="plan.featured ? 'bg-indigo-500 text-white hover:bg-indigo-400' : 'border border-white/10 bg-white/5 text-white hover:bg-white/10'"
          >
            Обсудить формат
            <ArrowRightIcon class="h-4 w-4" />
          </router-link>
        </div>
      </article>
    </section>

    <section class="grid gap-6 lg:grid-cols-[0.9fr_1.1fr] lg:items-start">
      <div>
        <div class="text-xs uppercase tracking-[0.18em] text-slate-500">
          Что влияет на стоимость
        </div>

        <h2 class="mt-3 text-3xl font-semibold tracking-tight text-white md:text-5xl">
          Цена зависит не от названия услуги, а от масштаба и связности задачи
        </h2>

        <p class="mt-4 text-base leading-8 text-slate-400 md:text-lg">
          Один и тот же тип услуги может быть либо быстрым запуском, либо проектом с
          интеграциями, ролями, аналитикой, доступами и длительным сопровождением.
        </p>
      </div>

      <div class="grid gap-4 sm:grid-cols-2">
        <div
          v-for="factor in factors"
          :key="factor.title"
          class="rounded-3xl border border-white/10 bg-white/[0.04] p-5"
        >
          <div class="flex h-11 w-11 items-center justify-center rounded-2xl border border-white/10 bg-white/5 text-white">
            <component :is="factor.icon" class="h-5 w-5" />
          </div>

          <div class="mt-4 text-base font-semibold text-white">
            {{ factor.title }}
          </div>

          <div class="mt-2 text-sm leading-7 text-slate-400">
            {{ factor.text }}
          </div>
        </div>
      </div>
    </section>

    <section class="rounded-[32px] border border-white/10 bg-white/[0.04] p-8 md:p-10">
      <div class="max-w-3xl">
        <div class="text-xs uppercase tracking-[0.18em] text-slate-500">
          Ориентиры по направлениям
        </div>

        <h2 class="mt-3 text-3xl font-semibold tracking-tight text-white md:text-5xl">
          Чтобы было проще понять порядок бюджета
        </h2>
      </div>

      <div class="mt-8 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
        <div
          v-for="item in ranges"
          :key="item.title"
          class="rounded-3xl border border-white/10 bg-white/[0.03] p-5"
        >
          <div class="text-sm font-semibold text-white">
            {{ item.title }}
          </div>

          <div class="mt-3 text-2xl font-semibold text-cyan-200">
            {{ item.range }}
          </div>

          <div class="mt-3 text-sm leading-7 text-slate-400">
            {{ item.text }}
          </div>
        </div>
      </div>
    </section>

    <section class="grid gap-6 lg:grid-cols-2">
      <div class="rounded-[28px] border border-white/10 bg-white/[0.04] p-8">
        <div class="text-xs uppercase tracking-[0.18em] text-slate-500">
          Частый вопрос
        </div>

        <h2 class="mt-3 text-2xl font-semibold text-white md:text-3xl">
          Можно ли начать с малого объёма?
        </h2>

        <p class="mt-4 text-sm leading-7 text-slate-400">
          Да. Часто работа стартует с аудита, настройки одной подсистемы, сайта или
          одного сценария, а дальше расширяется по мере роста задачи и доказанного эффекта.
        </p>
      </div>

      <div class="rounded-[28px] border border-white/10 bg-[linear-gradient(135deg,rgba(79,93,255,0.16),rgba(34,211,238,0.10))] p-8">
        <div class="text-xs uppercase tracking-[0.18em] text-slate-300/70">
          Нужна точная оценка
        </div>

        <h2 class="mt-3 text-2xl font-semibold text-white md:text-3xl">
          Разложим задачу по этапам и бюджету
        </h2>

        <p class="mt-4 text-sm leading-7 text-slate-300/80">
          После короткого брифа покажем реалистичный путь: что нужно сделать в первую
          очередь, что можно отложить и как не раздуть проект лишними работами.
        </p>

        <div class="mt-6">
          <router-link to="/contacts" class="btn-primary">
            Запросить расчёт
          </router-link>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import {
  ArrowRightIcon,
  BanknotesIcon,
  CheckIcon,
  CircleStackIcon,
  ClockIcon,
  Cog6ToothIcon,
  CpuChipIcon,
  GlobeAltIcon,
  ServerStackIcon,
  UserGroupIcon,
} from "@heroicons/vue/24/outline"

const plans = [
  {
    title: "Аудит и старт",
    badge: "Быстрый вход",
    price: "от 25 000 ₽",
    text: "Подходит, когда нужно разобраться в задаче, навести порядок в логике и определить правильный маршрут запуска.",
    points: [
      "Разбор текущей ситуации",
      "Список узких мест и рисков",
      "План работ без лишних этапов",
    ],
    featured: false,
  },
  {
    title: "Проект под ключ",
    badge: "Основной формат",
    price: "от 90 000 ₽",
    text: "Хороший вариант для сайта, 1С, автоматизации, маркировки или интеграционного проекта с измеримым результатом.",
    points: [
      "Фиксированный объём работ",
      "Этапность и контроль результата",
      "Запуск + поддержка после релиза",
    ],
    featured: true,
  },
  {
    title: "Сопровождение",
    badge: "Долгая работа",
    price: "от 45 000 ₽ / мес",
    text: "Для компаний, которым нужна не разовая услуга, а постоянное развитие и техническая стабильность.",
    points: [
      "Приоритетные задачи",
      "Поддержка и улучшения",
      "Работа в логике роста компании",
    ],
    featured: false,
  },
]

const factors = [
  {
    title: "Объём и сложность",
    text: "Сколько сущностей участвует в проекте, сколько сценариев нужно собрать и насколько зрелые у бизнеса процессы.",
    icon: Cog6ToothIcon,
  },
  {
    title: "Количество интеграций",
    text: "CRM, 1С, формы сайта, боты, маркировка, платёжные и внутренние сервисы увеличивают глубину проекта.",
    icon: CircleStackIcon,
  },
  {
    title: "Срочность и темп",
    text: "Если проект нужно запускать быстро, это влияет на плотность работы и внутреннее распределение ресурсов.",
    icon: ClockIcon,
  },
  {
    title: "Уровень сопровождения",
    text: "Одно дело — сделать и передать, другое — взять на себя поддержку, развитие и стабильность после запуска.",
    icon: UserGroupIcon,
  },
]

const ranges = [
  {
    title: "Сайт компании",
    range: "от 120 000 ₽",
    text: "Структура, дизайн, разработка, формы, SEO-подготовка и базовые интеграции.",
  },
  {
    title: "1С и учётные доработки",
    range: "от 60 000 ₽",
    text: "Настройка ролей, обменов, пользовательских сценариев и приведение схемы в рабочее состояние.",
  },
  {
    title: "Маркировка и процессы",
    range: "от 70 000 ₽",
    text: "Запуск, интеграции, связь со складом и учётной системой, поддержка после старта.",
  },
  {
    title: "Автоматизация и CRM",
    range: "от 80 000 ₽",
    text: "Уведомления, маршруты заявок, сценарии, связки между системами и операционная логика.",
  },
  {
    title: "VPN и инфраструктура",
    range: "от 40 000 ₽",
    text: "Безопасный доступ, контур подключений, базовая серверная схема и сопровождение.",
  },
  {
    title: "Игровые серверы",
    range: "от 50 000 ₽",
    text: "Запуск Minecraft или Rust-проекта, оптимизация, плагины, сборки и поддержка.",
  },
]
</script>