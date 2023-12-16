<script setup>
defineProps({
  item: Object,
})
</script>


<template>
  <tr>
    <td>
      {{ item.name }}
    </td>
    <td>

    </td>
  </tr>

  <!-- <template v-if="item.type == 'folders'"> -->
  <TreeTableRow v-for="folder in item.folders" :item="folder" />

  <TreeTableRow v-for="file in item.files" :item="file" />
  <!-- </template> -->
</template>