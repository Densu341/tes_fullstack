<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm, Link, usePage } from "@inertiajs/vue3";
import { ChevronRight } from "lucide-vue-next";

// Komponen input
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";

const { category } = usePage().props;

const form = useForm({
    name: category.name,
});

const submit = () => {
    form.patch(`/categories/${category.id}`);
};
</script>

<template>
    <Head title="Edit Kategori" />

    <AuthenticatedLayout>
        <template #breadcrumb>
            <ol class="flex space-x-2 items-center text-sm text-gray-600">
                <li>
                    <Link
                        href="/categories"
                        class="text-blue-600 hover:underline"
                        >Daftar Kategori</Link
                    >
                </li>
                <li>
                    <ChevronRight class="w-4 h-4 text-gray-400" />
                </li>
                <li class="text-gray-700">Edit Kategori</li>
            </ol>
        </template>

        <div class="flex justify-between items-center mb-4">
            <h1 class="text-lg font-semibold text-gray-800">Kategori</h1>
            <div class="flex space-x-2">
                <Link
                    href="/categories"
                    class="px-4 py-2 bg-gray-200 rounded-md text-gray-700 hover:bg-gray-300"
                >
                    Batal
                </Link>
                <button
                    @click="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
                    :disabled="form.processing"
                >
                    Simpan
                </button>
            </div>
        </div>

        <div class="p-6 bg-gray-50">
            <form
                @submit.prevent="submit"
                class="bg-white shadow rounded-xl p-6 space-y-4"
            >
                <!-- Nama Kategori -->
                <div>
                    <InputLabel for="name" value="Nama Kategori" />
                    <TextInput
                        id="name"
                        type="text"
                        v-model="form.name"
                        class="mt-1 block w-full"
                        autocomplete="off"
                    />
                    <InputError :message="form.errors.name" class="mt-2" />
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
