<template>
  <div class="flex min-h-screen items-center justify-center bg-[#07111f] px-6 text-white">
    <form
      class="w-full max-w-md rounded-3xl border border-white/10 bg-white/5 p-6"
      @submit.prevent="submit"
    >
      <div class="text-2xl font-semibold">Регистрация</div>
      <div class="mt-2 text-sm text-slate-400">
        Создайте аккаунт клиента
      </div>

      <div
        v-if="error"
        class="mt-4 rounded-2xl border border-rose-400/20 bg-rose-400/10 px-4 py-3 text-sm text-rose-200"
      >
        {{ error }}
      </div>

      <div class="mt-6 space-y-4">
        <input
          v-model="form.name"
          type="text"
          placeholder="Имя"
          class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none placeholder:text-slate-500"
        >

        <input
          v-model="form.email"
          type="email"
          placeholder="E-mail"
          class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none placeholder:text-slate-500"
        >

        <input
          v-model="form.password"
          type="password"
          placeholder="Пароль"
          class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none placeholder:text-slate-500"
        >

        <input
          v-model="form.password_confirmation"
          type="password"
          placeholder="Подтвердите пароль"
          class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none placeholder:text-slate-500"
        >

        <button
          :disabled="loading"
          type="submit"
          class="w-full rounded-2xl bg-cyan-400 px-4 py-3 text-sm font-semibold text-slate-950 disabled:opacity-60"
        >
          {{ loading ? 'Создаём...' : 'Создать аккаунт' }}
        </button>

        <RouterLink
          to="/login"
          class="block text-center text-sm text-cyan-300 hover:text-cyan-200"
        >
          Уже есть аккаунт? Войти
        </RouterLink>
      </div>
    </form>
  </div>
</template>

<script setup>
import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import { register } from '../../api/auth'

const router = useRouter()

const loading = ref(false)
const error = ref('')

const form = reactive({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
})

async function submit() {
  loading.value = true
  error.value = ''

  try {
    await register(form)
    router.push('/account')
  } catch (e) {
    error.value = e?.response?.data?.message || 'Не удалось создать аккаунт.'
  } finally {
    loading.value = false
  }
}
</script>