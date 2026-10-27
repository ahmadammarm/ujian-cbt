<script setup>
import { ref, computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import StudentLayout from '@/Components/Templates/StudentLayout.vue';
import CourseThumbnail from '@/Components/Atoms/CourseThumbnail.vue';
import GhostButton from '@/Components/Atoms/GhostButton.vue';
import InkButton from '@/Components/Atoms/InkButton.vue';
import ScoreMark from '@/Components/Atoms/ScoreMark.vue';
import StatusBadge from '@/Components/Atoms/StatusBadge.vue';
import EmptyState from '@/Components/Molecules/EmptyState.vue';
import PageHeader from '@/Components/Molecules/PageHeader.vue';
import SearchBar from '@/Components/Molecules/SearchBar.vue';
import { PASSING_SCORE, isPassing } from '@/Utils/exam';

const props = defineProps({
    courses: {
        type: Array,
        default: () => [],
    },
});

const searchQuery = ref('');

const filteredCourses = computed(() => {
    if (!searchQuery.value.trim()) {
        return props.courses;
    }
    const q = searchQuery.value.toLowerCase();
    return props.courses.filter(course =>
        course.name.toLowerCase().includes(q) ||
        (course.category && course.category.name.toLowerCase().includes(q))
    );
});
</script>

<template>
    <Head title="Ujian saya" />

    <StudentLayout>
        <div class="flex flex-col gap-8">
            <PageHeader
                eyebrow="Ujian saya"
                title="Pilih ujian yang mau dikerjakan."
                :description="`Kamu lulus kalau nilainya ${PASSING_SCORE} atau lebih. Ujian bisa diulang kapan saja.`"
            />

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div class="w-full sm:max-w-sm">
                    <SearchBar v-model="searchQuery" label="Cari ujian" placeholder="Cari mapel atau kategori…" />
                </div>
                <p class="font-form text-xs text-ink-soft">{{ filteredCourses.length }} dari {{ courses.length }} mapel</p>
            </div>

            <ul v-if="filteredCourses.length > 0" class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
                <li v-for="course in filteredCourses" :key="course.id" class="flex flex-col overflow-hidden rounded-md border border-rule bg-paper">
                    <div class="aspect-video w-full border-b border-rule">
                        <CourseThumbnail :src="course.cover" :name="course.name" monogram-class="text-4xl" />
                    </div>

                    <div class="flex flex-1 flex-col gap-5 p-5">
                        <div>
                            <p v-if="course.category" class="font-form text-[11px] font-semibold uppercase tracking-[0.14em] text-pen">{{ course.category.name }}</p>
                            <h2 class="mt-1 text-lg font-bold leading-snug text-ink">{{ course.name }}</h2>
                            <p class="mt-1 text-sm text-ink-soft">{{ course.questions_count }} soal pilihan ganda</p>
                        </div>

                        <div class="mt-auto flex items-center gap-3 border-t border-dashed border-rule pt-4">
                            <template v-if="course.latest_assessment">
                                <ScoreMark :score="course.latest_assessment.score ?? 0" size="sm" />
                                <div>
                                    <p class="text-xs text-ink-soft">Nilai terakhir</p>
                                    <StatusBadge :variant="isPassing(course.latest_assessment.score) ? 'success' : 'danger'">
                                        {{ isPassing(course.latest_assessment.score) ? 'Lulus' : 'Remedial' }}
                                    </StatusBadge>
                                </div>
                            </template>
                            <p v-else class="text-sm text-ink-soft">Belum pernah dikerjakan.</p>
                        </div>

                        <div class="flex gap-2">
                            <InkButton
                                :href="route('dashboard.learning.start', course.id)"
                                method="post"
                                as="button"
                                size="sm"
                                class="flex-1"
                            >
                                {{ course.latest_assessment ? 'Ujian ulang' : 'Mulai ujian' }}
                            </InkButton>
                            <GhostButton
                                v-if="course.latest_assessment"
                                :href="route('dashboard.learning.report', course.latest_assessment.id)"
                                size="sm"
                            >
                                Rapor
                            </GhostButton>
                        </div>
                    </div>
                </li>
            </ul>

            <EmptyState
                v-else
                :icon="searchQuery ? 'search' : 'clipboard'"
                :title="searchQuery ? 'Tidak ada yang cocok.' : 'Belum ada ujian untukmu.'"
                :description="searchQuery
                    ? `Tidak ada mapel atau kategori yang cocok dengan “${searchQuery}”. Coba kata kunci lain.`
                    : 'Gurumu belum memasukkanmu ke mapel mana pun. Kasih tahu gurumu email akunmu supaya kamu didaftarkan.'"
            />
        </div>
    </StudentLayout>
</template>
