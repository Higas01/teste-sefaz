import useAPI from "./useAPI";
import { ref } from "vue";
export default function useEmployee() {
  const employee = ref<{ data: any[] }>({ data: [] });

  async function register(payload: useEmployeePayload) {
    const { data, error, statusCode, response } = await useAPI("/employee")
      .post(payload)
      .json();
    return { data, error, statusCode, response };
  }

  async function update(payload: useEmployeePayload, id: number) {
    const { data, error, statusCode, response } = await useAPI(
      `/employee/${id}`
    )
      .patch(payload)
      .json();
    return { data, error, statusCode, response };
  }

  async function get() {
    const { data, error, statusCode, response } = await useAPI<GetEmployee>(
      "/employee"
    )
      .get()
      .json();
    if (data && data.value) {
      employee.value = data.value;
    }
    console.log(data, error);
    return { data, error, statusCode, response };
  }

  async function del(id: number) {
    const { data, error, statusCode, response } = await useAPI(
      `/employee/${id}`
    )
      .delete()
      .json();
    return { data, error, statusCode, response };
  }

  return {
    register,
    get,
    update,
    del,
    employee,
  };
}

// Contabilidade, Financeiro,

export type Department =
  | "Contabilidade"
  | "Financeiro"
  | "Atendimento"
  | "Orçamento"
  | "TI";

export interface useEmployeePayload {
  name: string;
  email: string;
  department: Department | null;
}

export interface GetEmployee {
  count: number;
  data: Array<any>;
}
