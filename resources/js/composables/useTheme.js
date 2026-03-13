import { computed, onMounted, ref, watch } from "vue"

const theme = ref("dark")
const ready = ref(false)

function applyTheme(value) {
  const html = document.documentElement
  html.classList.remove("theme-dark", "theme-light")
  html.classList.add(value === "light" ? "theme-light" : "theme-dark")
  html.setAttribute("data-theme", value)
}

function detectInitialTheme() {
  const saved = localStorage.getItem("site-theme")

  if (saved === "light" || saved === "dark") {
    return saved
  }

  const prefersLight = window.matchMedia("(prefers-color-scheme: light)").matches
  return prefersLight ? "light" : "dark"
}

export function useTheme() {
  const isDark = computed(() => theme.value === "dark")
  const isLight = computed(() => theme.value === "light")

  function setTheme(value) {
    theme.value = value === "light" ? "light" : "dark"
  }

  function toggleTheme() {
    theme.value = theme.value === "dark" ? "light" : "dark"
  }

  onMounted(() => {
    theme.value = detectInitialTheme()
    applyTheme(theme.value)
    ready.value = true
  })

  watch(theme, (value) => {
    if (!ready.value) return
    localStorage.setItem("site-theme", value)
    applyTheme(value)
  })

  return {
    theme,
    isDark,
    isLight,
    setTheme,
    toggleTheme,
  }
}