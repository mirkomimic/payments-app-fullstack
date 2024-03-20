<template>
  <div>
    checkout page

    <button @click="router.post(route('checkout.store'))" type="submit">Submit2</button>

  </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3'


</script>