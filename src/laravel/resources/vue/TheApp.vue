<script setup>
import AppBar from './components/AppBar.vue';
import TreeTable from './components/TreeTable.vue';
</script>


<template>
  <AppBar />

  <Suspense>
    <TreeTable />
  </Suspense>
</template>