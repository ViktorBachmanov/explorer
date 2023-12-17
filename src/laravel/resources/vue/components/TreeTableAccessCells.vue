<script setup>
import axios from 'axios'
import { storeToRefs } from 'pinia'
import { useUsersStore } from '../stores/users.js'


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

const usersStore = useUsersStore()
const { userAccessFor } = storeToRefs(usersStore)


// const loading = ref(false)

async function changeAccess(event) {
  // loading.value = true
  event.target.disabled = true
  try {
    await axios.patch(`/api/update-access/folders/${props.itemId}`, {
      userIdAccessFor: userAccessFor.value.id,
      access: {
        type: event.target.name,
        value: event.target.checked,
      }
    })
    event.target.checked = true
  } catch (error) {
  } finally {
    // loading.value = false
    event.target.disabled = false
  }
}
</script>


<template>
  <td v-for="number in 3"></td>
  <td v-for="(accessValue, accessType) in accessForUser" :key="accessType">
    <input v-if="accessValue !== null" type="checkbox" :name="accessType" :checked="accessValue"
      @click.prevent="changeAccess">
    <!-- <span v-if="loading" class="text-slate-800 dark:text-slate-400">wait...</span> -->
  </td>
</template>


<style scoped>
td {
  text-align: center;
  width: 4.5em;
}
</style>