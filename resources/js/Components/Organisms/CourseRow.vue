<script setup>
import { Link } from '@inertiajs/vue3';
import CourseThumbnail from '@/Components/Atoms/CourseThumbnail.vue';
import GhostButton from '@/Components/Atoms/GhostButton.vue';
import Icon from '@/Components/Atoms/Icon.vue';
import { formatDate } from '@/Utils/exam';

defineProps({
    course: {
        type: Object,
        required: true,
    },
});

defineEmits(['delete']);
</script>

<template>
    <div class="flex flex-col gap-4 px-4 py-4 sm:flex-row sm:items-center sm:px-5">
        <div class="flex min-w-0 flex-1 items-center gap-4">
            <div class="size-14 shrink-0 overflow-hidden rounded-md border border-rule">
                <CourseThumbnail :src="course.cover" :name="course.name" monogram-class="text-lg" />
            </div>
            <div class="min-w-0">
                <p v-if="course.category" class="font-form text-[11px] font-semibold uppercase tracking-[0.14em] text-pen">{{ course.category.name }}</p>
                <Link
                    :href="route('dashboard.courses.show', course.id)"
                    class="block truncate rounded-sm font-bold text-ink hover:underline focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pen"
                >
                    {{ course.name }}
                </Link>
                <p class="font-form text-xs text-ink-soft">Dibuat {{ formatDate(course.created_at, { day: 'numeric', month: 'short', year: 'numeric' }) }}</p>
            </div>
        </div>

        <div class="flex shrink-0 items-center gap-2">
            <GhostButton :href="route('dashboard.courses.show', course.id)" size="sm">Kelola soal &amp; siswa</GhostButton>
            <Link
                :href="route('dashboard.courses.edit', course.id)"
                :aria-label="`Ubah ${course.name}`"
                class="flex size-9 items-center justify-center rounded-md text-ink-soft transition-colors hover:bg-rule/50 hover:text-ink focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pen motion-reduce:transition-none"
            >
                <Icon name="edit" class="size-4" />
            </Link>
            <button
                type="button"
                :aria-label="`Hapus ${course.name}`"
                class="flex size-9 items-center justify-center rounded-md text-pen transition-colors hover:bg-pen/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pen motion-reduce:transition-none"
                @click="$emit('delete', course.id)"
            >
                <Icon name="trash" class="size-4" />
            </button>
        </div>
    </div>
</template>
