<template>
  <MainLayout>
    <Head title="Subscriptions"/>
    
    <Snackbar />

    <v-container>
      <Breadcrumbs :breadcrumbs="breadcrumbs"/>

      <v-table>
        <thead>
          <tr>
            <th></th>
            <th>Name</th>
            <th>Price</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in props.subscriptions" :key="index">
            <td>
              <v-img
                :src="`/storage/images/products/${item.product.images[0]}`"
                width="50">
              </v-img>
            </td>
            <td>{{ item.product.name }}</td>
            <td>{{ formatPriceAsString(item.price) }}</td>
            <td>
              <CancelSubscriptionDialog v-if="!item.subscription.ends_at" :subscription="item.subscription"/>
              <span v-else class="text-red">Canceled</span>
            </td>
          </tr>
        </tbody>
      </v-table>
    </v-container>
  </MainLayout>
</template>

<script setup>
import CancelSubscriptionDialog from '@/Components/Dialogs/CancelSubscriptionDialog.vue';
import Breadcrumbs from '@/Components/Other/Breadcrumbs.vue';
import Snackbar from '@/Components/Other/Snackbar.vue';
import { formatPriceAsString } from '@/Composables/helpers';
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head } from '@inertiajs/vue3'

const breadcrumbs = [
  {
    title: 'Home',
    disabled: false,
    route: 'home',
  },
  {
    title: 'Subscriptions',
    disabled: true,
    route: 'subscriptions.index',
  },
]

const props = defineProps({
  subscriptions: {type: Array}
})

</script>