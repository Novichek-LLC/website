<template>
  <div class="fixed bottom-5 right-5 z-50">
    <button @click="open = !open" class="btn-primary h-14 w-14 rounded-full p-0 text-xl shadow-2xl">💬</button>
    <div v-if="open" class="card mt-3 flex h-[34rem] w-[22rem] flex-col overflow-hidden">
      <div class="border-b border-slate-800 px-4 py-3"><div class="font-semibold">Чат с поддержкой</div><div class="text-sm text-slate-400">Обычно отвечаем быстро</div></div>
      <div v-if="!conversationUuid" class="grid gap-3 border-b border-slate-800 p-4"><input v-model="visitor.name" class="input" placeholder="Имя" /><input v-model="visitor.email" class="input" placeholder="Email" /></div>
      <div class="flex-1 space-y-3 overflow-y-auto p-4"><div v-for="m in messages" :key="m.id || m.created_at" class="flex" :class="m.sender_type === 'admin' ? 'justify-start' : 'justify-end'"><div class="max-w-[80%] rounded-2xl px-3 py-2 text-sm" :class="m.sender_type === 'admin' ? 'bg-slate-800 text-slate-100' : 'bg-indigo-500 text-white'">{{ m.message }}</div></div></div>
      <form @submit.prevent="send" class="border-t border-slate-800 p-3"><div class="flex gap-2"><input v-model="message" class="input !mb-0" placeholder="Введите сообщение" /><button class="btn-primary shrink-0 px-4">➤</button></div></form>
    </div>
  </div>
</template>
<script setup>
import axios from "axios"
import { reactive, ref } from "vue"
const open = ref(false)
const message = ref("")
const messages = ref([])
const conversationUuid = ref(localStorage.getItem("conversation_uuid") || "")
const visitor = reactive({ name: "", email: "", phone: "" })
async function ensureConversation() {
  if (conversationUuid.value) return
  const res = await axios.post("/api/chat/conversations", { visitor_name: visitor.name, visitor_email: visitor.email, visitor_phone: visitor.phone, message: message.value })
  conversationUuid.value = res.data.conversation.uuid
  localStorage.setItem("conversation_uuid", conversationUuid.value)
  messages.value.push(res.data.message)
  if (window.Echo) { window.Echo.channel(`chat.${conversationUuid.value}`).listen(".message.sent", (e) => { messages.value.push(e) }) }
}
async function send() {
  if (!message.value.trim()) return
  if (!conversationUuid.value) { await ensureConversation(); message.value = ""; return }
  const res = await axios.post(`/api/chat/conversations/${conversationUuid.value}/messages`, { message: message.value })
  messages.value.push(res.data.message)
  message.value = ""
}
</script>
