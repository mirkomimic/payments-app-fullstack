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
          <v-row>
            <v-col
              cols="12"
              class="pa-0"
            >
              <CurrencyInput
                :currency="'EUR'"
                @change="(value) => form.price = value"
              />
            </v-col>

            <v-col
              cols="6"
              class="pa-0"
            >
              <v-checkbox
                v-model="form.recurring"
                color="primary"
                label="Recurring"
                hide-details
                :error-messages="form.errors.recurring"
              ></v-checkbox>
            </v-col>

            <v-col
              cols="6"
              class="pa-0"
              align-self="center"
            >
              <v-fade-transition>
                <v-select
                  v-if="form.recurring"
                  v-model="form.interval"
                  :items="['day', 'week', 'month', 'year']"
                  color="primary"
                  variant="outlined"
                  label="Choose Interval"
                  hide-details
                  :error-messages="form.errors.interval"
                  density="compact"
                ></v-select>
              </v-fade-transition>
            </v-col>
          </v-row>

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
  recurring: false,
  interval: 'month',
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