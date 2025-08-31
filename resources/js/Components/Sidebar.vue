<script setup>
import { defineProps, defineEmits } from "vue";
import { Link } from "@inertiajs/vue3";
import { Home, Package, Tags, CircleChevronLeft } from "lucide-vue-next"; // contoh icon

const props = defineProps({
    open: { type: Boolean, default: false },
    collapsed: { type: Boolean, default: false },
});

const emit = defineEmits(["close", "toggleCollapse"]);
</script>

<template>
    <div
        v-if="open"
        class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden"
        @click="emit('close')"
    ></div>

    <aside
        :class="[
            'fixed lg:static z-50 inset-y-0 left-0 bg-white shadow flex flex-col justify-between transition-all duration-300 ease-in-out',
            open ? 'translate-x-0' : '-translate-x-full lg:translate-x-0',
            collapsed ? 'w-20' : 'w-64',
        ]"
    >
        <div
            class="relative flex h-14 items-center justify-between border-b px-4"
        >
            <img
                v-if="!collapsed"
                src="/img/logo.png"
                alt="Logo"
                class="h-32"
            />

            <button
                class="absolute right-0 top-1/2 hidden -translate-y-1/2 translate-x-1/2 rounded-full border-r bg-white p-2 after:absolute after:right-0 after:top-0 after:h-full after:w-1/2 after:rounded-r-full after:shadow-[4px_0_8px_-2px_rgba(0,0,0,0.1)] lg:flex lg:items-center lg:justify-center"
                @click="emit('toggleCollapse')"
            >
                <CircleChevronLeft
                    :class="[
                        'h-8 w-8 transform transition-transform',
                        collapsed ? 'rotate-180' : '',
                    ]"
                />
            </button>

            <button class="lg:hidden" @click="emit('close')">✕</button>
        </div>

        <nav class="flex-1 space-y-2 p-2">
            <Link
                href="/dashboard"
                :class="[
                    'flex items-center space-x-3 rounded px-3 py-2 hover:bg-gray-100',
                    $page.url.startsWith('/dashboard')
                        ? 'bg-blue-600 text-white hover:bg-blue-700'
                        : 'text-gray-700',
                ]"
            >
                <Home
                    class="h-5 w-5"
                    :class="{
                        'text-white': $page.url.startsWith('/dashboard'),
                    }"
                />
                <span v-if="!collapsed">Dashboard</span>
            </Link>
            <Link
                href="/products"
                :class="[
                    'flex items-center space-x-3 rounded px-3 py-2 hover:bg-gray-100',
                    $page.url.startsWith('/products')
                        ? 'bg-blue-600 text-white hover:bg-blue-700'
                        : 'text-gray-700',
                ]"
            >
                <Package
                    class="h-5 w-5"
                    :class="{
                        'text-white': $page.url.startsWith('/products'),
                    }"
                />
                <span v-if="!collapsed">Produk</span>
            </Link>
            <Link
                href="/categories"
                :class="[
                    'flex items-center space-x-3 rounded px-3 py-2 hover:bg-gray-100',
                    $page.url.startsWith('/categories')
                        ? 'bg-blue-600 text-white hover:bg-blue-700'
                        : 'text-gray-700',
                ]"
            >
                <Tags
                    class="h-5 w-5"
                    :class="{
                        'text-white': $page.url.startsWith('/categories'),
                    }"
                />
                <span v-if="!collapsed">Kategori</span>
            </Link>
        </nav>
    </aside>
</template>
