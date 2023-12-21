<script setup>
import { ref, onMounted, onUnmounted, nextTick } from 'vue'
import axios from 'axios'
import { getNode } from '@formkit/core'
import { useTreeStore } from '../stores/tree.js'
import ModalDialog from './lib/ModalDialog.vue'


const writeAccess = ref(null)

const treeStore = useTreeStore()

let fileId, initialText

async function open(id, content, selfWriteAccess) {
  fileId = id
  initialText = content
  writeAccess.value = selfWriteAccess
  modalDialog.value.open()
  await nextTick()
  const textNode = getNode('text')
  textNode.input(initialText)
}

const modalDialog = ref(null)

function close() {
  modalDialog.value.close()
}

defineExpose({
  open,
})

async function handleSubmit(data, node) {
  try {
    await axios.patch(`/api/files/${fileId}`, data)
    await treeStore.fetchTree()
    close()
  } catch (error) {
    if (error.response.status === 403) {
      node.setErrors(
        ['Error'],
        {
          text: error.response.data.message
        }
      )
    } else {
      node.setErrors(
        ['Error'],
        error.response.data.errors
      )
    }
  }
}

function textChanged(node) {
  return node.value !== initialText
}
</script>


<template>
  <ModalDialog ref="modalDialog">
    <template #header>
      File text
    </template>

    <template #default="{ setDisableState }">
      <FormKit type="form" :actions="false" #default="{ disabled, state: { valid } }" @submit="handleSubmit"
        :config="{ validationVisibility: 'submit' }">
        {{ setDisableState(disabled) }}
        <FormKit id="text" name="text" type="textarea" :validation-rules="{ textChanged }" validation="+textChanged"
          input-class="dark:bg-gray-800 dark:text-zinc-200 p-2 w-80" :readonly="!writeAccess" />
        <div class="flex justify-end gap-x-2">
          <FormKit type="submit" :disabled="!valid || disabled" outer-class="grow-0" v-if="writeAccess">
            <span v-if="disabled"
              class='w-5 h-5 border-2 border-white border-r-transparent mr-2 rounded-full animate-spin'></span>
            <span>Save</span>
          </FormKit>
        </div>
      </FormKit>
    </template>
  </ModalDialog>
</template>


<style scoped>
.v-enter-active,
.v-leave-active {
  transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
  opacity: 0;
}
</style>