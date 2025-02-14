<template>
  <AuthPage
    router="/cadastrar"
    router-link-text="cadastre-se"
    detail-text="Não tem conta?"
    :submit-fn="onSubmit"
    :error-message="errorMessage"
    :clear-error-message="clearErrorMessage"
  />
</template>

<script setup lang="ts">
import AuthPage from "@/components/auth/AuthPage.vue";
import { nextTick, reactive } from "vue";
import useAuth from "@/composables/useAuth";
import "vue-toast-notification/dist/theme-sugar.css";
import { useToast } from "vue-toast-notification";
import router from "@/router";

const errorMessage = reactive({
  email: [],
  password: [],
});

const clearErrorMessage = (key: keyof typeof errorMessage) => {
  errorMessage[key] = [];
};

const $toast = useToast();

const onSubmit = async (payload: { email: string; password: string }) => {
  let instance;
  const { login } = useAuth();
  const { data, error, statusCode } = await login(payload);

  if (statusCode.value === 200) {
    instance = $toast.success("Usuário autenticado com sucesso!");
    localStorage.setItem("access-token", data.value.token);
    await router.push("/");
    return;
  }

  if (statusCode.value === 400) {
    const apiErrors = error.value.data.message;
    errorMessage.email = apiErrors;
    errorMessage.password = apiErrors;
  }
};
</script>

<style scoped></style>
