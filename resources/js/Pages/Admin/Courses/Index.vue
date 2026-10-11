<script setup>
import AdminLayout from '@/Components/Templates/AdminLayout.vue';
import AlertDialog from '@/Components/Organisms/AlertDialog.vue';
import Breadcrumbs from '@/Components/Molecules/Breadcrumbs.vue';
import Pagination from '@/Components/Molecules/Pagination.vue';
import SearchBar from '@/Components/Molecules/SearchBar.vue';
import CourseRow from '@/Components/Organisms/CourseRow.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

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
    <Head title="Manajemen Kursus" />

    <AdminLayout>
        <div class="max-w-7xl mx-auto pb-20">
            <Breadcrumbs :items="[
                { label: 'Naiju Studio', href: route('dashboard.overview') },
                { label: 'Daftar Kursus' }
            ]" />

            <!-- Page Header -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-6 mb-8 animate-fade-in">
                <div class="flex flex-col gap-2">
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded text-[10px] font-extrabold uppercase tracking-widest bg-[#D95300]/10 text-[#D95300] border border-[#D95300]/20">
                            Kurikulum Ujian
                        </span>
                        <span class="text-xs font-semibold text-slate-400 dark:text-slate-500">
                            {{ courses.total }} Modul Terdaftar
                        </span>
                    </div>
                    <h1 class="font-black text-3xl lg:text-4xl tracking-tight text-[#0A090B] dark:text-white leading-tight">
                        Manajemen Kursus &amp; Bank Soal
                    </h1>
                    <p class="text-slate-500 dark:text-slate-400 font-medium text-sm max-w-xl">
                        Kelola kurikulum pengujian digital, konfigurasi bank soal, dan pantau distribusi materi asesmen peserta didik.
                    </p>
                </div>

                <Link
                    :href="route('dashboard.courses.create')"
                    class="px-5 py-3 bg-[#D95300] hover:bg-[#b84600] text-white rounded-xl font-bold uppercase tracking-wider text-xs transition-colors active:scale-95 flex items-center justify-center gap-2 shrink-0"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 5v14M5 12h14" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Tambah Kursus Baru</span>
                </Link>
            </div>

            <!-- Search & Controls Bar -->
            <div class="w-full flex flex-col sm:flex-row items-center justify-between gap-4 p-4 mb-6 bg-white dark:bg-[#111116] border border-slate-200/80 dark:border-slate-800 rounded-2xl">
                <div class="w-full sm:w-80">
                    <SearchBar
                        v-model="searchQuery"
                        placeholder="Cari nama kursus atau kategori..."
                        theme="teacher"
                    />
                </div>

                <div class="text-xs font-semibold text-slate-400 dark:text-slate-500 self-end sm:self-auto">
                    Menampilkan <span class="font-bold text-[#0A090B] dark:text-white">{{ filteredCourses.length }}</span> dari {{ courses.total }} kursus
                </div>
            </div>

            <!-- Structured Row Table -->
            <div class="space-y-3">
                <!-- Desktop Table Headers -->
                <div class="hidden lg:grid grid-cols-12 gap-4 px-6 py-3 bg-slate-50 dark:bg-[#141419] rounded-xl border border-slate-200/80 dark:border-slate-800 text-[10px] font-extrabold text-slate-400 dark:text-slate-500 uppercase tracking-widest">
                    <div class="col-span-5">Informasi Kursus &amp; Modul</div>
                    <div class="col-span-2 text-center">Kategori Materi</div>
                    <div class="col-span-2 text-center">Status Asesmen</div>
                    <div class="col-span-1 text-center">Terdaftar</div>
                    <div class="col-span-2 text-right">Aksi Kelola</div>
                </div>

                <!-- Course Rows -->
                <CourseRow
                    v-for="course in filteredCourses"
                    :key="course.id"
                    :course="course"
                    @delete="confirmDeleteCourse"
                />

                <!-- Empty State -->
                <div v-if="filteredCourses.length === 0" class="py-16 bg-white dark:bg-[#111116] rounded-2xl text-center border border-slate-200/80 dark:border-slate-800">
                    <p class="font-bold text-base text-[#0A090B] dark:text-white">Tidak ada kursus yang sesuai.</p>
                    <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">Coba sesuaikan kata kunci pencarian Anda atau buat kursus baru.</p>
                </div>

                <!-- Pagination -->
                <div class="pt-6">
                    <Pagination :links="courses.links" />
                </div>
            </div>
        </div>

        <AlertDialog
            :show="isDeleteDialogOpen"
            title="Hapus Modul Kursus Ini?"
            message="Menghapus kursus ini juga akan menghapus seluruh butir soal, hasil ujian, dan data enroll siswa yang terkait. Tindakan ini tidak dapat dibatalkan."
            confirm-text="Hapus Kursus"
            cancel-text="Batal"
            type="danger"
            @close="isDeleteDialogOpen = false"
            @confirm="deleteCourse"
        />
    </AdminLayout>
</template>
