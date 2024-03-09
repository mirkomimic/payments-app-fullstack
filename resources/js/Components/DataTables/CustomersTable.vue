<template>
  <v-data-table
    :headers="headers"
    :items="customers"
    item-key="name"
    items-per-page="5"
  >
    <template v-slot:item.actions="{ item }">
      <v-icon
        class="me-2"
        size="small"
        @click="editItem(item)"
      >
        mdi-pencil
      </v-icon>
      <v-icon
        size="small"
        @click="deleteItem(item)"
      >
        mdi-delete
      </v-icon>
    </template>

    <template v-slot:top>
      <v-toolbar
        flat
        color="transparent"
      >
        <v-toolbar-title>Customers</v-toolbar-title>

        <v-dialog
          v-model="dialogTable"
          max-width="500px"
        >
          <v-card>

            <v-card-title>
              <span class="text-h5">Edit Customer</span>
            </v-card-title>
            <v-card-text>
              <v-container>
                <v-row>
                  <v-col
                    cols="12"
                  >
                    <v-text-field
                      v-model="form.id"
                      disabled
                      label="ID"
                      variant="outlined"
                    >
                    </v-text-field>
                  </v-col>
                  <v-col
                    cols="12"
                  >
                    <v-text-field
                      v-model="form.name"
                      :rules="[rules.required]"
                      :error-messages="$page.props.errors.name"
                      label="Name"
                      variant="outlined"
                    >
                    </v-text-field>
                  </v-col>
                  <v-col
                    cols="12"
                  >
                    <v-text-field
                      v-model="form.email"
                      :rules="[rules.required]"
                      :error-messages="$page.props.errors.email"
                      label="Email"
                      variant="outlined"
                    >
                    </v-text-field>
                  </v-col>
                </v-row>
              </v-container>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn
                variant="text"
                @click="close"
              >
                Cancel
              </v-btn>
              <v-btn
                variant="text"
                @click="save"
              >
                Save
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>

        <v-dialog v-model="dialogDelete" max-width="500px">
          <v-card>
            <v-card-title class="text-h5">Are you sure you want to delete this item?</v-card-title>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue-darken-1" variant="text" @click="closeDelete">Cancel</v-btn>
              <v-btn color="blue-darken-1" variant="text" @click="deleteItemConfirm">OK</v-btn>
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-toolbar>
    </template>

  </v-data-table>
</template>

<script setup>
import { ref, nextTick, watch } from 'vue';
import { router, useForm, usePage } from '@inertiajs/vue3'

const props = defineProps({
  customers: {type: Array},
})

const dialogDelete = ref(false)
const dialogTable = ref(false)
const editedIndex = ref(-1)

const editedItem = ref({
  id: null,
  name: null,
  email: null,
  stripe_id: null,
})

const defaultItem = ref({
  id: null,
  name: null,
  email: null,
  stripe_id: null,
})

const form = useForm({
  id: null,
  name: null,
  email: null,
})

const headers = [
  { title: 'ID', key: 'id' },
  { title: 'Name', key: 'name' },
  { title: 'Email', key: 'email' },
  { title: 'Stripe ID', key: 'stripe_id' },
  { title: 'Actions', key: 'actions'}
]

const rules = {
  required: value => !!value || 'The field is required.',
}

const deleteItem = (item) => {
  editedIndex.value = props.customers.indexOf(item)
  editedItem.value = Object.assign({}, item)
  dialogDelete.value = true
}

const editItem = (item) => {
  form.id = item.id
  form.name = item.name
  form.email = item.email

  editedIndex.value = props.customers.indexOf(item)
  editedItem.value = Object.assign({}, item)
  dialogTable.value = true
}

const deleteItemConfirm = () => {
  // delete customer
  try {
    router.delete(route('customers.destroy', editedItem.value.id))

  } catch (error) {
    console.log(error);
  }

  closeDelete()
}

const closeDelete = () => {
  dialogDelete.value = false
  nextTick(() => {
    editedItem.value = Object.assign({}, defaultItem.value)
    editedIndex.value = -1
  })
}

const close = () => {
  dialogTable.value = false
  nextTick(() => {
    editedItem.value = Object.assign({}, defaultItem.value)
    editedIndex.value = -1
    // usePage().props.errors.name = null
    form.reset();
  })
}

const save = () => {
  try {

    form.patch(route('customers.update', form.id));

    form.reset()
    dialogTable.value = false

    setTimeout(() => {
      usePage().props.flash.msg = null

    }, 5000);


    } catch (error) {
      console.log(error);
    }
}

watch(dialogTable, (val) => {
  val || close()
})
watch(dialogDelete, (val) => {
  val || closeDelete()
})
</script>