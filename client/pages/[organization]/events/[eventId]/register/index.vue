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
          <label for="name" class="block text-sm font-medium text-gray-700 mb-1"
            >Name</label
          >
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
          <label
            for="email"
            class="block text-sm font-medium text-gray-700 mb-1"
            >Email</label
          >
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
          <label
            for="phone"
            class="block text-sm font-medium text-gray-700 mb-1"
            >Phone</label
          >
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
          :class="{ 'opacity-50 cursor-not-allowed': loading }"
          :disabled="loading"
        >
          {{ loading ? "Hold on..." : "Register" }}
        </button>
      </form>
    </div>
  </div>
</template>

<script lang="ts" setup>
import type { User } from "@/types";
import { ref } from "vue";

const toast = useToast();
const user = useSanctumUser<User>();

const route = useRoute();
const router = useRouter();
const organization = route.params.organization as string;
const eventId = route.params.eventId as string;
const name = ref("");
const email = ref("");
const phone = ref("");
const loading = ref(false);

const { isAuthenticated } = useSanctumAuth();

if (!isAuthenticated.value) {
  navigateTo("/login");
}

const handleRegister = async () => {
  loading.value = true;
  console.log(
    `Registering for event ${eventId} at organization ${organization} user ${user.value?.name}`
  );
  const { error, data } = await useApiFetch(
    `/${organization}/events/${eventId}/register`,
    {
      method: "POST",
      body: {
        event_id: eventId,
        user_id: user.value?.id || null,
        name: name.value,
        email: email.value,
        phone: phone.value,
      },
    }
  );

  if (error.value) {
    toast.error({
      title: "Registration Failed",
      message: error.value.message || "An error occurred while registering.",
      timeout: 4000,
      position: "topRight",
    });
  } else {
    toast.success({
      title: "Success!",
      message: "Registration successful! Redirecting to your events...",
      timeout: 5000,
      position: "topRight",
    });

    router.replace({ path: "/my-events" });
  }
  loading.value = false;
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
