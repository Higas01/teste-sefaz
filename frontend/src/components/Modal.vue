<template>
  <v-container>
    <v-dialog :model-value="openModal" max-width="500" persistent>
      <template v-slot:default="{ isActive }">
        <v-card :title="title">
          <v-card-text> <slot /> </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>

            <v-btn
              :text="props.delete ? 'Excluir' : 'Enviar'"
              variant="elevated"
              :color="props.delete ? 'danger' : 'primary'"
              type="submit"
              @click="submitFn"
              :disabled="disabledBtn"
            ></v-btn>
            <v-btn
              :text="props.delete ? 'Voltar' : 'Cancelar'"
              :color="props.delete ? 'primary' : 'danger'"
              variant="elevated"
              @click="cancelFn"
            ></v-btn>
          </v-card-actions>
        </v-card>
      </template>
    </v-dialog>
  </v-container>
</template>

<script setup lang="ts">
interface Props {
  submitFn: () => void;
  cancelFn: () => void;
  openModal: boolean;
  disabledBtn: boolean;
  title: string;
  delete?: boolean;
}
const props = defineProps<Props>();
</script>
