<template><section class="space-y-8"><SectionHeader title="Блог" text="Публикации по 1С, автоматизации, сайтам, маркировке и процессам бизнеса." /><div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3"><article v-for="item in items" :key="item.id" class="card p-6"><h3 class="text-xl font-semibold">{{ item.title }}</h3><p class="mt-3 text-sm text-slate-400">{{ item.excerpt }}</p><router-link class="mt-5 inline-flex text-sm font-medium text-indigo-300" :to="`/blog/${item.slug}`">Читать</router-link></article></div></section></template>
<script setup>
import axios from "axios"
import { onMounted, ref } from "vue"
import SectionHeader from "../components/SectionHeader.vue"
const items = ref([])
onMounted(async () => { const res = await axios.get("/api/blog"); items.value = res.data })
</script>
