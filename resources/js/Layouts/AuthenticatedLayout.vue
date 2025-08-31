<script setup>
import Sidebar from '@/Components/Sidebar.vue'
import Header from '@/Components/Header.vue'
import { ref } from 'vue'

const props = defineProps({
  showHeader: { type: Boolean, default: true },
  showBreadcrumb: { type: Boolean, default: true },
})

const sidebarOpen = ref(false)
const sidebarCollapsed = ref(false)
</script>

<template>
  <div class="flex h-screen bg-gray-100">
    <Sidebar
      :open="sidebarOpen"
      :collapsed="sidebarCollapsed"
      @close="sidebarOpen = false"
      @toggleCollapse="sidebarCollapsed = !sidebarCollapsed"
    />

    <div class="flex flex-1 flex-col ml-0 transition-all duration-300">
      <Header @toggleSidebar="sidebarOpen = !sidebarOpen" />

      <header v-if="showHeader && ($slots.header || $slots.breadcrumb)" class="bg-gray-100">
        <div v-if="showBreadcrumb && $slots.breadcrumb" class="mx-auto max-w-7xl px-4 py-3">
          <slot name="breadcrumb" />
        </div>

        <div v-if="$slots.header" class="mx-auto max-w-7xl px-4 py-4">
          <slot name="header" />
        </div>
      </header>

        <div class="flex flex-1 flex-col ml-0 transition-all duration-300 overflow-y-auto">
            <main class="max-w-7xl py-3 px-4">
                <slot />
            </main>
        </div>
    </div>
  </div>
</template>
