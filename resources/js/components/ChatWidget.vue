<template>
  <div class="fixed bottom-5 right-5 z-50">
    <transition name="fade">
      <div v-if="opened" class="mb-4 w-[360px] overflow-hidden rounded-4xl border border-white/10 bg-slate-900 shadow-soft">
        <div class="bg-gradient-to-br from-brand-500 to-brand-700 p-5">
          <div class="flex items-center justify-between">
            <div>
              <div class="text-xs uppercase tracking-[0.3em] text-brand-100/80">Онлайн-чат</div>
              <div class="mt-1 text-lg font-semibold text-white">ООО «НОВИЧЁК»</div>
            </div>
            <button class="rounded-full bg-white/15 px-3 py-1 text-sm text-white" @click="opened = false">×</button>
          </div>
          <p class="mt-3 text-sm text-brand-50/90">Напишите задачу — ответим из админки.</p>
        </div>

        <div class="max-h-[320px] space-y-3 overflow-y-auto p-4">
          <div v-if="messages.length === 0" class="rounded-2xl bg-white/5 p-4 text-sm text-slate-300">
            Здравствуйте. Опишите задачу, сроки и удобный контакт.
          </div>
          <div v-for="(msg, index) in messages" :key="index" :class="msg.role === 'client' ? 'text-right' : 'text-left'">
            <div :class="msg.role === 'client' ? 'inline-block rounded-2xl bg-brand-500 px-4 py-3 text-sm text-white' : 'inline-block rounded-2xl bg-white/5 px-4 py-3 text-sm text-slate-100'">
              {{ msg.body }}
            </div>
          </div>
        </div>

        <form class="border-t border-white/10 p-4" @submit.prevent="send">
          <div v-if="!conversationToken" class="mb-3 grid gap-3">
            <input v-model="profile.name" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm outline-none" placeholder="Ваше имя" />
            <input v-model="profile.contact" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm outline-none" placeholder="Email / Telegram / телефон" />
          </div>
          <div class="flex gap-3">
            <input v-model="draft" class="flex-1 rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm outline-none" placeholder="Ваше сообщение" />
            <button class="btn-primary px-4" :disabled="loading">→</button>
          </div>
        </form>
      </div>
    </transition>

    <button @click="opened = !opened" class="flex h-16 w-16 items-center justify-center rounded-full bg-brand-500 text-2xl text-white shadow-soft transition hover:scale-105">
      💬
    </button>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import axios from 'axios';

const opened = ref(false);
const loading = ref(false);
const draft = ref('');
const conversationToken = ref(localStorage.getItem('chat_token') || '');
const messages = ref([]);
const profile = ref({ name: '', contact: '' });

const loadConversation = async () => {
  if (!conversationToken.value) return;
  const { data } = await axios.get(`/api/chat/${conversationToken.value}`);
  messages.value = data.messages || [];
};

const send = async () => {
  if (!draft.value.trim()) return;
  loading.value = true;

  try {
    if (!conversationToken.value) {
      const { data } = await axios.post('/api/chat/start', {
        name: profile.value.name,
        contact: profile.value.contact,
        body: draft.value,
      });
      conversationToken.value = data.token;
      localStorage.setItem('chat_token', data.token);
      messages.value = data.messages;
    } else {
      const { data } = await axios.post(`/api/chat/${conversationToken.value}/message`, {
        body: draft.value,
      });
      messages.value = data.messages;
    }

    draft.value = '';
  } finally {
    loading.value = false;
  }
};

onMounted(loadConversation);
</script>
