import { computed } from 'vue'
import { storeToRefs } from 'pinia'
import { useTreeStore } from '../stores/tree.js'


export function useSelectItem(type, id) {
  const treeStore = useTreeStore()
  const { selectedItem } = storeToRefs(treeStore)

  function selectItem(item) {
    treeStore.selectItem(type, item.id, item.name)
  }

  const isSelected = computed(() => selectedItem.value.type === type && selectedItem.value.id === id)


  return { isSelected, selectItem }
}