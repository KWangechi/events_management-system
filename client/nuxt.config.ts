// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: "2025-05-15",
  devtools: { enabled: true },
  css: ["@/assets/css/main.css"],
  modules: ["@nuxtjs/tailwindcss", "nuxt-auth-sanctum", "nuxt-toast"],
  runtimeConfig: {
    public: {
      apiBase: "http://localhost:8000/api",
    },
  },
  sanctum: {
    mode: "token",
    baseUrl: "http://localhost:8000/api",
    endpoints: {
      login: "/login",
      logout: "/logout",
      user: "/user"
    },
    redirect: {
      onLogout: "/login",
      keepRequestedRoute: true,
    },
    globalMiddleware: {
      enabled: false,
    },
  },
});
