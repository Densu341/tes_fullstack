<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm, Link } from "@inertiajs/vue3";
import { ChevronRight, Search } from "lucide-vue-next";
import { ref, watch, computed } from "vue";

// Komponen
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import ToggleSwitch from "@/Components/ToggleSwitch.vue";

// Props
const props = defineProps({
    product: Object,
    categories: Array,
});

// Inisialisasi form dengan penyesuaian untuk Decimal128
const form = useForm({
    name: props.product?.name || "",
    sku: props.product?.sku || "",
    stock: props.product?.stock || "",
    price: props.product?.price || "",
    cost_price: props.product?.cost_price || "",
    special_price: props.product?.special_price || "",
    category_name: props.product?.category?.name || "",
    category_id: props.product?.category?.id || null,
    image: null,
    status: props.product?.status || 0,
    tipe: props.product?.tipe || "",
    varian: props.product?.varian || "",
    _method: "PUT", // Untuk metode PUT
});

// Preview gambar
const previewUrl = ref(props.product?.image_url || null);
const handleImageUpload = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.image = file;
        previewUrl.value = URL.createObjectURL(file);
    }
};

watch(
    () => form.category_name,
    (newName) => {
        const foundCategory = props.categories.find((c) => c.name === newName);
        form.category_id = foundCategory?.id || null;
    }
);

// ToggleSwitch bind ke boolean tapi simpan 0/1
const formStatusBoolean = computed({
    get: () => Boolean(form.status),
    set: (val) => (form.status = val ? 1 : 0),
});

const handleSubmit = () => {
    if (!props.product?.id) return;

    form.post(route("products.update", props.product.id), {
        forceFormData: true,
    });
};
</script>

<template>
    <Head title="Edit Produk" />

    <AuthenticatedLayout v-if="props.product && props.categories">
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
                <li class="text-gray-700">Edit Produk</li>
            </ol>
        </template>

        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-lg font-semibold text-gray-800">Edit Produk</h1>
            <div class="flex space-x-2">
                <Link
                    href="/products"
                    class="rounded-md bg-gray-200 px-4 py-2 text-gray-700 hover:bg-gray-300"
                    >Kembali</Link
                >
                <button
                    @click="handleSubmit"
                    class="rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                    :disabled="form.processing"
                >
                    Simpan Perubahan
                </button>
            </div>
        </div>

        <form
            @submit.prevent="handleSubmit"
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

                        <input
                            type="hidden"
                            id="category_id"
                            v-model="form.category_id"
                        />

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
                                <div
                                    v-else
                                    class="mx-auto h-12 w-12 text-gray-400 flex items-center justify-center border rounded"
                                >
                                    <span>+</span>
                                </div>
                                <div
                                    class="flex text-sm text-gray-600 justify-center"
                                >
                                    <label
                                        for="image-upload"
                                        class="relative cursor-pointer rounded-md bg-white font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2"
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
                    <span class="text-sm text-gray-600">
                        Tentukan apakah produk ditampilkan di toko. Nonaktifkan
                        untuk menyembunyikan.
                    </span>
                </div>
                <div class="mt-2 flex items-center space-x-3">
                    <ToggleSwitch v-model="formStatusBoolean" />
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
