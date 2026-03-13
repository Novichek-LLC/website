<template>
  <div class="space-y-12">
    <section class="rounded-[32px] border border-white/10 bg-[radial-gradient(circle_at_top_left,rgba(79,93,255,0.16),transparent_34%),radial-gradient(circle_at_bottom_right,rgba(34,211,238,0.10),transparent_32%),rgba(255,255,255,0.04)] p-8 md:p-10 lg:p-12">
      <div class="max-w-4xl">
        <div class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-medium text-slate-300">
          <BuildingOffice2Icon class="h-4 w-4" />
          О компании ООО "НОВИЧЁК"
        </div>

        <h1 class="mt-5 text-4xl font-semibold tracking-tight text-white md:text-6xl">
          Собираем не набор услуг, а рабочую систему для роста бизнеса
        </h1>

        <p class="mt-5 max-w-3xl text-base leading-8 text-slate-300 md:text-lg">
          Работаем на стыке business-процессов, digital, инфраструктуры и сопровождения.
          Нас интересует не отдельный сайт, модуль или настройка, а то, как всё это вместе
          влияет на заявки, управляемость, стабильность и рост компании.
        </p>

        <div class="mt-8 flex flex-wrap gap-3">
          <router-link to="/contacts" class="btn-primary">Обсудить проект</router-link>
          <router-link to="/services" class="btn-secondary">Посмотреть услуги</router-link>
        </div>
      </div>
    </section>

    <section class="grid gap-6 md:grid-cols-3">
      <article
        v-for="value in values"
        :key="value.title"
        class="rounded-[28px] border border-white/10 bg-white/[0.04] p-6"
      >
        <div class="flex h-12 w-12 items-center justify-center rounded-2xl border border-white/10 bg-white/5 text-white">
          <component :is="value.icon" class="h-6 w-6" />
        </div>

        <h2 class="mt-5 text-xl font-semibold text-white">
          {{ value.title }}
        </h2>

        <p class="mt-3 text-sm leading-7 text-slate-400">
          {{ value.text }}
        </p>
      </article>
    </section>

    <section class="grid gap-8 lg:grid-cols-[0.95fr_1.05fr] lg:items-start">
      <div>
        <div class="text-xs uppercase tracking-[0.18em] text-slate-500">
          Как мы смотрим на проект
        </div>

        <h2 class="mt-3 text-3xl font-semibold tracking-tight text-white md:text-5xl">
          Для нас задача начинается не с технологии, а с проблемы бизнеса
        </h2>

        <p class="mt-4 text-base leading-8 text-slate-400 md:text-lg">
          Поэтому мы не продаём сайт сам по себе, 1С ради галочки или автоматизацию ради
          модного слова. Сначала разбираем, где компания теряет время, деньги, заявки,
          управляемость или контроль, а уже потом собираем решение.
        </p>
      </div>

      <div class="grid gap-4 sm:grid-cols-2">
        <div
          v-for="point in principles"
          :key="point.title"
          class="rounded-3xl border border-white/10 bg-white/[0.04] p-5"
        >
          <div class="text-base font-semibold text-white">
            {{ point.title }}
          </div>
          <div class="mt-2 text-sm leading-7 text-slate-400">
            {{ point.text }}
          </div>
        </div>
      </div>
    </section>

    <section class="rounded-[32px] border border-white/10 bg-white/[0.04] p-8 md:p-10">
      <div class="grid gap-8 lg:grid-cols-[0.9fr_1.1fr] lg:items-center">
        <div>
          <div class="text-xs uppercase tracking-[0.18em] text-slate-500">
            Почему клиентам удобно
          </div>

          <h2 class="mt-3 text-3xl font-semibold tracking-tight text-white md:text-5xl">
            Одна команда вместо пяти отдельных подрядчиков
          </h2>

          <p class="mt-4 text-base leading-8 text-slate-400 md:text-lg">
            Когда сайт, учёт, автоматизация, дизайн, инфраструктура и поддержка делаются
            вразнобой, клиент получает не систему, а набор стыков. Мы собираем всё в один
            понятный рабочий контур.
          </p>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
          <div
            v-for="item in advantages"
            :key="item.title"
            class="rounded-3xl border border-white/10 bg-white/[0.03] p-5"
          >
            <div class="text-base font-semibold text-white">
              {{ item.title }}
            </div>
            <div class="mt-2 text-sm leading-7 text-slate-400">
              {{ item.text }}
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="space-y-6">
      <div class="max-w-3xl">
        <div class="text-xs uppercase tracking-[0.18em] text-slate-500">
          С чем к нам приходят
        </div>

        <h2 class="mt-3 text-3xl font-semibold tracking-tight text-white md:text-5xl">
          Типовые задачи, с которыми работаем чаще всего
        </h2>
      </div>

      <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
        <div
          v-for="task in tasks"
          :key="task"
          class="rounded-3xl border border-white/10 bg-white/[0.04] px-5 py-4 text-sm leading-7 text-slate-300"
        >
          {{ task }}
        </div>
      </div>
    </section>

    <section class="grid gap-6 lg:grid-cols-3">
      <article
        v-for="direction in directions"
        :key="direction.title"
        class="rounded-[28px] border border-white/10 bg-white/[0.04] p-6"
      >
        <div class="flex h-12 w-12 items-center justify-center rounded-2xl border border-white/10 bg-white/5 text-white">
          <component :is="direction.icon" class="h-6 w-6" />
        </div>

        <h2 class="mt-5 text-xl font-semibold text-white">
          {{ direction.title }}
        </h2>

        <p class="mt-3 text-sm leading-7 text-slate-400">
          {{ direction.text }}
        </p>

        <ul class="mt-5 space-y-2 text-sm text-slate-300">
          <li
            v-for="point in direction.points"
            :key="point"
            class="flex items-start gap-2"
          >
            <CheckIcon class="mt-0.5 h-4 w-4 shrink-0 text-cyan-300" />
            <span>{{ point }}</span>
          </li>
        </ul>
      </article>
    </section>

    <section class="rounded-[32px] border border-white/10 bg-white/[0.04] p-8 md:p-10">
      <div class="grid gap-8 lg:grid-cols-[0.95fr_1.05fr] lg:items-center">
        <div>
          <div class="text-xs uppercase tracking-[0.18em] text-slate-500">
            Реквизиты компании
          </div>

          <h2 class="mt-3 text-3xl font-semibold tracking-tight text-white md:text-5xl">
            Основная юридическая информация
          </h2>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
          <div
            v-for="item in companyDetails"
            :key="item.label"
            class="rounded-3xl border border-white/10 bg-white/[0.03] p-5"
          >
            <div class="text-xs uppercase tracking-[0.14em] text-slate-500">
              {{ item.label }}
            </div>

            <div class="mt-3 whitespace-pre-line text-sm leading-7 text-slate-200">
              {{ item.value }}
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="rounded-[28px] border border-white/10 bg-[linear-gradient(135deg,rgba(79,93,255,0.16),rgba(34,211,238,0.10))] p-8 md:p-10">
      <div class="grid gap-6 lg:grid-cols-[1fr_auto] lg:items-center">
        <div>
          <div class="text-xs uppercase tracking-[0.18em] text-slate-300/70">
            Если важен системный результат
          </div>

          <h2 class="mt-3 text-2xl font-semibold text-white md:text-3xl">
            Можно начать с одной задачи и выстроить большую систему позже
          </h2>

          <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-300/80">
            Не обязательно заходить сразу в большой проект. Часто достаточно одного
            точного шага, чтобы стало понятно, где компания теряет ресурс и как это
            исправить без лишней сложности.
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
import {
  BoltIcon,
  BuildingOffice2Icon,
  CheckIcon,
  CircleStackIcon,
  Cog6ToothIcon,
  GlobeAltIcon,
  PuzzlePieceIcon,
  ServerStackIcon,
  UserGroupIcon,
} from "@heroicons/vue/24/outline"

const values = [
  {
    title: "Смотрим на систему целиком",
    text: "Нас интересует не отдельный модуль, а то, как сайт, учёт, заявки, интеграции и процессы работают вместе.",
    icon: PuzzlePieceIcon,
  },
  {
    title: "Работаем без лишнего технического шума",
    text: "Говорим с клиентом языком результата, а не перегружаем ненужной терминологией и искусственной сложностью.",
    icon: BoltIcon,
  },
  {
    title: "Остаёмся после запуска",
    text: "Поддержка, развитие и доработка после релиза для нас такая же важная часть работы, как и сам старт проекта.",
    icon: UserGroupIcon,
  },
]

const principles = [
  {
    title: "Сначала контекст",
    text: "Разбираем процессы, точки потерь, роли и маршрут заявки, а уже потом предлагаем решение.",
  },
  {
    title: "Потом технология",
    text: "Подбираем инструмент под задачу, а не под модный стек или случайный шаблон.",
  },
  {
    title: "Только рабочая глубина",
    text: "Не раздуваем проект ради масштаба, а делаем только то, что действительно усиливает систему.",
  },
  {
    title: "Рост по этапам",
    text: "Строим решение так, чтобы бизнес мог масштабировать его без пересборки с нуля.",
  },
]

const advantages = [
  {
    title: "Меньше стыков и перекладывания ответственности",
    text: "Не возникает ситуации, когда сайт “не виноват”, CRM “не виновата”, а проблема всё равно остаётся у клиента.",
  },
  {
    title: "Быстрее запуск и развитие",
    text: "Когда одна команда понимает весь контекст, не нужно заново объяснять проект каждому новому исполнителю.",
  },
  {
    title: "Нормальная архитектура",
    text: "Сервисы, процессы и контент собираются в единую систему, а не в набор случайных решений.",
  },
  {
    title: "Удобнее для руководителя",
    text: "Клиент занимается бизнесом, а не управляет хаосом между несколькими подрядчиками.",
  },
]

const tasks = [
  "Навести порядок в 1С и учёте компании",
  "Запустить маркировку без ручного хаоса и постоянных сбоев",
  "Сделать сайт, который не просто существует, а помогает продавать",
  "Связать заявки, CRM и внутренние процессы в одну систему",
  "Настроить ботов, уведомления и маршрутизацию обращений",
  "Собрать безопасную инфраструктуру и доступы для команды",
  "Запустить Minecraft или Rust-сервер под стабильную нагрузку",
  "Взять проект на сопровождение и развитие после релиза",
]

const directions = [
  {
    title: "Бизнес-системы",
    text: "Помогаем компаниям, которым нужен не просто учёт, а понятная и управляемая операционная схема.",
    points: [
      "1С и связанные процессы",
      "Маркировка и обязательные операции",
      "Связка учёта, сотрудников и документов",
    ],
    icon: CircleStackIcon,
  },
  {
    title: "Digital и автоматизация",
    text: "Собираем сайты, интерфейсы, воронки, CRM-сценарии и точки входа в системный рост.",
    points: [
      "Корпоративные сайты и продуктовые страницы",
      "Автоматизация заявок и уведомлений",
      "Интеграции между сервисами и отделами",
    ],
    icon: GlobeAltIcon,
  },
  {
    title: "Инфраструктура и техпроекты",
    text: "Поддерживаем техническую сторону: доступы, стабильность, игровые серверы и сопровождение.",
    points: [
      "VPN и безопасный доступ",
      "Игровые серверы Minecraft и Rust",
      "Поддержка и развитие после запуска",
    ],
    icon: ServerStackIcon,
  },
]

const companyDetails = [
  {
    label: "ОГРН",
    value: "1257400015982\nот 2 июля 2025 г.",
  },
  {
    label: "Дата регистрации",
    value: "02.07.2025",
  },
  {
    label: "ИНН / КПП",
    value: "7448262795\n744801001",
  },
  {
    label: "Уставный капитал",
    value: "10 000 руб.",
  },
  {
    label: "Юридический адрес",
    value: "456234, Челябинская область,\nг. Златоуст, ул. Свободы, д. 14, кв. 2",
  },
  {
    label: "Руководитель",
    value: "Директор\nНовичёк Данил Маркович",
  },
  {
    label: "Регистрирующий орган",
    value: "Межрайонная инспекция ФНС России № 27 по Челябинской области\nс 2 июля 2025 г.",
  },
  {
    label: "ОКПО",
    value: "84860340",
  },
  {
    label: "ОКАТО",
    value: "75412000000",
  },
  {
    label: "ОКТМО",
    value: "75712000001",
  },
  {
    label: "ОКФС",
    value: "16\nЧастная собственность",
  },
  {
    label: "ОКОПФ",
    value: "12300\nОбщества с ограниченной ответственностью",
  },
]
</script>