<template>
    <aside
        :class="[
            sidebarOpen ? 'translate-x-0' : '-translate-x-full',
            isCollapsed ? 'w-[120px]' : 'w-[300px]',
        ]"
        class="absolute left-0 top-0 z-9999 flex h-screen flex-col overflow-y-hidden bg-gray-700 duration-300 ease-linear lg:static lg:translate-x-0"
    >
        <!-- Logo 區域 -->
        <div
            class="flex items-center justify-between gap-2 px-4 py-4 lg:py-6.5"
        >
            <div class="flex items-center">
                <img
                    :class="{ 'w-10': isCollapsed, 'w-32': !isCollapsed }"
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
            <div class="px-4 py-4 border-b border-gray-600" v-if="!isCollapsed">
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
                        :class="{ 'text-center': isCollapsed }"
                    >
                        MENU
                    </h3>

                    <ul class="mb-6 flex flex-col gap-1.5">
                        <!-- 儀表板 -->
                        <li>
                            <router-link
                                to="/dashboard"
                                class="group relative flex items-center gap-2.5 rounded-lg py-2 px-4 font-medium text-white duration-300 ease-in-out hover:bg-gray-800"
                                :class="{
                                    'justify-center': isCollapsed,
                                    'bg-gray-800': route().current('dashboard'),
                                }"
                            >
                                <svg
                                    class="h-6 w-6"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                                    />
                                </svg>
                                <span :class="{ hidden: isCollapsed }"
                                    >儀表板</span
                                >
                                <span
                                    v-if="isCollapsed"
                                    class="absolute right-full ml-1 rounded-md bg-gray-800 px-2 py-1 text-xs text-white opacity-0 group-hover:opacity-100"
                                    >儀表板</span
                                >
                            </router-link>
                        </li>

                        <!-- 訂單管理 -->
                        <li>
                            <router-link
                                to="/orders"
                                class="group relative flex items-center gap-2.5 rounded-lg py-2 px-4 font-medium text-white duration-300 ease-in-out hover:bg-gray-800"
                                :class="{
                                    'justify-center': isCollapsed,
                                    'bg-gray-800': route().current('orders.*'),
                                }"
                            >
                                <svg
                                    class="h-6 w-6"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"
                                    />
                                </svg>
                                <span :class="{ hidden: isCollapsed }"
                                    >訂單管理</span
                                >
                                <span
                                    v-if="isCollapsed"
                                    class="absolute right-full ml-1 rounded-md bg-gray-800 px-2 py-1 text-xs text-white opacity-0 group-hover:opacity-100"
                                    >訂單管理</span
                                >
                            </router-link>
                        </li>

                        <!-- 客戶管理 -->
                        <li>
                            <router-link
                                to="/customers"
                                class="group relative flex items-center gap-2.5 rounded-lg py-2 px-4 font-medium text-white duration-300 ease-in-out hover:bg-gray-800"
                                :class="{
                                    'justify-center': isCollapsed,
                                    'bg-gray-800':
                                        route().current('customers.*'),
                                }"
                            >
                                <svg
                                    class="h-6 w-6"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                                    />
                                </svg>
                                <span :class="{ hidden: isCollapsed }"
                                    >客戶管理</span
                                >
                                <span
                                    v-if="isCollapsed"
                                    class="absolute right-full ml-1 rounded-md bg-gray-800 px-2 py-1 text-xs text-white opacity-0 group-hover:opacity-100"
                                    >客戶管理</span
                                >
                            </router-link>
                        </li>

                        <li>
                            <router-link
                                to="/customers"
                                class="group relative flex items-center gap-2.5 rounded-lg py-2 px-4 font-medium text-white duration-300 ease-in-out hover:bg-gray-800"
                                :class="{
                                    'justify-center': isCollapsed,
                                    'bg-gray-800':
                                        route().current('customers.*'),
                                }"
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
                                        d="M9 3.75H6.912a2.25 2.25 0 0 0-2.15 1.588L2.35 13.177a2.25 2.25 0 0 0-.1.661V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 0 0-2.15-1.588H15M2.25 13.5h3.86a2.25 2.25 0 0 1 2.012 1.244l.256.512a2.25 2.25 0 0 0 2.013 1.244h3.218a2.25 2.25 0 0 0 2.013-1.244l.256-.512a2.25 2.25 0 0 1 2.013-1.244h3.859M12 3v8.25m0 0-3-3m3 3 3-3"
                                    />
                                </svg>

                                <span :class="{ hidden: isCollapsed }"
                                    >商品上架</span
                                >
                                <span
                                    v-if="isCollapsed"
                                    class="absolute right-full ml-1 rounded-md bg-gray-800 px-2 py-1 text-xs text-white opacity-0 group-hover:opacity-100"
                                    >商品上架</span
                                >
                            </router-link>
                        </li>

                        <li>
                            <router-link
                                to="/customers"
                                class="group relative flex items-center gap-2.5 rounded-lg py-2 px-4 font-medium text-white duration-300 ease-in-out hover:bg-gray-800"
                                :class="{
                                    'justify-center': isCollapsed,
                                    'bg-gray-800':
                                        route().current('customers.*'),
                                }"
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
                                        d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25Z"
                                    />
                                </svg>

                                <span :class="{ hidden: isCollapsed }"
                                    >報表</span
                                >
                                <span
                                    v-if="isCollapsed"
                                    class="absolute right-full ml-1 rounded-md bg-gray-800 px-2 py-1 text-xs text-white opacity-0 group-hover:opacity-100"
                                    >報表</span
                                >
                            </router-link>
                        </li>

                        <!-- 登出按鈕 -->
                        <li class="mt-auto">
                            <Link
                                :href="route('logout')"
                                method="post"
                                as="button"
                                class="w-full group relative flex items-center gap-2.5 rounded-lg py-2 px-4 font-medium text-white duration-300 ease-in-out hover:bg-gray-800"
                                :class="{ 'justify-center': isCollapsed }"
                            >
                                <svg
                                    class="h-6 w-6"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                                    />
                                </svg>
                                <span :class="{ hidden: isCollapsed }"
                                    >登出</span
                                >
                                <span
                                    v-if="isCollapsed"
                                    class="absolute right-full ml-1 rounded-md bg-gray-800 px-2 py-1 text-xs text-white opacity-0 group-hover:opacity-100"
                                    >登出</span
                                >
                            </Link>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </aside>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { useSidebar } from "../composables/useSidebar";
import { Link, usePage } from "@inertiajs/vue3";

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

const { sidebarOpen, toggleSidebar } = useSidebar();
const isCollapsed = ref(false);
const page = usePage<PageProps>();

const toggleCollapse = () => {
    isCollapsed.value = !isCollapsed.value;
};
</script>
