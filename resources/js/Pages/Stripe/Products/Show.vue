<template>
  <MainLayout>
    <Head title="Products"/>
    
    <Snackbar />

    <v-container>
      <Breadcrumbs :breadcrumbs="breadcrumbs"/>
    </v-container>
  </MainLayout>
</template>

<script setup>
import Breadcrumbs from '@/Components/Other/Breadcrumbs.vue';
import Snackbar from '@/Components/Other/Snackbar.vue';
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head } from '@inertiajs/vue3'

const props = defineProps({
  product: { type: Object, required: true },
  prices: {type: Object}
})

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