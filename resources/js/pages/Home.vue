<template>
  <div>
    <section class="relative">
      <div class="mx-auto max-w-[1280px] px-4 pt-14 pb-20 sm:px-6 lg:px-8 lg:pt-20 lg:pb-24">
        <div class="grid items-center gap-12 lg:grid-cols-[1.08fr_0.92fr]">
          <div>
            <div class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-medium text-slate-300">
              <span class="inline-block h-2 w-2 rounded-full bg-emerald-400"></span>
              Автоматизация, digital и инфраструктура
            </div>

            <h1 class="mt-6 max-w-4xl text-4xl font-semibold leading-[1.06] tracking-tight text-white md:text-5xl xl:text-[60px]">
              1С, сайты, маркировка,
              <span class="text-indigo-300">автоматизация</span>
              и IT-решения для бизнеса
            </h1>

            <p class="mt-6 max-w-2xl text-[17px] leading-8 text-slate-300 md:text-[18px]">
              Собираем цельную систему: заявки, процессы, CRM, учёт, поддержку, интеграции и развитие после запуска.
            </p>

            <div class="mt-8 flex flex-wrap gap-3">
              <a href="#lead-form" class="btn-primary">Получить консультацию</a>
              <router-link to="/services" class="btn-secondary">Посмотреть услуги</router-link>
            </div>

            <div class="mt-10 grid max-w-3xl gap-4 sm:grid-cols-3">
              <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-5 backdrop-blur-md">
                <div class="text-2xl font-bold text-white">10+</div>
                <div class="mt-2 text-sm text-slate-400">направлений услуг</div>
              </div>
              <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-5 backdrop-blur-md">
                <div class="text-2xl font-bold text-white">B2B</div>
                <div class="mt-2 text-sm text-slate-400">ориентация на результат</div>
              </div>
              <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-5 backdrop-blur-md">
                <div class="text-2xl font-bold text-white">Под ключ</div>
                <div class="mt-2 text-sm text-slate-400">от запуска до сопровождения</div>
              </div>
            </div>
          </div>

          <div class="relative">
            <div class="rounded-[28px] border border-white/10 bg-white/[0.05] p-4 shadow-[0_24px_80px_rgba(2,8,23,0.35)] backdrop-blur-2xl">
              <div class="overflow-hidden rounded-[22px] border border-white/10 bg-[#0d1730]/80">
                <div class="flex items-center justify-between border-b border-white/10 px-5 py-4">
                  <div>
                    <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Системы НОВИЧЁК</div>
                    <div class="mt-1 text-base font-semibold text-white">Как выглядит работа с нами</div>
                  </div>
                  <div class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-medium text-slate-300">
                    Пошагово
                  </div>
                </div>

                <div class="space-y-3 p-4">
                  <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-4">
                    <div class="text-xs uppercase tracking-[0.14em] text-slate-500">01</div>
                    <div class="mt-2 text-sm font-semibold text-white">Разбираем задачу</div>
                    <div class="mt-2 text-sm leading-6 text-slate-400">
                      Смотрим, где бизнес теряет время, деньги и управляемость.
                    </div>
                  </div>

                  <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-4">
                    <div class="text-xs uppercase tracking-[0.14em] text-slate-500">02</div>
                    <div class="mt-2 text-sm font-semibold text-white">Проектируем решение</div>
                    <div class="mt-2 text-sm leading-6 text-slate-400">
                      Определяем, что именно нужно: сайт, 1С, маркировка, CRM, бот, интеграции.
                    </div>
                  </div>

                  <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-4">
                    <div class="text-xs uppercase tracking-[0.14em] text-slate-500">03</div>
                    <div class="mt-2 text-sm font-semibold text-white">Запускаем и сопровождаем</div>
                    <div class="mt-2 text-sm leading-6 text-slate-400">
                      После запуска поддерживаем, дорабатываем и усиливаем результат.
                    </div>
                  </div>
                </div>

                <div class="border-t border-white/10 bg-white/[0.03] px-5 py-4 text-sm text-slate-300">
                  Один подрядчик вместо хаоса из разных исполнителей.
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="relative">
      <div class="mx-auto max-w-[1280px] px-4 py-8 sm:px-6 lg:px-8">
        <div class="rounded-[24px] border border-white/10 bg-white/[0.04] p-6 backdrop-blur-xl">
          <div class="grid gap-6 lg:grid-cols-[0.9fr_1.1fr] lg:items-center">
            <div>
              <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Что получает клиент</div>
              <h2 class="mt-3 text-2xl font-semibold text-white md:text-3xl">
                Не набор услуг, а рабочую систему роста
              </h2>
            </div>

            <div class="grid gap-5 sm:grid-cols-3">
              <div>
                <div class="text-sm font-semibold text-white">Больше заявок</div>
                <div class="mt-2 text-sm leading-6 text-slate-400">
                  Сайт, формы, боты и грамотный маршрут клиента.
                </div>
              </div>
              <div>
                <div class="text-sm font-semibold text-white">Меньше хаоса</div>
                <div class="mt-2 text-sm leading-6 text-slate-400">
                  1С, CRM, маркировка, уведомления и понятные процессы.
                </div>
              </div>
              <div>
                <div class="text-sm font-semibold text-white">Больше контроля</div>
                <div class="mt-2 text-sm leading-6 text-slate-400">
                  Единая ответственность и сопровождение после запуска.
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="relative">
      <div class="mx-auto max-w-[1280px] px-4 py-16 sm:px-6 lg:px-8 lg:py-24">
        <div class="max-w-3xl">
          <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Ключевые направления</div>
          <h2 class="mt-3 text-3xl font-semibold tracking-tight text-white md:text-5xl">
            Всё, что нужно бизнесу для продаж, процессов и стабильной работы
          </h2>
          <p class="mt-4 text-base leading-8 text-slate-400 md:text-lg">
            Собираем сильную комбинацию из автоматизации, digital, интеграций и сопровождения.
          </p>
        </div>

        <div class="mt-10 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
          <article
            v-for="item in services"
            :key="item.title"
            class="group rounded-[24px] border border-white/10 bg-white/[0.04] p-6 transition hover:-translate-y-1 hover:bg-white/[0.06]"
          >
            <div class="flex items-start justify-between gap-4">
              <div class="flex h-12 w-12 items-center justify-center rounded-2xl border border-white/10 bg-white/5 text-white">
                <component :is="item.icon" class="h-6 w-6" />
              </div>
              <span class="text-xs uppercase tracking-[0.18em] text-slate-500">{{ item.tag }}</span>
            </div>

            <h3 class="mt-5 text-lg font-semibold text-white">{{ item.title }}</h3>
            <p class="mt-3 text-sm leading-7 text-slate-400">{{ item.text }}</p>

            <router-link
              :to="item.link"
              class="mt-6 inline-flex items-center gap-2 text-sm font-medium text-cyan-200 transition group-hover:text-white"
            >
              Подробнее
              <ArrowRightIcon class="h-4 w-4" />
            </router-link>
          </article>
        </div>
      </div>
    </section>

    <section class="relative">
      <div class="mx-auto max-w-[1280px] px-4 py-16 sm:px-6 lg:px-8 lg:py-24">
        <div class="rounded-[32px] border border-white/10 bg-white/[0.04] p-8 md:p-10 lg:p-12">
          <div class="grid gap-8 lg:grid-cols-[0.95fr_1.05fr] lg:items-center">
            <div>
              <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Отдельное направление</div>
              <h2 class="mt-3 text-3xl font-semibold tracking-tight text-white md:text-5xl">
                Игровые серверы для
                <span class="text-indigo-300">Minecraft и Rust</span>
              </h2>
              <p class="mt-4 max-w-2xl text-base leading-8 text-slate-400 md:text-lg">
                Развёртывание, настройка, оптимизация, модификации, защита и сопровождение игровых серверов под ключ.
              </p>

              <div class="mt-6 flex flex-wrap gap-3">
                <router-link to="/services/game-servers" class="btn-primary">
                  Подробнее об игровых серверах
                </router-link>
              </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
              <div class="rounded-3xl border border-white/10 bg-white/[0.03] p-5">
                <div class="text-base font-semibold text-white">Minecraft</div>
                <div class="mt-2 text-sm leading-7 text-slate-400">
                  Paper, Purpur, Forge, Fabric, модпаки, плагины и оптимизация производительности.
                </div>
              </div>

              <div class="rounded-3xl border border-white/10 bg-white/[0.03] p-5">
                <div class="text-base font-semibold text-white">Rust</div>
                <div class="mt-2 text-sm leading-7 text-slate-400">
                  Настройка Oxide/uMod, плагины, вайпы, балансировка и поддержка сервера.
                </div>
              </div>

              <div class="rounded-3xl border border-white/10 bg-white/[0.03] p-5 sm:col-span-2">
                <div class="text-base font-semibold text-white">Под ключ</div>
                <div class="mt-2 text-sm leading-7 text-slate-400">
                  Подбор конфигурации, запуск, резервные копии, безопасность, мониторинг и сопровождение проекта.
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="relative">
      <div class="mx-auto max-w-[1280px] px-4 py-16 sm:px-6 lg:px-8 lg:py-24">
        <div class="grid gap-8 lg:grid-cols-[0.95fr_1.05fr]">
          <div>
            <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Почему мы</div>
            <h2 class="mt-3 text-3xl font-semibold tracking-tight text-white md:text-5xl">
              Системный подход вместо набора разрозненных услуг
            </h2>
            <p class="mt-4 text-base leading-8 text-slate-400 md:text-lg">
              Мы держим весь контур проекта целиком и не перекладываем ответственность между исполнителями.
            </p>
          </div>

          <div class="grid gap-4 sm:grid-cols-2">
            <div v-for="item in benefits" :key="item.title" class="rounded-3xl border border-white/10 bg-white/[0.04] p-5">
              <div class="flex h-11 w-11 items-center justify-center rounded-2xl border border-white/10 bg-white/5 text-white">
                <component :is="item.icon" class="h-5 w-5" />
              </div>
              <div class="mt-4 text-base font-semibold text-white">{{ item.title }}</div>
              <div class="mt-2 text-sm leading-7 text-slate-400">{{ item.text }}</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="relative">
      <div class="mx-auto max-w-[1280px] px-4 py-16 sm:px-6 lg:px-8 lg:py-24">
        <div class="rounded-[32px] border border-white/10 bg-white/[0.04] p-8 md:p-10 lg:p-12">
          <div class="grid gap-8 lg:grid-cols-[0.9fr_1.1fr] lg:items-center">
            <div>
              <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Как мы работаем</div>
              <h2 class="mt-3 text-3xl font-semibold text-white md:text-5xl">
                Понятный путь от запроса до результата
              </h2>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
              <div v-for="(step, index) in steps" :key="step.title" class="rounded-3xl border border-white/10 bg-white/[0.03] p-5">
                <div class="text-sm font-semibold text-white">0{{ index + 1 }}</div>
                <div class="mt-2 text-base font-semibold text-white">{{ step.title }}</div>
                <div class="mt-2 text-sm leading-7 text-slate-400">{{ step.text }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="relative">
      <div class="mx-auto max-w-[1280px] px-4 py-16 sm:px-6 lg:px-8 lg:py-24">
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
          <div class="max-w-3xl">
            <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Кейсы и результаты</div>
            <h2 class="mt-3 text-3xl font-semibold tracking-tight text-white md:text-5xl">
              Как это выглядит на практике
            </h2>
          </div>

          <router-link to="/cases" class="btn-secondary">
            Смотреть все кейсы
          </router-link>
        </div>

        <div class="mt-10 grid gap-6 lg:grid-cols-3">
          <article v-for="item in cases" :key="item.title" class="rounded-[24px] border border-white/10 bg-white/[0.04] p-6">
            <div class="text-xs uppercase tracking-[0.18em] text-slate-500">{{ item.category }}</div>
            <h3 class="mt-3 text-xl font-semibold text-white">{{ item.title }}</h3>
            <p class="mt-3 text-sm leading-7 text-slate-400">{{ item.text }}</p>

            <div class="mt-6 flex flex-wrap gap-2">
              <span
                v-for="badge in item.badges"
                :key="badge"
                class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs text-slate-300"
              >
                {{ badge }}
              </span>
            </div>
          </article>
        </div>
      </div>
    </section>

    <section class="relative">
      <div class="mx-auto max-w-[1280px] px-4 py-16 sm:px-6 lg:px-8 lg:py-24">
        <div class="grid gap-8 lg:grid-cols-[0.9fr_1.1fr]">
          <div>
            <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Частые вопросы</div>
            <h2 class="mt-3 text-3xl font-semibold tracking-tight text-white md:text-5xl">
              Что обычно спрашивают перед стартом
            </h2>
          </div>

          <div class="space-y-4">
            <div v-for="item in faq" :key="item.q" class="rounded-3xl border border-white/10 bg-white/[0.04] p-5">
              <div class="text-base font-semibold text-white">{{ item.q }}</div>
              <div class="mt-3 text-sm leading-7 text-slate-400">{{ item.a }}</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="lead-form" class="relative">
      <div class="mx-auto max-w-[1280px] px-4 pt-6 pb-20 sm:px-6 lg:px-8 lg:pb-28">
        <div class="grid gap-8 lg:grid-cols-[0.95fr_1.05fr]">
          <div>
            <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Старт проекта</div>
            <h2 class="mt-3 text-3xl font-semibold tracking-tight text-white md:text-5xl">
              Оставь заявку — разложим задачу по шагам и покажем, с чего начать
            </h2>
            <p class="mt-4 text-base leading-8 text-slate-400 md:text-lg">
              Можно прийти с идеей, проблемой или хаосом в процессах. Мы предложим понятный путь и реальный план работ.
            </p>
          </div>

          <LeadForm />
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import LeadForm from '../components/LeadForm.vue'
import {
  ArrowRightIcon,
  ChatBubbleLeftRightIcon,
  CircleStackIcon,
  GlobeAltIcon,
  PaintBrushIcon,
  ShieldCheckIcon,
  SparklesIcon,
  UserGroupIcon,
  ChartBarIcon,
  CpuChipIcon,
  WrenchScrewdriverIcon,
  ServerStackIcon,
} from '@heroicons/vue/24/outline'

const services = [
  {
    title: '1С: установка и настройка',
    tag: 'ERP / Учёт',
    text: 'Внедрение, обновление, настройка ролей, рабочих сценариев и сопровождение после запуска.',
    link: '/services/1c',
    icon: CircleStackIcon,
  },
  {
    title: 'Маркировка и Контур',
    tag: 'Retail / Маркировка',
    text: 'Запуск и выстраивание процессов маркировки товаров, интеграции и рабочей дисциплины.',
    link: '/services/marking',
    icon: ShieldCheckIcon,
  },
  {
    title: 'Создание сайтов',
    tag: 'Web / Sales',
    text: 'Современные корпоративные сайты и digital-платформы, которые помогают продавать.',
    link: '/services/sites',
    icon: GlobeAltIcon,
  },
  {
    title: 'Чат-боты и автоматизация',
    tag: 'Automation',
    text: 'Боты, уведомления, CRM-сценарии, автоворонки и сокращение ручной рутины.',
    link: '/services/bots',
    icon: ChatBubbleLeftRightIcon,
  },
  {
    title: 'VPN и инфраструктура',
    tag: 'Security / Remote',
    text: 'Защищённый доступ, стабильная работа команды и инфраструктурная база для роста.',
    link: '/services/vpn',
    icon: CpuChipIcon,
  },
  {
    title: 'Игровые серверы',
    tag: 'Game Hosting',
    text: 'Minecraft и Rust: запуск, настройка, оптимизация и сопровождение серверов.',
    link: '/services/game-servers',
    icon: ServerStackIcon,
  },
]

const benefits = [
  {
    title: 'Одна команда вместо набора подрядчиков',
    text: 'Ты не собираешь сайт, 1С, интеграции, контент и сопровождение по кускам.',
    icon: UserGroupIcon,
  },
  {
    title: 'Фокус на бизнес-результате',
    text: 'Смотрим на заявки, управляемость, скорость работы и экономику процессов.',
    icon: ChartBarIcon,
  },
  {
    title: 'Плотное сопровождение после запуска',
    text: 'Не пропадаем после релиза: поддерживаем, дорабатываем и усиливаем результат.',
    icon: WrenchScrewdriverIcon,
  },
  {
    title: 'Сильная связка digital + автоматизация',
    text: 'Продажи, учёт, операционка и инфраструктура работают как единая система.',
    icon: SparklesIcon,
  },
]

const steps = [
  {
    title: 'Разбираем задачу',
    text: 'Понимаем, где сейчас узкие места и где лежит основной потенциал роста.',
  },
  {
    title: 'Проектируем решение',
    text: 'Собираем реалистичную схему: сайт, CRM, 1С, маркировка, бот, интеграции.',
  },
  {
    title: 'Запускаем и связываем всё в систему',
    text: 'Не разрозненные куски, а один работающий контур.',
  },
  {
    title: 'Сопровождаем и усиливаем',
    text: 'После запуска собираем обратную связь, аналитику и развиваем результат.',
  },
]

const cases = [
  {
    category: 'Ритейл / маркировка',
    title: 'Навели порядок в маркировке и связали процессы с учётом',
    text: 'Убрали ручные ошибки, ускорили работу сотрудников и сделали схему понятной для бизнеса.',
    badges: ['Маркировка', '1С', 'Интеграции'],
  },
  {
    category: 'Digital / продажи',
    title: 'Собрали сайт, формы заявок и коммуникации в единую воронку',
    text: 'Клиент перестал терять обращения, получил понятный маршрут пользователя и базу для роста рекламы.',
    badges: ['Сайт', 'UX', 'Лиды'],
  },
  {
    category: 'Game Hosting',
    title: 'Настроили игровые серверы с устойчивой производительностью',
    text: 'Подобрали конфигурацию, оптимизировали окружение и обеспечили стабильную работу игровых проектов.',
    badges: ['Minecraft / Rust', 'Оптимизация', 'Сопровождение'],
  },
]

const faq = [
  {
    q: 'Можно ли зайти с одной задачей, а потом масштабировать проект?',
    a: 'Да. Часто всё начинается с сайта, 1С или маркировки, а дальше мы расширяем систему до CRM, ботов, интеграций и поддержки.',
  },
  {
    q: 'Вы можете взять проект под ключ и дальше сопровождать?',
    a: 'Да. Это один из наших сильных сценариев: запуск и дальнейшее развитие без постоянной смены подрядчиков.',
  },
  {
    q: 'Работаете только с крупными компаниями?',
    a: 'Нет. Подходим и для малого/среднего бизнеса, если нужен системный результат, а не разовая услуга ради галочки.',
  },
]
</script>