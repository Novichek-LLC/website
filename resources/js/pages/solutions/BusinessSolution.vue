<template>
  <SolutionLanding
    title="Решения для бизнеса"
    service="automation"
    description="Комплексно закрываем контур: сайт, лиды, CRM, задачи, интеграции и контроль метрик руководителя."
    :benefits="benefits"
    :steps="steps"
  />
</template>

<script setup>
import SolutionLanding from '../../components/solutions/SolutionLanding.vue'

const benefits = [
  'Один подрядчик на ключевые digital и IT-задачи',
  'Сквозной путь клиента от заявки до оплаты',
  'Автоматизация рутинных операций команды',
  'Прозрачные KPI и регулярная отчётность',
]

const steps = [
  { title: 'Формируем roadmap', text: 'Фиксируем цели бизнеса, приоритеты и поэтапный план внедрения.' },
  { title: 'Запускаем MVP-конфигурацию', text: 'Быстро включаем базовые процессы, чтобы получить первые результаты.' },
  { title: 'Дорабатываем под рост', text: 'Добавляем новые модули, интеграции и регламенты по мере роста.' },
]
</script>
