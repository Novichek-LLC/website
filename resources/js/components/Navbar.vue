<template>
  <header class="sticky top-0 z-50 border-b border-white/10 bg-[#08111f]/90 backdrop-blur-xl">
    <div class="mx-auto flex h-[68px] max-w-[1280px] items-center justify-between px-4 sm:px-6 lg:px-8">
      <router-link to="/" class="flex items-center gap-3 shrink-0">
        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-500 text-white shadow-[0_10px_24px_rgba(79,93,255,0.28)]">
          <span class="text-sm font-extrabold">N</span>
        </div>

        <div class="leading-none">
          <div class="text-[12px] font-extrabold uppercase tracking-[0.18em] text-white">
            НОВИЧЁК
          </div>
          <div class="mt-1 text-[11px] text-slate-400">
            Automation & Digital
          </div>
        </div>
      </router-link>

      <PopoverGroup class="hidden items-center gap-1 xl:flex">
        <Popover class="relative">
          <PopoverButton class="nav-trigger">
            <span>Услуги</span>
            <ChevronDownIcon class="h-4 w-4" aria-hidden="true" />
          </PopoverButton>

          <transition
            enter-active-class="transition ease-out duration-150"
            enter-from-class="opacity-0 translate-y-1"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition ease-in duration-100"
            leave-from-class="opacity-100 translate-y-0"
            leave-to-class="opacity-0 translate-y-1"
          >
            <PopoverPanel class="absolute left-0 top-full z-20 mt-3 w-[860px] max-w-max">
              <div class="overflow-hidden rounded-[24px] border border-white/10 bg-[#0e1930] p-3 shadow-[0_30px_80px_rgba(2,8,23,0.5)]">
                <div class="grid grid-cols-3 gap-2">
                  <router-link
                    v-for="item in services"
                    :key="item.name"
                    :to="item.href"
                    class="group relative flex gap-x-4 rounded-2xl p-4 transition hover:bg-white/5"
                  >
                    <div class="mt-0.5 flex h-11 w-11 flex-none items-center justify-center rounded-xl bg-white/5 text-slate-400 transition group-hover:bg-white/10 group-hover:text-white">
                      <component :is="item.icon" class="h-5 w-5" aria-hidden="true" />
                    </div>

                    <div>
                      <div class="text-[14px] font-semibold text-white">
                        {{ item.name }}
                      </div>
                      <p class="mt-1 text-[12px] leading-5 text-slate-400">
                        {{ item.description }}
                      </p>
                    </div>
                  </router-link>
                </div>
              </div>
            </PopoverPanel>
          </transition>
        </Popover>

        <Popover class="relative">
          <PopoverButton class="nav-trigger">
            <span>Решения</span>
            <ChevronDownIcon class="h-4 w-4" aria-hidden="true" />
          </PopoverButton>

          <transition
            enter-active-class="transition ease-out duration-150"
            enter-from-class="opacity-0 translate-y-1"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition ease-in duration-100"
            leave-from-class="opacity-100 translate-y-0"
            leave-to-class="opacity-0 translate-y-1"
          >
            <PopoverPanel class="absolute left-0 top-full z-20 mt-3 w-[720px] max-w-max">
              <div class="overflow-hidden rounded-[24px] border border-white/10 bg-[#0e1930] p-3 shadow-[0_30px_80px_rgba(2,8,23,0.5)]">
                <div class="grid grid-cols-2 gap-2">
                  <router-link
                    v-for="item in solutions"
                    :key="item.name"
                    :to="item.href"
                    class="group relative flex gap-x-4 rounded-2xl p-4 transition hover:bg-white/5"
                  >
                    <div class="mt-0.5 flex h-11 w-11 flex-none items-center justify-center rounded-xl bg-white/5 text-slate-400 transition group-hover:bg-white/10 group-hover:text-white">
                      <component :is="item.icon" class="h-5 w-5" aria-hidden="true" />
                    </div>

                    <div>
                      <div class="text-[14px] font-semibold text-white">
                        {{ item.name }}
                      </div>
                      <p class="mt-1 text-[12px] leading-5 text-slate-400">
                        {{ item.description }}
                      </p>
                    </div>
                  </router-link>
                </div>
              </div>
            </PopoverPanel>
          </transition>
        </Popover>

        <Popover class="relative">
          <PopoverButton class="nav-trigger">
            <span>Ресурсы</span>
            <ChevronDownIcon class="h-4 w-4" aria-hidden="true" />
          </PopoverButton>

          <transition
            enter-active-class="transition ease-out duration-150"
            enter-from-class="opacity-0 translate-y-1"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition ease-in duration-100"
            leave-from-class="opacity-100 translate-y-0"
            leave-to-class="opacity-0 translate-y-1"
          >
            <PopoverPanel class="absolute left-0 top-full z-20 mt-3 w-[560px] max-w-max">
              <div class="overflow-hidden rounded-[24px] border border-white/10 bg-[#0e1930] p-3 shadow-[0_30px_80px_rgba(2,8,23,0.5)]">
                <div class="grid grid-cols-2 gap-2">
                  <router-link
                    v-for="item in resources"
                    :key="item.name"
                    :to="item.href"
                    class="group relative flex gap-x-4 rounded-2xl p-4 transition hover:bg-white/5"
                  >
                    <div class="mt-0.5 flex h-11 w-11 flex-none items-center justify-center rounded-xl bg-white/5 text-slate-400 transition group-hover:bg-white/10 group-hover:text-white">
                      <component :is="item.icon" class="h-5 w-5" aria-hidden="true" />
                    </div>

                    <div>
                      <div class="text-[14px] font-semibold text-white">
                        {{ item.name }}
                      </div>
                      <p class="mt-1 text-[12px] leading-5 text-slate-400">
                        {{ item.description }}
                      </p>
                    </div>
                  </router-link>
                </div>
              </div>
            </PopoverPanel>
          </transition>
        </Popover>

        <router-link to="/cases" class="nav-trigger nav-trigger--plain">Кейсы</router-link>
        <router-link to="/pricing" class="nav-trigger nav-trigger--plain">Тарифы</router-link>
        <router-link to="/contacts" class="nav-trigger nav-trigger--plain">Контакты</router-link>
      </PopoverGroup>

      <div class="hidden items-center gap-3 xl:flex">
        <a href="#lead-form" class="inline-flex h-10 items-center justify-center rounded-xl border border-white/10 bg-white/5 px-4 text-[13px] font-semibold text-white transition hover:bg-white/10">
          Обсудить проект
        </a>
        <router-link
          to="/contacts"
          class="inline-flex h-10 items-center justify-center rounded-xl bg-indigo-500 px-4 text-[13px] font-semibold text-white transition hover:bg-indigo-400"
        >
          Оставить заявку
        </router-link>
      </div>

      <button
        class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-white/10 bg-white/5 text-white xl:hidden"
        @click="mobileOpen = !mobileOpen"
      >
        <Bars3Icon class="h-5 w-5" />
      </button>
    </div>

    <div v-if="mobileOpen" class="border-t border-white/10 bg-[#08111f] xl:hidden">
      <div class="mx-auto flex max-w-[1280px] flex-col gap-1 px-4 py-4 sm:px-6 lg:px-8">
        <router-link to="/services" class="mobile-link">Услуги</router-link>
        <router-link to="/solutions" class="mobile-link">Решения</router-link>
        <router-link to="/cases" class="mobile-link">Кейсы</router-link>
        <router-link to="/pricing" class="mobile-link">Тарифы</router-link>
        <router-link to="/contacts" class="mobile-link">Контакты</router-link>
        <router-link
          to="/contacts"
          class="mt-2 inline-flex h-10 items-center justify-center rounded-xl bg-indigo-500 px-4 text-[13px] font-semibold text-white transition hover:bg-indigo-400"
        >
          Оставить заявку
        </router-link>
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref } from 'vue'
import { Popover, PopoverButton, PopoverPanel, PopoverGroup } from '@headlessui/vue'
import { ChevronDownIcon } from '@heroicons/vue/20/solid'
import {
  Bars3Icon,
  CircleStackIcon,
  Cog6ToothIcon,
  CpuChipIcon,
  GlobeAltIcon,
  MegaphoneIcon,
  PaintBrushIcon,
  ShieldCheckIcon,
  ChatBubbleBottomCenterTextIcon,
  BuildingOffice2Icon,
  ShoppingBagIcon,
  RocketLaunchIcon,
  BriefcaseIcon,
  BookOpenIcon,
  DocumentTextIcon,
  LifebuoyIcon,
  PhoneIcon,
  MusicalNoteIcon,
} from '@heroicons/vue/24/outline'

const mobileOpen = ref(false)

const services = [
  { name: '1С: установка и настройка', description: 'Внедрение, обновление и сопровождение 1С.', href: '/services/1c', icon: CircleStackIcon },
  { name: 'Маркировка и Контур', description: 'Честный знак, интеграции и рабочие процессы.', href: '/services/marking', icon: ShieldCheckIcon },
  { name: 'Создание сайтов', description: 'Современные сайты и продающие digital-решения.', href: '/services/sites', icon: GlobeAltIcon },
  { name: 'Чат-боты и автоматизация', description: 'Боты, CRM и автоматизация внутренних процессов.', href: '/services/bots', icon: ChatBubbleBottomCenterTextIcon },
  { name: 'VPN и инфраструктура', description: 'Безопасный доступ и стабильная работа команды.', href: '/services/vpn', icon: CpuChipIcon },
  { name: 'Дизайн', description: 'Интерфейсы, фирменный стиль и визуальные материалы.', href: '/services/design', icon: PaintBrushIcon },
  { name: 'Музыкальная дистрибуция', description: 'Лейбл, релизы и цифровые площадки.', href: '/services/music', icon: MusicalNoteIcon },
  { name: 'Пескоструйные работы', description: 'Промышленное направление компании.', href: '/services/sandblasting', icon: Cog6ToothIcon },
  { name: 'Сопровождение и интеграции', description: 'Поддержка, доработки и развитие систем.', href: '/services/support', icon: BriefcaseIcon },
]

const solutions = [
  { name: 'Для ритейла', description: 'Продажи, маркировка, учёт и процессы.', href: '/solutions/retail', icon: ShoppingBagIcon },
  { name: 'Для бизнеса', description: 'Сайт, CRM и автоматизация под ключ.', href: '/solutions/business', icon: BuildingOffice2Icon },
  { name: 'Для digital-команд', description: 'Лиды, контент, маркетинг и автоматизация.', href: '/solutions/digital', icon: RocketLaunchIcon },
  { name: 'Для удалённых команд', description: 'Безопасный доступ и стабильная инфраструктура.', href: '/solutions/remote', icon: ShieldCheckIcon },
]

const resources = [
  { name: 'О компании', description: 'Кто мы, чем занимаемся и как работаем.', href: '/about', icon: BriefcaseIcon },
  { name: 'Блог', description: 'Материалы по автоматизации, 1С и digital.', href: '/blog', icon: BookOpenIcon },
  { name: 'FAQ', description: 'Частые вопросы и быстрые ответы.', href: '/faq', icon: LifebuoyIcon },
  { name: 'Контакты', description: 'Как быстро с нами связаться.', href: '/contacts', icon: PhoneIcon },
]
</script>