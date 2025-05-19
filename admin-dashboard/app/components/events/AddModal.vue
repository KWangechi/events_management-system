<script setup lang="ts">
import * as z from 'zod'
import type { FormSubmitEvent } from '@nuxt/ui'

const schema = z.object({
  title: z.string().min(2, 'Too short'),
  description: z.string().min(2, 'Too short'),
  venue: z.string().min(2, 'Too short'),
  date: z.date().min(new Date(), 'Date must be in the future'),
  price: z.number().min(0, 'Price must be greater than 0'),
  max_attendees: z.number().min(1, 'Capacity must be greater than 0')
})
const open = ref(false)

type Schema = z.output<typeof schema>

const state = reactive<Partial<Schema>>({
  title: undefined,
  description: undefined,
  venue: undefined,
  date: undefined,
  price: undefined,
  max_attendees: undefined
})

const toast = useToast()
async function onSubmit(event: FormSubmitEvent<Schema>) {
  toast.add({ title: 'Success', description: `New event ${event.data.title} added`, color: 'success' })
  open.value = false
}
</script>

<template>
  <UModal v-model:open="open" title="New event" description="Add a new event to the database">
    <UButton label="New event" icon="i-lucide-plus" />

    <template #body>
      <UForm
        :schema="schema"
        :state="state"
        class="space-y-4"
        @submit="onSubmit"
      >
        <UFormField label="Title" placeholder="Event Title" name="title">
          <UInput v-model="state.title" class="w-full" />
        </UFormField>
        <UFormField label="Description" placeholder="Event Description" name="description">
          <UInput v-model="state.description" class="w-full" />
        </UFormField>
        <UFormField label="Venue" placeholder="Event Venue" name="venue">
          <UInput v-model="state.venue" class="w-full" />
        </UFormField>
        <UFormField label="Date" placeholder="Event Date" name="date">
          <!-- <UInput v-model="state.date" class="w-full" type="date" /> -->
        </UFormField>
        <UFormField label="Price" placeholder="Event Price" name="price">
          <UInput v-model="state.price" class="w-full" type="number" />
        </UFormField>
        <UFormField label="Max Attendees" placeholder="Max Attendees" name="max_attendees">
          <UInput v-model="state.max_attendees" class="w-full" type="number" />
        </UFormField>

        <div class="flex justify-end gap-2">
          <UButton
            label="Cancel"
            color="neutral"
            variant="subtle"
            @click="open = false"
          />
          <UButton
            label="Save"
            color="primary"
            variant="solid"
            type="submit"
          />
        </div>
      </UForm>
    </template>
  </UModal>
</template>
