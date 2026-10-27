<script setup>
import { computed } from 'vue';
import AppShell from '@/Components/Templates/AppShell.vue';

const navItems = computed(() => [
    {
        label: 'Beranda',
        href: route('dashboard'),
        icon: 'home',
        active: route().current('dashboard') && !route().current('dashboard.learning.*'),
    },
    {
        label: 'Ujian saya',
        href: route('dashboard.learning.index'),
        icon: 'clipboard',
        active: route().current('dashboard.learning.*'),
    },
]);
</script>

<template>
    <AppShell space-label="Naiju Exam" space-tag="Portal siswa" :nav-items="navItems">
        <slot />
    </AppShell>
</template>
