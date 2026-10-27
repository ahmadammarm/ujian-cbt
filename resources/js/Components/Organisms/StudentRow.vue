<script setup>
import GhostButton from '@/Components/Atoms/GhostButton.vue';
import ScoreMark from '@/Components/Atoms/ScoreMark.vue';
import StatusBadge from '@/Components/Atoms/StatusBadge.vue';

defineProps({
    student: {
        type: Object,
        required: true,
    },
});

defineEmits(['toggle-suspension']);
</script>

<template>
    <div class="flex flex-col gap-4 px-4 py-4 sm:flex-row sm:items-center sm:px-5">
        <div class="flex min-w-0 flex-1 items-center gap-4">
            <span class="flex size-10 shrink-0 items-center justify-center rounded-full bg-rule/60 font-hand text-lg font-bold text-ink">
                {{ student.name.charAt(0).toUpperCase() }}
            </span>
            <div class="min-w-0">
                <p class="truncate font-bold text-ink">{{ student.name }}</p>
                <p class="truncate text-sm text-ink-soft">{{ student.email }}</p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-x-6 gap-y-3">
            <div class="w-24">
                <p class="font-form text-[10px] font-semibold uppercase tracking-[0.14em] text-ink-soft">Kursus</p>
                <p class="font-bold text-ink">{{ student.courses_count }}</p>
            </div>
            <div class="flex w-28 items-center gap-2">
                <ScoreMark v-if="student.assessments_avg_score !== null" :score="student.assessments_avg_score" size="sm" />
                <div>
                    <p class="font-form text-[10px] font-semibold uppercase tracking-[0.14em] text-ink-soft">Rata-rata</p>
                    <p v-if="student.assessments_avg_score === null" class="text-sm text-ink-soft">Belum ada</p>
                </div>
            </div>
            <StatusBadge :active="!!student.is_active" class="w-24 justify-center">
                {{ student.is_active ? 'Aktif' : 'Nonaktif' }}
            </StatusBadge>
            <GhostButton
                size="sm"
                :variant="student.is_active ? 'danger' : 'ink'"
                class="w-28"
                @click="$emit('toggle-suspension', student)"
            >
                {{ student.is_active ? 'Nonaktifkan' : 'Aktifkan' }}
            </GhostButton>
        </div>
    </div>
</template>
