import { defineStore } from 'pinia'
import { ref, computed, watch } from 'vue'
import axios from 'axios'
import { useTreeStore } from './tree.js'


export const useUsersStore = defineStore('users', () => {
  const users = ref([])

  const guestUser = {
    id: -1,
    name: 'guest',
    email: 'guest@guest.ru'
  }

  const treeStore = useTreeStore()

  const currentUser = ref(guestUser)

  watch(currentUser, async (user) => {
    if (user.id === userAccessFor.value.id) {
      userAccessFor.value = emptyUser
    }    await login(user)

    await treeStore.fetchTree(userAccessFor.value.id)
  })

  const allUsers = computed(() => {
    return [
      guestUser,
      ...users.value
    ]
  })


  const emptyUser = {
    id: -1,
    name: 'Select user',
    email: 'empty@empty.ru'
  }
  const userAccessFor = ref(emptyUser)

  const usersAccessForSelect = computed(() => {
    return [
      emptyUser,
      ...users.value.filter(user => !user.is_admin && user.id !== currentUser.value.id)
    ]
  })


  async function init() {
    const { data } = await axios.get('/api/users')
    users.value = data.users
    currentUser.value = data.currentUser || guestUser
  }

  async function login(user) {
    await logout()

    if(user.email == guestUser.email) {      
      return
    }

    await axios.post('/api/login', { email: user.email, password: '123' })
  }

  async function logout() {
    await axios.post('/api/logout')
    await axios.get('/sanctum/csrf-cookie')
  }

  

  return { init, login, logout, allUsers, currentUser, usersAccessForSelect, userAccessFor }
})