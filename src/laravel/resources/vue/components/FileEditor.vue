<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue'
import axios from 'axios'
import { useTreeStore } from '../stores/tree.js'


const isOpen = ref(false)

const text = ref('')

const treeStore = useTreeStore()

let fileId, inititalText;

function open(id, content) {
  fileId = id
  text.value = inititalText = content
  isOpen.value = true
}

function close() {
  console.log('close')
  isOpen.value = false
}

const textWasChanged = computed(() => inititalText !== text.value)

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
    console.log('escape key')
    close()
  }
}

async function handleSubmit() {
  try {
    await axios.patch(`/api/files/${fileId}`, {
      text: text.value
    })
    await treeStore.fetchTree()
    close()
  } catch (error) {
    console.error(error)
  }
}
</script>


<template>
  <Transition>
    <div class="fixed inset-0 bg-gray-500/50 flex items-center justify-center" v-if="isOpen">
      <div class="bg-stone-500 rounded p-2">
        <h3 class="text-xl font-medium mb-4">File text</h3>
        <FormKit type="form" :actions="false" #default="{ disabled }" @submit="handleSubmit">
          <FormKit name="text" type="textarea" input-class="dark:bg-gray-800 dark:text-zinc-200 p-2 w-80"
            v-model="text" />
          <div class="flex justify-end gap-x-2">
            <FormKit type="submit" :disabled="disabled || !textWasChanged" outer-class="grow-0">
              <span v-if="disabled"
                class='w-5 h-5 border-2 border-white border-r-transparent mr-2 rounded-full animate-spin'></span>
              <span>Save</span>
            </FormKit>
            <FormKit type="button" :disabled="disabled" label="Close" @click="close"
              input-class="dark:bg-slate-700 dark:text-zinc-200" outer-class="grow-0" />
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