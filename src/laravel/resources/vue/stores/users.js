import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import axios from 'axios'


export const useUsersStore = defineStore('users', () => {
  const users = ref([])

  const guestEmail = 'guest@guest.ru'
  const guestUser = {
    id: -1,
    name: 'guest',
    email: guestEmail
  }

  const currentUser = ref(guestUser)

  const currentUserComputed = computed({
    get() {
      return currentUser.value
    },
    set(email) {
      login(email)
    }
  })

  async function init() {
    const { data } = await axios.get('/api/users')
    users.value = data.users
    currentUser.value = data.currentUser || guestUser
  }

  async function login(user) {
    await logout()

    if(user.email == guestEmail) {      
      return
    }

    const { data: loggedInUser } = await axios.post('/api/login', { email: user.email, password: '123' })

    currentUser.value = loggedInUser
  }

  async function logout() {
    await axios.post('/api/logout')
    await axios.get('/sanctum/csrf-cookie')
  }

  const allUsers = computed(() => {
    return [
      guestUser,
      ...users.value
    ]
  })

  return { init, login, logout, allUsers, currentUserComputed }
})