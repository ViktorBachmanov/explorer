<script setup>
import { ref, provide } from 'vue'
import AppBar from './components/AppBar.vue';
import TreeTable from './components/TreeTable.vue';
import FileEditor from './components/FileEditor.vue';

const fileEditor = ref(null)

provide('fileEditor', fileEditor)
</script>


<template>
  <AppBar />

  <main>
    <Suspense>
      <TreeTable />
    </Suspense>
  </main>

  <FileEditor ref="fileEditor" />
</template>



<style>
table {
  margin: 1em auto;
}

th,
td {
  border: solid 0.5px;
  border-color: black;
  padding: 0.5em;

  .dark & {
    border-color: white;
  }
}

select {
  padding: 0.5em;
  margin: 0.5em;
  border-radius: 0.5em;
  border: 1px solid;
  border-color: blue;

  .dark & {
    border-color: rgb(11, 86, 61);
  }
}
</style>