<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    canRegister: {
        type: Boolean,
        default: true,
    },
});
</script>

<template>
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="bg-white dark:bg-[#111116] border border-slate-300 dark:border-slate-800 rounded-3xl p-8 sm:p-12 lg:p-16 shadow-xs transition-colors">
            <div class="max-w-2xl space-y-4">
                <div class="text-xs font-bold uppercase tracking-wider text-[#D95300]">
                    Siap Memulai Evaluasi Digital?
                </div>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-[#0A090B] dark:text-white tracking-tight">
                    Tingkatkan Kualitas Ujian Sekolah Anda Bersama Naiju
                </h2>
                <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                    Mulai selenggarakan ujian online dengan bank soal guru yang aman, koreksi nilai instan, dan proses pelaksanaan yang bebas ribet. Hemat kertas, hemat waktu, dan hasil belajar terukur akurat.
                </p>

                <div class="flex flex-col sm:flex-row gap-3 pt-4">
                    <Link
                        v-if="!$page.props.auth.user"
                        :href="route('login')"
                        class="px-6 py-3.5 bg-[#D95300] text-white text-sm font-bold rounded-xl text-center hover:bg-[#BF4900] transition-colors shadow-sm"
                    >
                        Masuk ke Portal Ujian
                    </Link>

                    <Link
                        v-if="!$page.props.auth.user && canRegister"
                        :href="route('register')"
                        class="px-6 py-3.5 bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-200 text-sm font-bold rounded-xl text-center hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors"
                    >
                        Daftar Akun Baru
                    </Link>

                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('dashboard')"
                        class="px-6 py-3.5 bg-[#0A090B] dark:bg-white text-white dark:text-[#0A090B] text-sm font-bold rounded-xl text-center hover:bg-slate-800 dark:hover:bg-slate-100 transition-colors shadow-sm"
                    >
                        Buka Dashboard
                    </Link>
                </div>
            </div>
        </div>
    </section>
</template>
