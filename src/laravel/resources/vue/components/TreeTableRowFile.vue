<script setup>
import { ref, computed, inject, onMounted, onBeforeUnmount } from 'vue'
import TheIndent from './TheIndent.vue';
import TreeTableAccessCells from './TreeTableAccessCells.vue'
import { useSelectItem } from '../composables/select-item.js'
import FileAccessButton from './FileAccessButton.vue';


const props = defineProps({
  file: Object,
  level: Number,
})

const fileEditor = inject('fileEditor')

const fileLabel = ref(null)

onMounted(() => {
  fileLabel.value.addEventListener('dblclick', openFileEditor)
})

onBeforeUnmount(() => {
  fileLabel.value.removeEventListener('dblclick', openFileEditor)
})

function openFileEditor() {
  fileEditor.value.open(props.file.id, props.file.text, props.file.accessSelf.write)
}

const { isSelected, selectItem } = useSelectItem('file', props.file.id)

const fileAccessIcon = computed(() => {
  if (props.file.accessSelf.write) {
    return 'bi-pencil-square'
  } else if (props.file.accessSelf.read) {
    return 'bi-eye'
  }
  return 'bi-eye-slash'
})
</script>


<template>
  <tr>
    <td :style="{ paddingLeft: `${level * 1}em`, }">
      <div class="item-label">
        <TheIndent>
          <FileAccessButton class="bi" :class="fileAccessIcon" :disabled="!file.accessSelf.read && !file.accessSelf.write"
            @click="openFileEditor" />
        </TheIndent>
        <span ref="fileLabel" class="p-2 cursor-pointer" :class="{ selected: isSelected }" @click="selectItem(file)">
          {{ file.name }}
        </span>
      </div>
    </td>

    <TreeTableAccessCells item-type="files" :item-id="file.id" :accessSelf="file.accessSelf"
      :accessForUser="file.accessForUser" />
  </tr>
</template>



<style scoped>
.selected {
  box-shadow: 0 0 3px 3px magenta;
}
</style>