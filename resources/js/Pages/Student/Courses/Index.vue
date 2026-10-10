<script setup>
import StudentLayout from '@/Components/Templates/StudentLayout.vue';
import CourseThumbnail from '@/Components/Atoms/CourseThumbnail.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    courses: {
        type: Array,
        default: () => [],
    },
});

const searchQuery = ref('');

const filteredCourses = computed(() => {
    if (!searchQuery.value.trim()) {
        return props.courses;
    }
    const q = searchQuery.value.toLowerCase();
    return props.courses.filter(course =>
        course.name.toLowerCase().includes(q) ||
        (course.category && course.category.name.toLowerCase().includes(q))
    );
});
</script>

<template>
    <Head title="Katalog Modul Ujian & Asesmen · Naiju Exam" />

    <StudentLayout>
        <div class="max-w-7xl mx-auto pb-20 flex flex-col gap-8">
            <!-- Header Section: Editorial & Industrial CBT -->
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-6 border-b border-slate-200/80 dark:border-slate-800 pb-8 animate-fade-in">
                <div class="flex flex-col gap-2">
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded text-[10px] font-extrabold uppercase tracking-widest bg-[#2B82FE]/10 text-[#2B82FE] border border-[#2B82FE]/20">
                            Portal Siswa
                        </span>
                        <span class="text-xs font-semibold text-slate-400 dark:text-slate-500">Materi Terverifikasi</span>
                    </div>
                    <h1 class="text-3xl lg:text-4xl font-black text-[#0A090B] dark:text-white tracking-tight leading-tight">
                        Katalog Modul Ujian CBT
                    </h1>
                    <p class="text-xs lg:text-sm text-slate-500 dark:text-slate-400 max-w-2xl font-medium">
                        Pilih modul kurikulum untuk memulai ujian evaluasi mandiri atau melihat rekap nilai kelulusan asesmen sebelumnya.
                    </p>
                </div>

                <div class="flex items-center gap-4 text-xs font-semibold text-slate-400 dark:text-slate-500 shrink-0">
                    <div class="px-3.5 py-1.5 rounded-xl bg-slate-100 dark:bg-[#141419] border border-slate-200/80 dark:border-slate-800">
                        Total Modul: <span class="text-[#2B82FE] font-bold">{{ courses.length }}</span>
                    </div>
                </div>
            </div>

            <!-- Search & Filter Bar -->
            <div class="w-full flex flex-col sm:flex-row items-center justify-between gap-4 p-4 bg-white dark:bg-[#111116] border border-slate-200/80 dark:border-slate-800 rounded-2xl">
                <div class="w-full sm:w-80 relative">
                    <input
                        type="text"
                        v-model="searchQuery"
                        placeholder="Cari nama modul atau kategori..."
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-[#141419] border border-slate-200 dark:border-slate-700/80 rounded-xl text-slate-800 dark:text-slate-200 text-xs font-semibold placeholder-slate-400 focus:outline-none focus:border-[#2B82FE] transition-colors"
                    />
                    <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>

                <div class="text-xs font-semibold text-slate-400 dark:text-slate-500 self-end sm:self-auto">
                    Menampilkan <span class="font-bold text-[#0A090B] dark:text-white">{{ filteredCourses.length }}</span> dari {{ courses.length }} modul
                </div>
            </div>

            <!-- Modul Asesmen Presisi Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div
                    v-for="course in filteredCourses"
                    :key="course.id"
                    class="flex flex-col bg-white dark:bg-[#111116] border border-slate-200/80 dark:border-slate-800 rounded-3xl overflow-hidden hover:border-slate-300 dark:hover:border-slate-700 transition-colors group"
                >
                    <!-- 16:9 Aspect Ratio Thumbnail with Solid Border -->
                    <div class="relative w-full aspect-video overflow-hidden bg-slate-100 dark:bg-slate-800 border-b border-slate-200/80 dark:border-slate-800">
                        <CourseThumbnail
                            :src="course.cover"
                            :name="course.name"
                            theme="student"
                            imgClass="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                            monogramClass="text-3xl"
                        />

                        <!-- Solid Category Badge (Zero Blur) -->
                        <div class="absolute top-3.5 left-3.5" v-if="course.category">
                            <span class="bg-white dark:bg-[#0A090B] text-slate-800 dark:text-slate-200 text-[10px] font-extrabold uppercase tracking-wider px-2.5 py-1 rounded-lg border border-slate-200 dark:border-slate-700">
                                {{ course.category.name }}
                            </span>
                        </div>

                        <!-- Question Count Badge -->
                        <div class="absolute bottom-3.5 right-3.5">
                            <span class="bg-[#0A090B]/90 text-white text-[10px] font-bold px-2.5 py-1 rounded-lg border border-white/10">
                                {{ course.questions_count }} Butir Soal
                            </span>
                        </div>
                    </div>

                    <!-- Content Details -->
                    <div class="p-6 flex flex-col flex-1 justify-between gap-5">
                        <div class="space-y-2">
                            <h3 class="text-base font-bold text-[#0A090B] dark:text-white group-hover:text-[#2B82FE] dark:group-hover:text-[#2B82FE] transition-colors line-clamp-2 leading-snug">
                                {{ course.name }}
                            </h3>
                            <p class="text-xs text-slate-400 dark:text-slate-500 font-medium">
                                Standar KKM Kelulusan: <span class="font-bold text-slate-600 dark:text-slate-300">70%</span>
                            </p>
                        </div>

                        <!-- Assessment History Status -->
                        <div v-if="course.latest_assessment" class="p-3.5 bg-slate-50 dark:bg-[#141419] rounded-2xl border border-slate-200/60 dark:border-slate-800 flex items-center justify-between text-xs">
                            <div>
                                <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider block">Skor Terakhir</span>
                                <span class="text-base font-black" :class="course.latest_assessment.score >= 70 ? 'text-emerald-500' : 'text-[#D95300]'">
                                    {{ course.latest_assessment.score ?? 0 }}%
                                </span>
                            </div>
                            <div class="text-right">
                                <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider block">Hasil Evaluasi</span>
                                <span
                                    class="inline-block text-[10px] font-extrabold uppercase tracking-wider px-2 py-0.5 rounded"
                                    :class="course.latest_assessment.score >= 70
                                        ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20'
                                        : 'bg-[#D95300]/10 text-[#D95300] border border-[#D95300]/20'"
                                >
                                    {{ course.latest_assessment.score >= 70 ? 'Lulus KKM' : 'Perlu Remidial' }}
                                </span>
                            </div>
                        </div>

                        <div v-else class="p-3.5 bg-slate-50 dark:bg-[#141419] rounded-2xl border border-slate-200/60 dark:border-slate-800 flex items-center justify-between text-xs">
                            <div class="flex items-center gap-2 text-slate-400 dark:text-slate-500">
                                <span class="w-2 h-2 rounded-full bg-slate-300 dark:bg-slate-600"></span>
                                <span class="font-semibold text-[11px]">Belum Ada Riwayat Ujian</span>
                            </div>
                            <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase">Siap Diikuti</span>
                        </div>

                        <!-- Solid Action Buttons (Zero Glowing Shadow) -->
                        <div class="flex items-center gap-2.5 pt-2">
                            <Link
                                :href="route('dashboard.learning.start', course.id)"
                                method="post"
                                as="button"
                                class="flex-1 inline-flex justify-center items-center px-5 py-3 bg-[#0A090B] dark:bg-white text-white dark:text-[#0A090B] rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-[#2B82FE] dark:hover:bg-[#2B82FE] dark:hover:text-white transition-colors"
                            >
                                {{ course.latest_assessment ? 'Ujian Ulang' : 'Mulai Ujian' }}
                            </Link>

                            <Link
                                v-if="course.latest_assessment"
                                :href="route('dashboard.learning.report', course.latest_assessment.id)"
                                title="Lihat Laporan Evaluasi"
                                class="w-10 h-10 flex items-center justify-center bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-xl hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors shrink-0"
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
            <div v-if="filteredCourses.length === 0" class="flex flex-col items-center justify-center py-20 bg-white dark:bg-[#111116] border border-slate-200/80 dark:border-slate-800 rounded-3xl text-center">
                <div class="w-14 h-14 bg-slate-100 dark:bg-slate-800 rounded-2xl flex items-center justify-center mb-4 text-slate-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.168.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.168.477-4.5 1.253" />
                    </svg>
                </div>
                <h3 class="text-base font-bold text-[#0A090B] dark:text-white">Tidak Ada Modul Kursus</h3>
                <p class="text-xs text-slate-400 dark:text-slate-500 mt-1 max-w-sm">
                    {{ searchQuery ? 'Tidak ada modul yang cocok dengan pencarian Anda.' : 'Belum ada modul kursus yang didaftarkan ke akun Anda.' }}
                </p>
            </div>
        </div>
    </StudentLayout>
</template>
