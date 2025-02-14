<template>
  <Form
    :email="email"
    :password="password"
    @update:email="updateEmail"
    @update:password="updatePassword"
    :submit-fn="onSubmit"
    :is-register="isRegister"
    :error-message="errorMessage"
    :clearErrorMessage="clearErrorMessage"
  >
    <template #datail
      ><p>
        {{ detailText }}
        <RouterLink :to="router">{{ routerLinkText }}</RouterLink>
      </p></template
    >
  </Form>
</template>

<script setup lang="ts">
import Form from "@/components/auth/Form.vue";
import { ref, watch } from "vue";
import { RouterLink } from "vue-router";

interface Props {
  submitFn: (payload: { email: string; password: string }) => void;
  isRegister?: boolean;
  detailText: string;
  routerLinkText: string;
  router: string;
  errorMessage: { email: string[]; password: string[] };
  clearErrorMessage(key: string): void;
}

const email = ref("");
const password = ref("");
const props = defineProps<Props>();

const updateEmail = (value: string) => (email.value = value);
const updatePassword = (value: string) => (password.value = value);

const onSubmit = async () =>
  props.submitFn({ email: email.value, password: password.value });
</script>
