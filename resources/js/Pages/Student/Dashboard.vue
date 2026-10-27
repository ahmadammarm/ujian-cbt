<script setup>
import { computed } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import StudentLayout from '@/Components/Templates/StudentLayout.vue';
import CourseThumbnail from '@/Components/Atoms/CourseThumbnail.vue';
import Icon from '@/Components/Atoms/Icon.vue';
import InkButton from '@/Components/Atoms/InkButton.vue';
import PenLink from '@/Components/Atoms/PenLink.vue';
import ScoreMark from '@/Components/Atoms/ScoreMark.vue';
import StatusBadge from '@/Components/Atoms/StatusBadge.vue';
import EmptyState from '@/Components/Molecules/EmptyState.vue';
import MetricCard from '@/Components/Molecules/MetricCard.vue';
import PageHeader from '@/Components/Molecules/PageHeader.vue';
import { PASSING_SCORE, formatDate, isPassing } from '@/Utils/exam';

const RECENT_LIMIT = 5;

const props = defineProps({
    courses: Array,
    assessments: Array,
});

const page = usePage();
const firstName = computed(() => page.props.auth.user.name.split(' ')[0]);
const today = formatDate(new Date(), { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });

const finishedCount = computed(() => props.assessments.filter((a) => a.finished_at).length);
const averageScore = computed(() =>
    props.assessments.length > 0
        ? Math.round(props.assessments.reduce((acc, a) => acc + (a.score || 0), 0) / props.assessments.length)
        : 0
);
const recentAssessments = computed(() => props.assessments.slice(0, RECENT_LIMIT));
</script>

<template>
    <Head title="Beranda" />

    <StudentLayout>
        <div class="flex flex-col gap-10">
            <PageHeader
                :eyebrow="today"
                :title="`Halo, ${firstName}.`"
                description="Ini ringkasan ujianmu sejauh ini."
            />

            <div class="grid gap-4 sm:grid-cols-3">
                <MetricCard
                    title="Mapel diikuti"
                    :value="courses.length"
                    :href="route('dashboard.learning.index')"
                    link-text="Lihat ujian saya"
                >
                    <template #icon><Icon name="book" class="size-5" /></template>
                </MetricCard>
                <MetricCard
                    title="Ujian selesai"
                    :value="finishedCount"
                    :footer-text="`Dari ${assessments.length} kali mengerjakan`"
                >
                    <template #icon><Icon name="check" class="size-5" /></template>
                </MetricCard>
                <MetricCard
                    title="Rata-rata nilai"
                    :value="averageScore"
                    :footer-text="`Batas lulus ${PASSING_SCORE}`"
                >
                    <template #icon><Icon name="chart" class="size-5" /></template>
                </MetricCard>
            </div>

            <section aria-labelledby="riwayat-heading" class="flex flex-col gap-4">
                <div class="flex flex-wrap items-end justify-between gap-3">
                    <h2 id="riwayat-heading" class="text-xl font-bold text-ink">Riwayat nilai</h2>
                    <PenLink :href="route('dashboard.learning.index')" class="text-sm">Semua ujian</PenLink>
                </div>

                <ul v-if="recentAssessments.length > 0" class="divide-y divide-rule overflow-hidden rounded-md border border-rule bg-paper">
                    <li
                        v-for="assessment in recentAssessments"
                        :key="assessment.id"
                        class="flex flex-wrap items-center gap-4 px-4 py-4 sm:flex-nowrap sm:px-5"
                    >
                        <div class="size-12 shrink-0 overflow-hidden rounded-md border border-rule">
                            <CourseThumbnail :src="assessment.course.cover" :name="assessment.course.name" monogram-class="text-base" />
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="truncate font-bold text-ink">{{ assessment.course.name }}</p>
                            <p class="font-form text-xs text-ink-soft">Dikerjakan {{ formatDate(assessment.created_at) }}</p>
                        </div>
                        <div class="flex w-full items-center justify-between gap-4 sm:w-auto sm:justify-end">
                            <div class="flex items-center gap-3">
                                <template v-if="assessment.finished_at">
                                    <ScoreMark :score="assessment.score" size="sm" />
                                    <StatusBadge :variant="isPassing(assessment.score) ? 'success' : 'danger'">
                                        {{ isPassing(assessment.score) ? 'Lulus' : 'Remedial' }}
                                    </StatusBadge>
                                </template>
                                <StatusBadge v-else variant="warning">Belum selesai</StatusBadge>
                            </div>
                            <PenLink :href="route('dashboard.learning.report', assessment.id)" class="shrink-0 text-sm">Lihat rapor</PenLink>
                        </div>
                    </li>
                </ul>

                <EmptyState
                    v-else
                    icon="clipboard"
                    title="Belum ada nilai."
                    description="Nilai muncul di sini setelah kamu menyelesaikan ujian pertamamu."
                >
                    <InkButton :href="route('dashboard.learning.index')" size="sm">Buka ujian saya</InkButton>
                </EmptyState>
            </section>
        </div>
    </StudentLayout>
</template>
