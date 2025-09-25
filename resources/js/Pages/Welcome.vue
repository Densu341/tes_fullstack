<script setup>
import { Head } from "@inertiajs/vue3";
import Navbar from "@/Components/Navbar.vue";

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});
</script>

<template>
    <Head title="Welcome" />

    <div class="w-full max-w-[1440px]">
        <nav v-if="canLogin" class="-mx-3 flex flex-1 justify-end">
            <Navbar
                :items="[
                    $page.props.auth.user
                        ? {
                              label: 'Dashboard',
                              href: route('dashboard'),
                          }
                        : { label: 'Log in', href: route('login') },
                    ...(canRegister && !$page.props.auth.user
                        ? [
                              {
                                  label: 'Register',
                                  href: route('register'),
                              },
                          ]
                        : []),
                    {
                        label: 'Contact Management',
                        href: route('contact-management.index'),
                    },
                ]"
            />
        </nav>
    </div>
</template>
