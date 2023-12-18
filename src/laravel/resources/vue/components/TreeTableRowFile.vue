<script setup>
import { inject } from 'vue'
import TheIndent from './TheIndent.vue';
import TreeTableAccessCells from './TreeTableAccessCells.vue'


defineProps({
  file: Object,
  level: Number,
})

const fileEditor = inject('fileEditor')
</script>


<template>
  <tr>
    <td :style="{ paddingLeft: `${level * 1}em`, }">
      <div class="item-label">
        <TheIndent />
        <span class="p-2 cursor-pointer" @click="fileEditor.open(file.id)">{{ file.name }}</span>
      </div>
    </td>

    <TreeTableAccessCells item-type="files" :item-id="file.id" :accessSelf="file.accessSelf"
      :accessForUser="file.accessForUser" />
  </tr>
</template>