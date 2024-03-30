<template>
  <v-dialog
    v-model="dialog"
    max-width="600"
    persistent
    scrim="transparent"
    style="backdrop-filter: blur(3px);"
  >
    <template v-slot:activator="{ props: activatorProps }">
      <v-btn
        class="text-none font-weight-regular"
        prepend-icon="mdi-cancel"
        text="Cancel"
        variant="outlined"
        color="yellow"
        density="comfortable"
        v-bind="activatorProps"
      ></v-btn>
    </template>
    
    <v-card
      prepend-icon="mdi-cancel"
      title="Cancel subscription"
    >
      <v-card-text class="mt-5">
        Confirm cancel subscription.
      </v-card-text>

      <v-divider></v-divider>

      <v-card-actions>
        <v-spacer></v-spacer>

        <v-btn
          text="Close"
          variant="plain"
          @click="close"
        ></v-btn>

        <v-btn
          @click="submit"
          :disabled="form.processing"
          :loading="form.processing"
          color="primary"
          text="Confirm"
          variant="tonal"
          type="submit"
        ></v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script setup>
import { ref } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'

const dialog = ref(false)

const props = defineProps({subscription: {type: Object}})

const form = useForm({
  subscription_id: props.subscription.stripe_id,
  subscription_type: props.subscription.type
})

const close = () => {
  dialog.value = false
}

const submit = () => {
  form.delete(route('subscriptions.destroy', form.subscription_id), {
    onSuccess: () => {
      usePage().props.flash.isOpen = true
      close();
    }
  })
}
</script>