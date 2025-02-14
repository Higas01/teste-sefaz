import { createFetch } from "@vueuse/core";
const useAPI = createFetch({
  baseUrl: "http://localhost:8000",
  options: {
    // async beforeFetch({ options }) {
    //   const myToken = await getMyToken();
    //   options.headers.Authorization = `Bearer ${myToken}`;
    //   return { options };
    // },
    beforeFetch(ctx) {
      ctx.options.headers = {};
      const cookie = localStorage.getItem("access-token");
      if (cookie) {
        ctx.options.headers["Authorization"] = `Bearer ${cookie}`;
      }
    },
    onFetchError({ error, data, response }) {
      error.data = data;
      return { error };
    },
  },
  fetchOptions: {
    mode: "cors",
  },
});

export default useAPI;
