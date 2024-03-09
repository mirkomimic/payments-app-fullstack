<template>
  <v-col
    cols="12"
    md="8"
  >
    <v-sheet
      class="pa-3"
    >
      <v-autocomplete
        v-model="form.userId"
        :items="props.users"
        :item-props="userProps"
        label="Select User"
        variant="outlined"
        density="comfortable"
      >
      <template v-slot:item="{props, item}">
          <v-list-item v-bind="props">
            <template v-slot:prepend>
              <span class="mr-3">{{ props.value }}.</span>
            </template>
          </v-list-item>
        </template>
      </v-autocomplete>
      <Transition name="fade">
        <v-btn
          v-if="form.userId"
          @click="submit"
          color="light-blue-darken-4"
          :disabled="form.processing"
          :loading="form.processing"
          >Create stripe customer
        </v-btn>
      </Transition>
    </v-sheet>
  </v-col>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
  users: { type: Array }
})

const form = useForm({
  userId: null
})

const submit = () => {
  form.post(route('customers.store'))
  form.userId = null
}

const userProps = (user) => {
  return {
    title: user.name,
    value: user.id
  }
}
</script>
