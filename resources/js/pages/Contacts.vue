<template>
  <div class="space-y-12">
    <section class="rounded-[32px] border border-white/10 bg-[radial-gradient(circle_at_top_left,rgba(79,93,255,0.16),transparent_34%),radial-gradient(circle_at_bottom_right,rgba(34,211,238,0.10),transparent_32%),rgba(255,255,255,0.04)] p-8 md:p-10 lg:p-12">
      <div class="max-w-4xl">
        <div class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-medium text-slate-300">
          <EnvelopeIcon class="h-4 w-4" />
          Контакты ООО "НОВИЧЁК"
        </div>

        <h1 class="mt-5 text-4xl font-semibold tracking-tight text-white md:text-6xl">
          Приходите с задачей, проблемой или просто с хаосом — разберёмся
        </h1>

        <p class="mt-5 max-w-3xl text-base leading-8 text-slate-300 md:text-lg">
          Можно обратиться по 1С, маркировке, сайтам, автоматизации, инфраструктуре,
          игровым серверам или сопровождению. Если пока неясно, с чего начать —
          поможем определить первый разумный шаг.
        </p>

        <div class="mt-8 flex flex-wrap gap-3">
          <a href="#lead-form" class="btn-primary">Оставить заявку</a>
          <a href="#details" class="btn-secondary">Реквизиты и контакты</a>
        </div>
      </div>
    </section>

    <section class="grid gap-6 md:grid-cols-3">
      <article
        v-for="item in quickContacts"
        :key="item.title"
        class="rounded-[28px] border border-white/10 bg-white/[0.04] p-6"
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

        <div class="mt-4 text-sm leading-7 text-slate-200 whitespace-pre-line">
          {{ item.value }}
        </div>
      </article>
    </section>

    <section class="grid gap-8 lg:grid-cols-[0.9fr_1.1fr]">
      <div class="space-y-6">
        <div class="rounded-[28px] border border-white/10 bg-white/[0.04] p-6 md:p-8">
          <div class="text-xs uppercase tracking-[0.18em] text-slate-500">
            Как лучше написать
          </div>

          <h2 class="mt-3 text-2xl font-semibold text-white md:text-3xl">
            Чем точнее вводные, тем быстрее и полезнее ответ
          </h2>

          <div class="mt-6 grid gap-4 sm:grid-cols-2">
            <div
              v-for="item in briefingTips"
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

        <div class="rounded-[28px] border border-white/10 bg-white/[0.04] p-6 md:p-8">
          <div class="text-xs uppercase tracking-[0.18em] text-slate-500">
            Что можно обсудить
          </div>

          <h2 class="mt-3 text-2xl font-semibold text-white md:text-3xl">
            Типовые запросы, с которыми к нам приходят
          </h2>

          <div class="mt-6 grid gap-3">
            <div
              v-for="topic in topics"
              :key="topic"
              class="flex items-start gap-3 rounded-2xl border border-white/10 bg-white/[0.03] px-4 py-3 text-sm text-slate-300"
            >
              <CheckIcon class="mt-0.5 h-4 w-4 shrink-0 text-cyan-300" />
              <span>{{ topic }}</span>
            </div>
          </div>
        </div>

        <div id="details" class="rounded-[28px] border border-white/10 bg-white/[0.04] p-6 md:p-8">
          <div class="text-xs uppercase tracking-[0.18em] text-slate-500">
            Реквизиты и данные компании
          </div>

          <h2 class="mt-3 text-2xl font-semibold text-white md:text-3xl">
            Основная информация
          </h2>

          <div class="mt-6 grid gap-4 sm:grid-cols-2">
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
      </div>

      <section id="lead-form" class="rounded-[28px] border border-white/10 bg-[linear-gradient(180deg,rgba(255,255,255,0.05),rgba(255,255,255,0.03))] p-6 md:p-8">
        <div class="max-w-xl">
          <div class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-medium text-slate-300">
            <PaperAirplaneIcon class="h-4 w-4" />
            Старт общения
          </div>

          <h2 class="mt-4 text-2xl font-semibold text-white md:text-3xl">
            Опишите задачу — разложим её по шагам
          </h2>

          <p class="mt-3 text-sm leading-7 text-slate-400">
            Можно прийти с идеей, с проблемой или с текущей неработающей схемой.
            Мы предложим понятный путь, приоритеты и объём работ без лишнего перегруза.
          </p>
        </div>

        <div class="mt-6">
          <LeadForm />
        </div>
      </section>
    </section>

    <section class="rounded-[28px] border border-white/10 bg-[linear-gradient(135deg,rgba(79,93,255,0.16),rgba(34,211,238,0.10))] p-8 md:p-10">
      <div class="grid gap-6 lg:grid-cols-[1fr_auto] lg:items-center">
        <div>
          <div class="text-xs uppercase tracking-[0.18em] text-slate-300/70">
            Нужен не просто исполнитель
          </div>

          <h2 class="mt-3 text-2xl font-semibold text-white md:text-3xl">
            Подключимся как системная команда, а не как разовый подрядчик
          </h2>

          <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-300/80">
            Если задача шире одной услуги, поможем собрать рабочую систему:
            от первого аудита и структуры до внедрения, сопровождения и роста.
          </p>
        </div>

        <a href="#lead-form" class="btn-primary">
          Отправить заявку
        </a>
      </div>
    </section>
  </div>
</template>

<script setup>
import LeadForm from "../components/LeadForm.vue"
import {
  CheckIcon,
  ChatBubbleLeftRightIcon,
  EnvelopeIcon,
  MapPinIcon,
  PaperAirplaneIcon,
  PhoneIcon,
  BuildingOffice2Icon,
} from "@heroicons/vue/24/outline"

const quickContacts = [
  {
    title: "Основной канал связи",
    text: "Лучше всего оставить заявку через форму — так мы быстрее поймём контекст и не потеряем детали.",
    value: "Форма заявки на этой странице",
    icon: ChatBubbleLeftRightIcon,
  },
  {
    title: "Юридический адрес",
    text: "Официальный адрес организации, который можно использовать для документов и формальных запросов.",
    value: "456234, Челябинская область,\nг. Златоуст, ул. Свободы, д. 14, кв. 2",
    icon: MapPinIcon,
  },
  {
    title: "Руководитель",
    text: "Руководитель компании и основное ответственное лицо со стороны организации.",
    value: "Новичёк Данил Маркович\nДиректор",
    icon: BuildingOffice2Icon,
  },
]

const briefingTips = [
  {
    title: "Что у вас сейчас",
    text: "Коротко опишите текущую схему: сайт, 1С, склад, CRM, сотрудники, бот, сервер или другой контур.",
  },
  {
    title: "Что не работает",
    text: "Где теряются заявки, ломаются процессы, растёт ручная работа, появляются ошибки или тормозит запуск.",
  },
  {
    title: "Что хотите получить",
    text: "Какой результат нужен: больше заявок, порядок в учёте, маркировка без сбоев, стабильный сервер, автоматизация.",
  },
  {
    title: "Сроки и ограничения",
    text: "Есть ли срочность, дедлайны, ограничения по бюджету, внутренние согласования или внешние требования.",
  },
]

const topics = [
  "Настройка и внедрение 1С под реальные процессы компании",
  "Маркировка товаров и связка со складом, продажами и учётом",
  "Создание корпоративного сайта, landing page или digital-платформы",
  "Автоматизация заявок, CRM-сценариев, уведомлений и рутинных операций",
  "Настройка Telegram-ботов и связка с внутренними системами",
  "VPN, доступы и инфраструктурная база для команды",
  "Запуск и сопровождение игровых серверов Minecraft и Rust",
  "Поддержка уже существующего проекта, который нужно привести в порядок",
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
    label: "ОКОГУ",
    value: "4210014\nОрганизации, учрежденные юридическими лицами или гражданами, или юридическими лицами и гражданами совместно",
  },
  {
    label: "ОКОПФ",
    value: "12300\nОбщества с ограниченной ответственностью",
  },
  {
    label: "Все реквизиты",
    value: "ФНС / ПФР / ФСС / РОССТАТ",
  },
]
</script>