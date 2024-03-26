<template>
    <MainLayout>
      <Head title="Checkout"/>

      <v-container>
        <div id="checkout"></div>
      </v-container>
    </MainLayout>
</template>

<script setup>
import { onMounted } from 'vue';
import { usePage, Head } from '@inertiajs/vue3'
import MainLayout from '@/Layouts/MainLayout.vue';

const props = defineProps(['clientSecret'])

const stripe = Stripe(usePage().props.stripe_key);

onMounted(async () => {
  
  const checkout = await stripe.initEmbeddedCheckout({
    clientSecret: props.clientSecret
  });

  checkout.mount('#checkout');
})

</script>