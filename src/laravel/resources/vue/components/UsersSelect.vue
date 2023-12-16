<script setup>
import { storeToRefs } from 'pinia'
import { useUsersStore } from '../stores/users.js'


const usersStore = useUsersStore()
await usersStore.init()
const { allUsers, currentUserComputed } = storeToRefs(usersStore)
</script>


<template>
  <select class="dark:bg-slate-900 dark:text-violet-200" v-model="currentUserComputed">
    <option v-for="user in allUsers" :key="user.id" :value="user">{{ user.name }}</option>
  </select>
</template>


<!-- <style scoped>
</style> -->