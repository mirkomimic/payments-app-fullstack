<template>
  <MainLayout>
    <Head title="Products"/>
    
    <Snackbar />

    <v-container>
      <Breadcrumbs :breadcrumbs="breadcrumbs"/>

      <v-sheet color="transparent">
        <CreateProductDialog />
      </v-sheet>

      <v-row
        justify="start"
        class="mt-5"
      >
        <v-col
          v-for="product in props.products.data" :key="product.id"
          cols="12"
          sm="6"
          md="4"
          class="pa-5"
        >
          <ProductCard
            :product="product"
            :prices="getDefaultPriceByProd(props.prices, product)" 
          />
        </v-col>
      </v-row>
    </v-container>
  </MainLayout>
</template>

<script setup>
import ProductCard from '@/Components/Cards/ProductCard.vue';
import CreateProductDialog from '@/Components/Dialogs/CreateProductDialog.vue';
import Breadcrumbs from '@/Components/Other/Breadcrumbs.vue';
import Snackbar from '@/Components/Other/Snackbar.vue';
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head } from '@inertiajs/vue3';
import { getPriceByProdId, getDefaultPriceByProd } from '@/Composables/helpers';

const props = defineProps({
  products: { type: Object },
  prices: {type: Object}
})

const breadcrumbs = [
  {
    title: 'Home',
    disabled: false,
    route: 'home',
  },
  {
    title: 'Products',
    disabled: true,
    route: 'products.index',
  },
]


</script>