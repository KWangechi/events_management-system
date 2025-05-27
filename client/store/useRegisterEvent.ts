import { defineStore } from "pinia";
import { useRouter } from "vue-router";
import { ref } from "vue";
// import axios from 'axios';
// import { useFetchApi } from '@/composables/useFetchApi'; // Adjust the import path as needed

interface RegisterEventState {
  isLoading: boolean;
  error: string | null;
  success: boolean;
}

export const useRegisterEventStore = defineStore("registerEvent", {
  state: (): RegisterEventState => ({
    isLoading: false,
    error: null,
    success: false,
  }),
  actions: {
    isAuthenticated(): boolean {
      // Replace with your actual auth check logic
      const user = useSanctumUser();
      return user.value !== null && user.value !== undefined;
    },
    async registerForEvent(eventId: string, eventInfo: any): Promise<void> {
      const router = useRouter();

      if (!this.isAuthenticated()) {
        router.push({ name: "login" });
        return;
      }

      this.isLoading = true;
      this.error = null;
      this.success = false;

      try {
        await useApiFetch(`/events/${eventId}/register`, {
          method: "POST",
          body: { ...eventInfo },
          params: {
            eventId,
          },
        });
        this.success = true;
      } catch (err: any) {
        this.error =
          err?.response?.data?.message || err?.message || "Registration failed";
      } finally {
        this.isLoading = false;
      }
    },
  },
});
