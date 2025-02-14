<template>
  <v-container min-height="90vh" class="d-flex align-center justify-center">
    <v-card
      :min-width="width > 850 ? '40vw' : '100vw'"
      class="bg-surface-light pt-4"
    >
      <v-card-title class="mb-3">
        <v-img :src="logo" max-height="150" />
      </v-card-title>
      <v-card-text>
        <form @submit.prevent="submitFn">
          <v-text-field
            :model-value="email"
            type="email"
            label="E-mail"
            :rules="emailRules"
            :error-messages="errorMessage.email"
            @input="clearErrorMessage('email')"
            class="mb-2"
            @update:model-value="(e) => emits('update:email', e)"
          />
          <v-text-field
            :append-inner-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
            :model-value="password"
            :type="showPassword ? 'text' : 'password'"
            :error-messages="errorMessage.password"
            @input="clearErrorMessage('password')"
            label="Senha"
            :rules="props.isRegister ? passwordRules : []"
            @click:append-inner="showPassword = !showPassword"
            @update:model-value="(e) => emits('update:password', e)"
            class="mb-2"
          />

          <v-btn
            class="me-4"
            color="primary"
            type="submit"
            :disabled="isFormValid"
          >
            Enviar
          </v-btn>
          <v-btn color="secondary"> LIMPAR </v-btn>
        </form>
      </v-card-text>
      <v-container class="d-flex justify-end align-center">
        <slot name="datail" />
      </v-container>
    </v-card>
  </v-container>
</template>

<script setup lang="ts">
import logo from "@/assets/logo.png";
import { ref, computed, watchEffect } from "vue";
import { useWindowSize } from "@vueuse/core";
import { emailRules } from "@/utils/EmailRules";

interface Props {
  password: string;
  email: string;
  submitFn: (event: Event) => void;
  isRegister?: boolean;
  errorMessage: { email: string[]; password: string[] };
  clearErrorMessage(key: string): void;
}

interface Emits {
  (e: "update:email", value: string): void;
  (e: "update:password", value: string): void;
}

const { width } = useWindowSize();
const showPassword = ref(false);

const props = defineProps<Props>();
const emits = defineEmits<Emits>();

const passwordRules = [
  (v: string) => !!v || "Senha é obrigatória",
  (v: string) => v.length >= 8 || "Senha deve ter no mínimo 6 caracteres",
];

const isFormValid = computed(() => {
  const isEmailValid = emailRules.every((rule) => rule(props.email) === true);

  if (props.isRegister) {
    const isPasswordValid = passwordRules.every(
      (rule) => rule(props.password) === true
    );
    return !(isEmailValid && isPasswordValid);
  }
  return !isEmailValid;
});
</script>
