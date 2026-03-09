<template><section class="card grid gap-6 p-6 md:grid-cols-4"><div v-for="item in items" :key="item.label"><div class="text-3xl font-bold">{{ item.value }}</div><div class="mt-2 text-sm text-slate-400">{{ item.label }}</div></div></section></template>
<script setup>
const items = [{ value: '8+', label: 'направлений услуг' }, { value: '24/7', label: 'поддержка и сопровождение' }, { value: '100+', label: 'сценариев автоматизации' }, { value: 'CRM', label: 'сквозная работа с лидами' }]
</script>
