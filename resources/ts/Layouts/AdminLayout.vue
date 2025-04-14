<template>
  <div class="dark:bg-boxdark-2 dark:text-bodydark">
    <!-- ===== Page Wrapper Start ===== -->
    <div class="flex h-screen overflow-hidden">
      <!-- ===== Sidebar Start ===== -->
      <Sidebar />
      <!-- ===== Sidebar End ===== -->

      <!-- ===== Content Area Start ===== -->
      <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">
        <!-- ===== Header Start ===== -->
        <header class="sticky top-0 z-999 flex w-full bg-white drop-shadow-1 dark:bg-boxdark dark:drop-shadow-none">
          <div class="flex flex-grow items-center justify-between py-4 px-4 shadow-2 md:px-6 2xl:px-11">
            <div class="flex items-center gap-2 sm:gap-4 lg:hidden">
              <!-- Menu Toggle Button -->
              <button
                class="z-99999 block rounded-sm border border-stroke bg-white p-1.5 shadow-sm dark:border-strokedark dark:bg-boxdark lg:hidden"
                @click="toggleSidebar"
              >
                <span class="relative block h-5.5 w-5.5 cursor-pointer">
                  <span class="du-block absolute right-0 h-full w-full">
                    <span
                      class="relative left-0 top-0 my-1 block h-0.5 w-0 rounded-sm bg-black delay-[0] duration-200 ease-in-out dark:bg-white"
                      :class="{ '!w-full delay-300': !sidebarOpen }"
                    ></span>
                    <span
                      class="relative left-0 top-0 my-1 block h-0.5 w-0 rounded-sm bg-black delay-150 duration-200 ease-in-out dark:bg-white"
                      :class="{ '!w-full delay-400': !sidebarOpen }"
                    ></span>
                    <span
                      class="relative left-0 top-0 my-1 block h-0.5 w-0 rounded-sm bg-black delay-200 duration-200 ease-in-out dark:bg-white"
                      :class="{ '!w-full delay-500': !sidebarOpen }"
                    ></span>
                  </span>
                  <span class="absolute right-0 h-full w-full rotate-45">
                    <span
                      class="absolute left-2.5 top-0 block h-full w-0.5 rounded-sm bg-black delay-300 duration-200 ease-in-out dark:bg-white"
                      :class="{ '!h-0 delay-[0]': !sidebarOpen }"
                    ></span>
                    <span
                      class="delay-400 absolute left-0 top-2.5 block h-0.5 w-full rounded-sm bg-black duration-200 ease-in-out dark:bg-white"
                      :class="{ '!h-0 delay-200': !sidebarOpen }"
                    ></span>
                  </span>
                </span>
              </button>
              <!-- Logo -->
              <a class="block flex-shrink-0 lg:hidden" href="/">
                <img src="/img/logo.svg" alt="Logo" />
              </a>
            </div>
            <div class="hidden sm:block">
              <slot name="header" />
            </div>
          </div>
        </header>
        <!-- ===== Header End ===== -->

        <!-- ===== Main Content Start ===== -->
        <main>
          <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
            <slot />
          </div>
        </main>
        <!-- ===== Main Content End ===== -->
      </div>
      <!-- ===== Content Area End ===== -->
    </div>
    <!-- ===== Page Wrapper End ===== -->
  </div>
</template>

<script setup lang="ts">
import Sidebar from '@/components/Sidebar.vue'
import { useSidebar } from '@/composables/useSidebar'

const { sidebarOpen, toggleSidebar } = useSidebar()
</script>