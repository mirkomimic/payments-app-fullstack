<template>
  <v-dialog
    v-model="dialog"
    max-width="600"
    persistent
    scrim="transparent"
    style="backdrop-filter: blur(3px);"
  >
    <template v-slot:activator="{ props: activatorProps }">
      <v-badge 
        v-bind="activatorProps"
        :content="quantity"
        text-color="grey-lighten-4"
        color="red-lighten-1"
        class="cursor-pointer"
      >
        <v-icon icon="mdi-cart-variant" size="x-large"/>
      </v-badge>
    </template>
    
    <v-card
      prepend-icon="mdi-cart-variant"
      title="Cart"
    >
      <v-card-text class="mt-5">
        <v-table v-if="quantity">
          <thead>
            <tr>
              <th class="text-left">

              </th>
              <th class="text-left">
                Name
              </th>
              <th class="text-left">
                Price
              </th>
              <th class="text-left">
                Quantity
              </th>
              <th class="text-left">
                Total
              </th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(item, index) in $page.props.cart" :key="index"
            >
              <td>
                <v-img
                  :src="`/storage/images/products/${item.product.images[0]}`"
                  width="50">
                </v-img>
              </td>
              <td>{{ item.product.name }}</td>
              <td>&euro; {{ formatPrice(item.price.unit_amount / 100) }}</td>
              <td>{{ item.quantity }}</td>
              <td>&euro; {{ formatPrice((item.price.unit_amount * item.quantity) / 100) }}</td>
            </tr>
          </tbody>
          <tfoot>
            <tr class="font-weight-bold">
              <td colspan="3"></td>
              <td>Grand Total:</td>
              <td>&euro; {{ formatPrice(grandTotal / 100) }}</td>
            </tr>
          </tfoot>
        </v-table>
        <div v-else>
          No items in cart!
        </div>
      </v-card-text>

      <v-divider></v-divider>

      <v-card-actions>
        <v-btn
          @click="clear"
          :disabled="!quantity"
          color="error"
          text="Clear cart"
          variant="tonal"
          size="small"
        ></v-btn>

        <v-spacer></v-spacer>

        <v-btn
          @click="dialog = false"
          text="Close"
          variant="plain"
          size="small"
        ></v-btn>

        <v-btn
          @click="submit"
          :disabled="!quantity"
          form="form"
          color="primary"
          text="Checkout (hosted)"
          variant="tonal"
          size="small"
        ></v-btn>

        <v-btn
          @click="embeddedCheckout"
          :disabled="!quantity"
          form="form"
          color="primary"
          text="Checkout (embedded)"
          variant="tonal"
          size="small"
        ></v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script setup>
import { ref } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import { formatPrice } from '@/Composables/helpers';
import { computed } from 'vue';

const dialog = ref(false)

const cart = computed(() => usePage().props.cart)

const quantity = computed(() => {
  return cart.value.reduce((accumulator, item) => {
    return accumulator + item.quantity
  }, 0)
})

const grandTotal = computed(() => {
  return cart.value.reduce((accumulator, item) => {
    return accumulator + (item.quantity * item.price.unit_amount)
  }, 0)
})

const clear = () => {
  router.delete(route('cart.destroy'));
}

const submit = () => {
  let items = [];

  cart.value.forEach(item => {
    items.push({
      price: item.price.id,
      quantity: item.quantity,
    });
  })

  router.post(route('checkout.store', {items}))
}

const embeddedCheckout = () => {
  let items = [];

  cart.value.forEach(item => {
    items.push({
      price: item.price.id,
      quantity: item.quantity,
    });
  })

  router.get(route('embedded-checkout.index', {items}))
}
</script>