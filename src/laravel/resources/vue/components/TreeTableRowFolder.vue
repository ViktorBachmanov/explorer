<script setup>
import { ref } from 'vue'
import TreeTableRowFile from './TreeTableRowFile.vue';
import ArrowRight from './ArrowRight.vue'

const props = defineProps({
  folder: Object,
  level: Number,
  initialOpen: {
    type: Boolean,
    default: false,
  },
})

const isOpen = ref(props.initialOpen)
</script>


<template>
  <tr>
    <td :style="{ paddingLeft: `${level * 1}em`, }">
      <ArrowRight v-if="folder.folders.length || folder.files.length" :down="isOpen" @click="isOpen = !isOpen" />
      {{ folder.name }}
    </td>
    <td>

    </td>
  </tr>

  <template v-if="isOpen">
    <TreeTableRowFolder v-for="childFolder in folder.folders" :folder="childFolder" :level="level + 1" />

    <TreeTableRowFile v-for="file in folder.files" :file="file" :level="level + 1" />
  </template>
</template>