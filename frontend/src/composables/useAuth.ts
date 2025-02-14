import useAPI from "./useAPI";
export default function useAuth() {
  async function register(payload: PayloadAuth) {
    const { data, error, statusCode, response } = await useAPI("/register")
      .post(payload)
      .json();
    return { data, error, statusCode, response };
  }

  async function login(payload: PayloadAuth) {
    const { data, error, statusCode, response } = await useAPI("/login")
      .post(payload)
      .json();
    return { data, error, statusCode, response };
  }

  return {
    register,
    login,
  };
}

export interface PayloadAuth {
  email: string;
  password: string;
}
