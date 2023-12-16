<script setup>
import TheIndent from './TheIndent.vue';

defineProps({
  file: Object,
  level: Number,
})
</script>


<template>
  <tr>
    <td :style="{ paddingLeft: `${level * 1}em`, }">
      <div class="item-label">
        <TheIndent />
        {{ file.name }}
      </div>
    </td>

    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
</template>