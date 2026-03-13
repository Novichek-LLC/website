<template>
  <div class="space-y-10">
    <section class="rounded-[32px] border border-white/10 bg-[radial-gradient(circle_at_top_left,rgba(99,102,241,0.16),transparent_34%),radial-gradient(circle_at_bottom_right,rgba(34,211,238,0.10),transparent_32%),rgba(255,255,255,0.04)] p-8 md:p-10 lg:p-12">
      <div class="max-w-4xl">
        <div class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-medium text-slate-300">
          <IdentificationIcon class="h-4 w-4" />
          Реквизиты компании
        </div>

        <h1 class="mt-5 text-4xl font-semibold tracking-tight text-white md:text-6xl">
          Юридические данные и реквизиты Общества с ограниченной ответственность "НОВИЧЁК"
        </h1>

        <p class="mt-5 max-w-3xl text-base leading-8 text-slate-300 md:text-lg">
          На этой странице собрана основная регистрационная и юридическая информация компании,
          которую можно использовать для проверки данных и подготовки документов.
        </p>
      </div>
    </section>

    <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
      <article
        v-for="item in requisites"
        :key="item.label"
        class="rounded-[28px] border border-white/10 bg-white/[0.04] p-6"
      >
        <div class="text-xs uppercase tracking-[0.14em] text-slate-500">
          {{ item.label }}
        </div>

        <div class="mt-3 whitespace-pre-line text-sm leading-7 text-slate-200">
          {{ item.value }}
        </div>
      </article>
    </section>
  </div>
</template>

<script setup>
import { IdentificationIcon } from "@heroicons/vue/24/outline"

const requisites = [
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
    label: "ОКОГУ",
    value: "4210014\nОрганизации, учрежденные юридическими лицами или гражданами, или юридическими лицами и гражданами совместно",
  },
  {
    label: "ОКОПФ",
    value: "12300\nОбщества с ограниченной ответственностью",
  },
  {
    label: "Дополнительно",
    value: "Все реквизиты: ФНС / ПФР / ФСС / РОССТАТ",
  },
]
</script>