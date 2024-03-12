<template>
  <v-menu
    open-on-hover
    class="ms-auto"
    location="left"
    theme="light"
  >
    <template v-slot:activator="{ props }">
      <v-btn
        icon="mdi-dots-vertical"
        variant="text"
        v-bind="props"
      ></v-btn>
    </template>
    <v-list>
      <v-list-item
        value="1"
        prepend-icon="mdi-trash-can-outline"
        base-color="error"
        @click="form.delete(route('payment-methods.destroy', form.paymentMethodId))"
      >
        Remove
      </v-list-item>
      <v-list-item
        value="2"
        prepend-icon="mdi-check-circle-outline"
        v-if="!isDefault"
        @click="form.put(route('payment-methods.update', form.paymentMethodId))"
      >
        Set as default
      </v-list-item>
    </v-list>
  </v-menu>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import { computed } from 'vue'

const props = defineProps({
  paymentMethod: {type: Object},
  defaultMethod: {type: Object},
})

const isDefault = computed(() => {
  return props.paymentMethod.id == props.defaultMethod.id ? true : false
})

const form = useForm({
  paymentMethodId: props.paymentMethod.id
})


</script>