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
            &euro; {{ formatPrice(item.title / 100) }}
          </template>

          <template v-slot:item="{props, item}">
            <v-list-item
              :value="(props.value)"
              v-bind="props"
              v-if="item.raw.active"
            >
              <template v-slot:title>
                &euro; {{ formatPrice(props.title / 100) }}
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
import { ref, computed } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'
import { formatPrice, getDefaultPriceByProd } from '@/Composables/helpers';

const dialog = ref(false)

const props = defineProps({
  product: { type: Object, required: true },
  prices: {type: Object}
})

const isChanged = computed(() => {
  return getDefaultPriceByProd(props.prices, props.product)[0] == form.price_id ? true : false
})

const form = useForm({
  price_id: getDefaultPriceByProd(props.prices, props.product)[0].id,
  product_id: props.product.id
})


const close = () => {
  dialog.value = false
}

const submit = () => {

  form.patch(route('prices.update', form.price_id), {
    onSuccess: () => usePage().props.flash.isOpen = true,
  });

  close();

}

const deactivatePrice = () => {
  if (form.price_id == props.product.default_price) return false

  form.delete(route('prices.destroy', form.price_id), {
    onSuccess: () => usePage().props.flash.isOpen = true,
  });

  close();

}
</script>