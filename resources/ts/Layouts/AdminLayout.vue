<template>
  <div class="dark:bg-boxdark-2 dark:text-bodydark">
    <div class="flex h-screen overflow-hidden">
      <!-- Sidebar -->
      <Sidebar />

      <!-- Content Area -->
      <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">
        <!-- Header -->
        <header class="sticky top-0 z-999 flex w-full bg-white drop-shadow-1">
          <div class="flex flex-grow items-center justify-between py-4 px-4 shadow-2 md:px-6 2xl:px-11">
            <div class="flex items-center gap-2 sm:gap-4 lg:hidden">
              <!-- Mobile Menu Toggle -->
              <button
                class="block rounded-sm border border-gray-300 bg-white p-1.5 shadow-sm lg:hidden"
                @click="toggleSidebar"
              >
                <svg
                  class="h-5 w-5"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16"
                  />
                </svg>
              </button>
            </div>

            <!-- Header Right -->
            <div class="flex items-center gap-3 2xsm:gap-7">
              <!-- User Area -->
              <div class="relative">
                <a-dropdown>
                  <a class="flex items-center gap-4" @click.prevent>
                    <span class="hidden text-right lg:block">
                      <span class="block text-sm font-medium text-black">
                        使用者名稱
                      </span>
                      <span class="block text-xs font-medium">管理員</span>
                    </span>

                    <span class="h-12 w-12 rounded-full">
                      <img src="/img/user.png" alt="User" />
                    </span>
                  </a>

                  <template #overlay>
                    <a-menu>
                      <a-menu-item key="0">
                        <router-link to="/profile" class="flex items-center gap-3.5 text-sm font-medium duration-300 ease-in-out hover:text-primary lg:text-base">
                          <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                          </svg>
                          個人資料
                        </router-link>
                      </a-menu-item>
                      <a-menu-item key="1">
                        <a href="#" class="flex items-center gap-3.5 text-sm font-medium duration-300 ease-in-out hover:text-primary lg:text-base">
                          <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                          </svg>
                          登出
                        </a>
                      </a-menu-item>
                    </a-menu>
                  </template>
                </a-dropdown>
              </div>
            </div>
          </div>
        </header>

        <!-- Main Content -->
        <main>
          <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
            <slot />
          </div>
        </main>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import Sidebar from '@/Components/Sidebar.vue'
import { useSidebar } from '@/composables/useSidebar'

const { sidebarOpen, toggleSidebar } = useSidebar()
</script>