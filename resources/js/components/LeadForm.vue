<template>
  <section id="lead-form" class="container-shell mt-20">
    <div class="glass overflow-hidden rounded-4xl p-8 md:p-10">
      <div class="grid gap-10 lg:grid-cols-[1fr,0.9fr]">
        <div>
          <div class="text-sm font-semibold uppercase tracking-[0.3em] text-brand-300">Быстрый старт</div>
          <h3 class="mt-4 text-3xl font-semibold md:text-4xl">Оставьте заявку — предложим архитектуру, сроки и стек</h3>
          <p class="mt-4 max-w-2xl text-slate-300">
            Подходит для внедрения 1С, сайтов, автоматизации, маркировки, чат-ботов и спецпроектов.
          </p>
        </div>

        <form class="space-y-4" @submit.prevent="submit">
          <input v-model="form.name" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 outline-none" placeholder="Ваше имя" />
          <input v-model="form.contact" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 outline-none" placeholder="Телефон / Telegram / Email" />
          <input v-model="form.service" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 outline-none" placeholder="Интересующая услуга" />
          <textarea v-model="form.message" rows="4" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 outline-none" placeholder="Кратко опишите задачу"></textarea>
          <button class="btn-primary w-full" :disabled="loading">{{ loading ? 'Отправляем...' : 'Получить консультацию' }}</button>
          <p v-if="success" class="text-sm text-emerald-400">Заявка отправлена. Мы свяжемся с вами.</p>
        </form>
      </div>
    </div>
  </section>
</template>

<script setup>
import { reactive, ref } from 'vue';
import axios from 'axios';

const loading = ref(false);
const success = ref(false);
const form = reactive({ name: '', contact: '', service: '', message: '' });

const submit = async () => {
  loading.value = true;
  success.value = false;

  try {
    await axios.post('/api/leads', form);
    Object.assign(form, { name: '', contact: '', service: '', message: '' });
    success.value = true;
  } finally {
    loading.value = false;
  }
};
</script>
