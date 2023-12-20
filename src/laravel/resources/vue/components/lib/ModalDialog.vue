<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import 'bootstrap-icons/font/bootstrap-icons.css'


const isOpen = ref(false)

function open() {
  isOpen.value = true;
}

function close(e) {
  if (!e?.dontClose) {
    isOpen.value = false;
  }
}

function handleClickOnDialog(e) {
  e.dontClose = true
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
</script>


<template>
  <Transition>
    <div class="fixed inset-0 bg-gray-500/50 flex items-center justify-center" v-if="isOpen" @click="close">
      <div class="bg-stone-500 rounded p-2" @click="handleClickOnDialog">
        <header class="flex justify-between">
          <slot name="header"></slot>
          <button class="bi bi-x border rounded m-1 w-[1.33em]" style="font-size: 1.2em; line-size: 1.2em;"
            @click="close"></button>
        </header>

        <main>
          <slot></slot>
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
</style>