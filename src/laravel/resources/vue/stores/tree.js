import { defineStore } from 'pinia'
import { ref } from 'vue'
import axios from 'axios'


export const useTreeStore = defineStore('tree', () => {
  const rootFolder = ref([])

  async function fetchTree(userIdAccessFor = '') {
    const { data } = await axios.get(`/api/tree?userIdAccessFor=${userIdAccessFor}`)

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