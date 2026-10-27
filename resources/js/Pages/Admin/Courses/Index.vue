<script setup>
import { ref, computed } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Components/Templates/AdminLayout.vue';
import Icon from '@/Components/Atoms/Icon.vue';
import InkButton from '@/Components/Atoms/InkButton.vue';
import EmptyState from '@/Components/Molecules/EmptyState.vue';
import PageHeader from '@/Components/Molecules/PageHeader.vue';
import Pagination from '@/Components/Molecules/Pagination.vue';
import SearchBar from '@/Components/Molecules/SearchBar.vue';
import AlertDialog from '@/Components/Organisms/AlertDialog.vue';
import CourseRow from '@/Components/Organisms/CourseRow.vue';

const props = defineProps({
    courses: {
        type: Object,
        required: true,
    },
});

const searchQuery = ref('');
const isDeleteDialogOpen = ref(false);
const selectedCourseId = ref(null);

const confirmDeleteCourse = (id) => {
    selectedCourseId.value = id;
    isDeleteDialogOpen.value = true;
};

const deleteForm = useForm({});

const deleteCourse = () => {
    deleteForm.delete(route('dashboard.courses.destroy', selectedCourseId.value), {
        onSuccess: () => {
            isDeleteDialogOpen.value = false;
            selectedCourseId.value = null;
        },
    });
};

const filteredCourses = computed(() => {
    if (!searchQuery.value.trim()) {
        return props.courses.data;
    }
    const q = searchQuery.value.toLowerCase();
    return props.courses.data.filter(c =>
        c.name.toLowerCase().includes(q) ||
        (c.category && c.category.name.toLowerCase().includes(q))
    );
});
</script>

<template>
    <Head title="Kursus" />

    <AdminLayout>
        <div class="flex flex-col gap-8">
            <PageHeader
                eyebrow="Kursus & soal"
                title="Kursusmu."
                :description="`${courses.total} kursus. Buka kursus untuk menyusun soal dan mendaftarkan siswa.`"
            >
                <template #actions>
                    <InkButton :href="route('dashboard.courses.create')" size="sm">
                        <Icon name="plus" class="size-4" />
                        Buat kursus
                    </InkButton>
                </template>
            </PageHeader>

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div class="w-full sm:max-w-sm">
                    <SearchBar v-model="searchQuery" label="Cari kursus" placeholder="Cari nama kursus atau kategori…" />
                </div>
                <p class="font-form text-xs text-ink-soft">{{ filteredCourses.length }} ditampilkan di halaman ini</p>
            </div>

            <ul v-if="filteredCourses.length > 0" class="divide-y divide-rule overflow-hidden rounded-md border border-rule bg-paper">
                <li v-for="course in filteredCourses" :key="course.id">
                    <CourseRow :course="course" @delete="confirmDeleteCourse" />
                </li>
            </ul>

            <EmptyState
                v-else
                :icon="searchQuery ? 'search' : 'book'"
                :title="searchQuery ? 'Tidak ada yang cocok.' : 'Belum ada kursus.'"
                :description="searchQuery
                    ? `Tidak ada kursus di halaman ini yang cocok dengan “${searchQuery}”.`
                    : 'Buat kursus pertamamu, lalu tambahkan soal dan daftarkan siswa.'"
            >
                <InkButton v-if="!searchQuery" :href="route('dashboard.courses.create')" size="sm">Buat kursus</InkButton>
            </EmptyState>

            <Pagination :links="courses.links" />
        </div>

        <AlertDialog
            :show="isDeleteDialogOpen"
            title="Hapus kursus ini?"
            message="Semua soal, hasil ujian, dan daftar siswa di kursus ini ikut terhapus. Tindakan ini tidak bisa dibatalkan."
            confirm-text="Hapus kursus"
            type="danger"
            @close="isDeleteDialogOpen = false"
            @confirm="deleteCourse"
        />
    </AdminLayout>
</template>
