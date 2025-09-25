<script setup>
import { Head } from "@inertiajs/vue3";
import FormPattern from "@/Components/FormPattern.vue";
</script>

<template>
    <Head title="Contact Management" />

    <div class="container">
        <h1 class="title">Contact Management</h1>
        <div class="p-6">
            <FormPattern />
        </div>
    </div>
</template>

<style scoped>
.container {
    margin: auto;
    height: 100%;
    width: 1440px;
    border-radius: 10px;
    background-color: cadetblue;
    box-shadow: 1px 1px 1px 1px rgba(0, 0, 0, 0.2);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}
.title {
    font-size: 20px;
    font-weight: bold;
}
</style>
