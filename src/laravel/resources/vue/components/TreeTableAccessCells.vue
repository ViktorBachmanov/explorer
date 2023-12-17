<script setup>
import { ref } from 'vue'
import axios from 'axios'

const props = defineProps({
  itemId: Number,
  accessForUser: {
    type: Object,
    default: {
      1: null,
      2: null,
      3: null,
    }
  }
})

const accessTypes = ['read', 'write', 'grant']

const loading = ref(false)

async function changeAccess(event) {
  loading.value = true
  try {
    await axios.patch(`/api/update-access/folders/${props.itemId}`, {
      userIdAccessFor: 3,
      access: {
        type: event.target.name,
        value: event.target.checked,
      }
    })
  } catch (error) {
    event.preventDefault()
  } finally {
    loading.value = false
  }
}
</script>


<template>
  <td v-for="number in 3"></td>
  <td v-for="(accessValue, accessType) in accessForUser" :key="accessType">
    <input v-if="accessValue !== null" type="checkbox" :name="accessType" :checked="accessValue" @click="changeAccess">
    <span v-if="loading" class="text-slate-800 dark:text-slate-400">wait...</span>
  </td>
</template>


<style scoped>
td {
  text-align: center;
  width: 4.5em;
}
</style>