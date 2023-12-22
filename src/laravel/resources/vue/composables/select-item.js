import { computed } from 'vue'
import { storeToRefs } from 'pinia'
import { useTreeStore } from '../stores/tree.js'


export function useSelectItem(type, id, name) {
  const treeStore = useTreeStore()
  const { selectedItem } = storeToRefs(treeStore)

  function selectItem() {
    treeStore.selectItem(type, id, name)
  }

  const isSelected = computed(() => selectedItem.value.type === type && selectedItem.value.id === id)


  return { isSelected, selectItem }
}