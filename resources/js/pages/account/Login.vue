<template>
  <div class="mx-auto max-w-md px-4 py-14">
    <section
      class="rounded-[32px] border p-8 md:p-10"
      style="background: var(--panel); border-color: var(--panel-border);"
    >
      <div class="text-xs uppercase tracking-[0.18em]" style="color: var(--text-muted)">
        Кабинет заказчика
      </div>

      <h1 class="mt-3 text-3xl font-semibold" style="color: var(--text)">
        Вход в личный кабинет
      </h1>

      <p class="mt-3 text-sm leading-7" style="color: var(--text-soft)">
        Войдите, чтобы видеть проекты, сроки, статусы и основную информацию по работе.
      </p>

      <form class="mt-8 space-y-4" @submit.prevent="submit">
        <div>
          <label class="mb-2 block text-sm font-medium" style="color: var(--text)">
            Email
          </label>
          <input
            v-model="form.email"
            type="email"
            class="input"
            placeholder="client@example.com"
            autocomplete="email"
          />
        </div>

        <div>
          <label class="mb-2 block text-sm font-medium" style="color: var(--text)">
            Пароль
          </label>
          <input
            v-model="form.password"
            type="password"
            class="input"
            placeholder="Введите пароль"
            autocomplete="current-password"
          />
        </div>

        <label class="flex items-center gap-3 text-sm" style="color: var(--text-soft)">
          <input v-model="form.remember" type="checkbox" />
          <span>Запомнить меня</span>
        </label>

        <button type="submit" class="btn-primary w-full justify-center" :disabled="loading">
          {{ loading ? "Входим..." : "Войти" }}
        </button>

        <div v-if="error" class="rounded-2xl border px-4 py-3 text-sm text-red-300"
             style="border-color: rgba(239,68,68,.25); background: rgba(239,68,68,.08);">
          {{ error }}
        </div>
      </form>
    </section>
  </div>
</template>

<script setup>
import { reactive, ref } from "vue"
import { useRouter, useRoute } from "vue-router"
import { login } from "../../composables/useAuth"

const router = useRouter()
const route = useRoute()

const loading = ref(false)
const error = ref("")

const form = reactive({
  email: "",
  password: "",
  remember: true,
})

async function submit() {
  loading.value = true
  error.value = ""

  try {
    await login(form.email, form.password, form.remember)
    router.push(route.query.redirect || "/account")
  } catch (e) {
    error.value = "Не удалось войти. Проверьте email и пароль."
  } finally {
    loading.value = false
  }
}
</script>