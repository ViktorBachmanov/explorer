import { defineStore } from 'pinia'
import { ref, computed, watch } from 'vue'
import axios from 'axios'


export const useUsersStore = defineStore('users', () => {
  const users = ref([])

  const guestUser = {
    id: -1,
    name: 'guest',
    email: 'guest@guest.ru'
  }

  const currentUser = ref(guestUser)

  watch(currentUser, (user) => {
    console.log('currentUser changed: ', user.name)
    login(user)
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

  watch(userAccessFor, (user) => {
    console.log('userAccessFor changed: ', user.name)
  })

  const notAdminUsers = computed(() => {
    return [
      emptyUser,
      ...users.value.filter(user => !user.is_admin)
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

  

  return { init, login, logout, allUsers, currentUser, notAdminUsers, userAccessFor }
})