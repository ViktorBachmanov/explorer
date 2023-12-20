<script setup>
import { ref, onMounted, onUnmounted, nextTick } from 'vue'
import axios from 'axios'
import { getNode } from '@formkit/core'
import { useTreeStore } from '../stores/tree.js'


const isOpen = ref(false)

const writeAccess = ref(null)

const treeStore = useTreeStore()

let fileId, initialText

async function open(id, content, selfWriteAccess) {
  fileId = id
  initialText = content
  writeAccess.value = selfWriteAccess
  isOpen.value = true
  await nextTick()
  const textNode = getNode('text')
  textNode.input(initialText)
}

function close() {
  isOpen.value = false
}

defineExpose({
  open,
})

onMounted(() => {
  addEventListener('keyup', escape)
})

onUnmounted(() => {
  removeEventListener('keyup', escape)
})

function escape(e) {
  if (e.key === 'Escape') {
    close()
  }
}

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

function handleClose(e) {
  if (!e.dontClose) {
    close()
  }
}

function handleClickOnDialog(e) {
  e.dontClose = true
}
</script>


<template>
  <Transition>
    <div class="fixed inset-0 bg-gray-500/50 flex items-center justify-center" v-if="isOpen" @click="handleClose">
      <div class="bg-stone-500 rounded p-2" @click="handleClickOnDialog">
        <h3 class="text-xl font-medium mb-4">File text</h3>
        <FormKit type="form" :actions="false" #default="{ disabled, state: { valid } }" @submit="handleSubmit"
          :config="{ validationVisibility: 'submit' }">
          <FormKit id="text" name="text" type="textarea" :validation-rules="{ textChanged }" validation="+textChanged"
            input-class="dark:bg-gray-800 dark:text-zinc-200 p-2 w-80" :readonly="!writeAccess" />
          <div class="flex justify-end gap-x-2">
            <FormKit type="submit" :disabled="!valid || disabled" outer-class="grow-0" v-if="writeAccess">
              <span v-if="disabled"
                class='w-5 h-5 border-2 border-white border-r-transparent mr-2 rounded-full animate-spin'></span>
              <span>Save</span>
            </FormKit>
            <FormKit type="button" :disabled="disabled" label="Close" @click="close"
              input-class="dark:!bg-sky-800 dark:text-zinc-200" outer-class="grow-0" />
          </div>
        </FormKit>
      </div>
    </div>
  </Transition>
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