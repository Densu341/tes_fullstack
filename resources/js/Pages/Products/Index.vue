<script setup>
import { Head, Link, usePage, router } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref, onMounted, onBeforeUnmount } from "vue";
import { EllipsisVertical, RotateCw, Trash2 } from "lucide-vue-next";
import ToggleSwitch from "@/Components/ToggleSwitch.vue";
import ConfirmModalDelete from "@/Components/ConfirmDeleteModal.vue";

// Gunakan `ref` untuk `products` agar bisa dimanipulasi secara reaktif
const { products } = usePage().props;
const localProducts = ref(products.data);

const openMenu = ref(null);
const showConfirmModal = ref(false);
const productToDelete = ref(null);

function toggleMenu(id) {
    openMenu.value = openMenu.value === id ? null : id;
}

function closeMenu(e) {
    if (!e.target.closest(".dropdown-menu")) openMenu.value = null;
}

onMounted(() => document.addEventListener("click", closeMenu));
onBeforeUnmount(() => document.removeEventListener("click", closeMenu));

function openConfirmModal(product) {
    productToDelete.value = product;
    showConfirmModal.value = true;
}

function closeConfirmModal() {
    showConfirmModal.value = false;
    productToDelete.value = null;
}

function updateStatus(product) {
    router.patch(
        route("products.updateStatus", product.id),
        {},
        {
            preserveScroll: true,
            onSuccess: () => {
                // Perbarui status langsung pada objek produk yang ada di properti
                product.status = product.status === 1 ? 0 : 1;
            },
            onError: () => {
                alert("Gagal mengubah status produk");
            },
        }
    );
}

function deleteProduct() {
    if (productToDelete.value) {
        router.delete(`/products/${productToDelete.value.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                // Filter array `localProducts` untuk menghapus produk yang dihapus
                localProducts.value = localProducts.value.filter(
                    (p) => p.id !== productToDelete.value.id
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
    <Head title="Daftar Produk" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold text-gray-800">Daftar Produk</h2>
        </template>

        <div class="p-6 bg-gray-50">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-lg font-semibold text-gray-800">Produk</h1>
                <Link
                    href="/products/create"
                    class="inline-block bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800"
                >
                    + Tambah Produk
                </Link>
            </div>

            <div class="bg-white rounded-xl shadow p-4 overflow-x-auto">
                <div
                    v-if="!localProducts || localProducts.length === 0"
                    class="text-center py-10 text-gray-500"
                >
                    <p class="text-lg">Belum ada produk yang tersedia.</p>
                </div>

                <table v-else class="min-w-full text-left text-sm">
                    <thead>
                        <tr class="text-gray-500 border-b">
                            <th class="py-3 px-2">Nama Produk</th>
                            <th class="py-3 px-2">Varian</th>
                            <th class="py-3 px-2">Tipe</th>
                            <th class="py-3 px-2">Kategori</th>
                            <th class="py-3 px-2">Harga Jual</th>
                            <th class="py-3 px-2">Waktu Dibuat</th>
                            <th class="py-3 px-2">Status</th>
                            <th class="py-3 px-2 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <tr
                            v-for="product in localProducts"
                            :key="product.id"
                            class="hover:bg-gray-50"
                        >
                            <td
                                class="py-3 font-medium text-gray-800 flex items-center space-x-4"
                            >
                                <img
                                    :src="
                                        product.image
                                            ? `/storage/${product.image}`
                                            : '/images/placeholder.png'
                                    "
                                    alt="Gambar Produk"
                                    :style="{
                                        width: '40px',
                                        height: '40px',
                                        objectFit: 'cover',
                                    }"
                                />
                                <div>
                                    <div>
                                        {{ product.name ?? "Tanpa Nama" }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{
                                            product.sku ?? "SKU tidak tersedia"
                                        }}
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-2">
                                {{ product.varian ?? "-" }}
                            </td>
                            <td class="py-3 px-2">
                                {{ product.tipe ?? "-" }}
                            </td>
                            <td class="py-3 px-2">
                                {{
                                    product.category?.name ??
                                    "Tidak ada kategori"
                                }}
                            </td>
                            <td class="py-3 px-2">
                                {{
                                    product.price
                                        ? `Rp ${product.price}`
                                        : "Harga belum ditentukan"
                                }}
                            </td>
                            <td class="py-3 px-2">
                                {{
                                    product.created_at
                                        ? new Date(
                                              product.created_at
                                          ).toLocaleDateString("id-ID", {
                                              day: "2-digit",
                                              month: "short",
                                              year: "numeric",
                                          })
                                        : "-"
                                }}
                            </td>
                            <td class="py-3 px-2">
                                <ToggleSwitch
                                    :modelValue="Number(product.status)"
                                    @update:modelValue="updateStatus(product)"
                                />
                            </td>
                            <td class="py-3 px-2 text-right relative">
                                <button
                                    @click.stop="toggleMenu(product.id)"
                                    class="p-1 rounded hover:bg-gray-100"
                                >
                                    <EllipsisVertical
                                        class="w-5 h-5 text-gray-600"
                                    />
                                </button>
                                <div
                                    v-if="openMenu === product.id"
                                    class="dropdown-menu absolute right-0 mt-2 w-40 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50"
                                >
                                    <Link
                                        :href="`/products/${product.id}/edit`"
                                        class="flex items-center px-2 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                    >
                                        <RotateCw class="w-4 h-4 mr-2" />
                                        Edit Produk
                                    </Link>
                                    <button
                                        @click="openConfirmModal(product)"
                                        class="flex items-center w-full px-2 py-2 text-sm text-red-600 hover:bg-gray-100"
                                    >
                                        <Trash2 class="w-4 h-4 mr-2" />
                                        Hapus Produk
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div
                    class="mt-4 flex justify-end"
                    v-if="products.links?.length > 3"
                >
                    <nav aria-label="Pagination">
                        <ul class="flex items-center space-x-2">
                            <li
                                v-for="link in products.links"
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
            :title="`Yakin ingin menghapus produk?`"
            :message="`Setelah dihapus, produk ${
                productToDelete?.name ?? ''
            } tidak bisa dikembalikan.`"
            confirm-text="Hapus"
            cancel-text="Batal"
            @close="closeConfirmModal"
            @confirm="deleteProduct"
        />
    </AuthenticatedLayout>
</template>
