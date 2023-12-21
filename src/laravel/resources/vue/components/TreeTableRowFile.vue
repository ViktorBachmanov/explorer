<script setup>
import { ref, inject, onMounted, onBeforeUnmount } from 'vue'
import TheIndent from './TheIndent.vue';
import TreeTableAccessCells from './TreeTableAccessCells.vue'


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
  console.log('dblclick')
  fileEditor.value.open(props.file.id, props.file.text, props.file.accessSelf.write)
}
</script>


<template>
  <tr>
    <td :style="{ paddingLeft: `${level * 1}em`, }">
      <div class="item-label">
        <TheIndent />
        <span ref="fileLabel" class="p-2 cursor-pointer">
          {{ file.name }}
        </span>
      </div>
    </td>

    <TreeTableAccessCells item-type="files" :item-id="file.id" :accessSelf="file.accessSelf"
      :accessForUser="file.accessForUser" />
  </tr>
</template>