<script setup>
import UsersSelect from './UsersSelect.vue';
import ThemeButton from './ThemeButton.vue';
</script>


<template>
  <div class="app-bar">
    <Suspense>
      <UsersSelect />
    </Suspense>

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