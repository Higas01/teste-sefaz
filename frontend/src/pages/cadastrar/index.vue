<template>
  <AuthPage
    router="/login"
    router-link-text="entrar"
    detail-text="Já tem conta?"
    :submit-fn="onSubmit"
    :error-message="errorMessage"
    :clear-error-message="clearErrorMessage"
  />
</template>

<script setup lang="ts">
import AuthPage from "@/components/auth/AuthPage.vue";
import { reactive } from "vue";
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
  const { register } = useAuth();
  const { data, error, statusCode, response } = await register(payload);

  if (statusCode.value === 201) {
    instance = $toast.success("Usuário cadastrado com sucesso!");
    await router.push("/login");
    return;
  }

  if (statusCode.value === 422) {
    Object.keys(errorMessage).forEach((key) => {
      //@ts-ignore
      errorMessage[key] = [];
    });

    const apiErrors = error.value.data.errors;
    Object.keys(apiErrors).forEach((key) => {
      if (errorMessage.hasOwnProperty(key)) {
        //@ts-ignore
        errorMessage[key] = apiErrors[key];
      }
    });
  }
};
</script>

<style scoped></style>
