<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import 'bootstrap-icons/font/bootstrap-icons.css'


const isOpen = ref(false)

function open() {
  isOpen.value = true;
}

function close() {
  isOpen.value = false;
}

function handleClickOnBacking(e) {
  if (!e?.dontClose && !isDisabled.value) {
    close()
  }
}

function handleClickOnDialog(e) {
  e.dontClose = true
}

defineExpose({
  open,
  close,
})

onMounted(() => {
  addEventListener('keyup', escape)
})

onUnmounted(() => {
  removeEventListener('keyup', escape)
})

function escape(e) {
  if (e.key === 'Escape' && !isDisabled.value) {
    close()
  }
}

const isDisabled = ref(false)
function setDisabled(val) {
  isDisabled.value = val
}
</script>


<template>
  <Transition>
    <div class="fixed inset-0 bg-gray-500/50 flex items-center justify-center" v-if="isOpen"
      @click="handleClickOnBacking">
      <div class="bg-gray-200 dark:bg-slate-800 rounded p-2" @click="handleClickOnDialog">
        <header class="flex justify-between font-medium ps-1">
          <slot name="header"></slot>
          <button :disabled="isDisabled" class="bi bi-x border rounded m-1 mb-3 w-[1.33em] border-black dark:border-white"
            :class="{ disabled: isDisabled }" style="font-size: 1.2em; line-size: 1.2em;" @click="close"></button>
        </header>

        <main>
          <slot :setDisableState="setDisabled"></slot>
        </main>
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

.disabled {
  cursor: not-allowed;
}
</style>