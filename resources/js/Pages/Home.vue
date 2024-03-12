<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { useTheme } from 'vuetify'
import { toggleBasedOnTheme } from '@/Composables/helpers'; 
import { computed } from 'vue'
import Breadcrumbs from '@/Components/Other/Breadcrumbs.vue';

const theme = useTheme()

const buttons = [
  {
    name: 'Simple Charge',
    route: 'simple-charge.index'
  },
  {
    name: 'Customers',
    route: 'customers.index'
  },
  {
    name: 'Payment Methods',
    route: 'payment-methods.index'
  },
]

const breadcrumbs = [
  {
    title: 'Home',
    disabled: true,
    route: 'home',
  },
]

const msg = computed(() => {
  return usePage().props.msg ? true : false
})
</script>

<template>

  <Head title="Home" />

  <MainLayout>

    <v-snackbar
      v-model="msg"
      location="top right"
      position="fixed"
      variant="elevated"
      color="light-blue-darken-4"
      vertical
    >
      <div class="text-subtitle-1 pb-2 font-weight-bold">Message</div>

      <p>{{ $page.props.msg }}</p>

      <template v-slot:actions>
        <v-btn
          color="black"
          variant="text"
          @click="$page.props.msg = false"
        >
          Close
        </v-btn>
      </template>
    </v-snackbar>

    <v-container>

      <Breadcrumbs :breadcrumbs="breadcrumbs"/>

      <v-row
        style="height: 150px;"
        no-gutters
        justify="space-between"
        justify-md="center"
        align-content="center"
      >
        <v-col
          v-for="button in buttons" :key="button.name"
          cols="3"
          class="ma-3"
        >
          <Link :href="route(button.route)">
            <v-btn
              height="100"
              width="100%"
              :color="toggleBasedOnTheme(theme, 'light-blue-darken-4', 'light-blue-lighten-4')"
              variant="flat"
            >
              <div class="text-wrap">{{ button.name }}</div>
            </v-btn>
          </Link>
        </v-col>
      </v-row>
    </v-container>
  </MainLayout>
</template>