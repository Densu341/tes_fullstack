<script setup>
import { ref } from "vue";
import { ChevronDown } from "lucide-vue-next";
import { Link } from "@inertiajs/vue3";
import { defineEmits } from "vue";
import { onClickOutside } from "@vueuse/core";

const emit = defineEmits(["toggleSidebar"]);
const dropdownOpen = ref(false);
const dropdownRef = ref(null);

const toggleDropdown = () => {
    dropdownOpen.value = !dropdownOpen.value;
};

// Menutup dropdown saat klik di luar area
onClickOutside(dropdownRef, () => {
    dropdownOpen.value = false;
});
</script>

<template>
    <header class="flex items-center justify-between h-16 bg-white shadow px-4">
        <div class="flex items-center space-x-4">
            <button class="lg:hidden" @click="emit('toggleSidebar')">☰</button>
        </div>

        <div class="flex items-center space-x-4">
            <div class="hidden md:flex items-center space-x-2">
                <div class="flex items-center space-x-1">
                    <img src="/img/mirroring.svg" />
                    <span>10</span>
                </div>
                <img src="/img/book.svg" />
                <img src="/img/bell.svg" />
                <img src="/img/chat.svg" />
            </div>

            <div class="relative" ref="dropdownRef">
                <div
                    class="flex items-center space-x-2 cursor-pointer bg-gray-100 rounded-md p-1"
                    @click="toggleDropdown"
                >
                    <img
                        class="w-8 h-8 rounded-md bg-blue-200"
                        :src="$page.props.auth.user.avatar ?? '/img/avatar.png'"
                        alt="User Avatar"
                    />
                    <span class="text-gray-700 bg-white rounded-md p-0.5">
                        {{ $page.props.auth.user.name }}
                    </span>
                    <ChevronDown
                        class="w-4 h-4 text-gray-500 transform transition-transform"
                        :class="{ 'rotate-180': dropdownOpen }"
                    />
                </div>

                <transition
                    enter-active-class="transition ease-out duration-100"
                    enter-from-class="opacity-0 scale-95"
                    enter-to-class="opacity-100 scale-100"
                    leave-active-class="transition ease-in duration-75"
                    leave-from-class="opacity-100 scale-100"
                    leave-to-class="opacity-0 scale-95"
                >
                    <div
                        v-if="dropdownOpen"
                        class="absolute right-0 mt-2 w-48 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
                        role="menu"
                        aria-orientation="vertical"
                        aria-labelledby="user-menu-button"
                        tabindex="-1"
                    >
                        <div class="py-1">
                            <Link
                                :href="route('profile.edit')"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                            >
                                Profile
                            </Link>
                            <Link
                                :href="route('logout')"
                                method="post"
                                as="button"
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                            >
                                Log Out
                            </Link>
                        </div>
                    </div>
                </transition>
            </div>
        </div>
    </header>
</template>
