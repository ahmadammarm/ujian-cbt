<script setup>
import StudentLayout from '@/Components/Templates/StudentLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    courses: Array
});
</script>

<template>
    <Head title="Katalog Kursus & Ujian · Naiju Exam" />

    <StudentLayout>
        <div class="flex flex-col gap-10">
            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                <div class="flex flex-col gap-2">
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-[#2B82FE]/10 text-[#2B82FE] border border-[#2B82FE]/20 tracking-wider uppercase">
                            Kurikulum Ujian
                        </span>
                        <span class="text-xs font-semibold text-slate-400 dark:text-slate-500">Materi Terverifikasi</span>
                    </div>
                    <h1 class="text-3xl lg:text-4xl font-extrabold text-[#0A090B] dark:text-white tracking-tight">
                        Daftar Kursus & Asesmen
                    </h1>
                    <p class="text-sm lg:text-base text-slate-500 dark:text-slate-400 max-w-2xl">
                        Pilih modul kursus untuk mengikuti ujian CBT secara mandiri atau meninjau evaluasi skor terdahulu.
                    </p>
                </div>
                <div class="text-xs font-bold text-slate-400 dark:text-slate-500">
                    Total: <span class="text-[#2B82FE] font-extrabold">{{ courses.length }}</span> Kursus
                </div>
            </div>

            <!-- Course Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div
                    v-for="course in courses"
                    :key="course.id"
                    class="flex flex-col bg-white dark:bg-[#111116] border border-slate-200/80 dark:border-slate-800 rounded-3xl overflow-hidden transition-all duration-300 hover:border-[#2B82FE]/40 dark:hover:border-[#2B82FE]/40 hover:shadow-lg hover:shadow-black/5 group"
                >
                    <!-- Thumbnail with Badge -->
                    <div class="relative w-full h-48 overflow-hidden bg-slate-100 dark:bg-slate-800">
                        <img
                            v-if="course.cover"
                            :src="'/storage/' + course.cover"
                            :alt="course.name"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                        >
                        <div v-else class="w-full h-full flex items-center justify-center bg-[#2B82FE]/10 text-[#2B82FE] font-black text-3xl">
                            {{ course.name.substring(0, 2).toUpperCase() }}
                        </div>
                        <div class="absolute top-4 left-4" v-if="course.category">
                            <span class="bg-white/95 dark:bg-[#111116]/95 backdrop-blur-md text-[#0A090B] dark:text-white text-xs font-bold px-3 py-1.5 rounded-xl border border-slate-200/60 dark:border-slate-800 shadow-xs">
                                {{ course.category.name }}
                            </span>
                        </div>
                    </div>

                    <!-- Content Card -->
                    <div class="p-6 flex flex-col flex-1 justify-between gap-6">
                        <div class="flex flex-col gap-2">
                            <h3 class="text-lg font-bold text-[#0A090B] dark:text-white group-hover:text-[#2B82FE] transition-colors line-clamp-1">
                                {{ course.name }}
                            </h3>
                            <div class="flex items-center gap-2 text-xs font-semibold text-slate-400 dark:text-slate-500">
                                <svg class="w-4 h-4 text-[#2B82FE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <span>{{ course.questions_count }} Pertanyaan Ujian</span>
                            </div>
                        </div>

                        <!-- Assessment Status Card -->
                        <div v-if="course.latest_assessment" class="p-3.5 bg-slate-50 dark:bg-slate-800/60 rounded-2xl border border-slate-100 dark:border-slate-800 flex items-center justify-between">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Skor Terakhir</span>
                                <span class="text-base font-extrabold" :class="course.latest_assessment.score >= 70 ? 'text-emerald-500' : 'text-[#D95300]'">
                                    {{ course.latest_assessment.score ?? '---' }}%
                                </span>
                            </div>
                            <div class="text-right">
                                <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Status</span>
                                <span class="inline-block text-xs font-extrabold px-2 py-0.5 rounded-md" :class="course.latest_assessment.score >= 70 ? 'bg-emerald-500/10 text-emerald-500' : 'bg-[#D95300]/10 text-[#D95300]'">
                                    {{ course.latest_assessment.score >= 70 ? 'LULUS' : 'REMIDIAL' }}
                                </span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center gap-2.5 mt-auto pt-2">
                            <Link
                                :href="route('dashboard.learning.start', course.id)"
                                method="post"
                                as="button"
                                class="flex-1 inline-flex justify-center items-center px-5 py-3.5 bg-[#0A090B] dark:bg-white text-white dark:text-[#0A090B] rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-[#2B82FE] dark:hover:bg-[#2B82FE] dark:hover:text-white transition-all duration-300 shadow-md shadow-black/5"
                            >
                                {{ course.latest_assessment ? 'Ujian Ulang' : 'Mulai Ujian' }}
                            </Link>
                            <Link
                                v-if="course.latest_assessment"
                                :href="route('dashboard.learning.report', course.latest_assessment.id)"
                                title="Lihat Laporan Hasil"
                                class="w-11 h-11 flex items-center justify-center bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200/80 dark:border-slate-700 rounded-xl hover:bg-[#2B82FE] hover:text-white hover:border-[#2B82FE] transition-all duration-300 shrink-0"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div v-if="courses.length === 0" class="flex flex-col items-center justify-center py-20 bg-white dark:bg-[#111116] border-2 border-dashed border-slate-200 dark:border-slate-800 rounded-3xl text-center">
                <div class="w-16 h-16 bg-slate-100 dark:bg-slate-800 rounded-2xl shadow-xs flex items-center justify-center mb-4 text-slate-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.168.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.168.477-4.5 1.253" />
                    </svg>
                </div>
                <h3 class="text-base font-bold text-[#0A090B] dark:text-white">Belum Ada Kursus Tersedia</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 max-w-sm">Hubungi pengajar atau administrator Anda untuk mendaftarkan modul ujian.</p>
            </div>
        </div>
    </StudentLayout>
</template>