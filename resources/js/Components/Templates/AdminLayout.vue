<script setup>
import { computed } from 'vue';
import AppShell from '@/Components/Templates/AppShell.vue';

const navItems = computed(() => [
    {
        label: 'Ringkasan',
        href: route('dashboard.overview'),
        icon: 'home',
        active: route().current('dashboard.overview'),
    },
    {
        label: 'Kursus & soal',
        href: route('dashboard.courses.index'),
        icon: 'book',
        active: route().current('dashboard.courses.*') || route().current('dashboard.course.question.*'),
    },
    {
        label: 'Siswa',
        href: route('dashboard.students.index'),
        icon: 'users',
        active: route().current('dashboard.students.*'),
    },
    {
        label: 'Analitik',
        href: route('dashboard.analytics'),
        icon: 'chart',
        active: route().current('dashboard.analytics*'),
    },
]);
</script>

<template>
    <AppShell space-label="Naiju Studio" space-tag="Ruang pengajar" :nav-items="navItems">
        <slot />
    </AppShell>
</template>
