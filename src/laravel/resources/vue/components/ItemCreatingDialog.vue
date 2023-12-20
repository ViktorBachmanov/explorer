<script setup>
import { ref } from 'vue'
import axios from 'axios'
import ModalDialog from './lib/ModalDialog.vue'


const modalDialog = ref(null)

let itemName = ''

function open(iName) {
  itemName = iName;
  modalDialog.value.open()
}

// function close() {
//   isOpen.value = false;
// }

defineExpose({
  open,
})

async function handleSubmit(data) {
  // try {
  //   await axios.post(`/api/${itemName}s`, data)
  // } catch (error) {
  //   console.error(error)
  // }
  await new Promise((r) => setTimeout(r, 2000))
}
</script>


<template>
  <ModalDialog ref="modalDialog">
    <template #header>
      Create {{ itemName }}
    </template>

    <template #default>
      <FormKit type="form" submit-label="Create" @submit="handleSubmit">
        <FormKit name="name" label="Name" />
      </FormKit>
    </template>
  </ModalDialog>
</template>