<script setup>
import AdminLayout from '@/Components/Templates/AdminLayout.vue';
import Breadcrumbs from '@/Components/Molecules/Breadcrumbs.vue';
import MetricCard from '@/Components/Molecules/MetricCard.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    metrics: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <Head title="Ringkasan Overview" />

    <AdminLayout>
        <Breadcrumbs :items="[
            { label: 'Naiju Studio', href: route('dashboard.overview') },
            { label: 'Overview' }
        ]" />

        <div class="flex flex-col gap-10">
            <!-- Header Section -->
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                <div class="flex flex-col gap-2">
                    <div class="flex items-center gap-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-[#D95300]/10 text-[#D95300] border border-[#D95300]/20 tracking-wider uppercase">
                            Ruang Pengajar
                        </span>
                        <span class="text-xs font-semibold text-slate-400 dark:text-slate-500">Versi Sistem 2.4</span>
                    </div>
                    <h1 class="text-3xl lg:text-4xl font-extrabold text-[#0A090B] dark:text-white tracking-tight">
                        Ringkasan Platform &amp; Asesmen
                    </h1>
                    <p class="text-sm lg:text-base text-slate-500 dark:text-slate-400 max-w-2xl">
                        Pantau seluruh aktivitas penyelenggaraan ujian, distribusi soal, dan rekapitulasi performa siswa secara real-time.
                    </p>
                </div>

                <!-- Quick Action Button -->
                <div class="flex items-center gap-3">
                    <Link
                        :href="route('dashboard.courses.create')"
                        class="inline-flex items-center gap-2.5 px-6 py-3.5 bg-[#D95300] hover:bg-[#b84600] text-white rounded-2xl font-bold text-sm transition-colors active:scale-95"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Buat Kursus Baru</span>
                    </Link>
                </div>
            </div>

            <!-- Metric Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Courses -->
                <MetricCard
                    title="Total Kursus Aktif"
                    :value="metrics.totalCourses"
                    sublabel="Katalog Soal"
                    :href="route('dashboard.courses.index')"
                    link-text="Kelola modul kursus"
                    theme="teacher"
                >
                    <template #icon>
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.168.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.168.477-4.5 1.253" />
                        </svg>
                    </template>
                </MetricCard>

                <!-- Total Students -->
                <MetricCard
                    title="Total Siswa Terdaftar"
                    :value="metrics.totalStudents"
                    sublabel="Peserta Didik"
                    :href="route('dashboard.students.index')"
                    link-text="Lihat direktori siswa"
                    theme="student"
                >
                    <template #icon>
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </template>
                </MetricCard>

                <!-- Assessments Completed -->
                <MetricCard
                    title="Sesi Ujian Selesai"
                    :value="metrics.assessmentsTaken"
                    sublabel="Riwayat Asesmen"
                    :href="route('dashboard.analytics')"
                    link-text="Buka analisis nilai"
                    theme="emerald"
                >
                    <template #icon>
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </template>
                </MetricCard>
            </div>

            <!-- Quick Access Navigation & Information Architecture -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Quick Link 1 -->
                <Link
                    :href="route('dashboard.courses.index')"
                    class="p-6 bg-white dark:bg-[#111116] border border-slate-200/80 dark:border-slate-800 rounded-3xl hover:border-slate-300 dark:hover:border-slate-700 transition-all flex items-start gap-4 group"
                >
                    <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-600 dark:text-slate-300 group-hover:bg-[#D95300] group-hover:text-white transition-all shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <h2 class="text-base font-bold text-[#0A090B] dark:text-white group-hover:text-[#D95300] transition-colors">Bank Soal &amp; Kursus</h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">Kelola pertanyaan pilihan ganda, kunci jawaban, dan alokasi durasi ujian.</p>
                    </div>
                </Link>

                <!-- Quick Link 2 -->
                <Link
                    :href="route('dashboard.students.index')"
                    class="p-6 bg-white dark:bg-[#111116] border border-slate-200/80 dark:border-slate-800 rounded-3xl hover:border-slate-300 dark:hover:border-slate-700 transition-all flex items-start gap-4 group"
                >
                    <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-600 dark:text-slate-300 group-hover:bg-[#2B82FE] group-hover:text-white transition-all shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <h2 class="text-base font-bold text-[#0A090B] dark:text-white group-hover:text-[#2B82FE] transition-colors">Daftar &amp; Status Siswa</h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">Pencarian siswa aktif, pemantauan hak akses akun, dan verifikasi status belajar.</p>
                    </div>
                </Link>

                <!-- Quick Link 3 -->
                <Link
                    :href="route('dashboard.analytics')"
                    class="p-6 bg-white dark:bg-[#111116] border border-slate-200/80 dark:border-slate-800 rounded-3xl hover:border-slate-300 dark:hover:border-slate-700 transition-all flex items-start gap-4 group"
                >
                    <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-600 dark:text-slate-300 group-hover:bg-emerald-600 group-hover:text-white transition-all shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <h2 class="text-base font-bold text-[#0A090B] dark:text-white group-hover:text-emerald-500 transition-colors">Statistik &amp; Distribusi Nilai</h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">Visualisasi tren kelulusan, skor rata-rata, dan evaluasi hasil ujian menyeluruh.</p>
                    </div>
                </Link>
            </div>
        </div>
    </AdminLayout>
</template>
