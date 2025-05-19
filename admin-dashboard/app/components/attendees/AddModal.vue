<script setup lang="ts">
import * as z from 'zod'
import type { FormSubmitEvent } from '@nuxt/ui'

const schema = z.object({
  name: z.string().min(2, 'Too short'),
  phone: z.string().min(2, 'Too short'),
  email: z.string().email('Invalid email')
})
const open = ref(false)

type Schema = z.output<typeof schema>

const state = reactive<Partial<Schema>>({
  name: undefined,
  phone: undefined,
  email: undefined
})

const toast = useToast()
async function onSubmit(event: FormSubmitEvent<Schema>) {
  toast.add({ title: 'Success', description: `New attendee ${event.data.name} added`, color: 'success' })
  open.value = false
}
</script>

<template>
  <UModal v-model:open="open" title="New attendee" description="Add a new attendee to the database">
    <UButton label="New attendee" icon="i-lucide-plus" />

    <template #body>
      <UForm
        :schema="schema"
        :state="state"
        class="space-y-4"
        @submit="onSubmit"
      >
        <UFormField label="Name" placeholder="John Doe" name="name">
          <UInput v-model="state.name" class="w-full" />
        </UFormField>
        <UFormField label="Phone" placeholder="123-456-7890" name="phone">
          <UInput v-model="state.phone" class="w-full" />
        </UFormField>
        <UFormField label="Email" placeholder="john.doe@example.com" name="email">
          <UInput v-model="state.email" class="w-full" />
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
