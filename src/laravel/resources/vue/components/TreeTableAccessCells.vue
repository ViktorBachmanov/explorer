<script setup>
import axios from 'axios'

const props = defineProps({
  itemId: Number,
})

const accessTypes = ['read', 'write', 'grant']

function changeAccess(event) {
  axios.patch(`/api/update-access/folders/${props.itemId}`, {
    userIdAccessFor: 3,
    access: {
      type: event.target.name,
      value: event.target.checked,
    }
  })
}
</script>


<template>
  <td v-for="number in 3"></td>
  <td v-for="accessType in accessTypes" :key="accessType">
    <input type="checkbox" :name="accessType" :checked="false" @click.prevent="changeAccess">
  </td>
</template>


<style scoped>
td {
  text-align: center;
  width: 4.5em;
}
</style>