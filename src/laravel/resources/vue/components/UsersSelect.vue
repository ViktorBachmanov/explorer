<script setup>
import axios from 'axios'
import { storeToRefs } from 'pinia'
import { useUsersStore } from '../stores/users.js'

const { data: dbUsers } = await axios.get('/api/users')

const usersStore = useUsersStore()
usersStore.setUsers(dbUsers)
const { allUsers } = storeToRefs(usersStore)
</script>


<template>
  <select class="dark:bg-slate-900 dark:text-violet-200">
    <option disabled selected>Select user</option>
    <option v-for="user in allUsers" :key="user.id">{{ user.name }}</option>
  </select>
</template>


<!-- <style scoped>
</style> -->