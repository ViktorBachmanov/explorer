import { defineStore } from 'pinia'
import { ref } from 'vue'
import axios from 'axios'
import { useUsersStore } from '../stores/users.js'


export const useTreeStore = defineStore('tree', () => {
  const rootFolder = ref([])

  const usersStore = useUsersStore()

  async function fetchTree() {
    const { data } = await axios.get(`/api/tree?userIdAccessFor=${usersStore.userAccessFor.id}`)

    rootFolder.value = data
  }

  async function init() {
    await fetchTree()
  }

  const selectedFolderId = ref(null)

  function selectFolder(folderId) {
    selectedFolderId.value = folderId
  }

  return { rootFolder, fetchTree, init, selectFolder, selectedFolderId }  
})