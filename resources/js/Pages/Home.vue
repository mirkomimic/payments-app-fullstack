<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { useTheme } from 'vuetify'
import { toggleBasedOnTheme } from '@/Composables/helpers'; 

const theme = useTheme()

const buttons = [
  {
    name: 'first',
    route: 'href'
  },
]
</script>

<template>

  <Head title="Home" />

  <MainLayout>
    <v-container>
      <v-row
        style="height: 150px;"
        no-gutters
      >
        <v-col
          v-for="button in buttons" :key="button.name"
          cols="3"
        >
          <Link href="/">
            <v-btn
              height="100"
              width="100"
              :color="toggleBasedOnTheme(theme, 'light-blue-darken-4', 'light-blue-lighten-4')"
              variant="tonal"
            >
              {{ button.name }}
            </v-btn>
          </Link>
        </v-col>
      </v-row>
    </v-container>
  </MainLayout>
</template>