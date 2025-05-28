<template>
  <div class="min-h-screen">
    <div class="max-w-6xl mx-auto py-8 px-4">
      <h1 class="text-4xl font-bold text-primary text-center mb-2 font-sans">
        Discover Events
      </h1>
      <p class="text-gray-500 text-center mb-10">
        Curated experiences, workshops, and gatherings
      </p>
      <div
        v-if="events.length"
        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-y-12 gap-x-8"
      >
        <div
          v-for="event in events"
          :key="event.id"
          class="bg-white rounded-xl shadow-card hover:shadow-lg transition-shadow duration-200 overflow-hidden flex flex-col"
        >
          <div
            class="h-40 bg-gradient-to-br from-primary/10 to-secondary flex items-center justify-center"
          >
            <img
              :src="`/images/events_${(event.id % 5) + 1}.jpg`"
              alt="Event image"
              class="object-cover w-full h-full"
            />
            <!-- <span
              class="text-5xl text-primary font-bold"
            >
              {{ event.title.charAt(0) }}
            </span> -->
          </div>
          <div class="flex-1 flex flex-col p-6">
            <h3 class="text-lg font-semibold text-primary mb-1 line-clamp-1">
              {{ event.title }}
            </h3>
            <p class="text-gray-600 mb-3 line-clamp-2">
              {{ event.description }}
            </p>
            <div class="flex flex-col gap-1 text-sm text-gray-500 mb-4">
              <span
                ><i class="i-mdi-map-marker-outline mr-1"></i>
                {{ event.venue }}</span
              >
              <span
                ><i class="i-mdi-calendar-blank-outline mr-1"></i>
                {{ new Date(event.date).toLocaleDateString() }}</span
              >
              <span
                ><i class="i-mdi-currency-usd mr-1"></i> ${{
                  event.price
                }}</span
              >
            </div>
            <button
              @click="registerForEvent(event.id, event)"
              class="mt-auto w-full bg-primary text-white font-semibold py-2 rounded-lg hover:bg-primary/90 transition"
              :class="{ 'opacity-50 cursor-not-allowed': loading }"
              :disabled="loading"
            >
              {{ loading ? "..." : "Register" }}
            </button>
          </div>
        </div>
      </div>
      <p v-else class="text-center text-gray-400 text-lg mt-20">
        No events available at the moment.
      </p>
      <p v-if="message" class="mt-6 text-center text-green-600 font-medium">
        {{ message }}
      </p>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { ref, toDisplayString } from "vue";
import type { EventApiResponse, Event as OrgEvent } from "@/types";

const route = useRoute();
const router = useRouter();
let organizationSlug = route.params.organization as string;
const events = ref<OrgEvent[]>([]);
const message = ref("");
const toast = useToast();
const loading = ref(false);

const { data } = await useApiFetch<EventApiResponse>(`/all-events`);
events.value = data.value?.data || [];

// const registerForEvent = (eventId: number, event: OrgEvent) => {
//   console.log(
//     `Registering for event ${event.title} at organization ${
//       organizationSlug || event.organization_slug
//     }`
//   );

//   if (event.organization_slug) organizationSlug = event.organization_slug;
//   if (!organizationSlug) {
//     message.value = "Invalid organization or event ID.";
//     return;
//   }

//   // get to route to register for event
//   const registerUrl = `/${organizationSlug}/events/${eventId}/register`;
//   router.push(registerUrl);
// };

const registerForEvent = async (eventId: number, orgEvent: OrgEvent) => {
  const organization = orgEvent.organization_slug;
  // Check if attendee already exists for this user
  const { data: attendeeData } = await useApiFetch<{
    success: boolean;
    message: string;
    data: any;
  }>(`/${organization}/events/${eventId}/attendee/me`);

  if (attendeeData.value?.data) {
    const { error, data } = await useApiFetch(
      `/${organization}/events/${eventId}/register`,
      {
        method: "POST",
        body: {
          name: attendeeData.value.data.name,
          email: attendeeData.value.data.email,
          phone: attendeeData.value.data.phone,
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
  } else {
    // Go to registration form with eventId
    router.replace(`/${organization}/events/${eventId}/register`);
  }
};
</script>
