<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { storeToRefs } from 'pinia'
import ModalDialog from './lib/ModalDialog.vue'
import { useTreeStore } from '../stores/tree.js'


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

const treeStore = useTreeStore()
const { selectedFolderId } = storeToRefs(treeStore)

async function handleSubmit(data, node) {
  try {
    await axios.post(`/api/${itemName}s`, {
      ...data,
      parentFolderId: selectedFolderId.value
    })
  } catch (error) {
    node.setErrors(
      [error.response.data.errors.name ? '' : error.response.data.message],
      {
        name: error.response.data.errors.name || ''
      }
    )
  }
  // await new Promise((r) => setTimeout(r, 3000))
}
</script>


<template>
  <ModalDialog ref="modalDialog">
    <template #header>
      Create {{ itemName }}
    </template>

    <template #default="{ setDisableState }">
      <FormKit type="form" :actions="false" #default="{ disabled, state: { valid } }" @submit="handleSubmit">
        {{ setDisableState(disabled) }}
        <FormKit type="text" name="name" label="Name" inner-class="dark:bg-slate-700" />
        <FormKit type="submit" :disabled="!valid || disabled" outer-class="grow-0">
          <span v-if="disabled"
            class='w-5 h-5 border-2 border-white border-r-transparent mr-2 rounded-full animate-spin'></span>
          <span>Create</span>
        </FormKit>
      </FormKit>
    </template>
  </ModalDialog>
</template>