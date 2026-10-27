<script setup>
import { Head } from '@inertiajs/vue3';
import ErrorSheet from '@/Components/Organisms/ErrorSheet.vue';

const FORBIDDEN_CODE = 403;
</script>

<template>
    <Head title="Tidak punya akses" />
    <ErrorSheet
        :code="FORBIDDEN_CODE"
        title="Halaman ini bukan untukmu."
        description="Akunmu tidak punya akses ke halaman ini. Kalau menurutmu ini keliru, tanya guru atau admin sekolahmu."
    />
</template>
