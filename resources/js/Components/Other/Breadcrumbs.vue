<template>
  <v-breadcrumbs :items="props.breadcrumbs" icon="mdi-home" divider="/">
    <template v-slot:item="{item}">
      <v-breadcrumbs-item :disabled="item.disabled">
        <Link :href="route(item.route)" as="button">{{ item.title }}</Link>
      </v-breadcrumbs-item>
    </template>
  </v-breadcrumbs>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps(['breadcrumbs'])
</script>