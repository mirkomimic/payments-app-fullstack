<template>
  <v-table density="compact" :class="toggleBasedOnTheme(theme, '', 'bg-grey-lighten-1')" theme="light">
    <tbody>
      <tr>
        <td>Name</td>
        <td>{{ props.paymentMethod.billing_details.name }}</td>
      </tr>
      <tr>
        <td>Number</td>
        <td class="d-flex align-center">
          <div class="mx-1">••••</div>
          <div class="mx-1">{{ props.paymentMethod.card.last4 }}</div>
        </td>
      </tr>
      <tr>
        <td>Fingerprint</td>
        <td>{{ props.paymentMethod.card.fingerprint }}</td>
      </tr>
      <tr>
        <td>Expires</td>
        <td>{{ props.paymentMethod.card.exp_month + ' / ' + props.paymentMethod.card.exp_year }}</td>
      </tr>
      <tr>
        <td>Type</td>
        <td class="text-capitalize">{{ props.paymentMethod.type }}</td>
      </tr>
      <tr>
        <td>ID</td>
        <td>{{ props.paymentMethod.id }}</td>
      </tr>
      <tr>
        <td>Postal code</td>
        <td>{{ props.paymentMethod.billing_details.address.postal_code }}</td>
      </tr>
      <tr>
        <td>Phone</td>
        <td>{{ props.paymentMethod.billing_details.phone || '-' }}</td>
      </tr>
      <tr>
        <td>Email</td>
        <td>{{ props.paymentMethod.billing_details.email || '-' }}</td>
      </tr>
      <tr>
        <td>Origin</td>
        <td>{{ props.paymentMethod.card.country }}</td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <td>
          <v-btn
            @click="form.delete(route('payment-methods.destroy', form.paymentMethodId))"
            :loading="form.processing"
            :disabled="form.processing"
            color="error"
            variant="outlined"
            density="comfortable"
            class="mt-3"
            >Remove Card
          </v-btn>
        </td>
        <td>
          <v-btn
            v-if="!isDefaultMethod"
            @click="form.put(route('payment-methods.update', form.paymentMethodId))"
            :loading="form.processing"
            :disabled="form.processing"
            color="primary"
            variant="outlined"
            density="comfortable"
            class="mt-3"
            >Set as default
          </v-btn>
        </td>
      </tr>
    </tfoot>
  </v-table>
</template>

<script setup>
import { toggleBasedOnTheme } from '@/Composables/helpers';
import { useTheme } from 'vuetify'
import { useForm } from '@inertiajs/vue3'

const theme = useTheme()

const props = defineProps({
  paymentMethod: { type: Object },
  isDefaultMethod: {type: Boolean}
})

const form = useForm({
  paymentMethodId: props.paymentMethod.id
})
</script>