<template>
  <div class="max-h-screen flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-card w-full max-w-md p-8">
      <h2 class="text-3xl font-bold text-primary text-center mb-2 font-sans">
        Register for Event
      </h2>
      <p class="text-gray-500 text-center mb-6">
        Fill in your details to secure your spot.
      </p>
      <form @submit.prevent="handleRegister" class="space-y-5">
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
          <input
            v-model="name"
            type="text"
            id="name"
            required
            class="block w-full h-12 rounded-lg border border-gray-300 px-4 focus:border-primary focus:ring focus:ring-primary/20 focus:ring-opacity-50 transition"
            placeholder="Your full name"
          />
        </div>
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
          <input
            v-model="email"
            type="email"
            id="email"
            required
            class="block w-full h-12 rounded-lg border border-gray-300 px-4 focus:border-primary focus:ring focus:ring-primary/20 focus:ring-opacity-50 transition"
            placeholder="you@email.com"
          />
        </div>
        <div>
          <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
          <input
            v-model="phone"
            type="tel"
            id="phone"
            required
            class="block w-full h-12 rounded-lg border border-gray-300 px-4 focus:border-primary focus:ring focus:ring-primary/20 focus:ring-opacity-50 transition"
            placeholder="e.g. 0712345678"
          />
        </div>
        <button
          type="submit"
          class="w-full bg-primary text-white font-semibold py-2 rounded-lg hover:bg-primary/90 transition"
        >
          Register
        </button>
        <p
          v-if="message"
          class="text-center mt-2 font-medium"
          :class="message.includes('successful') ? 'text-green-600' : 'text-red-600'"
        >
          {{ message }}
        </p>
      </form>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import { useApiFetch } from "@/composables/useFetchApi";

const route = useRoute();
const router = useRouter();
const organization = route.params.organization as string;
const eventId = ref((route.query.eventId as string) || "");
const name = ref("");
const email = ref("");
const phone = ref("");
const message = ref("");

const handleRegister = async () => {
  const { error } = await useApiFetch(
    `/${organization}/register`,
    {
      method: "POST",
      body: {
        event_id: eventId.value,
        name: name.value,
        email: email.value,
        phone: phone.value,
      },
    }
  );

  if (error.value) {
    message.value = "Registration failed. Please try again.";
  } else {
    message.value = "Registration successful! Thank you.";
    setTimeout(() => router.push(`/${organization}/events`), 2000);
  }
};
</script>

<style scoped>
.bg-secondary {
  background-color: #f7fafc;
}

.text-primary {
  color: #2b6cb0;
}

.shadow-card {
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1),
    0 2px 4px -1px rgba(0, 0, 0, 0.06);
}
</style>
