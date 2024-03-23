<template>
  <v-dialog
    v-model="dialog"
    max-width="500"
    persistent
    scrim="transparent"
    style="backdrop-filter: blur(3px);"
  >
    <template v-slot:activator="{ props: activatorProps }">
      <v-btn
        v-bind="activatorProps"
        class="text-none font-weight-regular"
        color="success" 
        variant="outlined" 
        prepend-icon="mdi-plus" 
        size="small"
        >Create price
      </v-btn>
    </template>
    
    <v-card
      prepend-icon="mdi-plus"
      title="Create product price"
    >
      <v-card-text class="mt-5">
        <v-form id="form">
          <CurrencyInput
            :currency="'EUR'"
            @change="(value) => form.price = value" 
          />
        </v-form>
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
          :disabled="form.processing || !form.price"
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
import CurrencyInput from '../Inputs/CurrencyInput.vue';

const dialog = ref(false)

const props = defineProps({
  product: { type: Object, required: true },
})

const form = useForm({
  product_id: props.product.id,
  price: null, 
})

const close = () => {
  form.reset()
  dialog.value = false
}

const submit = () => {
  form.post(route('prices.store'), {
    onSuccess: () => {
      usePage().props.flash.isOpen = true
      close();
    }
  });
}
</script>