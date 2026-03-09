<template><div class="mb-8"><h2 class="section-title">{{ title }}</h2><p v-if="text" class="muted mt-3">{{ text }}</p></div></template>
<script setup>defineProps({ title: String, text: String })</script>
