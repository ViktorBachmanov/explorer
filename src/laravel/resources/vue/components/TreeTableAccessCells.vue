<script setup>
import axios from 'axios'
import { storeToRefs } from 'pinia'
import { useUsersStore } from '../stores/users.js'
import { useTreeStore } from '../stores/tree.js'


const props = defineProps({
  itemType: String, // folders | files
  itemId: Number,
  accessSelf: {
    type: Object,
    default: {
      1: null,
      2: null,
      3: null,
    }
  },
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
const { userAccessFor, currentUser } = storeToRefs(usersStore)

const treeStore = useTreeStore()

async function changeAccess(event) {
  event.target.disabled = true
  try {
    await axios.patch(`/api/update-access/${props.itemType}/${props.itemId}`, {
      userIdAccessFor: userAccessFor.value.id,
      access: {
        type: event.target.name,
        value: event.target.checked,
      }
    })
    await treeStore.fetchTree()
  } catch (error) {
  } finally {
    event.target.disabled = false
  }
}
</script>


<template>
  <td v-for="(accessValue, accessType) in accessSelf" :key="accessType">
    <span v-if="accessValue">&#x2713;</span>
  </td>
  <td v-for="(accessValue, accessType) in accessForUser" :key="accessType">
    <input v-if="currentUser.id !== -1 && userAccessFor.id !== -1" type="checkbox" :name="accessType"
      :checked="accessValue" @click.prevent="changeAccess" :disabled="!accessSelf.grant || !accessSelf[accessType]">
  </td>
</template>


<style scoped>
td {
  text-align: center;
  width: 4.5em;
}
</style>