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
    await axios({
      method: 'DELETE',
      url: `/api/${selectedItem.value.type}s/${selectedItem.value.id}`
    })
    await treeStore.fetchTree()
    close();
  } catch (error) {
    node.setErrors(
      [error.response.data.message],
    )
  }
  // await new Promise((r) => setTimeout(r, 3000))
}
</script>


<template>
  <ModalDialog ref="modalDialog">
    <template #header>
      Remove {{ selectedItem.type }}
    </template>

    <template #default="{ setDisableState }">
      <FormKit type="form" :actions="false" #default="{ disabled, state: { valid } }" @submit="handleSubmit">
        {{ setDisableState(disabled) }}
        <div class="m-4">Remove '{{ selectedItem.name }}'?</div>
        <FormKit type="submit" :disabled="!valid || disabled" outer-class="grow-0">
          <span v-if="disabled"
            class='w-5 h-5 border-2 border-white border-r-transparent mr-2 rounded-full animate-spin'></span>
          <span>Yes</span>
        </FormKit>
      </FormKit>
    </template>
  </ModalDialog>
</template>