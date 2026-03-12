<template>
  <div class="grid gap-8 md:grid-cols-2">
    <section>
      <h1 class="section-title">Контакты</h1>
      <p class="muted mt-4">
        Напишите нам по задаче, и мы вернёмся с планом, оценкой и предложением по этапам запуска.
      </p>

      <div class="mt-6 space-y-4 text-sm text-slate-300">
        <div class="card p-5">
          <div class="text-slate-400">Email</div>
          <div class="mt-1 text-white">hello@novichek.su</div>
        </div>
        <div class="card p-5">
          <div class="text-slate-400">Telegram</div>
          <div class="mt-1 text-white">@novichek</div>
        </div>
        <div class="card p-5">
          <div class="text-slate-400">Телефон</div>
          <div class="mt-1 text-white">+7 (900) 000-00-00</div>
        </div>
      </div>
    </section>

    <LeadForm :initial-service="prefilledService" :initial-message="prefilledMessage" />
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useRoute } from 'vue-router'
import LeadForm from "../components/LeadForm.vue"

const route = useRoute()

const prefilledService = computed(() => String(route.query.service || ''))
const prefilledMessage = computed(() => String(route.query.message || ''))
</script>
