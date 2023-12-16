<script setup>
defineProps({
  file: Object,
  level: Number,
})
</script>


<template>
  <tr>
    <td :style="{ paddingLeft: `${level * 1}em`, }">
      {{ file.name }}
    </td>
    <td>

    </td>
  </tr>
</template>