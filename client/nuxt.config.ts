// https://nuxt.com/docs/api/configuration/nuxt-config

console.log("Base Url", import.meta.env.NUXT_PUBLIC_API_BASE);
export default defineNuxtConfig({
  compatibilityDate: "2025-05-15",
  devtools: { enabled: true },
  css: ["@/assets/css/main.css"],
  modules: ["@nuxtjs/tailwindcss", "nuxt-auth-sanctum", "nuxt-toast"],
  runtimeConfig: {
    public: {
      apiBase:
        process.env.NUXT_PUBLIC_API_BASE || "http://localhost:8000/api",
    },
  },
  sanctum: {
    mode: "token",
    baseUrl:
      process.env.NUXT_PUBLIC_API_BASE || "http://localhost:8000/api",
    endpoints: {
      login: "/login",
      logout: "/logout",
      user: "/user",
    },
    redirectIfAuthenticated: true,
    redirect: {
      onLogout: "/login",
      keepRequestedRoute: true,
      onAuthOnly: "/login",
    },
    globalMiddleware: {
      enabled: false,
    },
  },
});
