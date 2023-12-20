<script setup>
import { ref, computed } from 'vue'
import { storeToRefs } from 'pinia'
import TreeTableRowFile from './TreeTableRowFile.vue';
import ArrowRight from './ArrowRight.vue'
import TheIndent from './TheIndent.vue';
import TreeTableAccessCells from './TreeTableAccessCells.vue'
import { useTreeStore } from '../stores/tree.js'


const props = defineProps({
  folder: Object,
  level: Number,
  initialOpen: {
    type: Boolean,
    default: false,
  },
})

const isOpen = ref(props.initialOpen)

const treeStore = useTreeStore()
const { selectedFolderId } = storeToRefs(treeStore)

function selectFolder() {
  treeStore.selectFolder(props.folder.id)
}

const isSelected = computed(() => selectedFolderId.value === props.folder.id)
</script>


<template>
  <tr>
    <td :style="{ paddingLeft: `${level * 1}em`, }">
      <div class="item-label">
        <TheIndent>
          <ArrowRight v-if="folder.folders?.length || folder.files?.length" :down="isOpen" @click="isOpen = !isOpen" />
        </TheIndent>
        <span class="folder-label bg-amber-200 dark:bg-amber-800" :class="{ selected: isSelected }" @click="selectFolder">
          {{ folder.name }}
        </span>
      </div>
    </td>

    <TreeTableAccessCells item-type="folders" :item-id="folder.id" :accessSelf="folder.accessSelf"
      :accessForUser="folder.accessForUser" />
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
  cursor: pointer;

  &.selected {
    box-shadow: 0 0 3px 3px magenta;
  }

  .dark & {
    border-color: silver;
  }
}
</style>