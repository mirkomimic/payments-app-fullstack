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
        color="primary" 
        variant="outlined" 
        prepend-icon="mdi-pen" 
        size="small"
        >Edit prices
      </v-btn>
    </template>
    
    <v-card
      prepend-icon="mdi-pen"
      title="Edit product prices"
    >
      <v-card-text class="mt-5">
        <v-select
          v-model="form.price_id"
          label="Select default price"
          :items="props.prices.data"
          item-title="unit_amount_decimal"
          item-value="id"
          variant="outlined"
          class="mt-5"
          density="comfortable"
        >
          <template v-slot:selection="{item}">
            {{ formatPriceAsString(item.raw) }}
          </template>

          <template v-slot:item="{props, item}">
            <v-list-item
              :value="(props.value)"
              v-bind="props"
              :class="{'text-red': !item.raw.active}"
            >
              <template v-slot:title>
                {{ formatPriceAsString(item.raw) }}
              </template>
            </v-list-item>
          </template>
        </v-select>

      </v-card-text>

      <v-divider></v-divider>

      <v-card-actions>
        <v-btn
          @click="deactivatePrice"
          :disabled="form.processing || !form.isDirty"
          :loading="form.processing"
          form="form"
          color="error"
          text="Deactivate price"
          variant="tonal"
          type="submit"
        ></v-btn>

        <v-spacer></v-spacer>

        <v-btn
          text="Close"
          variant="plain"
          @click="close"
        ></v-btn>

        <v-btn
          @click="submit"
          :disabled="form.processing || !form.isDirty"
          :loading="form.processing"
          form="form"
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
import { findDefaultPriceByProd, formatPriceAsString } from '@/Composables/helpers';
import { computed } from 'vue';

const dialog = ref(false)

const props = defineProps({
  product: { type: Object, required: true },
  prices: {type: Object}
})

const defaultPrice = computed(() => {
  return findDefaultPriceByProd(props.prices, props.product)
})

const form = useForm({
  price_id: defaultPrice.value.id,
  product_id: props.product.id
})

const close = () => {
  dialog.value = false
}

const submit = () => {

  form.patch(route('prices.update', form.price_id), {
    onSuccess: () => {
      usePage().props.flash.isOpen = true
      close();
    },
  });
}

const deactivatePrice = () => {
  if (form.price_id == props.product.default_price) return false

  form.delete(route('prices.destroy', form.price_id), {
    onSuccess: () => {
      usePage().props.flash.isOpen = true
      close();
    },
  });
}
</script>