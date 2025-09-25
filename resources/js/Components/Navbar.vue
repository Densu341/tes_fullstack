<template>
    <div class="nav">
        <div class="container">
            <Link
                v-for="(item, index) in items"
                :key="index"
                :href="item.href"
                class="menu-item"
            >
                {{ item.label }}
            </Link>
        </div>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    items: {
        type: Array,
        default: () => [],
    },
});
</script>

<style scoped>
.nav {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    height: 60px;
    background-color: #fff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    z-index: 999;
}

.container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
    gap: 20px;
}

.menu-item {
    text-decoration: none;
    color: #333;
    font-weight: bold;
    transition: color 0.3s ease;
}

.menu-item:hover {
    color: #0077cc;
    border-bottom: #0077cc 2px solid;
}
</style>
