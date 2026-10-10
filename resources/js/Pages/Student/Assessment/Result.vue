<script setup>
import StudentLayout from '@/Components/Templates/StudentLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    assessment: Object
});

const formatDate = (date) => {
    return new Date(date).toLocaleString('id-ID', {
        day: '2-digit',
        month: 'long',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
};

const getDuration = () => {
    const start = new Date(props.assessment.started_at);
    const end = new Date(props.assessment.finished_at);
    const diff = Math.max(0, end - start);

    const hours = Math.floor(diff / 3600000);
    const minutes = Math.floor((diff % 3600000) / 60000);
    const seconds = Math.floor((diff % 60000) / 1000);

    let result = '';
    if (hours > 0) result += `${hours} jam `;
    if (minutes > 0 || hours > 0) result += `${minutes} menit `;
    result += `${seconds} detik`;
    return result;
};
</script>

<template>
    <Head title="Rapor Hasil Ujian" />

    <StudentLayout>
        <div class="flex flex-col gap-10">
            <!-- Header Section -->
            <div class="flex flex-col gap-2">
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-[#2B82FE]/10 text-[#2B82FE] border border-[#2B82FE]/20 tracking-wider uppercase">
                        Rapor Asesmen Digital
                    </span>
                    <span class="text-xs font-semibold text-slate-400 dark:text-slate-500">Hasil Resmi Tersertifikasi</span>
                </div>
                <h1 class="text-3xl lg:text-4xl font-extrabold text-[#0A090B] dark:text-white tracking-tight">
                    Evaluasi Hasil Ujian
                </h1>
                <p class="text-sm lg:text-base text-slate-500 dark:text-slate-400 max-w-2xl">
                    Berikut adalah rekapitulasi capaian dan lembar penilaian digital untuk kursus <strong class="text-[#0A090B] dark:text-white">{{ assessment.course.name }}</strong>.
                </p>
            </div>

            <!-- Two-Column Result Layout -->
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Score Card Sidebar -->
                <div class="lg:w-[380px] flex flex-col gap-6 bg-white dark:bg-[#111116] border border-slate-200/80 dark:border-slate-800 rounded-3xl p-7 lg:p-8 h-fit shadow-xs">
                    <div class="flex flex-col items-center text-center gap-5">
                        <!-- Circular Score Ring -->
                        <div
                            class="w-36 h-36 rounded-full flex flex-col items-center justify-center border-8 transition-all duration-700 shadow-sm"
                            :class="assessment.score >= 70 ? 'border-emerald-500/20 bg-emerald-500/5 text-emerald-600 dark:text-emerald-400' : 'border-rose-500/20 bg-rose-500/5 text-rose-600 dark:text-rose-400'"
                        >
                            <span class="text-4xl font-black tracking-tight">{{ assessment.score }}%</span>
                            <span class="text-[10px] font-bold uppercase tracking-widest opacity-80 mt-1">Skor Akhir</span>
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <h3 class="text-2xl font-extrabold text-[#0A090B] dark:text-white">
                                {{ assessment.score >= 70 ? 'Selamat! Anda Lulus' : 'Remidial Disarankan' }}
                            </h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 font-medium leading-relaxed">
                                {{ assessment.score >= 70
                                    ? 'Capaian kompetensi Anda telah memenuhi standar ketuntasan minimal yang ditentukan.'
                                    : 'Skor Anda belum mencapai ambang batas 70%. Silakan pelajari kembali modul dan coba ujian ulang.'
                                }}
                            </p>
                        </div>
                    </div>

                    <!-- Meta Details -->
                    <div class="flex flex-col gap-3 pt-2">
                        <div class="flex items-center justify-between p-3.5 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-100 dark:border-slate-800">
                            <span class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Status Kelulusan</span>
                            <span class="text-xs font-extrabold px-2.5 py-1 rounded-lg" :class="assessment.score >= 70 ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' : 'bg-rose-500/10 text-rose-600 dark:text-rose-400'">
                                {{ assessment.score >= 70 ? 'LULUS TUNTAS' : 'BELUM TUNTAS' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between p-3.5 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-100 dark:border-slate-800">
                            <span class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Waktu Pengerjaan</span>
                            <span class="text-xs font-bold text-[#0A090B] dark:text-white">{{ getDuration() }}</span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col gap-2.5 pt-2">
                        <Link
                            :href="route('dashboard.learning.start', assessment.course_id)"
                            method="post"
                            as="button"
                            class="w-full py-3.5 bg-[#2B82FE] hover:bg-blue-600 text-white rounded-xl font-bold text-xs uppercase tracking-wider transition-colors active:scale-95 text-center"
                        >
                            Ikuti Ujian Ulang
                        </Link>
                        <Link
                            :href="route('dashboard.learning.index')"
                            class="w-full py-3.5 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 rounded-xl font-bold text-xs uppercase tracking-wider transition-all text-center"
                        >
                            Kembali ke Daftar Kursus
                        </Link>
                    </div>
                </div>

                <!-- Detailed Analysis Card -->
                <div class="flex-1 flex flex-col gap-6">
                    <div class="bg-white dark:bg-[#111116] border border-slate-200/80 dark:border-slate-800 rounded-3xl p-7 lg:p-8 flex flex-col gap-8 shadow-xs">
                        <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800/80">
                            <div>
                                <h2 class="text-xl font-bold text-[#0A090B] dark:text-white">Rincian Informasi Asesmen</h2>
                                <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">Metadata dan parameter penilaian sistem CBT</p>
                            </div>
                            <span class="text-xs font-mono font-bold text-slate-400 dark:text-slate-500">
                                ID: #{{ assessment.id }}
                            </span>
                        </div>

                        <!-- Grid Metadata -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="p-5 bg-slate-50 dark:bg-slate-800/40 rounded-2xl border border-slate-100 dark:border-slate-800 flex flex-col gap-2">
                                <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Kategori Bidang</span>
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-white dark:bg-slate-800 flex items-center justify-center text-[#2B82FE] shadow-xs">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                    </div>
                                    <span class="font-bold text-sm text-[#0A090B] dark:text-white">{{ assessment.course.category ? assessment.course.category.name : 'Umum' }}</span>
                                </div>
                            </div>

                            <div class="p-5 bg-slate-50 dark:bg-slate-800/40 rounded-2xl border border-slate-100 dark:border-slate-800 flex flex-col gap-2">
                                <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Waktu Selesai</span>
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-white dark:bg-slate-800 flex items-center justify-center text-emerald-500 shadow-xs">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <span class="font-bold text-sm text-[#0A090B] dark:text-white">{{ formatDate(assessment.finished_at) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Performance Gauge Section -->
                        <div class="pt-6 border-t border-slate-100 dark:border-slate-800/80 flex flex-col gap-5">
                            <h3 class="font-bold text-base text-[#0A090B] dark:text-white">Analisis Skala Penguasaan Materi</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                                Evaluasi ini dikalkulasi berdasarkan skala standardisasi asesmen otomatis 50 poin. Hasil skor <strong>{{ assessment.score }}%</strong> mencerminkan tingkat penguasaan kompetensi kategori
                                <strong class="text-[#0A090B] dark:text-white">{{ assessment.score >= 90 ? 'Sangat Baik (Mahir)' : (assessment.score >= 70 ? 'Baik (Kompeten)' : 'Perlu Bimbingan Tambahan') }}</strong>.
                            </p>

                            <div class="flex flex-col gap-2">
                                <div class="flex items-center justify-between text-xs font-bold">
                                    <span class="text-slate-400 dark:text-slate-500">Skor Dicapai: {{ assessment.score }}%</span>
                                    <span class="text-slate-400 dark:text-slate-500">Target KKM: 70%</span>
                                </div>
                                <div class="w-full h-3 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden relative">
                                    <div
                                        class="h-full transition-all duration-1000 rounded-full"
                                        :class="assessment.score >= 70 ? 'bg-emerald-500' : 'bg-rose-500'"
                                        :style="{ width: assessment.score + '%' }"
                                    ></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </StudentLayout>
</template>