import { ref } from 'vue'

const sidebarOpen = ref(true)

export function useSidebar() {
  const toggleSidebar = () => {
    sidebarOpen.value = !sidebarOpen.value
  }

  const closeSidebar = () => {
    sidebarOpen.value = false
  }

  return {
    sidebarOpen,
    toggleSidebar,
    closeSidebar
  }
}