<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const isOpen = ref(false)

const fileId = ref(null)
const text = ref('')

function open(id, content) {
  text.value = content
  isOpen.value = true
}

function close() {
  console.log('close')
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
    console.log('escape key')
    close()
  }
}
</script>


<template>
  <Transition>
    <div class="fixed inset-0 bg-gray-500/50 flex items-center justify-center" v-if="isOpen">
      <!-- <div class="w-min">
        <textarea class="dark:bg-gray-800 dark:text-zinc-200 p-2" v-model="text"></textarea>
        <button @click="close">Close</button>
      </div>
     -->
      <h2 class="text-xl font-bold mb-4">Edit file</h2>
      <FormKit type="form">
        <FormKit name="text" type="textarea" />
      </FormKit>
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