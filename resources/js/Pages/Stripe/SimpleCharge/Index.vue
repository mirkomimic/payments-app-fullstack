<template>
  <Head title="Simple Charge" />

  <MainLayout>

    <v-container>

      <Breadcrumbs :breadcrumbs="breadcrumbs"/>

      <v-sheet
        class="mt-5 mx-auto pa-5"
        :class="toggleBasedOnTheme(theme, '', 'bg-grey-lighten-1')"
        style="width: 500px;"
        rounded="lg"
      >
        <h3 class="mb-3">Simple Charge</h3>
        <div>{{ error }}</div>
        <v-select
          v-model="form.amount"
          prepend-inner-icon="mdi-currency-eur"
          label="Select Amount"
          :items="amounts"
          variant="outlined"
          density="comfortable"
        >
          <template v-slot:item="{ props, item }">
            <v-list-item
              v-bind="props"
            >
              <template v-slot:prepend>
                <v-icon icon="mdi-currency-eur"></v-icon>
              </template>
            </v-list-item>
          </template>
        </v-select>
        <v-text-field
          variant="outlined"
          id="card-holder-name"
          type="text"
          placeholder="Card Holder"
          density="comfortable"
        />
        <div id="card-element" class="custom-card-element"></div>
      
        <v-btn
          id="card-button"
          class="mt-3"
          color="light-blue-darken-4"
          :disabled="loading"
          :loading="loading"
        >
          Process Payment
        </v-btn>
      </v-sheet>
    </v-container>
  </MainLayout>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { onMounted, ref } from 'vue';
import { Head, usePage, router, Link } from '@inertiajs/vue3';
import { useTheme } from 'vuetify'
import { toggleBasedOnTheme } from '@/Composables/helpers'; 
import Breadcrumbs from '@/Components/Other/Breadcrumbs.vue';

const theme = useTheme()
const error = ref('')
const loading = ref(false)

const form = ref({
  amount: 500
}) 

const amounts = [
  {
    title: '5,00',
    value: 500
  },
  {
    title: '10,00',
    value: 1000
  },
  {
    title: '20,00',
    value: 2000
  },
  {
    title: '50,00',
    value: 5000
  },
]

const breadcrumbs = [
  {
    title: 'Home',
    disabled: false,
    route: 'home',
  },
  {
    title: 'Simple Charge',
    disabled: true,
    route: 'simple-charge.index',
  },
]

onMounted(() => {
  const stripe = Stripe(usePage().props.stripe_key);

  // https://docs.stripe.com/js/appendix/style
  const style = {
    base: {
      iconColor: 'gray',
      color: 'black',
      fontWeight: '500',
      fontFamily: 'Roboto, Open Sans, Segoe UI, sans-serif',
      fontSize: '16px',
      fontSmoothing: 'antialiased',
      ':-webkit-autofill': {
          color: 'gray',
        },
      '::placeholder': {
          color: 'gray',
        },
      },
      invalid: {
        iconColor: 'red',
        color: 'red',
      },
  }

  const elements = stripe.elements();
  const cardElement = elements.create('card', {style});
  
  cardElement.mount('#card-element');

  const cardHolderName = document.getElementById('card-holder-name');
  const cardButton = document.getElementById('card-button');
  
  cardButton.addEventListener('click', async (e) => {
    loading.value = true

    const { paymentMethod, error } = await stripe.createPaymentMethod(
      'card', cardElement, {
        billing_details: { name: cardHolderName.value },
      }
    );

    if (error) {
      loading.value = false
      error.value = error.message
    } else {
      router.post(route('simple-charge.store', {
        paymentMethodId: paymentMethod.id,
        amount: form.value.amount,
      }))
    }
  });
})
</script>