<script setup>
import StudentLayout from '@/Components/Templates/StudentLayout.vue';
import CourseThumbnail from '@/Components/Atoms/CourseThumbnail.vue';
import MetricCard from '@/Components/Molecules/MetricCard.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    courses: Array,
    assessments: Array,
});

const getLatestScore = (courseId) => {
    const assessment = props.assessments.find(a => a.course_id === courseId);
    return assessment ? assessment.score : null;
};
</script>

<template>
    <Head title="Dasbor Siswa" />

    <StudentLayout>
        <div class="flex flex-col gap-10">
            <!-- Welcome Header -->
            <div class="flex flex-col gap-2">
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-[#2B82FE]/10 text-[#2B82FE] border border-[#2B82FE]/20 tracking-wider uppercase">
                        Portal Siswa
                    </span>
                    <span class="text-xs font-semibold text-slate-400 dark:text-slate-500">Ruang Asesmen Terintegrasi</span>
                </div>
                <h1 class="text-3xl lg:text-4xl font-extrabold text-[#0A090B] dark:text-white tracking-tight">
                    Selamat Datang, {{ $page.props.auth.user.name }}
                </h1>
                <p class="text-sm lg:text-base text-slate-500 dark:text-slate-400 max-w-2xl">
                    Pantau progres pembelajaran, evaluasi hasil ujian, dan ikuti simulasi CBT terjadwal Anda di sini.
                </p>
            </div>

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Enrolled Courses -->
                <MetricCard
                    title="Kursus Diikuti"
                    :value="courses.length"
                    sublabel="Kurikulum"
                    :href="route('dashboard.learning.index')"
                    link-text="Buka modul belajar"
                    theme="student"
                >
                    <template #icon>
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.168.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.168.477-4.5 1.253" />
                        </svg>
                    </template>
                </MetricCard>

                <!-- Completed Assessments -->
                <MetricCard
                    title="Ujian Selesai"
                    :value="assessments.filter(a => a.finished_at).length"
                    sublabel="Penyelesaian"
                    footer-text="Dari total asesmen yang ditugaskan"
                    theme="emerald"
                >
                    <template #icon>
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </template>
                </MetricCard>

                <!-- Average Score -->
                <MetricCard
                    title="Skor Kumulatif"
                    :value="`${assessments.length > 0 ? Math.round(assessments.reduce((acc, a) => acc + (a.score || 0), 0) / assessments.length) : 0}%`"
                    sublabel="Rata-Rata"
                    footer-text="Ambang batas kompetensi standar: 70%"
                    theme="amber"
                >
                    <template #icon>
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </template>
                </MetricCard>
            </div>

            <!-- Recent Assessments -->
            <div class="flex flex-col gap-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-[#0A090B] dark:text-white tracking-tight">Riwayat Ujian Terakhir</h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Daftar sesi asesmen yang telah dikerjakan beserta status kelulusan</p>
                    </div>
                    <Link :href="route('dashboard.learning.index')" class="text-[#2B82FE] font-bold text-xs hover:underline flex items-center gap-1">
                        Lihat Seluruh Kursus
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </Link>
                </div>

                <div v-if="assessments.length > 0" class="flex flex-col gap-3">
                    <div
                        v-for="assessment in assessments.slice(0, 5)"
                        :key="assessment.id"
                        class="bg-white dark:bg-[#111116] border border-slate-200/80 dark:border-slate-800 p-5 rounded-2xl flex items-center justify-between hover:border-[#2B82FE]/40 dark:hover:border-[#2B82FE]/40 transition-colors group"
                    >
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center overflow-hidden border border-slate-100 dark:border-slate-700 shrink-0">
                                <CourseThumbnail
                                    :src="assessment.course.cover"
                                    :name="assessment.course.name"
                                    theme="student"
                                    monogramClass="text-base"
                                />
                            </div>
                            <div class="flex flex-col">
                                <p class="font-bold text-base text-[#0A090B] dark:text-white group-hover:text-[#2B82FE] transition-colors line-clamp-1">
                                    {{ assessment.course.name }}
                                </p>
                                <p class="text-xs text-slate-400 dark:text-slate-500 font-medium">
                                    Diselesaikan pada {{ new Date(assessment.created_at).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' }) }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-6">
                            <div class="flex flex-col text-right">
                                <p class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider">Nilai Akhir</p>
                                <p class="text-xl font-extrabold" :class="assessment.score >= 70 ? 'text-emerald-500' : 'text-rose-500'">
                                    {{ assessment.score }}%
                                </p>
                            </div>
                            <Link
                                :href="route('dashboard.learning.report', assessment.id)"
                                class="px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-xl font-bold text-xs hover:bg-[#2B82FE] hover:text-white transition-all flex items-center gap-1.5"
                            >
                                <span>Lihat Rapor</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                            </Link>
                        </div>
                    </div>
                </div>

                <div v-else class="p-16 bg-white dark:bg-[#111116] rounded-3xl border-2 border-dashed border-slate-200 dark:border-slate-800 text-center">
                    <div class="w-16 h-16 bg-slate-100 dark:bg-slate-800 rounded-2xl shadow-xs flex items-center justify-center mx-auto mb-4 text-slate-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.168.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.168.477-4.5 1.253" />
                        </svg>
                    </div>
                    <p class="text-base font-bold text-[#0A090B] dark:text-white">Belum Ada Riwayat Ujian</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 max-w-sm mx-auto">Mulai ikuti modul kursus untuk mengikuti ujian dan mencatat sertifikat evaluasi Anda.</p>
                    <Link :href="route('dashboard.learning.index')" class="mt-6 inline-flex px-6 py-3 bg-[#2B82FE] hover:bg-blue-600 text-white rounded-xl font-bold text-xs uppercase tracking-wider transition-colors active:scale-95">
                        Buka Katalog Kursus
                    </Link>
                </div>
            </div>
        </div>
    </StudentLayout>
</template>
