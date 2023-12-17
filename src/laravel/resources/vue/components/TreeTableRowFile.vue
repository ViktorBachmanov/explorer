<script setup>
import TheIndent from './TheIndent.vue';
import TreeTableAccessCells from './TreeTableAccessCells.vue'


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

    <TreeTableAccessCells item-type="files" :item-id="file.id" :accessForUser="file.accessForUser" />
  </tr>
</template>