<template>
    <aside
        :class="[
            sidebarOpen ? 'translate-x-0' : '-translate-x-full',
            _isCollapsed ? 'w-[100px]' : 'w-[260px]',
        ]"
        class="absolute left-0 top-0 z-9999 flex h-screen flex-col overflow-y-hidden bg-gray-700 duration-300 ease-linear lg:static lg:translate-x-0"
    >
        <!-- Logo 區域 -->
        <div
            class="flex items-center justify-between gap-2 px-4 py-4 lg:py-6.5"
        >
            <div class="flex items-center">
                <img
                    :class="{ 'w-10': _isCollapsed, 'w-32': !_isCollapsed }"
                    src="/logo.svg"
                    alt="Logo"
                />
            </div>

            <button
                class="text-white hover:text-gray-300 rounded-full p-1 hover:bg-gray-600"
                @click="toggleCollapse"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="size-6"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"
                    />
                </svg>
            </button>
        </div>

        <div class="flex flex-col overflow-y-auto duration-300 ease-linear">
            <!-- 用戶資訊 -->
            <div
                class="px-6 py-4 border-b border-gray-600"
                v-if="!_isCollapsed"
            >
                <div class="text-white">
                    <div class="font-medium">
                        {{ page.props.auth.user.name }}
                    </div>
                    <div class="text-sm text-gray-400">
                        {{ page.props.auth.user.email }}
                    </div>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-5 py-4 px-4 lg:mt-1 lg:px-6">
                <div>
                    <h3
                        class="mb-4 text-sm font-medium text-gray-400"
                        :class="{ 'text-center': _isCollapsed }"
                    >
                        {{ menuTitle }}
                    </h3>
                    <ul class="mb-6 flex flex-col gap-3">
                        <!-- 儀表板 -->
                        <li v-for="(item, index) in sidebarItems" :key="index" class="cursor-pointer hover:douration-100">
                            <router-link
                                :to="item.route"
                                class="group relative flex items-center gap-2.5 rounded-lg py-3 px-4 font-medium text-white duration-300 ease-in-out hover:bg-gray-800"
                                :class="{
                                    'justify-center': _isCollapsed,
                                    'bg-gray-800':
                                        route().current('customers.*'),
                                }"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 30 30"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    class="size-6"
                                    v-html="item.icon"
                                >
                                </svg>

                                <span :class="{ hidden: _isCollapsed }"
                                    >{{ item.title }}</span
                                >
                                <span
                                    v-if="_isCollapsed"
                                    class="absolute right-full ml-1 rounded-md bg-gray-800 px-2 py-1 text-xs text-white opacity-0 group-hover:opacity-100"
                                    >{{  item.title }}</span
                                >
                            </router-link>
                        </li>                        
                    </ul>
                </div>
            </nav>
        </div>
    </aside>
</template>

<script setup lang="ts">
import { ref, watch } from "vue";
import { useSidebar } from "../composables/useSidebar";
import { Link, usePage } from "@inertiajs/vue3";
import { sidebarItems  } from "../composables/sidebarItem";

interface User {
    name: string;
    email: string;
}

interface PageProps {
    [key: string]: any;
    auth: {
        user: User;
    };
}

// 定義接收的屬性
const props = defineProps({
    isCollapsed: {
        type: Boolean,
        default: false,
    },
});

// 定義事件
const emit = defineEmits(["toggle-collapse"]);
const menuTitle = ref('MENU');

const { sidebarOpen, toggleSidebar } = useSidebar();
// 使用內部的 _isCollapsed 來追蹤狀態
const _isCollapsed = ref(props.isCollapsed);
const page = usePage<PageProps>();

// 監聽外部傳入的 isCollapsed 變更
watch(
    () => props.isCollapsed,
    (newValue) => {
        _isCollapsed.value = newValue;
    }
);

const toggleCollapse = () => {
    _isCollapsed.value = !_isCollapsed.value;
    // 向父元件發送狀態變更事件
    emit("toggle-collapse");
};
</script>
