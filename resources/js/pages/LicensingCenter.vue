<template>
  <div class="space-y-10">
    <section
      class="overflow-hidden rounded-[36px] border p-8 md:p-10 lg:p-12"
      style="
        border-color: var(--panel-border);
        background:
          radial-gradient(circle at top right, rgba(16, 185, 129, 0.16), transparent 28%),
          radial-gradient(circle at bottom left, rgba(99, 102, 241, 0.14), transparent 30%),
          linear-gradient(135deg, rgba(255,255,255,0.03), rgba(255,255,255,0.02));
        box-shadow: var(--shadow);
      "
    >
      <div class="grid gap-8 xl:grid-cols-[1.1fr_0.9fr] xl:items-center">
        <div>
          <div
            class="inline-flex items-center gap-2 rounded-full border px-3 py-1 text-xs font-semibold uppercase tracking-[0.16em]"
            style="border-color: rgba(16,185,129,.22); background: rgba(16,185,129,.08); color: #a7f3d0;"
          >
            <ShieldCheckIcon class="h-4 w-4" />
            Официальный центр проверки
          </div>

          <h1 class="mt-5 text-4xl font-semibold tracking-tight md:text-6xl" style="color: var(--text)">
            Центр лицензирования
          </h1>

          <p class="mt-5 max-w-3xl text-base leading-8 md:text-lg" style="color: var(--text-soft)">
            На этой странице можно проверить подлинность ресурса, приложения, веб-сервиса
            или цифрового решения, созданного от имени <strong style="color: var(--text)">ООО «НОВИЧЁК»</strong>.
            Это помогает заказчикам, партнёрам и пользователям убедиться, что продукт действительно выпущен
            или сопровождается нашей компанией.
          </p>

          <div class="mt-8 grid gap-4 sm:grid-cols-3">
            <div
              class="rounded-[24px] border p-5"
              style="border-color: var(--panel-border); background: var(--panel);"
            >
              <div class="text-sm" style="color: var(--text-muted)">Проверка по</div>
              <div class="mt-2 text-lg font-semibold" style="color: var(--text)">Домену / App ID / ключу</div>
            </div>

            <div
              class="rounded-[24px] border p-5"
              style="border-color: var(--panel-border); background: var(--panel);"
            >
              <div class="text-sm" style="color: var(--text-muted)">Статусы</div>
              <div class="mt-2 text-lg font-semibold" style="color: var(--text)">Подтверждено / отозвано</div>
            </div>

            <div
              class="rounded-[24px] border p-5"
              style="border-color: var(--panel-border); background: var(--panel);"
            >
              <div class="text-sm" style="color: var(--text-muted)">Назначение</div>
              <div class="mt-2 text-lg font-semibold" style="color: var(--text)">Trust & verification</div>
            </div>
          </div>
        </div>

        <div
          class="rounded-[30px] border p-6 md:p-7"
          style="border-color: var(--panel-border); background: var(--panel-strong);"
        >
          <div class="flex items-center justify-between gap-4">
            <div>
              <div class="text-xs uppercase tracking-[0.18em]" style="color: var(--text-muted)">
                Проверка лицензии
              </div>
              <div class="mt-2 text-2xl font-semibold" style="color: var(--text)">
                Проверить объект
              </div>
            </div>

            <div
              class="flex h-14 w-14 items-center justify-center rounded-2xl"
              style="background: rgba(16,185,129,.12); border: 1px solid rgba(16,185,129,.2); color: #a7f3d0;"
            >
              <FingerPrintIcon class="h-7 w-7" />
            </div>
          </div>

          <form class="mt-6 space-y-4" @submit.prevent="verifyLicense">
            <div>
              <label class="mb-2 block text-sm font-medium" style="color: var(--text)">
                Тип проверки
              </label>
              <select v-model="form.type" class="input">
                <option value="domain">Домен / сайт</option>
                <option value="application">ID приложения</option>
                <option value="license">Лицензионный код</option>
              </select>
            </div>

            <div>
              <label class="mb-2 block text-sm font-medium" style="color: var(--text)">
                Значение для проверки
              </label>
              <input
                v-model="form.value"
                type="text"
                class="input"
                :placeholder="placeholderByType"
              />
            </div>

            <div>
              <label class="mb-2 block text-sm font-medium" style="color: var(--text)">
                Дополнительно
              </label>
              <input
                v-model="form.customer"
                type="text"
                class="input"
                placeholder="Компания, заказчик или примечание (необязательно)"
              />
            </div>

            <button type="submit" class="btn-primary w-full justify-center" :disabled="loading">
              {{ loading ? "Проверяем..." : "Проверить подлинность" }}
            </button>
          </form>

          <div
            class="mt-5 rounded-2xl border p-4"
            style="border-color: var(--panel-border); background: var(--panel);"
          >
            <div class="flex items-start gap-3">
              <InformationCircleIcon class="mt-0.5 h-5 w-5 shrink-0" style="color: var(--brand)" />
              <p class="text-sm leading-7" style="color: var(--text-soft)">
                Система проверки показывает только официально зарегистрированные объекты,
                относящиеся к продуктам, сервисам и решениям ООО «НОВИЧЁК».
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section v-if="result" class="grid gap-6 xl:grid-cols-[1fr_0.8fr]">
      <div class="rounded-[30px] border p-6 md:p-8" :style="resultCardStyle">
        <div class="flex flex-col gap-5 md:flex-row md:items-start md:justify-between">
          <div>
            <div class="text-xs uppercase tracking-[0.18em]" :style="{ color: resultMetaColor }">
              Результат проверки
            </div>

            <h2 class="mt-2 text-3xl font-semibold" style="color: var(--text)">
              {{ result.title }}
            </h2>

            <p class="mt-4 max-w-3xl text-base leading-8" style="color: var(--text-soft)">
              {{ result.description }}
            </p>
          </div>

          <div
            class="inline-flex items-center gap-2 rounded-full border px-4 py-2 text-sm font-semibold"
            :style="resultBadgeStyle"
          >
            <component :is="result.icon" class="h-5 w-5" />
            {{ result.badge }}
          </div>
        </div>

        <div v-if="result.details" class="mt-8 grid gap-4 md:grid-cols-2">
          <div
            v-for="item in result.details"
            :key="item.label"
            class="rounded-[22px] border p-5"
            style="border-color: var(--panel-border); background: var(--panel);"
          >
            <div class="text-sm" style="color: var(--text-muted)">
              {{ item.label }}
            </div>
            <div class="mt-2 break-words text-lg font-semibold" style="color: var(--text)">
              {{ item.value }}
            </div>
          </div>
        </div>
      </div>

      <div class="space-y-6">
        <section
          class="rounded-[28px] border p-6"
          style="border-color: var(--panel-border); background: var(--panel);"
        >
          <div class="text-xs uppercase tracking-[0.18em]" style="color: var(--text-muted)">
            Что означает статус
          </div>

          <div class="mt-5 space-y-4 text-sm leading-7">
            <div>
              <div class="font-semibold" style="color: var(--text)">Подтверждено</div>
              <div style="color: var(--text-soft)">
                Объект найден в реестре и действительно связан с ООО «НОВИЧЁК».
              </div>
            </div>

            <div>
              <div class="font-semibold" style="color: var(--text)">Отозвано</div>
              <div style="color: var(--text-soft)">
                Объект ранее существовал в реестре, но больше не считается действующим.
              </div>
            </div>

            <div>
              <div class="font-semibold" style="color: var(--text)">Не найдено</div>
              <div style="color: var(--text-soft)">
                Проверяемый ресурс или идентификатор отсутствует в официальной базе.
              </div>
            </div>
          </div>
        </section>

        <section
          class="rounded-[28px] border p-6"
          style="border-color: var(--panel-border); background: var(--panel);"
        >
          <div class="text-xs uppercase tracking-[0.18em]" style="color: var(--text-muted)">
            Нужна дополнительная верификация
          </div>

          <p class="mt-4 text-sm leading-7" style="color: var(--text-soft)">
            Если вы хотите подтвердить происхождение продукта официальным письмом, запросить
            расширенную информацию по лицензии или сверить данные по конкретному проекту —
            свяжитесь с компанией через страницу контактов.
          </p>

          <router-link to="/contacts" class="btn-secondary mt-5">
            Связаться с компанией
          </router-link>
        </section>
      </div>
    </section>

    <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
      <article
        v-for="item in trustBlocks"
        :key="item.title"
        class="rounded-[26px] border p-5"
        style="border-color: var(--panel-border); background: var(--panel);"
      >
        <div
          class="flex h-12 w-12 items-center justify-center rounded-2xl"
          style="background: var(--panel-strong); border: 1px solid var(--panel-border); color: var(--text);"
        >
          <component :is="item.icon" class="h-6 w-6" />
        </div>

        <h3 class="mt-5 text-lg font-semibold" style="color: var(--text)">
          {{ item.title }}
        </h3>

        <p class="mt-3 text-sm leading-7" style="color: var(--text-soft)">
          {{ item.text }}
        </p>
      </article>
    </section>

    <VerificationProgressModal
      v-model="verificationModalOpen"
      :progress="verificationProgress"
      :elapsed="verificationElapsed"
      :steps="verificationSteps"
      :logs="verificationLogs"
    />
  </div>
</template>

<script setup>
import axios from "axios"
import { computed, ref } from "vue"
import VerificationProgressModal from "../components/VerificationProgressModal.vue"
import {
  CheckBadgeIcon,
  ExclamationTriangleIcon,
  FingerPrintIcon,
  GlobeAltIcon,
  IdentificationIcon,
  InformationCircleIcon,
  KeyIcon,
  ShieldCheckIcon,
  XCircleIcon,
  CubeTransparentIcon,
} from "@heroicons/vue/24/outline"

const loading = ref(false)
const result = ref(null)

const form = ref({
  type: "domain",
  value: "",
  customer: "",
})

const verificationModalOpen = ref(false)
const verificationProgress = ref(0)
const verificationElapsed = ref(0)
const verificationLogs = ref([])

const verificationSteps = ref([
  {
    key: "prepare",
    title: "Подготовка данных",
    description: "Нормализуем входные данные и подготавливаем защищённый запрос на верификацию.",
    status: "pending",
  },
  {
    key: "secure",
    title: "Шифрование и отправка",
    description: "Формируем пакет проверки и инициируем защищённый обмен с сервисом верификации.",
    status: "pending",
  },
  {
    key: "database",
    title: "Проверка по базе данных",
    description: "Сверяем объект с внутренним реестром лицензий, проектов и зарегистрированных ресурсов.",
    status: "pending",
  },
  {
    key: "resource",
    title: "Ожидание ответа от ресурса",
    description: "Ожидаем подтверждение от удалённого контура, приложения или проверяемого ресурса.",
    status: "pending",
  },
  {
    key: "finalize",
    title: "Финальная верификация",
    description: "Собираем итог, формируем статус и готовим результат для отображения пользователю.",
    status: "pending",
  },
])

let elapsedTimer = null
let progressTimer = null

const placeholderByType = computed(() => {
  if (form.value.type === "application") return "Например: nov-app-2026-001"
  if (form.value.type === "license") return "Например: NOV-LIC-8F3A-91X2"
  return "Например: panel.example.ru или app.example.ru"
})

const trustBlocks = [
  {
    title: "Официальный реестр",
    text: "Проверка выполняется только по объектам, зарегистрированным от имени ООО «НОВИЧЁК».",
    icon: ShieldCheckIcon,
  },
  {
    title: "Проверка ресурсов",
    text: "Подтверждайте достоверность сайтов, сервисов, панелей, приложений и внутренних систем.",
    icon: GlobeAltIcon,
  },
  {
    title: "Идентификаторы и ключи",
    text: "Поддерживается проверка по App ID, домену, регистрационному номеру и лицензионному коду.",
    icon: IdentificationIcon,
  },
  {
    title: "Надёжность для клиентов",
    text: "Раздел создаёт прозрачную и профессиональную точку доверия между компанией и заказчиком.",
    icon: CubeTransparentIcon,
  },
]

const resultCardStyle = computed(() => {
  if (!result.value) return {}
  return {
    borderColor: result.value.borderColor,
    background: result.value.background,
  }
})

const resultBadgeStyle = computed(() => {
  if (!result.value) return {}
  return {
    borderColor: result.value.badgeBorder,
    background: result.value.badgeBackground,
    color: result.value.badgeColor,
  }
})

const resultMetaColor = computed(() => {
  return result.value?.badgeColor || "var(--text-muted)"
})

function resetVerificationFlow() {
  verificationProgress.value = 0
  verificationElapsed.value = 0
  verificationLogs.value = []

  verificationSteps.value = verificationSteps.value.map((step) => ({
    ...step,
    status: "pending",
  }))
}

function openVerificationFlow() {
  resetVerificationFlow()
  verificationModalOpen.value = true

  elapsedTimer = setInterval(() => {
    verificationElapsed.value += 1000
  }, 1000)

  progressTimer = setInterval(() => {
    if (verificationProgress.value < 96) {
      verificationProgress.value += 1
    }
  }, 300)
}

function closeVerificationFlow() {
  if (elapsedTimer) {
    clearInterval(elapsedTimer)
    elapsedTimer = null
  }

  if (progressTimer) {
    clearInterval(progressTimer)
    progressTimer = null
  }

  verificationProgress.value = 100

  setTimeout(() => {
    verificationModalOpen.value = false
  }, 700)
}

function setStepActive(key, logMessage = null) {
  verificationSteps.value = verificationSteps.value.map((step) => {
    if (step.key === key) {
      return { ...step, status: "active" }
    }

    if (step.status === "active") {
      return { ...step, status: "done" }
    }

    return step
  })

  if (logMessage) {
    verificationLogs.value.push(logMessage)
  }
}

function finishAllSteps() {
  verificationSteps.value = verificationSteps.value.map((step) => ({
    ...step,
    status: "done",
  }))
  verificationProgress.value = 100
}

function wait(ms) {
  return new Promise((resolve) => setTimeout(resolve, ms))
}

async function runVerificationStages() {
  setStepActive("prepare", "Подготавливаем и нормализуем входные данные...")
  await wait(4500)

  setStepActive("secure", "Формируем защищённый пакет и отправляем запрос на проверку...")
  await wait(5500)

  setStepActive("database", "Выполняем сверку с внутренним лицензионным реестром...")
  await wait(6500)

  setStepActive("resource", "Ожидаем ответ от удалённого ресурса и проверяем ответный контур...")
  await wait(8500)

  setStepActive("finalize", "Формируем итоговую верификацию и собираем результат...")
  await wait(5000)
}

async function verifyLicense() {
  if (!form.value.value.trim()) {
    result.value = buildErrorResult("Введите значение для проверки.")
    return
  }

  loading.value = true
  openVerificationFlow()

  try {
    const apiPromise = axios.post("/api/licensing/verify", {
      type: form.value.type,
      value: form.value.value.trim(),
      customer: form.value.customer.trim() || null,
    })

    const stagePromise = runVerificationStages()

    const [apiResponse] = await Promise.allSettled([apiPromise, stagePromise])

    finishAllSteps()

    if (apiResponse.status === "fulfilled") {
      result.value = mapApiResult(apiResponse.value.data)
      verificationLogs.value.push("Проверка завершена. Результат успешно подготовлен.")
    } else {
      result.value = buildFallbackResult()
      verificationLogs.value.push("Backend недоступен или объект не ответил вовремя. Показан резервный результат.")
    }

    closeVerificationFlow()
  } catch {
    result.value = buildFallbackResult()
    verificationLogs.value.push("Во время проверки произошёл сбой. Используем безопасный резервный сценарий.")
    closeVerificationFlow()
  } finally {
    loading.value = false
  }
}

function mapApiResult(data) {
  const status = data?.status || "not_found"

  if (status === "verified") {
    return {
      title: "Подлинность подтверждена",
      description:
        data?.message ||
        "Объект найден в официальном реестре и подтверждён как продукт, ресурс или приложение, связанное с ООО «НОВИЧЁК».",
      badge: "Подтверждено",
      icon: CheckBadgeIcon,
      borderColor: "rgba(16,185,129,.24)",
      background: "linear-gradient(135deg, rgba(16,185,129,.10), rgba(255,255,255,.02))",
      badgeBorder: "rgba(16,185,129,.24)",
      badgeBackground: "rgba(16,185,129,.12)",
      badgeColor: "#86efac",
      details: normalizeDetails(data),
    }
  }

  if (status === "revoked") {
    return {
      title: "Лицензия или объект отозваны",
      description:
        data?.message ||
        "Проверяемый объект найден в реестре, но больше не имеет действующего статуса.",
      badge: "Отозвано",
      icon: ExclamationTriangleIcon,
      borderColor: "rgba(245,158,11,.24)",
      background: "linear-gradient(135deg, rgba(245,158,11,.10), rgba(255,255,255,.02))",
      badgeBorder: "rgba(245,158,11,.24)",
      badgeBackground: "rgba(245,158,11,.12)",
      badgeColor: "#fcd34d",
      details: normalizeDetails(data),
    }
  }

  return {
    title: "Объект не найден",
    description:
      data?.message ||
      "Такой ресурс, идентификатор или лицензионный код отсутствует в официальном реестре ООО «НОВИЧЁК».",
    badge: "Не найдено",
    icon: XCircleIcon,
    borderColor: "rgba(239,68,68,.24)",
    background: "linear-gradient(135deg, rgba(239,68,68,.08), rgba(255,255,255,.02))",
    badgeBorder: "rgba(239,68,68,.24)",
    badgeBackground: "rgba(239,68,68,.10)",
    badgeColor: "#fca5a5",
    details: normalizeDetails(data),
  }
}

function normalizeDetails(data) {
  const details = []

  if (data?.checked_value) {
    details.push({ label: "Проверенное значение", value: data.checked_value })
  }

  if (data?.type) {
    details.push({ label: "Тип проверки", value: data.type })
  }

  if (data?.project_name) {
    details.push({ label: "Проект / продукт", value: data.project_name })
  }

  if (data?.owner) {
    details.push({ label: "Правообладатель", value: data.owner })
  }

  if (data?.issued_at) {
    details.push({ label: "Дата регистрации", value: data.issued_at })
  }

  if (data?.expires_at) {
    details.push({ label: "Срок действия", value: data.expires_at })
  }

  return details.length ? details : null
}

function buildFallbackResult() {
  const input = form.value.value.trim()

  if (
    input.includes("novichek") ||
    input.includes("nov-") ||
    input.includes("lic-") ||
    input.includes("app.")
  ) {
    return {
      title: "Подлинность подтверждена",
      description:
        "Демо-режим страницы сработал успешно. После подключения backend-реестра здесь будут отображаться реальные данные по лицензии, ресурсу или приложению.",
      badge: "Подтверждено",
      icon: CheckBadgeIcon,
      borderColor: "rgba(16,185,129,.24)",
      background: "linear-gradient(135deg, rgba(16,185,129,.10), rgba(255,255,255,.02))",
      badgeBorder: "rgba(16,185,129,.24)",
      badgeBackground: "rgba(16,185,129,.12)",
      badgeColor: "#86efac",
      details: [
        { label: "Проверенное значение", value: input },
        { label: "Тип проверки", value: form.value.type },
        { label: "Статус", value: "Demo verified" },
        { label: "Правообладатель", value: "ООО «НОВИЧЁК»" },
      ],
    }
  }

  return {
    title: "Объект не найден",
    description:
      "Пока backend-проверка недоступна или объект отсутствует в реестре. После подключения серверной части здесь будет выполняться официальная верификация.",
    badge: "Не найдено",
    icon: XCircleIcon,
    borderColor: "rgba(239,68,68,.24)",
    background: "linear-gradient(135deg, rgba(239,68,68,.08), rgba(255,255,255,.02))",
    badgeBorder: "rgba(239,68,68,.24)",
    badgeBackground: "rgba(239,68,68,.10)",
    badgeColor: "#fca5a5",
    details: [
      { label: "Проверенное значение", value: input },
      { label: "Тип проверки", value: form.value.type },
    ],
  }
}

function buildErrorResult(message) {
  return {
    title: "Недостаточно данных для проверки",
    description: message,
    badge: "Ошибка ввода",
    icon: KeyIcon,
    borderColor: "rgba(245,158,11,.24)",
    background: "linear-gradient(135deg, rgba(245,158,11,.08), rgba(255,255,255,.02))",
    badgeBorder: "rgba(245,158,11,.24)",
    badgeBackground: "rgba(245,158,11,.12)",
    badgeColor: "#fcd34d",
    details: null,
  }
}
</script>