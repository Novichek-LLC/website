<template><section v-if="item" class="space-y-8"><div><div class="text-sm text-indigo-300">{{ item.service }}</div><h1 class="section-title mt-2">{{ item.title }}</h1><p class="muted mt-4 max-w-3xl">{{ item.summary }}</p></div><div class="card p-6 whitespace-pre-line text-slate-300">{{ item.content }}</div></section></template>
<script setup>
import axios from "axios"
import { onMounted, ref } from "vue"
import { useRoute } from "vue-router"
const route = useRoute()
const item = ref(null)
onMounted(async () => { const res = await axios.get(`/api/cases/${route.params.slug}`); item.value = res.data })
</script>
