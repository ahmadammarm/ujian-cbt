<script setup>
import { computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import { Line, Bar } from 'vue-chartjs';
import { Chart as ChartJS, Tooltip, LineElement, CategoryScale, LinearScale, PointElement, BarElement } from 'chart.js';
import AdminLayout from '@/Components/Templates/AdminLayout.vue';
import EmptyState from '@/Components/Molecules/EmptyState.vue';
import PageHeader from '@/Components/Molecules/PageHeader.vue';
import { CHART_COLORS, baseChartOptions } from '@/Utils/chartTheme';
import { PASSING_SCORE } from '@/Utils/exam';

ChartJS.register(Tooltip, LineElement, CategoryScale, LinearScale, PointElement, BarElement);

const MAX_SCORE = 100;

const props = defineProps({
    enrollmentTrends: Array,
    coursePerformance: Array,
    passFailRatio: Object,
});

// --- Enrollment trend: one series over time -> line with crosshair tooltip
const enrollmentData = computed(() => ({
    labels: props.enrollmentTrends.map((t) => t.month),
    datasets: [{
        label: 'Siswa baru',
        data: props.enrollmentTrends.map((t) => t.count),
        borderColor: CHART_COLORS.inkMark,
        backgroundColor: CHART_COLORS.inkMark,
        borderWidth: 2,
        pointRadius: 4,
        pointHoverRadius: 6,
        pointBorderColor: CHART_COLORS.paper,
        pointBorderWidth: 2,
        tension: 0.3,
    }],
}));

const enrollmentOptions = baseChartOptions({
    interaction: { mode: 'index', intersect: false },
});
enrollmentOptions.scales.y = {
    ...enrollmentOptions.scales.y,
    beginAtZero: true,
    ticks: { ...enrollmentOptions.scales.y.ticks, precision: 0 },
};
enrollmentOptions.scales.x = { ...enrollmentOptions.scales.x, grid: { display: false } };

// --- Course performance: magnitude per course -> horizontal bars, one hue, pass mark drawn as a rule
const performanceData = computed(() => ({
    labels: props.coursePerformance.map((c) => c.name),
    datasets: [{
        label: 'Rata-rata nilai',
        data: props.coursePerformance.map((c) => Math.round(Number(c.avg_score) || 0)),
        backgroundColor: CHART_COLORS.inkMark,
        borderRadius: 4,
        borderSkipped: 'start',
        maxBarThickness: 28,
    }],
}));

const performanceOptions = baseChartOptions({ indexAxis: 'y' });
performanceOptions.scales.x = { ...performanceOptions.scales.x, min: 0, max: MAX_SCORE };
performanceOptions.scales.y = { ...performanceOptions.scales.y, grid: { display: false } };
performanceOptions.plugins.tooltip.callbacks = {
    label: (context) => {
        const course = props.coursePerformance[context.dataIndex];
        return [`Rata-rata nilai: ${context.parsed.x}`, `Siswa terdaftar: ${course.enrollment_count}`];
    },
};

const passLinePlugin = {
    id: 'passLine',
    afterDatasetsDraw(chart) {
        const { ctx, chartArea, scales } = chart;
        const x = scales.x.getPixelForValue(PASSING_SCORE);
        ctx.save();
        ctx.strokeStyle = CHART_COLORS.pen;
        ctx.lineWidth = 2;
        ctx.setLineDash([5, 4]);
        ctx.beginPath();
        ctx.moveTo(x, chartArea.top);
        ctx.lineTo(x, chartArea.bottom);
        ctx.stroke();
        ctx.restore();
    },
};

// --- Pass/fail: two parts of a whole -> numbers plus a labelled 100% bar, not a chart
const totalGraded = computed(() => props.passFailRatio.passed + props.passFailRatio.failed);
const passedPercent = computed(() =>
    totalGraded.value > 0 ? Math.round((props.passFailRatio.passed / totalGraded.value) * 100) : 0
);
const failedPercent = computed(() => (totalGraded.value > 0 ? 100 - passedPercent.value : 0));
</script>

<template>
    <Head title="Analitik" />

    <AdminLayout>
        <div class="flex flex-col gap-8">
            <PageHeader
                eyebrow="Analitik"
                title="Bagaimana ujiannya berjalan."
                description="Data dari seluruh platform: pendaftaran siswa, nilai per kursus, dan kelulusan."
            />

            <!-- Pass / fail -->
            <section aria-labelledby="kelulusan-heading" class="rounded-md border border-rule bg-paper p-5 sm:p-6">
                <h2 id="kelulusan-heading" class="text-lg font-bold text-ink">Kelulusan</h2>
                <p class="text-sm text-ink-soft">Ujian yang sudah dinilai, dengan batas lulus {{ PASSING_SCORE }}.</p>

                <template v-if="totalGraded > 0">
                    <dl class="mt-5 grid grid-cols-2 gap-4 sm:max-w-md">
                        <div>
                            <dt class="flex items-center gap-2 font-form text-[11px] font-semibold uppercase tracking-[0.14em] text-ink-soft">
                                <span class="size-3 rounded-sm bg-ink-mark"></span>
                                Lulus
                            </dt>
                            <dd class="mt-1 text-3xl font-bold text-ink">{{ passFailRatio.passed }} <span class="text-base font-normal text-ink-soft">({{ passedPercent }}%)</span></dd>
                        </div>
                        <div>
                            <dt class="flex items-center gap-2 font-form text-[11px] font-semibold uppercase tracking-[0.14em] text-ink-soft">
                                <span class="size-3 rounded-sm bg-pen"></span>
                                Remedial
                            </dt>
                            <dd class="mt-1 text-3xl font-bold text-ink">{{ passFailRatio.failed }} <span class="text-base font-normal text-ink-soft">({{ failedPercent }}%)</span></dd>
                        </div>
                    </dl>
                    <div class="mt-5 flex h-4 gap-0.5 overflow-hidden rounded" aria-hidden="true">
                        <div v-if="passFailRatio.passed > 0" class="h-full rounded-l bg-ink-mark" :style="{ width: `${passedPercent}%` }"></div>
                        <div v-if="passFailRatio.failed > 0" class="h-full rounded-r bg-pen" :style="{ width: `${failedPercent}%` }"></div>
                    </div>
                </template>
                <p v-else class="mt-5 text-ink-soft">Belum ada ujian yang dinilai.</p>
            </section>

            <div class="grid gap-6 xl:grid-cols-2">
                <!-- Enrollment trend -->
                <section aria-labelledby="pendaftaran-heading" class="rounded-md border border-rule bg-paper p-5 sm:p-6">
                    <h2 id="pendaftaran-heading" class="text-lg font-bold text-ink">Siswa baru per bulan</h2>
                    <p class="text-sm text-ink-soft">Jumlah akun siswa yang dibuat tiap bulan.</p>

                    <template v-if="enrollmentTrends.length > 0">
                        <div class="mt-5 h-64">
                            <Line :data="enrollmentData" :options="enrollmentOptions" aria-label="Grafik garis siswa baru per bulan" role="img" />
                        </div>
                        <details class="mt-4 text-sm">
                            <summary class="cursor-pointer font-bold text-ink-soft hover:text-ink">Lihat sebagai tabel</summary>
                            <table class="mt-3 w-full text-left">
                                <thead>
                                    <tr class="border-b border-rule font-form text-[11px] uppercase tracking-[0.14em] text-ink-soft">
                                        <th class="py-2 font-semibold">Bulan</th>
                                        <th class="py-2 text-right font-semibold">Siswa baru</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-dashed divide-rule">
                                    <tr v-for="trend in enrollmentTrends" :key="trend.month">
                                        <td class="py-2">{{ trend.month }}</td>
                                        <td class="py-2 text-right font-bold tabular-nums">{{ trend.count }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </details>
                    </template>
                    <EmptyState v-else class="mt-5" icon="users" title="Belum ada data." description="Grafik muncul setelah ada siswa yang mendaftar." />
                </section>

                <!-- Course performance -->
                <section aria-labelledby="performa-heading" class="rounded-md border border-rule bg-paper p-5 sm:p-6">
                    <h2 id="performa-heading" class="text-lg font-bold text-ink">Rata-rata nilai per kursus</h2>
                    <p class="flex flex-wrap items-center gap-x-2 text-sm text-ink-soft">
                        5 kursus dengan siswa terbanyak.
                        <span class="inline-flex items-center gap-1.5"><span class="inline-block h-0 w-5 border-t-2 border-dashed border-pen"></span> batas lulus {{ PASSING_SCORE }}</span>
                    </p>

                    <template v-if="coursePerformance.length > 0">
                        <div class="mt-5 h-64">
                            <Bar :data="performanceData" :options="performanceOptions" :plugins="[passLinePlugin]" aria-label="Grafik batang rata-rata nilai per kursus" role="img" />
                        </div>
                        <details class="mt-4 text-sm">
                            <summary class="cursor-pointer font-bold text-ink-soft hover:text-ink">Lihat sebagai tabel</summary>
                            <table class="mt-3 w-full text-left">
                                <thead>
                                    <tr class="border-b border-rule font-form text-[11px] uppercase tracking-[0.14em] text-ink-soft">
                                        <th class="py-2 font-semibold">Kursus</th>
                                        <th class="py-2 text-right font-semibold">Siswa</th>
                                        <th class="py-2 text-right font-semibold">Rata-rata</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-dashed divide-rule">
                                    <tr v-for="course in coursePerformance" :key="course.name">
                                        <td class="py-2 pr-4">{{ course.name }}</td>
                                        <td class="py-2 text-right tabular-nums">{{ course.enrollment_count }}</td>
                                        <td class="py-2 text-right font-bold tabular-nums">{{ Math.round(Number(course.avg_score) || 0) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </details>
                    </template>
                    <EmptyState v-else class="mt-5" icon="chart" title="Belum ada data." description="Grafik muncul setelah ada kursus dengan siswa terdaftar." />
                </section>
            </div>
        </div>
    </AdminLayout>
</template>
