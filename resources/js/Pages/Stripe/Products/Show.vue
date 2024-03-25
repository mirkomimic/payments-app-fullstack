<template>
  <MainLayout>
    <Head title="Products"/>
    
    <Snackbar />

    <v-container>
      <Breadcrumbs :breadcrumbs="breadcrumbs"/>

      <v-sheet class="mt-5 d-flex ga-3" color="transparent">
        <EditProductPricesDialog
          :product="props.product"
          :prices="props.prices" 
        />
        <CreateProductPriceDialog 
          :product="props.product"
        />
      </v-sheet>

      <v-carousel
        color="white"
        hide-delimiter-background
      >
        <v-carousel-item
          v-for="(image, index) in props.product.images" :key="index"
        >
          <template v-slot:default>
            <v-img :src="`/storage/images/products/${image}`" height="500"></v-img>
          </template>
        </v-carousel-item>
      </v-carousel>

      <v-table density="compact">
        <tbody>
          <tr>
            <td>ID</td>
            <td>{{ props.product.id }}</td>
          </tr>
          <tr>
            <td>Name</td>
            <td>{{ props.product.name }}</td>
          </tr>
          <tr>
            <td>Price</td>
            <td class="d-flex align-center ga-3"> 
              <div 
                v-for="(price, index) in props.prices.data" :key="index"
                :class="{
                  'text-red text-decoration-line-through': !isDefaultPrice(price, props.product),
                  'order-first': isDefaultPrice(price, props.product),
                  'd-none': !price.active
                }" 
              >
                &euro; {{ formatPrice((price.unit_amount_decimal / 100)) }}
              </div>
            </td>
          </tr>
        </tbody>
      </v-table>

      <AddRemoveFromCart :price="findDefaultPriceByProd(props.prices, props.product)" class="mt-3"/>
    </v-container>
  </MainLayout>
</template>

<script setup>
import CreateProductPriceDialog from '@/Components/Dialogs/CreateProductPriceDialog.vue';
import EditProductPricesDialog from '@/Components/Dialogs/EditProductPricesDialog.vue';
import Breadcrumbs from '@/Components/Other/Breadcrumbs.vue';
import Snackbar from '@/Components/Other/Snackbar.vue';
import { formatPrice, isDefaultPrice, findDefaultPriceByProd } from '@/Composables/helpers';
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head, useForm } from '@inertiajs/vue3'
import AddRemoveFromCart from './Partials/AddRemoveFromCart.vue';
import { provide } from 'vue';

const props = defineProps({
  product: { type: Object, required: true },
  prices: {type: Object}
})

provide('product', props.product)

const breadcrumbs = [
  {
    title: 'Home',
    disabled: false,
    route: 'home',
  },
  {
    title: 'Product',
    disabled: true,
    route: 'products.index',
  },
]
</script>