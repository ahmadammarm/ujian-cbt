<script setup>
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="404 Not Found" />
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 font-poppins">
        <div class="text-center p-8 bg-white rounded-3xl shadow-xl max-w-lg w-full">
            <div class="mb-6">
                <img src="/assets/images/icons/sms-tracking.svg" class="w-24 h-24 mx-auto text-[#2B82FE]" alt="Not Found">
            </div>
            <h1 class="text-6xl font-extrabold text-[#0A090B] mb-4">404</h1>
            <p class="text-xl text-[#7F8190] mb-8 leading-relaxed">
                Halaman yang Anda cari tidak ditemukan.
            </p>
            <Link :href="route('dashboard')" 
                class="inline-block px-8 py-4 bg-[#6436F1] text-white font-bold rounded-full shadow-lg hover:shadow-indigo-200 transition-all duration-300">
                Kembali ke Dashboard
            </Link>
        </div>
    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap');
.font-poppins {
    font-family: 'Poppins', sans-serif;
}
</style>

