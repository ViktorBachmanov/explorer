<script setup>
import axios from 'axios'
import TreeTableRowFolder from './TreeTableRowFolder.vue';

const { data: rootFolder } = await axios.get('/api/tree')
</script>


<template>
  <table class="dark:text-white">
    <thead>
      <tr>
        <th></th>
        <th></th>
      </tr>
    </thead>

    <tbody>
      <TreeTableRowFolder :folder="rootFolder" :level="1" :initial-open="true" />
    </tbody>
  </table>
</template>


<style>
.item-label {
  display: flex;
  align-items: center;
}
</style>