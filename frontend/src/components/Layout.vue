<template>
  <v-app-bar :elevation="2">
    <v-app-bar-title>Maceió-in</v-app-bar-title>
  </v-app-bar>

  <slot />
</template>

<script setup lang="ts">
const items = [{ title: "Cadastrar" }, { title: "Sair" }, { title: "Login" }];
</script>

<style lang="scss" scoped></style>
