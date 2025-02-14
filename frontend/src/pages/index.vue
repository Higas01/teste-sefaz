<template>
  <!-- Modal Cadastro Funcionário -->
  <Modal
    :disabled-btn="isFormValid"
    :open-modal="openModalRegister"
    :submit-fn="onRegister"
    :cancel-fn="() => (openModalRegister = false)"
    title="Cadastrar Funcionário"
  >
    <form @submit.prevent="">
      <v-text-field
        v-model="employeeInfo.name"
        :rules="nameRule"
        type="text"
        label="Nome"
        class="mb-2"
      />
      <v-text-field
        v-model="employeeInfo.email"
        :error-messages="errorMessage.email"
        @input="clearErrorMessage('email')"
        label="Email"
        type="email"
        class="mb-2"
        :rules="emailRules"
      />
      <v-select
        v-model="employeeInfo.department"
        :rules="departmentRule"
        label="Departamento"
        :items="items"
      />
    </form>
  </Modal>

  <!-- Modal Editar Funcionário -->
  <Modal
    :disabled-btn="isFormValid"
    :open-modal="openModal"
    :submit-fn="onUpdate"
    :cancel-fn="closeModalEdit"
    title="Editar Funcionário"
  >
    <form @submit.prevent="">
      <v-text-field
        v-model="employeeInfo.name"
        :rules="nameRule"
        type="text"
        label="Nome"
        class="mb-2"
      />
      <v-text-field
        v-model="employeeInfo.email"
        label="Email"
        type="email"
        class="mb-2"
        :error-messages="errorMessage.email"
        @input="clearErrorMessage('email')"
        :rules="emailRules"
      />
      <v-select
        v-model="employeeInfo.department"
        :rules="departmentRule"
        label="Departamento"
        :items="items"
      />
    </form>
  </Modal>

  <Modal
    :title="`Excluir o usuário ${employeeInfo.name}`"
    :cancel-fn="closeModalDelete"
    :submit-fn="onDelete"
    :disabled-btn="false"
    :open-modal="deleteModal"
    delete
  >
  </Modal>
  <v-row>
    <v-container class="mt-5" style="min-height: 50vh">
      <v-row>
        <v-col cols="12" class="text-center">
          <v-img :src="logoSefaz" max-height="250" />
          <h3 class="text-h3">Bem-vindo à SEFAZ-AL</h3>
          <p class="text-subtitle-1">
            Descubra como os nossos serviços podem facilitar sua vida e ajudar
            no seu dia a dia.
          </p>
        </v-col>
      </v-row>
    </v-container>
  </v-row>
  <v-row>
    <v-container class="mt-5" style="min-height: 20vh">
      <v-row>
        <v-col cols="12" md="4">
          <v-card class="elevation-7">
            <v-card-title>Consulta de Notas Fiscais</v-card-title>
            <v-card-text>
              Realize a consulta de suas notas fiscais de maneira rápida e
              simples.
            </v-card-text>
          </v-card>
        </v-col>
        <v-col cols="12" md="4">
          <v-card class="elevation-7">
            <v-card-title>Emissão de Certificados</v-card-title>
            <v-card-text>
              Emita certificados de regularidade fiscal com segurança e
              agilidade.
            </v-card-text>
          </v-card>
        </v-col>
        <v-col cols="12" md="4">
          <v-card class="elevation-7">
            <v-card-title>Gestão de Impostos</v-card-title>
            <v-card-text>
              Acompanhe e gerencie seus impostos de forma eficiente.
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </v-row>
  <v-container class="mt-5" minHeight="45vh">
    <v-row class="d-flex justify-space-between" align="center">
      <v-col class="d-flex" cols="auto">
        <h2>Funcionários</h2>
      </v-col>
      <v-col class="d-flex" cols="auto">
        <v-btn color="primary" @click="openModalRegister = true"
          >Adicionar Funcionário</v-btn
        >
      </v-col>
    </v-row>

    <v-row>
      <v-col cols="12">
        <v-data-table-virtual
          class="mt-3 pt-1"
          :headers="headers"
          :items="employee.data || []"
        >
          <template #no-data>
            <div class="text-center py-4">
              <v-icon color="grey" size="48">mdi-database-off</v-icon>
              <p>Nenhum dado disponível no momento.</p>
            </div>
          </template>

          <template #item.actions="{ item }">
            <v-menu>
              <template v-slot:activator="{ props }">
                <v-btn
                  icon="mdi-dots-vertical"
                  variant="text"
                  v-bind="props"
                ></v-btn>
              </template>

              <v-list>
                <v-list-item>
                  <v-list-item-title
                    @click="openModalEdit(item)"
                    class="text-secondary"
                    style="cursor: pointer"
                  >
                    editar
                  </v-list-item-title>

                  <v-list-item-title
                    @click="openModalDelete(item)"
                    class="mt-2 text-danger"
                    style="cursor: pointer"
                  >
                    excluir
                  </v-list-item-title>
                </v-list-item>
              </v-list>
            </v-menu>
          </template>
        </v-data-table-virtual>
      </v-col>
    </v-row>
  </v-container>
</template>

<script lang="ts" setup>
import { reactive, ref, computed, onMounted } from "vue";
import Modal from "@/components/Modal.vue";
import "vue-toast-notification/dist/theme-sugar.css";
import { useToast } from "vue-toast-notification";
import type { Department } from "@/composables/useEmployee";
import { emailRules } from "@/utils/EmailRules";
import useEmployee from "@/composables/useEmployee";
import logoSefaz from "@/assets/sefaz-logo.png";
import router from "@/router";

const errorMessage = reactive({
  email: [],
});

const clearErrorMessage = (key: "email") => {
  errorMessage[key] = [];
};
const { register, update, get, del, employee } = useEmployee();

onMounted(async () => {
  await get();
  console.log(employee.value.data);
});

const employeeInfo = reactive({
  name: "",
  email: "",
  department: null as Department | null,
});

const id = ref();

const openModalEdit = (item: {
  name: string;
  email: string;
  department: Department | null;
  id: number;
}) => {
  employeeInfo.name = item.name;
  employeeInfo.email = item.email;
  employeeInfo.department = item.department || null;
  openModal.value = true;
  id.value = item.id;
};
const openModalDelete = (item: { name: string; id: number }) => {
  employeeInfo.name = item.name;
  deleteModal.value = true;
  id.value = item.id;
};

const closeModalEdit = () => {
  employeeInfo.name = "";
  employeeInfo.email = "";
  employeeInfo.department = null;
  id.value = null;
  openModal.value = false;
};
const closeModalDelete = () => {
  deleteModal.value = false;
  employeeInfo.name = "";
  id.value = null;
};

const headers = [
  {
    title: "Nome",
    key: "name",
  },
  {
    title: "Email",
    key: "email",
  },
  {
    title: "Departamento",
    key: "department",
  },
  {
    title: "Ações",
    key: "actions",
  },
];

const openModal = ref(false);
const openModalRegister = ref(false);
const deleteModal = ref(false);

const items: Department[] = [
  "Contabilidade",
  "Financeiro",
  "Atendimento",
  "Orçamento",
  "TI",
];

const nameRule = [(v: string) => !!v || "Nome é obrigatório"];
const departmentRule = [(v: string) => !!v || "Departamento é obrigatório"];

const isFormValid = computed(() => {
  const isEmailValid = emailRules.every(
    (rule) => rule(employeeInfo.email) === true
  );

  const isNameValid = nameRule.every(
    (rule) => rule(employeeInfo.name) === true
  );
  const isDepartmentValid = nameRule.every(
    (rule) => rule(employeeInfo.department ?? "") === true
  );

  return !(isEmailValid && isDepartmentValid && isNameValid);
});

const $toast = useToast();
let instance;

const onRegister = async () => {
  const { data, error, statusCode } = await register(employeeInfo);

  if (statusCode.value === 401) {
    localStorage.removeItem("access-token");
    instance = $toast.warning("Token expirado, faça login novamente.");
    return router.push("/login");
  }

  if (statusCode.value === 422) {
    const apiErrors = error.value.data.errors;
    Object.keys(apiErrors).forEach((key) => {
      if (errorMessage.hasOwnProperty(key)) {
        //@ts-ignore
        errorMessage[key] = apiErrors[key];
      }
    });
  }

  if (statusCode.value === 201) {
    instance = $toast.success("Funcionário cadastrado com sucesso!");
    await get();
    openModalRegister.value = false;
  }
};

const onUpdate = async () => {
  const { data, error, statusCode } = await update(employeeInfo, id.value);

  if (statusCode.value === 401) {
    localStorage.removeItem("access-token");
    instance = $toast.warning("Token expirado, faça login novamente.");
    await router.push("/login");
    return;
  }

  if (statusCode.value === 200) {
    instance = $toast.success("Funcionário atualizado com sucesso!");
    await get();
    closeModalEdit();
  }

  if (statusCode.value === 422) {
    const apiErrors = error.value.data.errors;
    Object.keys(apiErrors).forEach((key) => {
      if (errorMessage.hasOwnProperty(key)) {
        //@ts-ignore
        errorMessage[key] = apiErrors[key];
      }
    });
  }
};
const onDelete = async () => {
  const { data, error, statusCode } = await del(id.value);

  if (statusCode.value === 401) {
    localStorage.removeItem("access-token");
    instance = $toast.warning("Token expirado, faça login novamente.");
    await router.push("/login");
    return;
  }

  if (statusCode.value === 200) {
    instance = $toast.success("Funcionário deletado com sucesso!");
    await get();
    closeModalDelete();
  }
};
</script>
<style scoped>
.background-image {
  background-image: url("@/assets/bg.png");
  background-size: cover; /* Para preencher completamente a área */
  background-position: center;
  background-repeat: no-repeat; /* Evita que a imagem se repita */
  height: 100vh; /* Ajuste o tamanho conforme necessário */
}
</style>
