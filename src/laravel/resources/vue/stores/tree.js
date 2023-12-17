import { defineStore } from 'pinia'
import { ref } from 'vue'
import axios from 'axios'


export const useTreeStore = defineStore('tree', () => {
  const rootFolder = ref([])

  async function fetchTree(userIdAccessFor = '') {
    const { data } = await axios.get(`/api/tree?userIdAccessFor=${userIdAccessFor}`)

    rootFolder.value = data
  }

  return { rootFolder, fetchTree }  
})