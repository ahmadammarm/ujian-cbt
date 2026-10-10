<script setup>
import AdminLayout from '@/Components/Templates/AdminLayout.vue';
import Breadcrumbs from '@/Components/Molecules/Breadcrumbs.vue';
import { Head } from '@inertiajs/vue3';
import { Line, Bar, Doughnut } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, LineElement, CategoryScale, LinearScale, PointElement, BarElement, ArcElement } from 'chart.js';

ChartJS.register(Title, Tooltip, Legend, LineElement, CategoryScale, LinearScale, PointElement, BarElement, ArcElement);

const props = defineProps({
    enrollmentTrends: Array,
    coursePerformance: Array,
    passFailRatio: Object,
});

const enrollmentData = {
    labels: props.enrollmentTrends.map(t => t.month),
    datasets: [{
        label: 'Siswa Baru',
        data: props.enrollmentTrends.map(t => t.count),
        borderColor: '#D95300',
        backgroundColor: 'rgba(217, 83, 0, 0.12)',
        fill: true,
        tension: 0.4
    }]
};

const performanceData = {
    labels: props.coursePerformance.map((c, index) => `#${index + 1} ${c.name}`),
    datasets: [{
        label: 'Rata-Rata Nilai (%)',
        data: props.coursePerformance.map(c => c.avg_score),
        backgroundColor: props.coursePerformance.map((_, index) => index === 0 ? '#D95300' : '#2B82FE'),
        borderRadius: 8,
    }]
};

const passFailData = {
    labels: ['Lulus (>= 70%)', 'Belum Lulus (< 70%)'],
    datasets: [{
        data: [props.passFailRatio.passed, props.passFailRatio.failed],
        backgroundColor: ['#10B981', '#F43F5E'],
        borderWidth: 0,
    }]
};

const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            display: false
        }
    }
};
</script>

<template>
    <Head title="Analitik Nilai" />

    <AdminLayout>
        <Breadcrumbs :items="[
            { label: 'Naiju Studio', href: route('dashboard.overview') },
            { label: 'Analitik Nilai' }
        ]" />

        <div class="flex flex-col gap-2 animate-slide-up">
            <div class="flex flex-col gap-2 mb-8">
                <h1 class="font-black text-3xl lg:text-4xl tracking-tight text-[#0A090B] dark:text-white leading-tight">
                    Analitik Asesmen & Tren Siswa
                </h1>
                <p class="text-slate-500 dark:text-slate-400 font-medium text-base">
                    Visualisasi data real-time capaian kelulusan, keterlibatan peserta, dan skor rata-rata materi ujian.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 pb-20">
                <!-- Enrollment Trend -->
                <div class="bg-white dark:bg-[#111116] p-7 lg:p-8 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-xs">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-lg font-bold text-[#0A090B] dark:text-white">Tren Pendaftaran Siswa</h2>
                            <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">Pertumbuhan peserta didik per bulan</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-[#D95300]/10 text-[#D95300] uppercase tracking-wider">
                            Akumulasi Bulanan
                        </span>
                    </div>
                    <div class="h-64">
                        <Line :data="enrollmentData" :options="chartOptions" />
                    </div>
                </div>

                <!-- Pass/Fail Ratio -->
                <div class="bg-white dark:bg-[#111116] p-7 lg:p-8 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-xs">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-lg font-bold text-[#0A090B] dark:text-white">Rasio Kelulusan Asesmen</h2>
                            <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">Perbandingan peserta lulus vs remidial</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 uppercase tracking-wider">
                            Standar KKM 70%
                        </span>
                    </div>
                    <div class="h-64 relative flex items-center justify-center">
                        <Doughnut :data="passFailData" :options="{ ...chartOptions, plugins: { legend: { display: true, position: 'bottom' } } }" />
                    </div>
                </div>

                <!-- Course Performance -->
                <div class="lg:col-span-2 bg-white dark:bg-[#111116] p-7 lg:p-8 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-xs">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-6">
                        <div>
                            <h2 class="text-lg font-bold text-[#0A090B] dark:text-white">Performa Rata-Rata Kursus Teratas</h2>
                            <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">Daftar kursus dengan peserta terbanyak beserta rata-rata skor evaluasi</p>
                        </div>
                        <span class="px-3.5 py-1.5 bg-slate-100 dark:bg-slate-800 rounded-xl text-[10px] font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 self-start sm:self-auto">
                            5 Kursus Paling Populer
                        </span>
                    </div>
                    <div class="h-80">
                        <Bar :data="performanceData" :options="chartOptions" />
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<style scoped>
@keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
.animate-slide-up { animation: slideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
</style>