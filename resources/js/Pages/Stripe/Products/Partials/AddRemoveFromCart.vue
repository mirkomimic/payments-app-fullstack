<template>
  <div>
    <v-btn
      @click="add"
      variant="tonal"
      color="primary"
      >Add to cart
    </v-btn>
    <v-btn
      @click="remove"
      variant="tonal"
      color="primary"
      >Remove from cart
    </v-btn>
  </div>
</template>

<script setup>
import { inject } from 'vue';
import { useForm } from '@inertiajs/vue3'

const product = inject('product')

const props = defineProps({
  price: { type: Object }
})

const form = useForm({
  product: product,
  price: props.price,
  quantity: 1,
})

const add = () => {
  form.post(route('cart.store'))
}

const remove = () => {
  form.post(route('cart.remove'))
}

</script>