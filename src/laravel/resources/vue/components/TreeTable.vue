<script setup>
import axios from 'axios'
import TreeTableRow from './TreeTableRow.vue';

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
      <TreeTableRow :item="rootFolder" />
    </tbody>
  </table>
</template>


<style scoped></style>