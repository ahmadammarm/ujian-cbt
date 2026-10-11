<script setup>
import { ref } from 'vue';

const activeWorkspaceTab = ref('studio');
</script>

<template>
    <section id="ruang-kerja" class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mb-12 space-y-2">
            <div class="text-xs font-bold uppercase tracking-wider text-[#D95300]">
                Desain Dua Ruang Kerja Terpisah
            </div>
            <h2 class="text-2xl sm:text-3xl font-black text-[#0A090B] dark:text-white tracking-tight">
                Dirancang Khusus Sesuai Peran Guru dan Kebutuhan Siswa
            </h2>
            <p class="text-sm text-slate-600 dark:text-slate-400">
                Akses terpisah antara portal manajemen pengajar dan portal pengerjaan soal siswa untuk menjamin keamanan dan kenyamanan maksimal.
            </p>
        </div>

        <!-- Role Workspace Switcher Control -->
        <div class="inline-flex p-1.5 bg-slate-200/80 dark:bg-slate-800 rounded-2xl mb-10 border border-slate-300 dark:border-slate-700">
            <button
                type="button"
                @click="activeWorkspaceTab = 'studio'"
                :class="[
                    'px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider transition-all cursor-pointer',
                    activeWorkspaceTab === 'studio'
                        ? 'bg-white dark:bg-[#111116] text-[#D95300] shadow-sm'
                        : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'
                ]"
            >
                Naiju Studio (Ruang Guru)
            </button>
            <button
                type="button"
                @click="activeWorkspaceTab = 'exam'"
                :class="[
                    'px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider transition-all cursor-pointer',
                    activeWorkspaceTab === 'exam'
                        ? 'bg-white dark:bg-[#111116] text-[#2B82FE] shadow-sm'
                        : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'
                ]"
            >
                Naiju Exam (Portal Siswa)
            </button>
        </div>

        <!-- Teacher Workspace Live Showcase -->
        <div v-if="activeWorkspaceTab === 'studio'" class="grid lg:grid-cols-12 gap-8 items-start">
            <div class="lg:col-span-7 bg-white dark:bg-[#111116] rounded-2xl border border-slate-300 dark:border-slate-800 p-6 sm:p-7 space-y-6 shadow-xs transition-colors">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800">
                    <div>
                        <span class="text-xs font-mono font-bold text-[#D95300] uppercase tracking-wider">PORTAL PENGAJAR</span>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Panel Manajemen Soal &amp; Kelas</h3>
                    </div>
                    <span class="text-xs font-semibold px-2.5 py-1 bg-orange-50 dark:bg-orange-950/40 text-orange-800 dark:text-orange-200 rounded-lg border border-orange-200 dark:border-orange-800">
                        Akses Guru Terverifikasi
                    </span>
                </div>

                <div class="grid grid-cols-3 gap-3 text-center">
                    <div class="p-3 bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 rounded-xl space-y-0.5">
                        <span class="text-[10px] font-bold text-slate-400 uppercase">Bank Soal</span>
                        <div class="text-xl font-black text-slate-900 dark:text-white">12 Modul</div>
                    </div>
                    <div class="p-3 bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 rounded-xl space-y-0.5">
                        <span class="text-[10px] font-bold text-slate-400 uppercase">Siswa Ujian</span>
                        <div class="text-xl font-black text-slate-900 dark:text-white">148 Siswa</div>
                    </div>
                    <div class="p-3 bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 rounded-xl space-y-0.5">
                        <span class="text-[10px] font-bold text-slate-400 uppercase">Rata-rata Nilai</span>
                        <div class="text-xl font-black text-emerald-600 dark:text-emerald-400">82.4%</div>
                    </div>
                </div>

                <div class="space-y-2 text-xs">
                    <div class="p-3 bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 rounded-xl flex items-center justify-between">
                        <span class="font-bold text-slate-800 dark:text-slate-200">Ujian Matematika Peminatan Kelas XII</span>
                        <span class="text-emerald-600 font-semibold">Terkoreksi Otomatis</span>
                    </div>
                    <div class="p-3 bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 rounded-xl flex items-center justify-between">
                        <span class="font-bold text-slate-800 dark:text-slate-200">Asesmen Informatika &amp; Pemrograman Dasar</span>
                        <span class="text-slate-500 font-semibold">Aktif Berlangsung</span>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5 space-y-4">
                <div class="bg-white dark:bg-[#111116] p-5 rounded-xl border border-slate-200 dark:border-slate-800 space-y-1.5 shadow-xs transition-colors">
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white">Bank Soal Mandiri Guru</h4>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Setiap pengajar memiliki ruang pribadi untuk menyusun paket soal, pilihan ganda, dan bobot nilai secara rahasia dan independen.
                    </p>
                </div>
                <div class="bg-white dark:bg-[#111116] p-5 rounded-xl border border-slate-200 dark:border-slate-800 space-y-1.5 shadow-xs transition-colors">
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white">Penugasan Kelas &amp; Siswa Mudah</h4>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Daftarkan peserta ujian berdasarkan kelas atau rombel dengan cepat tanpa khawatir salah jadwal ujian.
                    </p>
                </div>
                <div class="bg-white dark:bg-[#111116] p-5 rounded-xl border border-slate-200 dark:border-slate-800 space-y-1.5 shadow-xs transition-colors">
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white">Analisis Ketuntasan Belajar Instan</h4>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Rekap nilai rata-rata, persentase kelulusan KKM, dan butir soal yang paling sering salah tersaji otomatis tanpa rumus Excel manual.
                    </p>
                </div>
            </div>
        </div>

        <!-- Student Workspace Live Showcase -->
        <div v-else class="grid lg:grid-cols-12 gap-8 items-start">
            <div class="lg:col-span-7 bg-white dark:bg-[#111116] rounded-2xl border border-slate-300 dark:border-slate-800 p-6 sm:p-7 space-y-6 shadow-xs transition-colors">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800">
                    <div>
                        <span class="text-xs font-mono font-bold text-[#2B82FE] uppercase tracking-wider">HASIL ASESMEN SISWA</span>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Laporan Hasil Belajar (Rapor Digital)</h3>
                    </div>
                    <span class="text-xs font-semibold px-2.5 py-1 bg-emerald-50 dark:bg-emerald-950/40 text-emerald-800 dark:text-emerald-200 rounded-lg border border-emerald-200 dark:border-emerald-800">
                        Status: Tuntas / Lulus KKM
                    </span>
                </div>

                <!-- Score Metric Badge -->
                <div class="flex items-center gap-6 p-4 bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 rounded-xl">
                    <div class="w-20 h-20 bg-emerald-600 text-white rounded-2xl flex flex-col items-center justify-center font-black shrink-0 shadow-sm">
                        <span class="text-2xl leading-none">84</span>
                        <span class="text-[10px] font-medium opacity-80 pt-1">SKOR AKHIR</span>
                    </div>
                    <div class="space-y-1 text-xs">
                        <div class="font-bold text-slate-900 dark:text-white">Pencapaian: Melampaui Standar KKM (70)</div>
                        <p class="text-slate-500 dark:text-slate-400">42 jawaban benar dari total 50 butir soal (Bobot 2.0 poin per butir). Durasi pengerjaan: 38 menit.</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3 text-center text-xs">
                    <div class="p-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl">
                        <span class="text-slate-500 dark:text-slate-400 block">Jawaban Benar</span>
                        <span class="text-base font-bold text-emerald-700 dark:text-emerald-400">42 Butir</span>
                    </div>
                    <div class="p-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl">
                        <span class="text-slate-500 dark:text-slate-400 block">Jawaban Salah</span>
                        <span class="text-base font-bold text-rose-600 dark:text-rose-400">8 Butir</span>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5 space-y-4">
                <div class="bg-white dark:bg-[#111116] p-5 rounded-xl border border-slate-200 dark:border-slate-800 space-y-1.5 shadow-xs transition-colors">
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white">Antarmuka Bersih &amp; Bebas Distraksi</h4>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Tampilan ujian ramah mata, tanpa iklan atau pop-up, membantu siswa tetap rileks dan fokus membaca soal ujian.
                    </p>
                </div>
                <div class="bg-white dark:bg-[#111116] p-5 rounded-xl border border-slate-200 dark:border-slate-800 space-y-1.5 shadow-xs transition-colors">
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white">Auto-Save: Aman Saat Internet Terputus</h4>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Setiap butir yang diklik tersimpan otomatis ke server. Jawaban tidak hilang meskipun kuota habis atau laptop mati mendadak.
                    </p>
                </div>
                <div class="bg-white dark:bg-[#111116] p-5 rounded-xl border border-slate-200 dark:border-slate-800 space-y-1.5 shadow-xs transition-colors">
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white">Pengumuman Skor &amp; Pembahasan Transparan</h4>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Siswa dapat langsung melihat perolehan skor dan mengevaluasi hasil belajar segera setelah menyelesaikan ujian.
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>
