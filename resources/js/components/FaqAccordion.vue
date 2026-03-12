<template>
  <section class="space-y-6">
    <div class="card p-5">
      <label class="text-sm text-slate-300">
        Поиск по вопросам
        <input v-model="query" class="input mt-2" type="text" placeholder="Например: 1С, сроки, чат-бот" />
      </label>
    </div>

    <div class="space-y-3">
      <div v-for="item in filteredItems" :key="item.id" class="card overflow-hidden">
        <button
          class="flex w-full items-start justify-between gap-4 px-5 py-4 text-left"
          @click="toggle(item.id)"
        >
          <span class="font-medium text-white">{{ item.question }}</span>
          <span class="text-slate-400">{{ openId === item.id ? '−' : '+' }}</span>
        </button>

        <div v-if="openId === item.id" class="border-t border-white/10 px-5 py-4 text-sm leading-7 text-slate-300">
          {{ item.answer }}
        </div>
      </div>
    </div>

    <p v-if="!filteredItems.length" class="muted text-sm">По вашему запросу ничего не найдено. Попробуйте другое слово.</p>
  </section>
</template>

<script setup>
import { computed, ref } from 'vue'

const props = defineProps({
  items: {
    type: Array,
    required: true,
  },
})

const query = ref('')
const openId = ref(null)

const filteredItems = computed(() => {
  if (!query.value.trim()) return props.items

  const normalized = query.value.toLowerCase()
  return props.items.filter((item) => (
    item.question.toLowerCase().includes(normalized) || item.answer.toLowerCase().includes(normalized)
  ))
})

function toggle(id) {
  openId.value = openId.value === id ? null : id
}
</script>
