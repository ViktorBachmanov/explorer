<script setup>
import { useLocalStorage } from '@vueuse/core'

const theme = useLocalStorage(window.localStorageThemeKey, window.defaultTheme)

function toggleTheme() {
  switch (theme.value) {
    default:
    case 'dark':
      theme.value = 'light'
      document.documentElement.classList.remove('dark')
      break;
    case 'light':
      theme.value = 'dark'
      document.documentElement.classList.add('dark')
      break;
  }
}
</script>

<template>
  <button class="p-2 m-2 border rounded border-black dark:border-slate-300" @click="toggleTheme">
    <svg xmlns="http://www.w3.org/2000/svg" :fill="theme === 'dark' ? 'silver' : 'black'" viewBox="0 0 24 24" width="24"
      height="24">
      <title>brightness-4</title>
      <path
        d="M12,18C11.11,18 10.26,17.8 9.5,17.45C11.56,16.5 13,14.42 13,12C13,9.58 11.56,7.5 9.5,6.55C10.26,6.2 11.11,6 12,6A6,6 0 0,1 18,12A6,6 0 0,1 12,18M20,8.69V4H15.31L12,0.69L8.69,4H4V8.69L0.69,12L4,15.31V20H8.69L12,23.31L15.31,20H20V15.31L23.31,12L20,8.69Z" />
    </svg>
  </button>
</template>