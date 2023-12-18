<script setup>
import { storeToRefs } from 'pinia'
import { useUsersStore } from '../stores/users.js'


const usersStore = useUsersStore()
await usersStore.init()
const { allUsers, currentUser } = storeToRefs(usersStore)
</script>


<template>
  <div>
    <span class="mx-2 font-medium">Current user:</span>
    <select class="dark:bg-stone-800 dark:text-violet-200" v-model="currentUser">
      <option v-for="user in allUsers" :key="user.id" :value="user">{{ user.name }}</option>
    </select>
  </div>
</template>

