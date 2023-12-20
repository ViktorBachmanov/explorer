<script setup>
import 'bootstrap-icons/font/bootstrap-icons.css'
import axios from 'axios'

const props = defineProps({
  items: String,
})

function handleClick() {
  console.log(`create ${props.items}`)
}
</script>

<template>
  <button class="border rounded m-2 p-1 w-[2em]" @click="handleClick"></button>
</template>


<style scoped>
button {
  font-size: 1.5em;
  line-height: 1.5em;
}
</style>

