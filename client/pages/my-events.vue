<template>
  <div class="min-h-screen">
    <div class="max-w-6xl mx-auto py-8 px-4">
      <h1 class="text-4xl font-bold text-primary text-center mb-2 font-sans">
        View your Events
      </h1>
      <div
        v-if="attendeeEvent?.events.length"
        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mt-12"
      >
        <div
          v-for="event in attendeeEvent?.events"
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

            <div class="flex items-center justify-between mb-2">
              <p class="font-bold text-black flex items-center">
                🎟️ <span class="ml-2">You are going</span>
              </p>
              <button
                @click="cancelEventRegistration(event.id, event)"
                class="bg-red-300 text-white font-semibold py-2 px-4 rounded-lg hover:bg-red/100 transition btn-sm"
              >
                {{ loading ? "..." : "Cancel" }}
              </button>
            </div>
          </div>
        </div>
      </div>
      <p v-else class="text-center text-gray-400 text-lg mt-10">
        No events registered yet.
        <NuxtLink
          to="/events"
          class="text-primary font-semibold hover:underline"
          >Check Them Out Here</NuxtLink
        >
      </p>
      <p v-if="message" class="mt-6 text-center text-green-600 font-medium">
        {{ message }}
      </p>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { ref } from "vue";
import type {
  AttendeeEvent,
  AttendeeEventResponse,
  Event as OrgEvent,
} from "@/types";

const route = useRoute();
const router = useRouter();
const attendeeEvent = ref<AttendeeEvent>();
const message = ref("");
const toast = useToast();
const loading = ref(false);

const { data } = await useApiFetch<AttendeeEventResponse>(`/my-events`);
attendeeEvent.value = data.value?.data;

const cancelEventRegistration = (eventId: number, event: OrgEvent) => {
  const orgSlug = event.organization_slug;
  const { error, data } = useApiFetch(
    `/${orgSlug}/events/${eventId}/attendee/me`,
    {
      method: "DELETE",
    }
  );

  console.log(data.value);

  if (error.value) {
    toast.error({
      title: "Cancellation Failed",
      message: error.value.message || "An error occurred while cancelling.",
      timeout: 4000,
      position: "topRight",
    });
  } else {
    toast.success({
      title: "Success!",
      message: "Event Cancellation successful! Redirecting to your events...",
      timeout: 5000,
      position: "topRight",
    });

    window.location.reload();
  }
  loading.value = false;
};
</script>
