<script setup>
import { storeToRefs } from 'pinia'
import TreeTableRowFolder from './TreeTableRowFolder.vue';
import { useUsersStore } from '../stores/users.js'
import { useTreeStore } from '../stores/tree.js'


const usersStore = useUsersStore()
const { usersAccessForSelect, userAccessFor } = storeToRefs(usersStore)

const treeStore = useTreeStore()
await treeStore.fetchTree()
const { rootFolder } = storeToRefs(treeStore)

</script>


<template>
  <table class="dark:text-white">
    <thead>
      <tr>
        <th rowspan="2"></th>
        <th colspan="3">Access for current user</th>
        <th colspan="3">
          Access for
          <select class="dark:bg-stone-800 dark:text-violet-200" v-model="userAccessFor">
            <option v-for="user in usersAccessForSelect" :key="user.id" :value="user" :disabled="user.id == -1">{{
              user.name }}
            </option>
          </select>
        </th>
      </tr>

      <tr>
        <th>Read</th>
        <th>Write</th>
        <th>Grant</th>

        <th>Read</th>
        <th>Write</th>
        <th>Grant</th>
      </tr>
    </thead>

    <tbody>
      <TreeTableRowFolder :folder="rootFolder" :level="1" :initial-open="true" />
    </tbody>
  </table>
</template>


<style>
.item-label {
  display: flex;
  align-items: center;
}
</style>