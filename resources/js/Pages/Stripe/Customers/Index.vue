<template>
  <MainLayout>

    <Head title="Customers"/>

    <v-snackbar
      v-model="msg"
      location="top right"
      position="fixed"
      variant="elevated"
      color="light-blue-darken-4"
      vertical
    >
      <div class="text-subtitle-1 pb-2 font-weight-bold">Message</div>

      <p>{{ $page.props.flash.msg }}</p>

      <template v-slot:actions>
        <v-btn
          color="black"
          variant="text"
          @click="$page.props.flash.msg = false"
        >
          Close
        </v-btn>
      </template>
    </v-snackbar>
    
    <v-container>

      <Breadcrumbs :breadcrumbs="breadcrumbs"/>

      <v-card>
        <v-tabs
          v-model="tab"
          bg-color="primary"
          align-tabs="center"
        >
          <v-tab value="one">Customers</v-tab>
          <v-tab value="two">Create Customer</v-tab>
        </v-tabs>

        <v-card-text style="min-height: 500px;">
          <v-window v-model="tab">
            <v-window-item value="one">
              <CustomersTable :customers="customers"/>
            </v-window-item>

            <v-window-item value="two">
              <CreateTab :users="props.users"/>
            </v-window-item>

          </v-window>
        </v-card-text>
      </v-card>

    </v-container>
  </MainLayout>
</template>

<script setup>
import Breadcrumbs from '@/Components/Other/Breadcrumbs.vue';
import MainLayout from '@/Layouts/MainLayout.vue'
import { Head, usePage } from '@inertiajs/vue3'
import { computed, ref } from 'vue';
import CreateTab from '@/Pages/Stripe/Customers/Partials/CreateTab.vue';
import CustomersTable from '@/Components/DataTables/CustomersTable.vue';

const tab = ref(null)

const props = defineProps({
  users: { type: Array },
  customers: {type: Array}
})

const breadcrumbs = [
  {
    title: 'Home',
    disabled: false,
    route: 'home',
  },
  {
    title: 'Customers',
    disabled: true,
    route: 'customers.index',
  },
]

const msg = computed(() => {
  return usePage().props.flash.msg ? true : false
})
</script>