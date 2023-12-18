<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue'

const isOpen = ref(false)

const fileId = ref(null)
const text = ref('')

let inititalText;

function open(id, content) {
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

// const submitted = ref(false)
const submitHandler = async () => {
  // Let's pretend this is an ajax request:
  await new Promise((r) => setTimeout(r, 1000))
  // submitted.value = true
}
</script>


<template>
  <Transition>
    <div class="fixed inset-0 bg-gray-500/50 flex items-center justify-center" v-if="isOpen">
      <h2 class="text-xl font-bold mb-4">Edit file</h2>
      <FormKit type="form" :actions="false" #default="{ disabled }" @submit="submitHandler">
        <FormKit name="text" type="textarea" outer-class="dark:bg-gray-800 dark:text-zinc-200 p-2" v-model="text" />
        <div class="flex">
          <FormKit type="submit" :disabled="disabled || !textWasChanged">
            <span v-if="disabled"
              class='w-5 h-5 border-2 border-white border-r-transparent mr-2 rounded-full animate-spin'></span>
            <span>Save</span>
          </FormKit>
          <FormKit type="button" :disabled="disabled" label="Close" @click="close" />
        </div>
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