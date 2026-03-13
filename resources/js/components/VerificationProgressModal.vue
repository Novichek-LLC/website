<template>
  <Teleport to="body">
    <transition
      enter-active-class="transition duration-300 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition duration-200 ease-in"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div v-if="modelValue" class="verification-modal-overlay">
        <div class="verification-modal">
          <div class="verification-modal-header">
            <div class="verification-modal-header-grid">
              <div>
                <div class="text-xs uppercase tracking-[0.18em]" style="color: var(--text-muted)">
                  Центр лицензирования
                </div>

                <h3 class="verification-modal-title mt-2">
                  Идёт защищённая проверка объекта
                </h3>

                <p class="verification-modal-subtitle">
                  Выполняем многоэтапную верификацию, проверяем внутренний реестр и ожидаем ответ от ресурса.
                </p>
              </div>

              <div class="verification-modal-progress-box">
                <div class="verification-spinner"></div>

                <div>
                  <div class="text-xs uppercase tracking-[0.16em]" style="color: var(--text-muted)">
                    Выполнение
                  </div>
                  <div class="mt-1 text-lg font-semibold" style="color: var(--text)">
                    {{ progress }}%
                  </div>
                </div>
              </div>
            </div>

            <div class="verification-modal-progress-track">
              <div
                class="verification-modal-progress-bar"
                :style="{ width: `${progress}%` }"
              ></div>
            </div>

            <div class="verification-modal-progress-meta">
              <div style="color: var(--text-soft)">
                {{ currentStepTitle }}
              </div>
              <div style="color: var(--text-muted)">
                {{ formattedElapsed }}
              </div>
            </div>
          </div>

          <div class="verification-modal-body">
            <div class="verification-modal-col verification-modal-col--left">
              <div class="text-xs uppercase tracking-[0.18em]" style="color: var(--text-muted)">
                Этапы проверки
              </div>

              <div class="mt-5">
                <div
                  v-for="(step, index) in steps"
                  :key="step.key"
                  class="verification-stage-card"
                  :class="{
                    'verification-stage-card--done': step.status === 'done',
                    'verification-stage-card--active': step.status === 'active',
                  }"
                >
                  <div class="flex items-start gap-4">
                    <div
                      class="verification-stage-icon"
                      :class="{
                        'verification-stage-icon--done': step.status === 'done',
                        'verification-stage-icon--active': step.status === 'active',
                      }"
                    >
                      <CheckIcon v-if="step.status === 'done'" class="h-5 w-5" />
                      <ClockIcon v-else-if="step.status === 'pending'" class="h-5 w-5" />
                      <ArrowPathIcon v-else class="h-5 w-5 animate-spin" />
                    </div>

                    <div class="min-w-0">
                      <div class="flex flex-wrap items-center gap-3">
                        <div class="text-sm font-semibold" style="color: var(--text)">
                          {{ index + 1 }}. {{ step.title }}
                        </div>

                        <span
                          class="verification-stage-badge"
                          :class="{
                            'verification-stage-badge--done': step.status === 'done',
                            'verification-stage-badge--active': step.status === 'active',
                          }"
                        >
                          {{ stepLabel(step.status) }}
                        </span>
                      </div>

                      <div class="mt-2 text-sm leading-7" style="color: var(--text-soft)">
                        {{ step.description }}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="verification-modal-col verification-modal-col--right">
              <div class="text-xs uppercase tracking-[0.18em]" style="color: var(--text-muted)">
                Журнал проверки
              </div>

              <div class="verification-log-box mt-5">
                <div class="mb-3 flex items-center justify-between gap-3">
                  <div class="text-sm font-semibold" style="color: var(--text)">
                    Системные события
                  </div>

                  <div
                    class="rounded-full border px-3 py-1 text-xs"
                    style="border-color: var(--panel-border); color: var(--text-muted);"
                  >
                    live
                  </div>
                </div>

                <div class="verification-log-list">
                  <div
                    v-for="(log, index) in logs"
                    :key="`${index}-${log}`"
                    class="verification-log-item"
                  >
                    {{ log }}
                  </div>
                </div>
              </div>

              <div class="verification-info-card">
                <div class="text-sm font-semibold" style="color: var(--text)">
                  Что происходит сейчас
                </div>

                <p class="mt-3 text-sm leading-7" style="color: var(--text-soft)">
                  {{ currentStepDescription }}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </Teleport>
</template>

<script setup>
import { computed } from "vue"
import { ArrowPathIcon, CheckIcon, ClockIcon } from "@heroicons/vue/24/outline"

const props = defineProps({
  modelValue: {
    type: Boolean,
    default: false,
  },
  progress: {
    type: Number,
    default: 0,
  },
  elapsed: {
    type: Number,
    default: 0,
  },
  steps: {
    type: Array,
    default: () => [],
  },
  logs: {
    type: Array,
    default: () => [],
  },
})

const currentStep = computed(() => {
  return props.steps.find((step) => step.status === "active") || props.steps.at(-1) || null
})

const currentStepTitle = computed(() => {
  return currentStep.value?.title || "Подготовка проверки"
})

const currentStepDescription = computed(() => {
  return currentStep.value?.description || "Идёт обработка данных."
})

const formattedElapsed = computed(() => {
  const seconds = Math.floor(props.elapsed / 1000)
  const min = Math.floor(seconds / 60)
  const sec = String(seconds % 60).padStart(2, "0")
  return `${min}:${sec}`
})

function stepLabel(status) {
  if (status === "done") return "Готово"
  if (status === "active") return "В процессе"
  return "Ожидание"
}
</script>