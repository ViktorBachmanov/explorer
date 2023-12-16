<script setup>
defineProps({
  item: Object,
  level: Number,
})
</script>


<template>
  <tr>
    <td :style="{ paddingLeft: `${level * 1}em`, }">
      {{ item.name }}
    </td>
    <td>

    </td>
  </tr>

  <TreeTableRow v-for="folder in item.folders" :item="folder" :level="level + 1" />

  <TreeTableRow v-for="file in item.files" :item="file" :level="level + 1" />
</template>