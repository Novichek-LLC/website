<template>
  <div class="space-y-8">
    <section
      class="rounded-[32px] border p-8 md:p-10"
      style="background: var(--panel); border-color: var(--panel-border);"
    >
      <div class="text-xs uppercase tracking-[0.18em]" style="color: var(--text-muted)">
        Профиль
      </div>
      <h1 class="mt-2 text-3xl font-semibold md:text-4xl" style="color: var(--text)">
        Профиль клиента
      </h1>
      <p class="mt-3 max-w-3xl text-sm leading-7 md:text-base" style="color: var(--text-soft)">
        Основные данные пользователя и компании. На следующем этапе сюда можно добавить полноценное редактирование реквизитов и контактных лиц.
      </p>
    </section>

    <section v-if="loading" class="text-sm" style="color: var(--text-soft)">
      Загружаем профиль...
    </section>

    <template v-else-if="data">
      <section class="grid gap-4 md:grid-cols-2">
        <article
          class="rounded-[28px] border p-6"
          style="background: var(--panel); border-color: var(--panel-border);"
        >
          <div class="text-xs uppercase tracking-[0.16em]" style="color: var(--text-muted)">
            Пользователь
          </div>

          <div class="mt-5 space-y-4 text-sm">
            <div>
              <div style="color: var(--text-muted)">Имя</div>
              <div class="mt-1 font-medium" style="color: var(--text)">{{ data.user.name }}</div>
            </div>
            <div>
              <div style="color: var(--text-muted)">Email</div>
              <div class="mt-1 font-medium" style="color: var(--text)">{{ data.user.email }}</div>
            </div>
          </div>
        </article>

        <article
          class="rounded-[28px] border p-6"
          style="background: var(--panel); border-color: var(--panel-border);"
        >
          <div class="text-xs uppercase tracking-[0.16em]" style="color: var(--text-muted)">
            Компания
          </div>

          <div class="mt-5 space-y-4 text-sm">
            <div>
              <div style="color: var(--text-muted)">Название</div>
              <div class="mt-1 font-medium" style="color: var(--text)">{{ data.company.name }}</div>
            </div>
            <div>
              <div style="color: var(--text-muted)">Контактное лицо</div>
              <div class="mt-1 font-medium" style="color: var(--text)">{{ data.company.contact_person || "Не указано" }}</div>
            </div>
            <div>
              <div style="color: var(--text-muted)">Email</div>
              <div class="mt-1 font-medium" style="color: var(--text)">{{ data.company.email || "Не указан" }}</div>
            </div>
            <div>
              <div style="color: var(--text-muted)">Телефон</div>
              <div class="mt-1 font-medium" style="color: var(--text)">{{ data.company.phone || "Не указан" }}</div>
            </div>
          </div>
        </article>
      </section>
    </template>
  </div>
</template>

<script setup>
import axios from "axios"
import { onMounted, ref } from "vue"

const loading = ref(true)
const data = ref(null)

onMounted(async () => {
  try {
    const response = await axios.get("/api/account/dashboard")
    data.value = response.data
  } finally {
    loading.value = false
  }
})
</script>