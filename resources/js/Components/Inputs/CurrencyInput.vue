<template>
  <v-text-field
    v-model="formattedValue"
    @change="$emit('change', numberValue)"
    ref="inputRef"
    variant="outlined"
    density="comfortable"
    label="Price"
  ></v-text-field>
</template>

<script setup>
import { useCurrencyInput } from 'vue-currency-input'

const modelValue = defineModel();
const emits = defineEmits(['change'])
const props = defineProps({currency: {type: String}})

const { inputRef, formattedValue, numberValue } = useCurrencyInput({
  currency: props.currency,
  hideCurrencySymbolOnFocus: false,
  hideGroupingSeparatorOnFocus: false,
  precision: 2,
  valueRange: { min: 0 },
  locale: 'de-DE',
  valueScaling: 'precision'
});
</script>