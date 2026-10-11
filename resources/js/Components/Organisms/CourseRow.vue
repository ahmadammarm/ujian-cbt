<script setup>
import CourseThumbnail from '@/Components/Atoms/CourseThumbnail.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    course: {
        type: Object,
        required: true,
    },
});

defineEmits(['delete']);

const formatDate = (dateString) => {
    if (!dateString) return '-';
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
    });
};
</script>

<template>
    <div
        class="bg-white dark:bg-[#111116] p-5 lg:p-6 rounded-2xl border border-slate-200/80 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700 transition-colors flex flex-col lg:grid lg:grid-cols-12 gap-4 items-start lg:items-center"
    >
        <!-- Col 1: Course Info (5 Cols) -->
        <div class="w-full lg:col-span-5 flex items-center gap-4 min-w-0">
            <div class="w-16 h-16 rounded-xl overflow-hidden shrink-0 bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                <CourseThumbnail
                    :src="course.cover"
                    :name="course.name"
                    theme="teacher"
                    monogramClass="text-lg"
                />
            </div>
            <div class="min-w-0 flex-1">
                <Link
                    :href="route('dashboard.courses.show', course.id)"
                    class="font-bold text-base text-[#0A090B] dark:text-white hover:text-[#D95300] dark:hover:text-[#D95300] transition-colors truncate block"
                >
                    {{ course.name }}
                </Link>
                <p class="text-xs text-slate-400 dark:text-slate-500 font-medium truncate mt-0.5">
                    slug: /{{ course.slug }}
                </p>
            </div>
        </div>

        <!-- Col 2: Category (2 Cols) -->
        <div class="w-full lg:col-span-2 flex justify-start lg:justify-center">
            <span
                v-if="course.category"
                class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200/60 dark:border-slate-700"
            >
                {{ course.category.name }}
            </span>
            <span v-else class="text-xs text-slate-300 dark:text-slate-600 font-bold">---</span>
        </div>

        <!-- Col 3: Status (2 Cols) -->
        <div class="w-full lg:col-span-2 flex flex-col items-start lg:items-center">
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20 text-[10px] font-bold uppercase tracking-wider">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                <span>Siap Diuji</span>
            </div>
        </div>

        <!-- Col 4: Created Date (1 Col) -->
        <div class="w-full lg:col-span-1 flex flex-col items-start lg:items-center">
            <span class="text-xs font-semibold text-slate-700 dark:text-slate-300 whitespace-nowrap">
                {{ formatDate(course.created_at) }}
            </span>
        </div>

        <!-- Col 5: Actions (2 Cols) -->
        <div class="w-full lg:col-span-2 flex items-center justify-end gap-2 pt-3 lg:pt-0 border-t lg:border-t-0 border-slate-100 dark:border-slate-800">
            <Link
                :href="route('dashboard.courses.show', course.id)"
                class="px-3.5 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-[#0A090B] hover:text-white dark:hover:bg-white dark:hover:text-[#0A090B] text-slate-700 dark:text-slate-300 text-xs font-bold transition-colors flex items-center gap-1.5"
            >
                <span>Kelola Soal</span>
            </Link>
            <Link
                :href="route('dashboard.courses.edit', course.id)"
                title="Edit Informasi Kursus"
                class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 flex items-center justify-center transition-colors"
            >
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
            </Link>
            <button
                type="button"
                @click="$emit('delete', course.id)"
                title="Hapus Kursus"
                class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-rose-500 hover:text-white text-rose-500 flex items-center justify-center transition-colors cursor-pointer"
            >
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </button>
        </div>
    </div>
</template>
