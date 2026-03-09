<template>
  <div class="container-shell pt-16">
    <SectionHeader eyebrow="Каталог услуг" title="Все направления компании в одном цифровом контуре" description="От внедрения 1С и маркировки до сайтов, лейбла и автоматизации. Каждую страницу можно усиливать SEO-контентом, кейсами и отдельными формами." />
    <div class="mt-10">
      <ServiceGrid :services="services" />
    </div>
    <LeadForm />
  </div>
</template>

<script setup>
import SectionHeader from '@/components/SectionHeader.vue';
import ServiceGrid from '@/components/ServiceGrid.vue';
import LeadForm from '@/components/LeadForm.vue';
import { services } from '@/data';
</script>
