<script setup>
import { ref } from 'vue'
import TreeTableRowFile from './TreeTableRowFile.vue';
import ArrowRight from './ArrowRight.vue'
import TheIndent from './TheIndent.vue';
import TreeTableAccessCells from './TreeTableAccessCells.vue'

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
      <div class="item-label">
        <TheIndent>
          <ArrowRight v-if="folder.folders.length || folder.files.length" :down="isOpen" @click="isOpen = !isOpen" />
        </TheIndent>
        <span class="folder-label bg-amber-200 dark:bg-amber-800">{{ folder.name }}</span>
      </div>
    </td>

    <TreeTableAccessCells item-type="folders" :item-id="folder.id" :accessForUser="folder.accessForUser" />
  </tr>

  <template v-if="isOpen">
    <TreeTableRowFolder v-for="childFolder in folder.folders" :folder="childFolder" :level="level + 1" />

    <TreeTableRowFile v-for="file in folder.files" :file="file" :level="level + 1" />
  </template>
</template>


<style scoped>
.folder-label {
  padding: 0.25em;
  border: 1px solid;
  border-color: black;
  border-radius: 0.25em;

  .dark & {
    border-color: silver;
  }
}
</style>