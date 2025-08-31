<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: { type: String, required: true },
    active: { type: Boolean },
    class: { type: String, default: '' }, // <-- Tambahkan ini
});

const classes = computed(() =>
    [
        'inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out',
        props.active
            ? 'border-indigo-400 text-gray-900 focus:border-indigo-700'
            : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:text-gray-700 focus:border-gray-300',
        props.class // <-- gabungkan class eksternal
    ].join(' ')
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
