<template>
  <header
    class="sticky top-0 z-50 border-b"
    style="background: var(--bg-soft); border-color: var(--panel-border);"
  >
    <div class="mx-auto flex max-w-[1280px] items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
      <router-link to="/" class="flex items-center gap-3">
        <div
          class="flex h-11 w-11 items-center justify-center rounded-2xl font-extrabold"
          style="background: linear-gradient(135deg, var(--brand) 0%, var(--brand-2) 100%); color: white;"
        >
          N
        </div>

        <div class="hidden sm:block">
          <div class="text-[13px] font-bold uppercase tracking-[0.2em]" style="color: var(--text)">
            NOVICHEK
          </div>
          <div class="text-[11px]" style="color: var(--text-muted)">
            Automation • Digital • Infrastructure
          </div>
        </div>
      </router-link>

      <nav class="hidden items-center gap-2 xl:flex">
        <div
          v-for="group in dropdowns"
          :key="group.key"
          class="relative"
          @mouseenter="openMenu(group.key)"
          @mouseleave="scheduleClose(group.key)"
        >
          <div class="flex items-center rounded-2xl" style="background: transparent;">
            <router-link
              :to="group.link"
              class="inline-flex h-11 items-center rounded-l-2xl px-4 text-sm font-medium transition"
              style="color: var(--text-soft);"
              @mouseenter="openMenu(group.key)"
            >
              {{ group.title }}
            </router-link>

            <button
              type="button"
              class="inline-flex h-11 items-center rounded-r-2xl px-3 transition"
              style="color: var(--text-soft);"
              @mouseenter="openMenu(group.key)"
              @click.prevent="toggleMenu(group.key)"
              :aria-expanded="openedMenu === group.key"
            >
              <ChevronDownIcon
                class="h-4 w-4 transition"
                :class="{ 'rotate-180': openedMenu === group.key }"
              />
            </button>
          </div>

          <transition
            enter-active-class="transition duration-150 ease-out"
            enter-from-class="opacity-0 translate-y-2"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition duration-100 ease-in"
            leave-from-class="opacity-100 translate-y-0"
            leave-to-class="opacity-0 translate-y-1"
          >
            <div
              v-if="openedMenu === group.key"
              class="absolute left-0 top-full z-50 mt-3 w-[760px] max-w-[85vw]"
              @mouseenter="cancelClose"
              @mouseleave="scheduleClose(group.key)"
            >
              <div
                class="rounded-[28px] border p-4 shadow-2xl"
                style="background: var(--bg-soft); border-color: var(--panel-border); box-shadow: var(--shadow);"
              >
                <div class="mb-3 flex items-center justify-between px-2">
                  <router-link
                    :to="group.link"
                    class="text-sm font-semibold"
                    style="color: var(--text);"
                    @click="closeMenu"
                  >
                    Перейти в раздел
                  </router-link>

                  <router-link
                    :to="group.link"
                    class="text-sm"
                    style="color: var(--text-muted);"
                    @click="closeMenu"
                  >
                    {{ group.title }}
                  </router-link>
                </div>

                <div class="grid gap-3 md:grid-cols-2">
                  <router-link
                    v-for="item in group.items"
                    :key="item.title"
                    :to="item.link"
                    class="group rounded-2xl border p-4 transition"
                    style="border-color: var(--panel-border); background: var(--panel);"
                    @click="closeMenu"
                  >
                    <div class="flex items-start gap-4">
                      <div
                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl"
                        style="background: var(--panel-strong); border: 1px solid var(--panel-border); color: var(--text);"
                      >
                        <component :is="item.icon" class="h-5 w-5" />
                      </div>

                      <div class="min-w-0">
                        <div class="text-base font-semibold" style="color: var(--text)">
                          {{ item.title }}
                        </div>
                        <div class="mt-1 text-sm leading-6" style="color: var(--text-muted)">
                          {{ item.text }}
                        </div>
                      </div>
                    </div>
                  </router-link>
                </div>
              </div>
            </div>
          </transition>
        </div>

        <router-link to="/cases" class="nav-link-plain">Кейсы</router-link>
        <router-link to="/blog" class="nav-link-plain">Блог</router-link>
        <router-link to="/knowledge" class="nav-link-plain">База знаний</router-link>
      </nav>

      <div class="flex items-center gap-2">
        <router-link to="/contacts" class="btn-primary hidden lg:inline-flex">
          Обсудить проект
        </router-link>

        <button
          type="button"
          class="inline-flex h-11 w-11 items-center justify-center rounded-2xl xl:hidden"
          style="border: 1px solid var(--panel-border); background: var(--panel); color: var(--text);"
          @click="mobileOpen = !mobileOpen"
          aria-label="Открыть меню"
        >
          <XMarkIcon v-if="mobileOpen" class="h-6 w-6" />
          <Bars3Icon v-else class="h-6 w-6" />
        </button>
      </div>
    </div>

    <transition
      enter-active-class="transition duration-150 ease-out"
      enter-from-class="opacity-0 -translate-y-2"
      enter-to-class="opacity-100 translate-y-0"
      leave-active-class="transition duration-100 ease-in"
      leave-from-class="opacity-100 translate-y-0"
      leave-to-class="opacity-0 -translate-y-2"
    >
      <div
        v-if="mobileOpen"
        class="border-t xl:hidden"
        style="border-color: var(--panel-border); background: var(--bg-soft);"
      >
        <div class="mx-auto max-w-[1280px] space-y-6 px-4 py-6 sm:px-6 lg:px-8">
          <div v-for="group in dropdowns" :key="group.key">
            <div class="mb-3 flex items-center justify-between gap-3">
              <router-link
                :to="group.link"
                class="text-xs font-semibold uppercase tracking-[0.18em]"
                style="color: var(--text-muted);"
                @click="mobileOpen = false"
              >
                {{ group.title }}
              </router-link>
            </div>

            <div class="grid gap-2">
              <router-link
                v-for="item in group.items"
                :key="item.title"
                :to="item.link"
                class="rounded-2xl border p-4"
                style="border-color: var(--panel-border); background: var(--panel);"
                @click="mobileOpen = false"
              >
                <div class="flex items-start gap-3">
                  <div
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl"
                    style="background: var(--panel-strong); border: 1px solid var(--panel-border); color: var(--text);"
                  >
                    <component :is="item.icon" class="h-5 w-5" />
                  </div>

                  <div>
                    <div class="text-sm font-semibold" style="color: var(--text)">
                      {{ item.title }}
                    </div>
                    <div class="mt-1 text-sm leading-6" style="color: var(--text-muted)">
                      {{ item.text }}
                    </div>
                  </div>
                </div>
              </router-link>
            </div>
          </div>

          <div class="grid gap-2">
            <router-link to="/cases" class="mobile-link" @click="mobileOpen = false">Кейсы</router-link>
            <router-link to="/blog" class="mobile-link" @click="mobileOpen = false">Блог</router-link>
            <router-link to="/faq" class="mobile-link" @click="mobileOpen = false">FAQ</router-link>
            <router-link to="/documents" class="mobile-link" @click="mobileOpen = false">Документы</router-link>
            <router-link to="/contacts" class="mobile-link" @click="mobileOpen = false">Контакты</router-link>
          </div>

          <router-link to="/contacts" class="btn-primary w-full justify-center" @click="mobileOpen = false">
            Обсудить проект
          </router-link>
        </div>
      </div>
    </transition>
  </header>
</template>

<script setup>
import { ref } from "vue"
import { ChevronDownIcon } from "@heroicons/vue/20/solid"
import {
  Bars3Icon,
  BookOpenIcon,
  BriefcaseIcon,
  BuildingOffice2Icon,
  BuildingStorefrontIcon,
  ChatBubbleBottomCenterTextIcon,
  CircleStackIcon,
  CpuChipIcon,
  GlobeAltIcon,
  LifebuoyIcon,
  MusicalNoteIcon,
  PaintBrushIcon,
  QrCodeIcon,
  RocketLaunchIcon,
  ShieldCheckIcon,
  WrenchScrewdriverIcon,
  XMarkIcon,
} from "@heroicons/vue/24/outline"

const mobileOpen = ref(false)
const openedMenu = ref(null)
let closeTimer = null

const dropdowns = [
  {
    key: "solutions",
    title: "Решения",
    link: "/solutions",
    items: [
      {
        title: "Для ритейла",
        text: "Учёт, маркировка, процессы и стабильная операционная схема.",
        link: "/solutions/retail",
        icon: BuildingStorefrontIcon,
      },
      {
        title: "Для digital-команд",
        text: "Сайты, лиды, коммуникация, UX и внутренняя связность процессов.",
        link: "/solutions/digital-teams",
        icon: RocketLaunchIcon,
      },
      {
        title: "Для бизнеса",
        text: "Заявки, CRM, учёт, автоматизация и управляемая система роста.",
        link: "/solutions/business",
        icon: BriefcaseIcon,
      },
      {
        title: "Для удалённых команд",
        text: "Доступы, инфраструктура, безопасность и удобная распределённая работа.",
        link: "/solutions/remote-teams",
        icon: CpuChipIcon,
      },
    ],
  },
  {
    key: "services",
    title: "Услуги",
    link: "/services",
    items: [
      {
        title: "1С: установка и настройка",
        text: "Внедрение, роли, процессы, учёт и сопровождение.",
        link: "/services/1c",
        icon: CircleStackIcon,
      },
      {
        title: "Чат-боты и автоматизация",
        text: "Боты, уведомления, CRM-сценарии и меньше ручной рутины.",
        link: "/services/bots",
        icon: ChatBubbleBottomCenterTextIcon,
      },
      {
        title: "Музыкальная дистрибуция",
        text: "Релизы, цифровая упаковка и сопровождение музыкальных проектов.",
        link: "/services/music",
        icon: MusicalNoteIcon,
      },
      {
        title: "Маркировка товаров",
        text: "Запуск и поддержка маркировки без хаоса в операционке.",
        link: "/services/marking",
        icon: QrCodeIcon,
      },
      {
        title: "VPN и инфраструктура",
        text: "Безопасный доступ, роли, удалённая работа и инфраструктурный контур.",
        link: "/services/vpn",
        icon: ShieldCheckIcon,
      },
      {
        title: "Пескоструйные работы",
        text: "Очистка, подготовка поверхности и технологическая обработка.",
        link: "/services/sandblast",
        icon: WrenchScrewdriverIcon,
      },
      {
        title: "Создание сайтов",
        text: "Сильные сайты, которые объясняют, продают и собирают заявки.",
        link: "/services/sites",
        icon: GlobeAltIcon,
      },
      {
        title: "Дизайн",
        text: "UX/UI, визуальная система и digital-подача продукта.",
        link: "/services/design",
        icon: PaintBrushIcon,
      },
      {
        title: "Сопровождение и интеграции",
        text: "Поддержка проекта после запуска и связка сервисов в единый контур.",
        link: "/services/automation",
        icon: LifebuoyIcon,
      },
    ],
  },
  {
    key: "company",
    title: "Компания",
    link: "/about",
    items: [
      {
        title: "О компании",
        text: "Подход, принципы работы и юридическая информация.",
        link: "/about",
        icon: BuildingOffice2Icon,
      },
      {
        title: "FAQ",
        text: "Ответы на частые вопросы по услугам, запуску и сопровождению.",
        link: "/faq",
        icon: BookOpenIcon,
      },
      {
        title: "Документы",
        text: "Оферта, политика, согласия, cookies и реквизиты компании.",
        link: "/documents",
        icon: BookOpenIcon,
      },
      {
        title: "Контакты",
        text: "Форма связи, данные компании и официальные каналы общения.",
        link: "/contacts",
        icon: BuildingOffice2Icon,
      },
    ],
  },
]

function openMenu(key) {
  cancelClose()
  openedMenu.value = key
}

function toggleMenu(key) {
  openedMenu.value = openedMenu.value === key ? null : key
}

function closeMenu() {
  cancelClose()
  openedMenu.value = null
}

function scheduleClose(key) {
  cancelClose()
  closeTimer = setTimeout(() => {
    if (openedMenu.value === key) {
      openedMenu.value = null
    }
  }, 140)
}

function cancelClose() {
  if (closeTimer) {
    clearTimeout(closeTimer)
    closeTimer = null
  }
}
</script>