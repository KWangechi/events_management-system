<template>
  <div class="flex justify-center items-center max-h-screen">
    <div class="bg-white p-8 rounded-xl shadow-card w-full max-w-md">
      <h2 class="text-3xl font-bold text-center text-primary mb-6 font-sans">
        Create a New Account
      </h2>
      <form @submit.prevent="handleRegister" class="space-y-5">
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700 mb-1"
            >Name</label
          >
          <input
            v-model="user.name"
            type="text"
            id="name"
            required
            class="block w-full h-12 rounded-lg border border-gray-300 px-4 focus:border-primary focus:ring focus:ring-primary/20 focus:ring-opacity-50 transition"
            placeholder="Your name"
          />
        </div>
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
          Register
        </button>
        <p v-if="error" class="text-red-500 text-sm text-center">{{ error }}</p>
        <p class="text-sm text-center">
          <span class="text-gray-500 pr-2">👤Already have an account?</span>
          <NuxtLink
            to="/login"
            class="text-primary font-semibold hover:underline"
          >
            Login here
          </NuxtLink>
        </p>
      </form>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { ref } from "vue";
import { useRouter } from "vue-router";

const error = ref("");
const user = ref({
  name: "",
  email: "",
  password: "",
});
const loading = ref(false);
const router = useRouter();

const toast = useToast();
const handleRegister = async () => {
  loading.value = true;
  // Uncomment and use your API logic here
  const { data, error: fetchError } = await useApiFetch("/register", {
    method: "POST",
    body: {
      name: user.value.name,
      email: user.value.email,
      password: user.value.password,
    },
  });
  if (fetchError.value) {
    toast.error({
      title: "Error",
      message: "Something happened",
      timeout: 2000,
    });
  } else {
    toast.success({
      title: "Registration Successful",
      message: "Redirecting to login...",
      timeout: 3000,
      position: "topRight",
    });
    // Redirect to login page after successful registration
    router.push("/login");
  }
  loading.value = false;
};
</script>
