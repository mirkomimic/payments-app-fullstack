<template>
  <v-dialog
    v-model="dialog"
    max-width="600"
    persistent
    scrim="transparent"
    style="backdrop-filter: blur(3px);"
  >
    <template v-slot:activator="{ props: activatorProps }">
      <v-btn
        class="text-none font-weight-regular"
        prepend-icon="mdi-plus"
        text="Create Product"
        variant="tonal"
        v-bind="activatorProps"
      ></v-btn>
    </template>
    
    <v-card
      prepend-icon="mdi-plus"
      title="Product"
    >
      <v-card-text class="mt-5">
        <v-form
          v-model="isValid"
          @submit.prevent="submit"
          id="form"
        >
          <v-row dense>

            <v-col
              cols="12"
            >
              <v-text-field
                v-model="form.name"
                label="Name*"
                required
                variant="outlined"
                :rules="[rules.required]"
                :error-messages="form.errors.name"
              ></v-text-field>
            </v-col>

            <v-col
              cols="12"
            >
              <v-text-field
                v-model="form.price"
                @blur="form.price = formatInputPrice(form.price)"
                type="text"
                label="Price*"
                required
                variant="outlined"
                prefix="&euro;"
                :rules="[rules.required, rules.price]"
                :error-messages="form.errors.price"
              ></v-text-field>
            </v-col>

            <v-col
              cols="12"
            >
              <v-file-input
                v-model="form.images"
                @change="setImg"
                :rules="[rules.fileCount]"
                :error-messages="form.errors.images"
                label="Add Image"
                variant="solo"
                prepend-icon="mdi-camera"
                clear-icon="false"
                multiple
              ></v-file-input>
            </v-col>

            <v-col
              cols="12"
            >
              <v-sheet class="d-flex justify-center">
                <v-img v-if="imgPreview" :src="imgPreview" width="100" height="100"></v-img>
                <v-sheet v-else border="sm" rounded class="d-flex justify-center items-center pa-2" width="300" height="200">
                  <v-icon icon="mdi-image-frame" size="50" class="mt-3"></v-icon>
                </v-sheet>
              </v-sheet>
            </v-col>

          </v-row>
        </v-form>
      </v-card-text>

      <v-divider></v-divider>

      <v-card-actions>
        <v-spacer></v-spacer>

        <v-btn
          text="Close"
          variant="plain"
          @click="close"
        ></v-btn>

        <v-btn
          :disabled="form.processing"
          :loading="form.processing"
          form="form"
          color="primary"
          text="Save"
          variant="tonal"
          type="submit"
        ></v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script setup>
import { ref } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'
import { rules, formatInputPrice, removeDotsAndCommas } from '@/Composables/helpers';

const dialog = ref(false)
const isValid = ref(false)
const imgPreview = ref(null)

const form = useForm({
  name: '',
  price: null,
  images: null
})

const close = () => {
  form.reset();
  dialog.value = false
  imgPreview.value = null
}

const submit = () => {
  if (!isValid.value) return

  form.transform((data) => ({
    ...data,
    price: Number(removeDotsAndCommas(data.price) * 100),
  })).post(route('products.store'), {
    onSuccess: () => usePage().props.flash.isOpen = true,
  });

  close();

}

const setImg = (e) => {
  if (e.target.files) {
    imgPreview.value = URL.createObjectURL(e.target.files[0])
  }
}
</script>