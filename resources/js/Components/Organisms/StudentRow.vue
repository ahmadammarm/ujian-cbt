<script setup>
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
    <div
        class="group bg-white dark:bg-[#111116] p-5 lg:p-6 rounded-3xl border border-slate-200/80 dark:border-slate-800 hover:border-[#D95300]/40 dark:hover:border-[#D95300]/40 hover:shadow-lg hover:shadow-black/5 transition-all duration-300 flex flex-col lg:flex-row lg:items-center"
    >
        <!-- Student Info -->
        <div class="lg:w-[35%] flex items-center gap-4">
            <div class="w-11 h-11 rounded-2xl bg-[#D95300]/10 text-[#D95300] dark:bg-[#D95300]/20 flex items-center justify-center font-extrabold text-sm shrink-0">
                {{ student.name ? student.name.charAt(0).toUpperCase() : 'S' }}
            </div>
            <div class="flex flex-col min-w-0">
                <p class="font-bold text-sm text-[#0A090B] dark:text-white group-hover:text-[#D95300] transition-colors truncate">
                    {{ student.name }}
                </p>
                <p class="text-xs text-slate-400 dark:text-slate-500 truncate">
                    {{ student.email }}
                </p>
            </div>
        </div>

        <!-- Enrolled Courses -->
        <div class="mt-4 lg:mt-0 lg:w-[15%] flex flex-col items-center">
            <p class="font-extrabold text-base text-[#0A090B] dark:text-slate-200">{{ student.courses_count }}</p>
            <p class="text-[10px] font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Modul</p>
        </div>

        <!-- Average Score -->
        <div class="mt-4 lg:mt-0 lg:w-[20%] flex flex-col items-center">
            <p v-if="student.assessments_avg_score !== null" :class="['font-extrabold text-base', student.assessments_avg_score >= 70 ? 'text-emerald-500' : 'text-rose-500']">
                {{ Math.round(student.assessments_avg_score) }}%
            </p>
            <p v-else class="text-xs font-semibold text-slate-400 dark:text-slate-500 py-0.5">
                Belum Ada Ujian
            </p>
            <p class="text-[10px] font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Rata-Rata</p>
        </div>

        <!-- Status -->
        <div class="mt-4 lg:mt-0 lg:w-[15%] flex justify-center">
            <StatusBadge :active="student.is_active">
                {{ student.is_active ? 'Aktif' : 'Ditangguhkan' }}
            </StatusBadge>
        </div>

        <!-- Actions -->
        <div class="mt-4 lg:mt-0 lg:w-[15%] flex justify-end">
            <button
                type="button"
                @click="$emit('toggle-suspension', student)"
                :class="[
                    'px-4 py-2 rounded-xl text-xs font-bold transition-all duration-200 active:scale-95 cursor-pointer',
                    student.is_active
                        ? 'bg-rose-50 text-rose-600 dark:bg-rose-500/10 dark:text-rose-400 hover:bg-rose-100 dark:hover:bg-rose-500/20'
                        : 'bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400 hover:bg-emerald-100 dark:hover:bg-emerald-500/20'
                ]"
            >
                {{ student.is_active ? 'Tangguhkan' : 'Aktifkan' }}
            </button>
        </div>
    </div>
</template>
