<script setup>
import { Head, Link, usePage, router } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref, onMounted, onBeforeUnmount } from "vue";
import { EllipsisVertical, RotateCw, Trash2 } from "lucide-vue-next";
import ConfirmModalDelete from "@/Components/ConfirmDeleteModal.vue";

const { categories } = usePage().props;
const openMenu = ref(null);
const showConfirmModal = ref(false);
const categoryToDelete = ref(null);

// Membuat data kategori menjadi reaktif
const categoryData = ref(categories.data);

function toggleMenu(id) {
    openMenu.value = openMenu.value === id ? null : id;
}

function closeMenu(e) {
    if (!e.target.closest(".dropdown-menu")) openMenu.value = null;
}

onMounted(() => document.addEventListener("click", closeMenu));
onBeforeUnmount(() => document.removeEventListener("click", closeMenu));

// Fungsi untuk membuka modal konfirmasi
function openConfirmModal(category) {
    categoryToDelete.value = category;
    showConfirmModal.value = true;
}

// Fungsi untuk menutup modal konfirmasi
function closeConfirmModal() {
    showConfirmModal.value = false;
    categoryToDelete.value = null;
}

// Fungsi untuk menghapus kategori
function deleteCategory() {
    if (categoryToDelete.value) {
        router.delete(`/categories/${categoryToDelete.value.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                categoryData.value = categoryData.value.filter(
                    (c) => c.id !== categoryToDelete.value.id
                );
                closeConfirmModal();
            },
            onError: () => {
                closeConfirmModal();
            },
        });
    }
}
</script>

<template>
    <Head title="Daftar Kategori" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold text-gray-800">Daftar Kategori</h2>
        </template>

        <div class="p-6 bg-gray-50">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-lg font-semibold text-gray-800">Kategori</h1>
                <Link
                    href="/categories/create"
                    class="inline-block bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800"
                >
                    + Tambah Kategori
                </Link>
            </div>

            <div class="bg-white rounded-xl shadow p-4 overflow-x-auto mt-4">
                <table class="min-w-full text-left text-sm">
                    <thead>
                        <tr class="text-gray-500 border-b">
                            <th class="py-3 px-2">Nama</th>
                            <th class="py-3 px-2 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <tr
                            v-for="category in categoryData"
                            :key="category.id"
                            class="hover:bg-gray-50"
                        >
                            <td class="py-3 px-2 font-medium text-gray-800">
                                {{ category.name }}
                            </td>
                            <td class="py-3 px-2 text-right relative">
                                <button
                                    @click.stop="toggleMenu(category.id)"
                                    class="p-1 rounded hover:bg-gray-100"
                                >
                                    <EllipsisVertical
                                        class="w-5 h-5 text-gray-600"
                                    />
                                </button>

                                <div
                                    v-if="openMenu === category.id"
                                    class="dropdown-menu absolute right-0 mt-2 w-40 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50"
                                >
                                    <Link
                                        :href="`/categories/${category.id}/edit`"
                                        class="flex items-center px-2 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                    >
                                        <RotateCw class="w-4 h-4 mr-2" />
                                        Edit Kategori
                                    </Link>
                                    <button
                                        @click="openConfirmModal(category)"
                                        class="flex items-center w-full px-2 py-2 text-sm text-red-600 hover:bg-gray-100"
                                    >
                                        <Trash2 class="w-4 h-4 mr-2" />
                                        Hapus Kategori
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div
                    class="mt-4 flex justify-end"
                    v-if="categories.links.length > 3"
                >
                    <nav aria-label="Pagination">
                        <ul class="flex items-center space-x-2">
                            <li
                                v-for="link in categories.links"
                                :key="link.label"
                            >
                                <Link
                                    :href="link.url ?? '#'"
                                    class="px-3 py-2 text-sm rounded-lg"
                                    :class="{
                                        'bg-blue-600 text-white font-semibold':
                                            link.active,
                                        'text-gray-700 hover:bg-gray-200':
                                            !link.active,
                                        'cursor-not-allowed': !link.url,
                                    }"
                                    :aria-current="link.active ? 'page' : null"
                                    v-html="link.label"
                                />
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <ConfirmModalDelete
            :show="showConfirmModal"
            :title="`Yakin ingin menghapus kategori ?`"
            :message="`Setelah dihapus, kategori ${
                categoryToDelete?.name ?? ''
            } tidak bisa dikembalikan.`"
            confirm-text="Hapus"
            cancel-text="Batal"
            image="/img/Icon.svg"
            @close="closeConfirmModal"
            @confirm="deleteCategory"
        />
    </AuthenticatedLayout>
</template>
