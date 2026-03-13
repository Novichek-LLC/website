<template>
  <div class="space-y-12">
    <section class="rounded-[34px] border border-white/10 bg-[radial-gradient(circle_at_top_left,rgba(129,140,248,0.22),transparent_34%),radial-gradient(circle_at_bottom_right,rgba(34,211,238,0.16),transparent_28%),rgba(255,255,255,0.05)] p-8 md:p-10 lg:p-12 shadow-[0_24px_80px_rgba(2,8,23,0.32)]">
      <div class="max-w-5xl">
        <div class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/10 px-3 py-1 text-xs font-medium text-slate-200">
          <component :is="page.heroIcon" class="h-4 w-4" />
          {{ page.eyebrow }}
        </div>

        <h1 class="mt-5 text-4xl font-semibold tracking-tight text-white md:text-6xl">
          {{ page.title }}
        </h1>

        <p class="mt-5 max-w-3xl text-base leading-8 text-slate-200 md:text-lg">
          {{ page.description }}
        </p>

        <div class="mt-8 flex flex-wrap gap-3">
          <router-link :to="page.primaryLink || '/contacts'" class="btn-primary">
            {{ page.primaryLabel || 'Обсудить решение' }}
          </router-link>
          <router-link :to="page.secondaryLink || '/services'" class="btn-secondary">
            {{ page.secondaryLabel || 'Посмотреть услуги' }}
          </router-link>
        </div>
      </div>
    </section>

    <section class="grid gap-6 md:grid-cols-3">
      <article
        v-for="item in page.audience"
        :key="item.title"
        class="rounded-[28px] border border-white/10 bg-white/[0.05] p-6 shadow-[0_18px_50px_rgba(2,8,23,0.18)]"
      >
        <div class="flex h-12 w-12 items-center justify-center rounded-2xl border border-white/10 bg-white/5 text-white">
          <component :is="item.icon" class="h-6 w-6" />
        </div>
        <h2 class="mt-5 text-xl font-semibold text-white">{{ item.title }}</h2>
        <p class="mt-3 text-sm leading-7 text-slate-400">{{ item.text }}</p>
      </article>
    </section>

    <section class="grid gap-8 lg:grid-cols-[0.95fr_1.05fr] lg:items-start">
      <div>
        <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Какие задачи решаем</div>
        <h2 class="mt-3 text-3xl font-semibold tracking-tight text-white md:text-5xl">
          {{ page.problemsTitle }}
        </h2>
        <p class="mt-4 text-base leading-8 text-slate-400 md:text-lg">
          {{ page.problemsText }}
        </p>
      </div>

      <div class="grid gap-4 sm:grid-cols-2">
        <div
          v-for="item in page.problems"
          :key="item.title"
          class="rounded-3xl border border-white/10 bg-white/[0.04] p-5"
        >
          <div class="text-base font-semibold text-white">{{ item.title }}</div>
          <div class="mt-2 text-sm leading-7 text-slate-400">{{ item.text }}</div>
        </div>
      </div>
    </section>

    <section class="space-y-6">
      <div class="max-w-3xl">
        <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Что входит в решение</div>
        <h2 class="mt-3 text-3xl font-semibold tracking-tight text-white md:text-5xl">
          {{ page.stackTitle }}
        </h2>
      </div>

      <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
        <article
          v-for="item in page.stack"
          :key="item.title"
          class="rounded-[28px] border border-white/10 bg-white/[0.04] p-6"
        >
          <div class="flex h-11 w-11 items-center justify-center rounded-2xl border border-white/10 bg-white/5 text-white">
            <component :is="item.icon" class="h-5 w-5" />
          </div>
          <h3 class="mt-4 text-lg font-semibold text-white">{{ item.title }}</h3>
          <p class="mt-3 text-sm leading-7 text-slate-400">{{ item.text }}</p>
        </article>
      </div>
    </section>

    <section class="rounded-[32px] border border-white/10 bg-white/[0.04] p-8 md:p-10">
      <div class="grid gap-8 lg:grid-cols-[0.9fr_1.1fr] lg:items-center">
        <div>
          <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Результат для клиента</div>
          <h2 class="mt-3 text-3xl font-semibold tracking-tight text-white md:text-5xl">
            {{ page.resultsTitle }}
          </h2>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
          <div
            v-for="item in page.results"
            :key="item.title"
            class="rounded-3xl border border-white/10 bg-white/[0.03] p-5"
          >
            <div class="text-base font-semibold text-white">{{ item.title }}</div>
            <div class="mt-2 text-sm leading-7 text-slate-400">{{ item.text }}</div>
          </div>
        </div>
      </div>
    </section>

    <section class="space-y-6">
      <div class="max-w-3xl">
        <div class="text-xs uppercase tracking-[0.18em] text-slate-500">FAQ</div>
        <h2 class="mt-3 text-3xl font-semibold tracking-tight text-white md:text-5xl">
          Частые вопросы по этому решению
        </h2>
      </div>

      <div class="space-y-4">
        <article
          v-for="(item, index) in page.faq"
          :key="item.q"
          class="rounded-[28px] border border-white/10 bg-white/[0.04] p-6"
        >
          <div class="text-lg font-semibold text-white">
            {{ index + 1 }}. {{ item.q }}
          </div>
          <div class="mt-3 text-sm leading-8 text-slate-400">
            {{ item.a }}
          </div>
        </article>
      </div>
    </section>

    <section class="rounded-[28px] border border-white/10 bg-[linear-gradient(135deg,rgba(99,102,241,0.18),rgba(34,211,238,0.12))] p-8 md:p-10">
      <div class="grid gap-6 lg:grid-cols-[1fr_auto] lg:items-center">
        <div>
          <div class="text-xs uppercase tracking-[0.18em] text-slate-300/70">Следующий шаг</div>
          <h2 class="mt-3 text-2xl font-semibold text-white md:text-3xl">
            {{ page.ctaTitle }}
          </h2>
          <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-300/80">
            {{ page.ctaText }}
          </p>
        </div>

        <router-link :to="page.primaryLink || '/contacts'" class="btn-primary">
          {{ page.primaryLabel || 'Обсудить решение' }}
        </router-link>
      </div>
    </section>
  </div>
</template>

<script setup>
defineProps({
  page: {
    type: Object,
    required: true,
  },
})
</script>
