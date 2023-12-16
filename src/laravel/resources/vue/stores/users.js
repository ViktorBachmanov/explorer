import { defineStore } from 'pinia'
import { ref, computed } from 'vue'


export const useUsersStore = defineStore('users', () => {
  const users = ref([])

  function setUsers(dbUsers) {
    users.value = dbUsers
  }

  const allUsers = computed(() => {
    return [
      {
        id: -1,
        name: 'guest'
      },
      ...users.value
    ]
  })

  return { setUsers, allUsers }
})