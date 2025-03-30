<template>
  <q-layout view="hHh lpR fFf">
    <q-page-container class="lk-layout">
      <AppHeaderCompact :showLandingLinksProp=false />
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script setup>
// import AppHeader from 'src/components/AppHeader.vue';
import AppHeaderCompact from 'src/components/AppHeaderCompact.vue'
// убрал ненужный код
</script>

<style>
/* лейаут и так всегда во весь экран, убрал класс */
</style>
