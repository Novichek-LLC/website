<template>
  <div class="rounded-[32px] border border-white/10 bg-white/[0.05] p-6 shadow-[0_24px_80px_rgba(2,8,23,0.35)] backdrop-blur-xl md:p-8">
    <form class="grid gap-4" @submit.prevent="submit">
      <div class="grid gap-4 md:grid-cols-2">
        <input v-model="form.name" type="text" class="input" placeholder="Ваше имя" />
        <input v-model="form.phone" type="text" class="input" placeholder="Телефон" />
      </div>

      <div class="grid gap-4 md:grid-cols-2">
        <input v-model="form.email" type="email" class="input" placeholder="Email" />
        <input v-model="form.company" type="text" class="input" placeholder="Компания" />
      </div>

      <select v-model="form.service" class="input">
        <option value="">Выберите услугу</option>
        <option value="1c">1С</option>
        <option value="marking">Маркировка</option>
        <option value="sites">Создание сайтов</option>
        <option value="bots">Чат-боты</option>
        <option value="automation">Автоматизация</option>
        <option value="support">Сопровождение</option>
        <option value="vpn">VPN</option>
        <option value="music">Музыкальная дистрибуция</option>
        <option value="design">Дизайн</option>
      </select>

      <textarea
        v-model="form.message"
        rows="5"
        class="input"
        placeholder="Опишите задачу"
      />

      <div class="flex flex-wrap items-center gap-3">
        <button type="submit" class="btn-nav-primary" :disabled="loading">
          {{ loading ? 'Отправка...' : 'Отправить заявку' }}
        </button>

        <div v-if="success" class="text-sm text-emerald-300">
          Заявка отправлена. Скоро свяжемся.
        </div>
      </div>
    </form>
  </div>
</template>

<script setup>
import axios from 'axios'
import { reactive, ref, watch } from 'vue'

const props = defineProps({
  initialService: {
    type: String,
    default: '',
  },
  initialMessage: {
    type: String,
    default: '',
  },
})

const loading = ref(false)
const success = ref(false)

const form = reactive({
  name: '',
  phone: '',
  email: '',
  company: '',
  service: props.initialService,
  message: props.initialMessage,
})

watch(() => props.initialService, (value) => {
  if (value) form.service = value
})

watch(() => props.initialMessage, (value) => {
  if (value) form.message = value
})

async function submit() {
  loading.value = true
  success.value = false

  try {
    await axios.post('/api/leads', form)
    success.value = true

    form.name = ''
    form.phone = ''
    form.email = ''
    form.company = ''
    form.service = props.initialService || ''
    form.message = ''
  } finally {
    loading.value = false
  }
}
</script>
