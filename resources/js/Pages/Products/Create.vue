<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm, Link } from "@inertiajs/vue3";
import { ChevronRight, Search } from "lucide-vue-next";
import { ref, watch } from "vue"; // Impor `watch` dari Vue

// Impor komponen form
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import ToggleSwitch from "@/Components/ToggleSwitch.vue";

// Mendefinisikan props yang diterima dari controller, yaitu daftar kategori
const props = defineProps({
    categories: Array,
});

// Mengubah form untuk menggunakan `category_name` sebagai input teks
const form = useForm({
    name: "",
    sku: "",
    price: "",
    stock: "",
    cost_price: "",
    special_price: "",
    category_id: "",
    category_name: "", // Menggunakan nama kategori, bukan ID
    status: 1,
    tipe: "",
    varian: "",
    image: null,
});

// State untuk preview gambar
const previewUrl = ref(null);

// Fungsi untuk menangani upload gambar dan membuat URL preview
const handleImageUpload = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.image = file;
        previewUrl.value = URL.createObjectURL(file);
    }
};

// Logika untuk mengisi category_id secara otomatis jika nama kategori ada di datalist
watch(
    () => form.category_name,
    (newCategoryName) => {
        // Cari kategori berdasarkan nama
        const foundCategory = props.categories.find(
            (cat) => cat.name === newCategoryName
        );

        // Jika kategori ditemukan, isi `category_id` dengan ID-nya
        if (foundCategory) {
            form.category_id = foundCategory.id;
        } else {
            // Jika tidak ditemukan, kosongkan `category_id`
            form.category_id = "";
        }
    }
);

// Fungsi submit yang disederhanakan.
const submitProduct = () => {
    // Karena `watch` sudah menangani logika, kita hanya perlu mengirim form
    form.post(route("products.store"));
};
</script>

<template>
    <Head title="Tambah Produk" />

    <AuthenticatedLayout>
        <template #breadcrumb>
            <ol class="flex items-center space-x-2 text-sm text-gray-600">
                <li>
                    <Link
                        href="/products"
                        class="text-blue-600 hover:underline"
                    >
                        Daftar Produk
                    </Link>
                </li>
                <li><ChevronRight class="h-4 w-4 text-gray-400" /></li>
                <li class="text-gray-700">Tambah Produk</li>
            </ol>
        </template>

        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-lg font-semibold text-gray-800">Tambah Produk</h1>
            <div class="flex space-x-2">
                <Link
                    href="/products"
                    class="rounded-md bg-gray-200 px-4 py-2 text-gray-700 hover:bg-gray-300"
                >
                    Kembali
                </Link>
                <button
                    @click="submitProduct"
                    class="rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                    :disabled="form.processing"
                >
                    Tambah Produk
                </button>
            </div>
        </div>

        <form
            @submit.prevent="submitProduct"
            class="space-y-8 rounded-xl bg-white p-6 shadow"
        >
            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                <div class="md:col-span-2">
                    <h2 class="mb-4 text-md font-semibold">Informasi Produk</h2>
                    <div class="space-y-4">
                        <div>
                            <InputLabel for="name" value="Nama Produk *" />
                            <TextInput
                                id="name"
                                v-model="form.name"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="Masukkan nama produk"
                                required
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.name"
                            />
                        </div>

                        <div class="relative">
                            <InputLabel
                                for="category_name"
                                value="Kategori Produk *"
                            />
                            <Search
                                class="absolute left-3 top-2/3 -translate-y-1/2 h-5 w-5 text-gray-400 pointer-events-none"
                            />
                            <TextInput
                                id="category_name"
                                v-model="form.category_name"
                                type="text"
                                class="block w-full pl-10"
                                placeholder="Ketik untuk mencari atau membuat kategori baru"
                                list="categories-list"
                                required
                            />
                            <datalist id="categories-list">
                                <option
                                    v-for="cat in categories"
                                    :key="cat.id"
                                    :value="cat.name"
                                ></option>
                            </datalist>
                            <InputError
                                class="mt-2"
                                :message="form.errors.category_name"
                            />
                        </div>

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                            <div>
                                <InputLabel
                                    for="sku"
                                    value="SKU (Stock Keeping Unit)"
                                />
                                <TextInput
                                    id="sku"
                                    v-model="form.sku"
                                    type="text"
                                    class="mt-1 block w-full"
                                    placeholder="Masukkan SKU"
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.sku"
                                />
                            </div>
                            <div>
                                <InputLabel for="varian" value="Varian" />
                                <TextInput
                                    id="varian"
                                    v-model="form.varian"
                                    type="text"
                                    class="mt-1 block w-full"
                                    placeholder="Masukkan varian"
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.varian"
                                />
                            </div>
                            <div>
                                <InputLabel for="tipe" value="Tipe" />
                                <TextInput
                                    id="tipe"
                                    v-model="form.tipe"
                                    type="text"
                                    class="mt-1 block w-full"
                                    placeholder="Masukkan tipe"
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.tipe"
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="md:col-span-1">
                    <h2 class="mb-4 text-md font-semibold">Gambar Produk</h2>
                    <div>
                        <InputLabel for="image" value="Upload Gambar" />
                        <div
                            class="mt-1 flex items-center justify-center rounded-md border-2 border-dashed border-gray-300 px-6 pt-5 pb-6"
                        >
                            <div class="space-y-1 text-center">
                                <img
                                    v-if="previewUrl"
                                    :src="previewUrl"
                                    class="mx-auto h-24 w-auto object-cover rounded-md mb-2"
                                    alt="Image Preview"
                                />
                                <svg
                                    v-else
                                    class="mx-auto h-12 w-12 text-gray-400"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 48 48"
                                    aria-hidden="true"
                                >
                                    <path
                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label
                                        for="image-upload"
                                        class="relative cursor-pointer rounded-md bg-white font-medium text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:text-indigo-500"
                                    >
                                        <span>Pilih file</span>
                                        <input
                                            id="image-upload"
                                            name="image-upload"
                                            type="file"
                                            class="sr-only"
                                            @change="handleImageUpload"
                                            accept="image/*"
                                        />
                                    </label>
                                    <p class="pl-1">atau tarik dan lepas</p>
                                </div>
                                <p class="text-xs text-gray-500">
                                    PNG, JPG, GIF hingga 2MB
                                </p>
                            </div>
                        </div>
                        <InputError class="mt-2" :message="form.errors.image" />
                    </div>
                </div>
            </div>

            <div
                class="border rounded-md p-4 flex items-center justify-between"
            >
                <div>
                    <InputLabel value="Status Produk" />
                    <span class="text-sm text-gray-600"
                        >Tentukan apakah produk ditampilkan ditoko dan toko
                        digital. Nonaktifkan untuk menyembunyikan produk dari
                        pembeli.</span
                    >
                </div>
                <div class="mt-2 flex items-center space-x-3">
                    <ToggleSwitch v-model="form.status" />
                    <span class="text-sm text-gray-700">Aktif</span>
                </div>
            </div>

            <div>
                <h2 class="mb-4 text-md font-semibold">
                    Harga & Stok Ketersediaan
                </h2>
                <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                    <div>
                        <InputLabel for="stock" value="Stok *" />
                        <TextInput
                            id="stock"
                            v-model="form.stock"
                            type="number"
                            class="mt-1 block w-full"
                            placeholder="0"
                            required
                        />
                        <InputError class="mt-2" :message="form.errors.stock" />
                    </div>
                    <div>
                        <InputLabel for="cost_price" value="Harga Modal *" />
                        <TextInput
                            id="cost_price"
                            v-model="form.cost_price"
                            type="number"
                            class="mt-1 block w-full"
                            placeholder="0"
                            required
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.cost_price"
                        />
                    </div>
                    <div>
                        <InputLabel for="price" value="Harga Jual *" />
                        <TextInput
                            id="price"
                            v-model="form.price"
                            type="number"
                            class="mt-1 block w-full"
                            placeholder="0"
                            required
                        />
                        <InputError class="mt-2" :message="form.errors.price" />
                    </div>
                    <div>
                        <InputLabel
                            for="special_price"
                            value="Harga Spesial (Opsional)"
                        />
                        <TextInput
                            id="special_price"
                            v-model="form.special_price"
                            type="number"
                            class="mt-1 block w-full"
                            placeholder="0"
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.special_price"
                        />
                    </div>
                </div>
            </div>
        </form>
    </AuthenticatedLayout>
</template>
