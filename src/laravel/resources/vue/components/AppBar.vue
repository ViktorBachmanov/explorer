<script setup>
import UsersSelect from './UsersSelect.vue';
import ThemeButton from './ThemeButton.vue';
</script>


<template>
  <div class="app-bar">
    <Suspense>
      <UsersSelect />
    </Suspense>

    <a href="https://github.com/ViktorBachmanov/explorer"
      class="p-2 rounded bg-slate-300 dark:bg-slate-800 dark:text-gray-100 shadow-md">
      Source code
    </a>

    <ThemeButton />
  </div>
</template>


<style scoped>
.app-bar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0.5em;
}
</style>