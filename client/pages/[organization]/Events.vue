<template>
  <div class="min-h-screen">
    <div class="max-w-6xl mx-auto py-8 px-4">
      <h1 class="text-4xl font-bold text-primary text-center mb-2 font-sans">
        Discover Events for {{ organization }}
      </h1>
      <p class="text-gray-500 text-center mb-10">
        Curated experiences, workshops, and gatherings
      </p>
      <div
        v-if="events.length"
        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8"
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
              @click="registerForEvent(event.id)"
              class="mt-auto w-full bg-primary text-white font-semibold py-2 rounded-lg hover:bg-primary/90 transition"
            >
              Register
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
import { ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import type { EventApiResponse, Event as OrgEvent } from "@/types";

const route = useRoute();
const router = useRouter();
const organization = route.params.organization as string;
const events = ref<OrgEvent[]>([]);
const message = ref("");

import { useApiFetch } from "@/composables/useFetchApi";

const { data } = await useApiFetch<EventApiResponse>(`/${organization}/events`);
events.value = data.value?.data || [];

const registerForEvent = (eventId: number) => {
  router.push(`/${organization}/register?eventId=${eventId}`);
};
</script>
