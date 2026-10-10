<script setup>
import AdminLayout from '@/Components/Templates/AdminLayout.vue';
import AlertDialog from '@/Components/Organisms/AlertDialog.vue';
import Breadcrumbs from '@/Components/Molecules/Breadcrumbs.vue';
import Pagination from '@/Components/Molecules/Pagination.vue';
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

const formatDate = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
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
    <Head title="Manajemen Kursus & Asesmen · Naiju Studio" />

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
                <div class="w-full sm:w-80 relative">
                    <input
                        type="text"
                        v-model="searchQuery"
                        placeholder="Cari nama kursus atau kategori..."
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-[#141419] border border-slate-200 dark:border-slate-700/80 rounded-xl text-slate-800 dark:text-slate-200 text-xs font-semibold placeholder-slate-400 focus:outline-none focus:border-[#D95300] transition-colors"
                    />
                    <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
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
                <div
                    v-for="course in filteredCourses"
                    :key="course.id"
                    class="bg-white dark:bg-[#111116] p-5 lg:p-6 rounded-2xl border border-slate-200/80 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700 transition-colors flex flex-col lg:grid lg:grid-cols-12 gap-4 items-start lg:items-center"
                >
                    <!-- Col 1: Course Info (5 Cols) -->
                    <div class="w-full lg:col-span-5 flex items-center gap-4 min-w-0">
                        <div class="w-16 h-16 rounded-xl overflow-hidden shrink-0 bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                            <img v-if="course.cover" :src="'/storage/' + course.cover" class="w-full h-full object-cover" alt="thumbnail">
                            <div v-else class="w-full h-full flex items-center justify-center font-bold text-lg text-[#D95300]">
                                {{ course.name.charAt(0).toUpperCase() }}
                            </div>
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
                            @click="confirmDeleteCourse(course.id)"
                            title="Hapus Kursus"
                            class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-rose-500 hover:text-white text-rose-500 flex items-center justify-center transition-colors"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                </div>

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
