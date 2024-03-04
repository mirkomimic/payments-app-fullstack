<template>
  <v-toolbar
    color="transparent"
    density="compact"
  >
    <v-container>
      <div class="ml-auto d-flex items-center gap-4">

        <div class="d-none d-md-block">
          <Link href="/">
            <img width="70" src=""> ICON
          </Link>
        </div>

        <v-spacer></v-spacer>

        <Link v-if="!$page.props.auth.user" :href="route('login')" class="">Log in</Link>
        <Link v-if="!$page.props.auth.user" :href="route('register')" class="">Register</Link>
        <v-switch
          @click="toggleTheme(theme)"
          density="compact"
          true-icon="mdi-white-balance-sunny"
          false-icon="mdi-weather-night"
          color="light-blue-lighten-4"
          value="secondary"
          hide-details
        ></v-switch>
        <NavBarUserMenu v-if="$page.props.auth.user"/>
      </div>
    </v-container>
  </v-toolbar>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { toggleTheme } from '@/Composables/helpers'
import { useTheme } from 'vuetify'
import NavBarUserMenu from './Menus/NavBarUserMenu.vue';

const theme = useTheme()

</script>