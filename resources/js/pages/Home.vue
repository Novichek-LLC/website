<template><div class="space-y-20"><HeroSection /><StatsStrip /><ServicesGrid /><section class="grid gap-6 md:grid-cols-2"><div><h2 class="section-title">Проектируем процессы под задачи компании</h2><p class="muted mt-4">Собираем сайт, CRM-воронку, уведомления, блог, кейсы, чат, админку и интеграции в одной системе.</p></div><LeadForm /></section></div></template>
<script setup>
import HeroSection from "../components/HeroSection.vue"
import ServicesGrid from "../components/ServicesGrid.vue"
import LeadForm from "../components/LeadForm.vue"
import StatsStrip from "../components/StatsStrip.vue"
</script>
