<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="space-y-6 text-white pt-2 sm:pt-4">
        <!-- Hero Primary Headline -->
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight leading-[1.18]">
            Sistem Ujian Berbasis Komputer <br />
            <span class="text-amber-200">Aman, Terstruktur, &amp; Bebas Curang</span>
        </h1>

        <!-- Hero Subtitle -->
        <p class="text-base sm:text-lg text-orange-50/95 dark:text-slate-200 leading-relaxed font-normal max-w-xl">
            Platform Computer-Based Test (CBT) terpadu untuk pelaksanaan Penilaian Harian, PTS, dan PAS sekolah. Dilengkapi proctoring kunci layar penuh, penyimpanan jawaban real-time, dan rekapitulasi nilai otomatis berstandar KKM.
        </p>

        <!-- Primary Direct Action Buttons (Pill Shapes) -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3.5 pt-2">
            <a
                href="#simulasi"
                class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-[#0A090B] hover:bg-black text-white font-black text-sm uppercase tracking-wider rounded-full shadow-2xl shadow-black/40 hover:scale-105 active:scale-95 transition-all cursor-pointer"
            >
                <span>Coba Simulasi CBT Siswa</span>
                <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>

            <Link
                v-if="!$page.props.auth.user"
                :href="route('login')"
                class="inline-flex items-center justify-center px-6 py-4 bg-white/15 hover:bg-white/25 text-white font-bold text-sm rounded-full border border-white/30 backdrop-blur-sm transition-all text-center"
            >
                Masuk ke Portal Ujian
            </Link>

            <Link
                v-else
                :href="route('dashboard')"
                class="inline-flex items-center justify-center px-6 py-4 bg-white text-[#D95300] hover:bg-orange-50 font-bold text-sm rounded-full shadow-md transition-all text-center"
            >
                Buka Dashboard Saya
            </Link>
        </div>

        <!-- Micro Feature Tags -->
        <div class="flex flex-wrap items-center gap-2 pt-3 text-xs font-semibold text-orange-100 dark:text-slate-300">
            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-black/15 dark:bg-slate-900/60 border border-white/20 dark:border-slate-700/60">
                <svg class="w-3.5 h-3.5 text-amber-300" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                <span>Proteksi Kunci Layar Penuh</span>
            </div>
            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-black/15 dark:bg-slate-900/60 border border-white/20 dark:border-slate-700/60">
                <svg class="w-3.5 h-3.5 text-amber-300" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                <span>Penyimpanan Jawaban Real-Time</span>
            </div>
            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-black/15 dark:bg-slate-900/60 border border-white/20 dark:border-slate-700/60">
                <svg class="w-3.5 h-3.5 text-amber-300" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                <span>Rekapitulasi Nilai Ambang KKM 70%</span>
            </div>
        </div>
    </div>
</template>
