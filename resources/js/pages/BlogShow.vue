<template><section v-if="item" class="space-y-8"><div><h1 class="section-title">{{ item.title }}</h1><p class="muted mt-4 max-w-3xl">{{ item.excerpt }}</p></div><div class="card p-6 whitespace-pre-line text-slate-300">{{ item.content }}</div></section></template>
<script setup>
import axios from "axios"
import { onMounted, ref } from "vue"
import { useRoute } from "vue-router"
const route = useRoute()
const item = ref(null)
onMounted(async () => { const res = await axios.get(`/api/blog/${route.params.slug}`); item.value = res.data })
</script>
