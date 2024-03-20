<template>
  <v-hover v-slot="{ isHovering, props }">
    <v-card
      v-bind="props"
      @click="router.get(route('products.show', product.id))"
      class="mx-auto"
      max-width="400"
      :elevation="isHovering ? 4 : 1"
      link
    >
      <v-img
        class="align-end text-white"
        height="200"
        :src="`storage/images/products/${product.images[0]}`"
        cover
      >
        <v-card-title>{{ product.name }}</v-card-title>
      </v-img>
      <v-card-subtitle class="pt-4">
        {{ product.object }}
      </v-card-subtitle>
      <v-card-text>
        
        <div v-for="price in prices" :key="price.id">
          {{ formatPrice(price.unit_amount_decimal / 100) }}
        </div>

        <div>{{ product.description }}</div>
      </v-card-text>
      <v-card-actions>

        <DeleteProductDialog :id="product.id"/>

      </v-card-actions>
    </v-card>
  </v-hover> 
</template>

<script setup>
import { formatPrice } from '@/Composables/helpers';
import DeleteProductDialog from '../Dialogs/DeleteProductDialog.vue';
import { router } from '@inertiajs/vue3'

defineProps({
  product: { type: Object, required: true },
  prices: {type: Array}
})
</script>