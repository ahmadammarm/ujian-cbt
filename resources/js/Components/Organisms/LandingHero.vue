<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="space-y-6 lg:pt-4">
        <div class="text-xs font-bold uppercase tracking-wider text-[#D95300]">
            Sistem CBT &amp; Asesmen Sekolah Modern
        </div>

        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-[#0A090B] dark:text-white tracking-tight leading-[1.15]">
            Aplikasi Ujian Online &amp; CBT Sekolah yang Praktis, Akurat, dan Anti-Bocor.
        </h1>

        <p class="text-base text-slate-600 dark:text-slate-300 leading-relaxed font-normal">
            Naiju membantu sekolah dan perguruan tinggi menyelenggarakan ujian berbasis komputer (CBT) tanpa repot. Kelola bank soal guru dengan mudah, amankan kunci jawaban di server, dan peroleh hasil evaluasi siswa secara instan tanpa perlu koreksi manual.
        </p>

        <!-- Primary Direct Actions -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 pt-2">
            <Link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="px-6 py-3.5 bg-[#D95300] text-white font-bold text-sm rounded-xl text-center hover:bg-[#BF4900] transition-colors shadow-xs"
            >
                Menuju Portal Dashboard
            </Link>

            <Link
                v-else
                :href="route('login')"
                class="px-6 py-3.5 bg-[#D95300] text-white font-bold text-sm rounded-xl text-center hover:bg-[#BF4900] transition-colors shadow-xs"
            >
                Masuk ke Portal Ujian
            </Link>

            <a
                href="#simulasi"
                class="px-6 py-3.5 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-200 font-bold text-sm border border-slate-300 dark:border-slate-700 rounded-xl text-center hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white transition-colors shadow-xs"
            >
                Coba Simulasi CBT Interaktif
            </a>
        </div>

        <!-- Technical Highlights Grid -->
        <div class="pt-6 border-t border-slate-200 dark:border-slate-800 grid grid-cols-2 gap-4 text-left">
            <div class="p-4 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl space-y-1.5 shadow-xs">
                <span class="text-xs font-bold text-slate-900 dark:text-slate-100 block">Kunci Jawaban Anti-Bocor</span>
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-normal">
                    Kunci jawaban diamankan di server, mencegah siswa membocorkan jawaban via Inspect Element di browser.
                </p>
            </div>
            <div class="p-4 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl space-y-1.5 shadow-xs">
                <span class="text-xs font-bold text-slate-900 dark:text-slate-100 block">Penyimpanan Jawaban Real-Time</span>
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-normal">
                    Setiap pilihan tersimpan otomatis ke server. Bebas cemas dari kendala mati listrik atau koneksi internet terputus.
                </p>
            </div>
        </div>
    </div>
</template>
