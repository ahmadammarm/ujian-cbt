<script setup>
import { computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import StudentLayout from '@/Components/Templates/StudentLayout.vue';
import GhostButton from '@/Components/Atoms/GhostButton.vue';
import Icon from '@/Components/Atoms/Icon.vue';
import InkButton from '@/Components/Atoms/InkButton.vue';
import ScoreMark from '@/Components/Atoms/ScoreMark.vue';
import TallyMarks from '@/Components/Atoms/TallyMarks.vue';
import PageHeader from '@/Components/Molecules/PageHeader.vue';
import { PASSING_SCORE, formatDateTime, isPassing } from '@/Utils/exam';

const EXCELLENT_SCORE = 90;

const SUBMITTED_REASON_LABELS = {
    normal: 'Kamu kirim sendiri',
    timeout: 'Waktu habis',
    violation_limit: 'Batas pelanggaran terlewati',
};

const props = defineProps({
    assessment: Object
});

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

const passed = computed(() => isPassing(props.assessment.score));
const violations = computed(() => props.assessment.violations_count || 0);
const verdict = computed(() => {
    if (props.assessment.score >= EXCELLENT_SCORE) return 'Hampir sempurna. Pertahankan!';
    if (passed.value) return 'Kamu lulus ujian ini.';
    return 'Belum lulus. Pelajari lagi materinya, lalu coba ujian ulang.';
});
</script>

<template>
    <Head :title="`Rapor: ${assessment.course.name}`" />

    <StudentLayout>
        <div class="flex flex-col gap-8">
            <PageHeader
                :eyebrow="assessment.course.category ? `Rapor · ${assessment.course.category.name}` : 'Rapor'"
                :title="assessment.course.name"
            />

            <div
                v-if="assessment.submitted_reason === 'violation_limit'"
                role="note"
                class="flex items-start gap-3 border-l-4 border-pen bg-pen/10 px-5 py-4 text-[15px] leading-7 text-pen"
            >
                <Icon name="alert" class="mt-1 size-5 shrink-0" />
                <p>
                    <span class="font-bold">Jawabanmu dikirim otomatis.</span>
                    Kamu melewati batas peringatan saat ujian. Nilai di bawah dihitung dari jawaban yang sudah terisi saat itu.
                </p>
            </div>

            <div class="grid overflow-hidden rounded-md border border-rule bg-paper md:grid-cols-5">
                <!-- Graded score -->
                <section class="flex flex-col items-center justify-center gap-5 border-b border-rule px-6 py-10 text-center md:col-span-2 md:border-b-0 md:border-r">
                    <ScoreMark :score="assessment.score" size="lg" />
                    <span
                        :class="[
                            'inline-block -rotate-6 border-[3px] px-4 py-1 font-form text-lg font-semibold uppercase tracking-[0.2em]',
                            passed ? 'border-ink text-ink' : 'border-pen text-pen',
                        ]"
                    >
                        {{ passed ? 'Lulus' : 'Remedial' }}
                    </span>
                    <p class="max-w-xs text-[15px] leading-7 text-ink-soft">{{ verdict }} Batas lulus {{ PASSING_SCORE }}.</p>
                </section>

                <!-- Details -->
                <section class="px-6 py-6 sm:px-8 md:col-span-3">
                    <h2 class="font-form text-[11px] font-semibold uppercase tracking-[0.16em] text-pen">Rincian</h2>
                    <dl class="mt-4 divide-y divide-dashed divide-rule">
                        <div class="flex flex-wrap justify-between gap-x-6 gap-y-1 py-3">
                            <dt class="text-ink-soft">Mulai</dt>
                            <dd class="font-bold">{{ formatDateTime(assessment.started_at) }}</dd>
                        </div>
                        <div class="flex flex-wrap justify-between gap-x-6 gap-y-1 py-3">
                            <dt class="text-ink-soft">Selesai</dt>
                            <dd class="font-bold">{{ formatDateTime(assessment.finished_at) }}</dd>
                        </div>
                        <div class="flex flex-wrap justify-between gap-x-6 gap-y-1 py-3">
                            <dt class="text-ink-soft">Lama mengerjakan</dt>
                            <dd class="font-bold">{{ getDuration() }}</dd>
                        </div>
                        <div class="flex flex-wrap justify-between gap-x-6 gap-y-1 py-3">
                            <dt class="text-ink-soft">Cara dikirim</dt>
                            <dd class="font-bold">{{ SUBMITTED_REASON_LABELS[assessment.submitted_reason] || '–' }}</dd>
                        </div>
                        <div class="flex flex-wrap items-center justify-between gap-x-6 gap-y-1 py-3">
                            <dt class="text-ink-soft">Pelanggaran</dt>
                            <dd class="flex items-center gap-3 font-bold">
                                <TallyMarks v-if="violations > 0" :count="violations" size="sm" tone="pen" />
                                {{ violations > 0 ? `${violations} kali` : 'Tidak ada' }}
                            </dd>
                        </div>
                    </dl>
                </section>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row">
                <InkButton
                    :href="route('dashboard.learning.start', assessment.course_id)"
                    method="post"
                    as="button"
                >
                    <Icon name="refresh" class="size-5" />
                    Ujian ulang
                </InkButton>
                <GhostButton :href="route('dashboard.learning.index')">Kembali ke ujian saya</GhostButton>
            </div>
        </div>
    </StudentLayout>
</template>
