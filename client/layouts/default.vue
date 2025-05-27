<template>
  <div
    class="min-h-screen bg-gradient-to-br from-secondary to-white flex flex-col"
  >
    <nav class="bg-white shadow-card">
      <div
        class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between"
      >
        <div class="flex items-center gap-2">
          <span
            class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center font-bold text-xl"
            >S</span
          >
          <span class="text-xl font-bold text-primary tracking-tight"
            >Shikisha Events</span
          >
        </div>
        <div class="flex gap-6">
          <NuxtLink
            to="/"
            class="text-gray-700 hover:text-primary font-medium transition"
            >Home</NuxtLink
          >
          <template v-if="user">
            <NuxtLink
              to="/my-events"
              class="text-gray-700 hover:text-primary font-medium transition"
              >My Events</NuxtLink
            >
          </template>
          <template v-else>
            <NuxtLink
              to="/login"
              class="text-gray-700 hover:text-primary font-medium transition"
              >Login</NuxtLink
            >
            <NuxtLink
              to="/register"
              class="text-gray-700 hover:text-primary font-medium transition"
              >Register</NuxtLink
            >
          </template>
        </div>

        <div v-if="user" class="flex items-center gap-3">
          <span class="text-gray-700 font-medium">Hello, {{ user?.name }}</span>
          <button
            @click="handleLogout"
            class="bg-primary text-white px-3 py-1 rounded hover:bg-primary-dark transition"
          >
            Logout
          </button>
        </div>
      </div>
    </nav>
    <main class="flex-1 max-w-7xl mx-auto py-8 px-4 w-full">
      <slot />
    </main>
    <footer class="bg-white border-t mt-8 py-6">
      <div class="max-w-7xl mx-auto px-4 text-center text-gray-400 text-sm">
        &copy; {{ new Date().getFullYear() }} Shikisha Events. All rights
        reserved.
      </div>
    </footer>
  </div>
</template>

<script lang="ts" setup>
import type { User } from "@/types";

const user = useSanctumUser<User>();
const { logout } = useSanctumAuth();
const toast = useToast();

const error = ref("");

const handleLogout = async () => {
  try {
    await logout();
    toast.success({
      
      title: "Success",
      message: "Logged Out",
      timeout: 2000,
      position: "topRight",
    });
  } catch (err) {
    console.error("Logout error:", err);

    if (typeof err === "string") {
      error.value = err;
    } else if (err instanceof Error) {
      error.value = err.message;
    } else {
      error.value = "An unexpected error occurred.";
    }
    toast.error({
      title: "Error!",
      message: `${error.value} || Something went wrong!`,
      timeout: 30000,
    });
  }
};
</script>
