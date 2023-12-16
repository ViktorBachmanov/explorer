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



<style>
th,
td {
  border: solid 0.5px;
  border-color: black;
  padding: 0.5em;

  .dark & {
    border-color: white;
  }
}
</style>