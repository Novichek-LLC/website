<template>
  <div class="container-shell pt-16">
    <SectionHeader eyebrow="Контакты" title="Открыты для проектов, поддержки и партнёрств" description="Добавьте сюда реальные реквизиты, адрес, почту, карту, Telegram и график работы." />
    <div class="mt-10 grid gap-6 lg:grid-cols-3">
      <div class="grid-card lg:col-span-2">
        <div class="text-sm text-slate-400">Связь</div>
        <div class="mt-4 space-y-3 text-lg text-slate-100">
          <div>Email: hello@novichek.ru</div>
          <div>Telegram: @novichek_support</div>
          <div>Телефон: +7 (900) 000-00-00</div>
        </div>
      </div>
      <div class="grid-card">
        <div class="text-sm text-slate-400">Режим работы</div>
        <div class="mt-4 text-lg text-slate-100">Пн–Пт, 09:00–19:00</div>
      </div>
    </div>
    <LeadForm />
  </div>
</template>

<script setup>
import SectionHeader from '@/components/SectionHeader.vue';
import LeadForm from '@/components/LeadForm.vue';
</script>
