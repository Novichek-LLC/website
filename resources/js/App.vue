<template>
  <MainLayout>
    <router-view />
    <ChatWidget />
  </MainLayout>
</template>

<script setup>
import MainLayout from './layouts/MainLayout.vue';
import ChatWidget from './components/ChatWidget.vue';
</script>
