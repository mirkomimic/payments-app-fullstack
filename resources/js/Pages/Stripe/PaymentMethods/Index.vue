<template>
  <div>
    <Head title="Payment Methods"/>
    
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

    <MainLayout>
      <v-container>
        <Breadcrumbs :breadcrumbs="breadcrumbs"/>

        <v-sheet
          class="mt-5 mx-auto pa-5"
          :class="toggleBasedOnTheme(theme, '', 'bg-grey-lighten-1')"
          style="width: 500px;"
          rounded="lg"
        >
          <h3 class="mb-3">Add Payment Method</h3>

          <div>
            <v-text-field 
              id="card-holder-name" 
              type="text"
              variant="outlined"
              placeholder="Card Holder"
              density="comfortable"
            />
 
            <!-- Stripe Elements Placeholder -->
            <div id="card-element" class="custom-card-element"></div>
            
            <v-btn 
              id="card-button" 
              :data-secret="props.intent.client_secret"
              class="mt-3"
              color="light-blue-darken-4"
            >
              Add Payment Method
            </v-btn>
          </div>

        </v-sheet>


        <v-sheet
          class="mt-5 mx-auto pa-5 w-75"
          :class="toggleBasedOnTheme(theme, '', 'bg-grey-lighten-1')"
          rounded="lg"
        >
          <h3 class="mb-3">Your Payment Methods</h3>

          <v-expansion-panels
            flat
            tile
            variant="accordion"
            :color="toggleBasedOnTheme(theme, '', 'grey-lighten-1')"
          >
            <v-expansion-panel
              v-for="(paymentMethod, index) in props.paymentMethods" :key="paymentMethod.id"
              :bg-color="toggleBasedOnTheme(theme, '', 'grey-lighten-1')"
              rounded
            >
              <v-expansion-panel-title>
                <div class="w-100 d-flex justify-space-between align-center">
                  <div class="d-flex">
                    <v-img :src="`/images/credit-cards/${paymentMethod.card.brand}.png`" width="30" class="mx-1"></v-img>
                    <div class="text-h6 mx-1 text-capitalize">{{ paymentMethod.card.brand }}</div>
                    <div class="text-h6 mx-1">••••</div>
                    <div class="text-h6 mx-1">{{ paymentMethod.card.last4 }}</div>
                  </div>

                  <v-chip
                    v-if="isDefault(paymentMethod)"
                    variant="outlined"
                    color="green-darken-2"
                    >{{isDefault(paymentMethod) ? 'default' : ''}}
                  </v-chip>

                  <PaymentMethodOptionsMenu
                    :payment-method="paymentMethod"
                    :default-method="props.defaultMethod" 
                  />
                </div>
                
              </v-expansion-panel-title>
              <v-expansion-panel-text>
                <PaymentMethodInfoTable
                  :payment-method="paymentMethod"
                  :is-default-method="isDefault(paymentMethod)" 
                />
              </v-expansion-panel-text>
            </v-expansion-panel>
          </v-expansion-panels>
        </v-sheet>
      </v-container>
    </MainLayout>
  </div>
</template>

<script setup>
import { Head, usePage, router } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import { computed, onMounted } from 'vue';
import Breadcrumbs from '@/Components/Other/Breadcrumbs.vue';
import { toggleBasedOnTheme } from '@/Composables/helpers';
import { useTheme } from 'vuetify'
import PaymentMethodInfoTable from './Partials/PaymentMethodInfoTable.vue';
import PaymentMethodOptionsMenu from '@/Components/Menus/PaymentMethodOptionsMenu.vue';

const props = defineProps({
  intent: { type: Object },
  paymentMethods: { type: Array },
  defaultMethod: { type: Object },
})

const msg = computed(() => {
  return usePage().props.flash.msg ? true : false
})

const isDefault = (paymentMethod) => {
  return paymentMethod.id == props.defaultMethod.id ? true : false
}

const theme = useTheme()

const breadcrumbs = [
  {
    title: 'Home',
    disabled: false,
    route: 'home',
  },
  {
    title: 'Payment Methods',
    disabled: true,
    route: 'payment-methods.index',
  },
]


onMounted(() => {
  const stripe = Stripe(usePage().props.stripe_key);

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
  const clientSecret = cardButton.dataset.secret;
  
  cardButton.addEventListener('click', async (e) => {
    const { setupIntent, error } = await stripe.confirmCardSetup(
      clientSecret, {
      payment_method: {
        card: cardElement,
        billing_details: { name: cardHolderName.value }
      }
    }
    );

    if (error) {
      console.log(error);
    } else {
      // The card has been verified successfully...
      router.post(route('payment-methods.store', {
        payment_method: setupIntent.payment_method
      }))
    }
  });
})

</script>