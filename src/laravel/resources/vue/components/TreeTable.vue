<script setup>
import { ref } from 'vue'
import { storeToRefs } from 'pinia'
import TreeTableRowFolder from './TreeTableRowFolder.vue';
import { useUsersStore } from '../stores/users.js'
import { useTreeStore } from '../stores/tree.js'
import ItemButton from './ItemButton.vue';
import ItemCreatingDialog from './ItemCreatingDialog.vue';


const usersStore = useUsersStore()
const { usersAccessForSelect, userAccessFor } = storeToRefs(usersStore)

const treeStore = useTreeStore()
await treeStore.init()
const { rootFolder } = storeToRefs(treeStore)

const accesses = Object.keys(rootFolder.value.accessSelf)
const capitalizedAccesses = accesses.map(access => {
  return access.charAt(0).toUpperCase() + access.slice(1)
})

const itemCreatingDialog = ref(null)

</script>


<template>
  <table class="dark:text-white">
    <thead>
      <tr>
        <th rowspan="2">
          <ItemButton class="bi bi-folder-plus" @click="itemCreatingDialog.open('folder')" />
          <ItemButton class="bi bi-filetype-txt" @click="itemCreatingDialog.open('file')" />
        </th>
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
        <th v-for="access in capitalizedAccesses">{{ access }}</th>
        <th v-for="access in capitalizedAccesses">{{ access }}</th>
      </tr>
    </thead>

    <tbody>
      <TreeTableRowFolder :folder="rootFolder" :level="1" :initial-open="true" />
    </tbody>
  </table>

  <ItemCreatingDialog ref="itemCreatingDialog" />
</template>


<style>
.item-label {
  display: flex;
  align-items: center;
}
</style>