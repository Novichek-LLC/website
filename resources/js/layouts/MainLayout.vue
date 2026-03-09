<template>
  <div class="min-h-screen bg-slate-950 text-slate-50">
    <Navbar />
    <main class="container-page py-10 md:py-14"><slot /></main>
    <Footer />
  </div>
</template>
<script setup>
import Navbar from "../components/Navbar.vue"
import Footer from "../components/Footer.vue"
</script>
