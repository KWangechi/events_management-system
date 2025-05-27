<template>
  <div class="flex justify-center items-center max-h-screen">
    <div class="bg-white p-8 rounded-xl shadow-card w-full max-w-md">
      <h2 class="text-3xl font-bold text-center text-primary mb-6 font-sans">
        Welcome Back
      </h2>
      <form @submit.prevent="handleLogin" class="space-y-5">
        <div>
          <label
            for="email"
            class="block text-sm font-medium text-gray-700 mb-1"
            >Email</label
          >
          <input
            v-model="user.email"
            type="email"
            id="email"
            required
            class="block w-full h-12 rounded-lg border border-gray-300 px-4 focus:border-primary focus:ring focus:ring-primary/20 focus:ring-opacity-50 transition"
            placeholder="you@email.com"
          />
        </div>
        <div>
          <label
            for="password"
            class="block text-sm font-medium text-gray-700 mb-1"
            >Password</label
          >
          <input
            v-model="user.password"
            type="password"
            id="password"
            required
            class="block w-full h-12 rounded-lg border border-gray-300 px-4 focus:border-primary focus:ring focus:ring-primary/20 focus:ring-opacity-50 transition"
            placeholder="Your password"
          />
        </div>
        <button
          type="submit"
          class="w-full bg-primary text-white font-semibold py-2 rounded-lg hover:bg-primary/90 transition"
          :class="{ 'opacity-50 cursor-not-allowed': loading }"
          :disabled="loading"
        >
          {{ loading ? "Logging in..." : "Login" }}
        </button>
        <p class="text-sm text-center">
          <span class="text-gray-500 pr-2">👤Don't have an account?</span>
          <NuxtLink
            to="/register"
            class="text-primary font-semibold hover:underline"
          >
            Register here
          </NuxtLink>
        </p>
      </form>
    </div>
  </div>
</template>

<script lang="ts" setup>
import type { User } from "@/types";
import { ref } from "vue";

const error = ref("");
const user = ref<User>({
  email: "",
  password: "",
});
const loading = ref(false);

const toast = useToast();

const { login } = useSanctumAuth();

const handleLogin = async () => {
  console.log("Login attempt with:", {
    email: user.value.email,
    password: user.value.password,
  });
  loading.value = true;

  try {
    await login({
      email: user.value.email,
      password: user.value.password,
    });
  } catch (err) {
    console.error("Login error:", err);

    if (typeof err === "string") {
      error.value = err;
    } else if (err instanceof Error) {
      error.value = err.message;
    } else {
      error.value = "An unexpected error occurred.";
    }
    toast.error({
      title: "Error!",
      message: `${error.value} || Login failed. Please try again.`,
      timeout: 30000,
    });
  }
  loading.value = false;
};
</script>
