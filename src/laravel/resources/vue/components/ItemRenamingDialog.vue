<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { storeToRefs } from 'pinia'
import ModalDialog from './lib/ModalDialog.vue'
import { useTreeStore } from '../stores/tree.js'


const modalDialog = ref(null)

function open() {
  modalDialog.value.open()
}

function close() {
  modalDialog.value.close()
}

defineExpose({
  open,
})

const treeStore = useTreeStore()
const { selectedItem } = storeToRefs(treeStore)

async function handleSubmit(data, node) {
  try {
    await axios.patch(`/api/rename/${selectedItem.value.type}s/${selectedItem.value.id}`, data)
    await treeStore.fetchTree()
    close();
  } catch (error) {
    switch (error.response.status) {
      case 401:
      case 403:
        node.setErrors(
          [error.response.data.message],
        )
        break;
      default:
        node.setErrors(
          [error.response.data.errors.newName ? '' : error.response.data.message],
          {
            newName: error.response.data.errors.newName || ''
          }
        )
        break;
    }
  }
  // await new Promise((r) => setTimeout(r, 3000))
}
</script>


<template>
  <ModalDialog ref="modalDialog">
    <template #header>
      Rename {{ selectedItem.type }}
    </template>

    <template #default="{ setDisableState }">
      <FormKit type="form" :actions="false" #default="{ disabled, state: { valid } }" @submit="handleSubmit">
        {{ setDisableState(disabled) }}
        <FormKit type="text" name="currentName" label="Current name" inner-class="dark:bg-slate-700"
          :value="selectedItem.name" readonly />
        <FormKit type="text" name="newName" label="New name" inner-class="dark:bg-slate-700" />
        <FormKit type="submit" :disabled="!valid || disabled" outer-class="grow-0">
          <span v-if="disabled"
            class='w-5 h-5 border-2 border-white border-r-transparent mr-2 rounded-full animate-spin'></span>
          <span>Rename</span>
        </FormKit>
      </FormKit>
    </template>
  </ModalDialog>
</template>