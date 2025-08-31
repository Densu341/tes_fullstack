<script setup>
import { defineProps, defineEmits } from "vue";

const props = defineProps({
    show: { type: Boolean, default: false },
    title: { type: String, default: "Yakin ingin menghapus kategori ?" },
    message: {
        type: String,
        default: "Setelah dihapus, kategori ini tidak bisa dikembalikan.",
    },
    confirmText: { type: String, default: "Hapus" },
    cancelText: { type: String, default: "Batal" },
    image: { type: String, default: "/img/Icon.svg" }, // icon trash
});

const emit = defineEmits(["close", "confirm"]);
</script>

<template>
    <transition name="fade">
        <div
            v-if="show"
            class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50"
        >
            <div
                class="relative bg-gradient-to-r from-white to-[#f8fbff] rounded-xl shadow-lg w-[580px] p-8 overflow-hidden"
            >
                <!-- Tombol close -->
                <button
                    @click="$emit('close')"
                    class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 z-20"
                >
                    ✕
                </button>

                <!-- Content -->
                <div class="relative z-10">
                    <h2 class="text-lg font-semibold text-gray-800 mb-2">
                        {{ title }}
                    </h2>
                    <p class="text-gray-600 leading-relaxed">
                        {{ message }}
                    </p>

                    <!-- Actions -->
                    <div class="mt-8 flex space-x-3 justify-end">
                        <button
                            @click="$emit('close')"
                            class="px-6 py-2 rounded-lg bg-gray-100 text-gray-700 font-medium hover:bg-gray-200 transition"
                        >
                            {{ cancelText }}
                        </button>
                        <button
                            @click="$emit('confirm')"
                            class="px-6 py-2 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700 transition"
                        >
                            {{ confirmText }}
                        </button>
                    </div>
                </div>

                <!-- Icon Trash Background (z-0) -->
                <img
                    :src="image"
                    alt="Trash Icon"
                    class="absolute right-7 bottom-6 w-40 h-40 opacity-50 pointer-events-none select-none z-0"
                />
            </div>
        </div>
    </transition>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.25s ease;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
