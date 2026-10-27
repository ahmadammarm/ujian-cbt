<script setup>
import { Head } from '@inertiajs/vue3';
import ErrorSheet from '@/Components/Organisms/ErrorSheet.vue';

const NOT_FOUND_CODE = 404;
</script>

<template>
    <Head title="Halaman tidak ditemukan" />
    <ErrorSheet
        :code="NOT_FOUND_CODE"
        title="Halamannya tidak ada."
        description="Mungkin alamatnya salah ketik, atau halamannya sudah dihapus. Coba kembali dan buka lagi dari menu."
    />
</template>
