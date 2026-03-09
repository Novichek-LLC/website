<template>
  <div class="container-shell pt-16">
    <SectionHeader eyebrow="Admin" title="Панель ответов на сообщения из чат-виджета" description="Прототип админского интерфейса. Сюда можно добавить авторизацию, real-time обновления, фильтры и назначение ответственного менеджера." />
    <div class="mt-10 grid gap-6 lg:grid-cols-[380px,1fr]">
      <div class="glass rounded-4xl p-4">
        <div class="mb-4 flex items-center justify-between">
          <div class="text-sm text-slate-400">Диалоги</div>
          <button class="btn-secondary px-3 py-2 text-xs" @click="load">Обновить</button>
        </div>
        <div class="space-y-3">
          <button
            v-for="item in conversations"
            :key="item.id"
            class="w-full rounded-3xl border border-white/10 bg-white/5 p-4 text-left transition hover:bg-white/10"
            @click="select(item)"
          >
            <div class="flex items-center justify-between gap-3">
              <div class="font-medium">{{ item.client_name || 'Гость' }}</div>
              <div class="text-xs uppercase tracking-[0.2em] text-brand-300">{{ item.status }}</div>
            </div>
            <div class="mt-2 text-sm text-slate-400">{{ item.client_contact || 'Без контакта' }}</div>
          </button>
        </div>
      </div>

      <div class="glass rounded-4xl p-6">
        <div v-if="current">
          <div class="flex items-center justify-between gap-4">
            <div>
              <div class="text-2xl font-semibold">{{ current.client_name || 'Гость' }}</div>
              <div class="mt-1 text-sm text-slate-400">{{ current.client_contact || 'Контакт не указан' }}</div>
            </div>
            <select v-model="current.status" class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3" @change="updateStatus">
              <option value="new">new</option>
              <option value="active">active</option>
              <option value="closed">closed</option>
            </select>
          </div>
          <div class="mt-6 max-h-[420px] space-y-3 overflow-y-auto rounded-3xl border border-white/10 bg-slate-950/70 p-4">
            <div v-for="message in current.messages" :key="message.id" :class="message.role === 'admin' ? 'text-right' : 'text-left'">
              <div :class="message.role === 'admin' ? 'inline-block rounded-2xl bg-brand-500 px-4 py-3 text-sm text-white' : 'inline-block rounded-2xl bg-white/5 px-4 py-3 text-sm text-slate-100'">
                {{ message.body }}
              </div>
            </div>
          </div>
          <form class="mt-4 flex gap-3" @submit.prevent="reply">
            <input v-model="replyText" class="flex-1 rounded-2xl border border-white/10 bg-white/5 px-4 py-3 outline-none" placeholder="Ответ клиенту" />
            <button class="btn-primary">Отправить</button>
          </form>
        </div>
        <div v-else class="text-slate-400">Выберите диалог слева.</div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import axios from 'axios';
import SectionHeader from '@/components/SectionHeader.vue';

const conversations = ref([]);
const current = ref(null);
const replyText = ref('');

const load = async () => {
  const { data } = await axios.get('/api/admin/chat/conversations');
  conversations.value = data;
  if (!current.value && data.length) current.value = data[0];
};

const select = (item) => {
  current.value = item;
};

const reply = async () => {
  if (!current.value || !replyText.value.trim()) return;
  const { data } = await axios.post(`/api/admin/chat/${current.value.id}/reply`, { body: replyText.value });
  current.value = data;
  replyText.value = '';
  await load();
};

const updateStatus = async () => {
  if (!current.value) return;
  const { data } = await axios.post(`/api/admin/chat/${current.value.id}/status`, { status: current.value.status });
  current.value = data;
  await load();
};

onMounted(load);
</script>
