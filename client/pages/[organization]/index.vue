<script setup lang="ts">
definePageMeta({
  middleware: (to) => {
    const orgSlug = to.params.organization as string;
    if (orgSlug) {
      console.log(`Redirecting to events for organization: ${orgSlug}`);
      return navigateTo(`/${orgSlug}/events`);
    }
  },
});
</script>
