<template>
  <form @submit.prevent="submit" class="card grid gap-4 p-6">
    <div class="grid gap-4 md:grid-cols-2"><input v-model="form.name" class="input" placeholder="Ваше имя" /><input v-model="form.phone" class="input" placeholder="Телефон" /></div>
    <div class="grid gap-4 md:grid-cols-2"><input v-model="form.email" class="input" placeholder="Email" /><select v-model="form.service" class="input"><option value="Сайт">Сайт</option><option value="1С">1С</option><option value="Маркировка">Маркировка</option><option value="Чат-бот">Чат-бот</option></select></div>
    <textarea v-model="form.message" rows="5" class="input" placeholder="Коротко опишите задачу"></textarea>
    <div class="flex items-center justify-between gap-3"><div class="text-sm text-slate-400">{{ sent ? 'Заявка отправлена' : 'Ответим в ближайшее время' }}</div><button class="btn-primary" :disabled="loading">{{ loading ? 'Отправка...' : 'Отправить' }}</button></div>
  </form>
</template>
<script setup>
import axios from "axios"
import { reactive, ref } from "vue"
const loading = ref(false)
const sent = ref(false)
const form = reactive({ service: "Сайт", name: "", company: "", email: "", phone: "", telegram: "", message: "" })
async function submit() {
  loading.value = true
  sent.value = false
  try { await axios.post("/api/leads", form); sent.value = true; form.name=""; form.email=""; form.phone=""; form.message=""; } finally { loading.value = false }
}
</script>
