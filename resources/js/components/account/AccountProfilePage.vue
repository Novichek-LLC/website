<template>
  <div class="grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
    <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
      <div class="mb-4 text-lg font-semibold">Профиль клиента</div>

      <div class="grid gap-4 md:grid-cols-2">
        <input class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3" value="Данил">
        <input class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3" value="danil@example.com">
        <input class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3" value="+49 000 000 000">
        <input class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3" value="ООО «НОВИЧЁК»">
      </div>

      <button class="mt-4 rounded-xl bg-cyan-400 px-5 py-3 text-sm font-semibold text-slate-950">
        Сохранить изменения
      </button>
    </div>

    <div class="space-y-6">
      <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
        <div class="text-lg font-semibold">Telegram</div>
        <div class="mt-3 text-sm text-slate-400">
          Аккаунт подключён. Можно входить в кабинет через Telegram-бота.
        </div>
        <button class="mt-4 rounded-xl border border-white/10 px-4 py-2 text-sm text-slate-300">
          Отвязать аккаунт
        </button>
      </div>

      <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
        <div class="text-lg font-semibold">Безопасность</div>
        <div class="mt-3 text-sm text-slate-400">
          Последний вход: сегодня, 12:42
        </div>
        <button class="mt-4 rounded-xl border border-white/10 px-4 py-2 text-sm text-slate-300">
          Завершить все сессии
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
</script>