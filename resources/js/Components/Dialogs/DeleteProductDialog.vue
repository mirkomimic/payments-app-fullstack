<template>
  <v-dialog
    v-model="dialog"
    max-width="300"
    persistent
    scrim="transparent"
    style="backdrop-filter: blur(3px);"
  >
    <template v-slot:activator="{ props: activatorProps }">
      <v-btn
        v-bind="activatorProps"
        class="text-none font-weight-regular"
        color="error" 
        variant="outlined" 
        prepend-icon="mdi-trash-can-outline" 
        size="small"
      >Delete</v-btn>
    </template>
    
    <v-card
      prepend-icon="mdi-trash-can-outline"
      title="Delete Product"
    >
      <v-card-text class="mt-5">
        Are you sure you want to delete this product?
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
          form="form"
          color="primary"
          text="Save"
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

const props = defineProps({
  id: {type: String}
})

const form = useForm({
  id: props.id,
})

const close = () => {
  dialog.value = false
}

const submit = () => {

  form.delete(route('products.destroy', form.id), {
    onSuccess: () => usePage().props.flash.isOpen = true,
  });

  close();

}
</script>