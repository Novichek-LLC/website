<template>
  <div class="fixed bottom-5 right-5 z-[80]">
    <transition name="fade-slide">
      <div
        v-if="open"
        class="mb-4 w-[380px] max-w-[calc(100vw-24px)] overflow-hidden rounded-[28px] border border-white/10 bg-[#0c1730]/95 shadow-[0_24px_80px_rgba(2,8,23,0.55)] backdrop-blur-2xl"
      >
        <div class="flex items-center justify-between border-b border-white/10 px-5 py-4">
          <div class="flex items-center gap-3">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#4f5dff] text-white font-bold">
              N
            </div>
            <div>
              <div class="text-sm font-semibold text-white">Поддержка NOVICHEK</div>
              <div class="text-xs text-emerald-300">Онлайн-чат</div>
            </div>
          </div>

          <button class="text-slate-400 hover:text-white" @click="open = false">✕</button>
        </div>

        <div v-if="!conversationUuid && !started" class="px-5 py-5">
          <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-4">
            <div class="text-sm font-medium text-white">Здравствуйте 👋</div>
            <div class="mt-2 text-sm leading-6 text-slate-400">
              Напишите нам, и мы поможем с 1С, маркировкой, сайтом, ботами, игровыми серверами или автоматизацией.
            </div>
          </div>
        </div>

        <div class="h-[360px] space-y-3 overflow-y-auto px-4 py-4" ref="messagesBox">
          <div
            v-for="m in messages"
            :key="m.id"
            class="max-w-[85%] rounded-2xl px-4 py-3 text-sm leading-6"
            :class="m.sender_type === 'guest'
              ? 'ml-auto border border-cyan-300/15 bg-cyan-400/12 text-cyan-50'
              : 'border border-white/10 bg-white/[0.05] text-white'"
          >
            {{ m.message }}
          </div>
        </div>

        <div class="border-t border-white/10 p-4">
          <div v-if="!started" class="mb-3 grid gap-3">
            <input v-model="visitor.name" class="input !mb-0" placeholder="Ваше имя" />
            <input v-model="visitor.email" class="input !mb-0" placeholder="Email" />
          </div>

          <div class="flex gap-2">
            <input
              v-model="message"
              class="input !mb-0"
              placeholder="Напишите сообщение..."
              @keyup.enter="send"
            />
            <button class="btn-primary min-w-[52px] px-0" @click="send" :disabled="sending">
              →
            </button>
          </div>

          <div v-if="errorText" class="mt-2 text-xs text-rose-300">
            {{ errorText }}
          </div>
        </div>
      </div>
    </transition>

    <button
      class="relative flex h-16 w-16 items-center justify-center rounded-full bg-[linear-gradient(135deg,#4f5dff_0%,#6f9bff_100%)] text-2xl text-white shadow-[0_20px_50px_rgba(79,93,255,0.42)]"
      @click="toggleOpen"
    >
      💬
      <span
        v-if="unreadCount > 0 && !open"
        class="absolute -right-1 -top-1 flex h-6 min-w-[24px] items-center justify-center rounded-full bg-rose-500 px-1 text-xs font-bold text-white"
      >
        {{ unreadCount }}
      </span>
    </button>
  </div>
</template>

<script setup>
import axios from 'axios'
import { nextTick, onBeforeUnmount, onMounted, ref, watch } from 'vue'

const open = ref(false)
const started = ref(false)
const sending = ref(false)
const message = ref('')
const errorText = ref('')
const messages = ref([])
const unreadCount = ref(0)
const conversationUuid = ref(localStorage.getItem('chat_conversation_uuid') || '')
const lastMessageId = ref(Number(localStorage.getItem('chat_last_message_id') || 0))
const messagesBox = ref(null)
let intervalId = null

const visitor = ref({
  name: localStorage.getItem('chat_visitor_name') || '',
  email: localStorage.getItem('chat_visitor_email') || '',
})

function normalizePayload() {
  const payload = {
    message: message.value.trim(),
  }

  const name = visitor.value.name?.trim()
  const email = visitor.value.email?.trim()

  if (name) payload.visitor_name = name
  if (email) payload.visitor_email = email

  return payload
}

function toggleOpen() {
  open.value = !open.value
  if (open.value) {
    unreadCount.value = 0
    localStorage.setItem('chat_unread_count', '0')
    fetchMessages()
  }
}

async function send() {
  errorText.value = ''

  const payload = normalizePayload()

  if (!payload.message) {
    errorText.value = 'Введите сообщение'
    return
  }

  sending.value = true

  try {
    if (!conversationUuid.value) {
      const res = await axios.post('/api/chat/conversations', payload)

      started.value = true
      conversationUuid.value = res.data.conversation.uuid
      localStorage.setItem('chat_conversation_uuid', conversationUuid.value)
      localStorage.setItem('chat_visitor_name', payload.visitor_name || '')
      localStorage.setItem('chat_visitor_email', payload.visitor_email || '')

      messages.value = [res.data.message]
      rememberLastMessage()
    } else {
      const res = await axios.post(`/api/chat/conversations/${conversationUuid.value}/messages`, {
        message: payload.message,
      })

      started.value = true
      messages.value.push(res.data.message)
      rememberLastMessage()
    }

    message.value = ''
    scrollToBottom()
  } catch (e) {
    if (e.response?.status === 422) {
      const errors = e.response?.data?.errors || {}
      const firstError = Object.values(errors)?.flat?.()[0]
      errorText.value = firstError || 'Проверьте корректность введённых данных'
    } else {
      errorText.value = 'Не удалось отправить сообщение'
    }

    console.error(e)
  } finally {
    sending.value = false
  }
}

async function fetchMessages() {
  if (!conversationUuid.value) return

  const res = await axios.get(`/api/chat/conversations/${conversationUuid.value}/messages`)
  const oldLastId = lastMessageId.value
  messages.value = res.data
  rememberLastMessage()

  const newAdminMessages = messages.value.filter(
    m => m.sender_type !== 'guest' && m.id > oldLastId
  )

  if (!open.value && newAdminMessages.length > 0) {
    unreadCount.value += newAdminMessages.length
    localStorage.setItem('chat_unread_count', String(unreadCount.value))
  }

  scrollToBottom()
}

function rememberLastMessage() {
  if (!messages.value.length) return
  const id = messages.value[messages.value.length - 1].id
  lastMessageId.value = id
  localStorage.setItem('chat_last_message_id', String(id))
}

async function scrollToBottom() {
  await nextTick()
  if (messagesBox.value) {
    messagesBox.value.scrollTop = messagesBox.value.scrollHeight
  }
}

onMounted(async () => {
  unreadCount.value = Number(localStorage.getItem('chat_unread_count') || 0)

  if (conversationUuid.value) {
    started.value = true
    await fetchMessages()
  }

  intervalId = setInterval(fetchMessages, 4000)
})

onBeforeUnmount(() => {
  if (intervalId) clearInterval(intervalId)
})

watch(open, async value => {
  if (value) {
    unreadCount.value = 0
    localStorage.setItem('chat_unread_count', '0')
    await fetchMessages()
  }
})
</script>