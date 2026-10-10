<script setup>
import AdminLayout from '@/Components/Templates/AdminLayout.vue';
import AlertDialog from '@/Components/Organisms/AlertDialog.vue';
import Breadcrumbs from '@/Components/Molecules/Breadcrumbs.vue';
import Pagination from '@/Components/Molecules/Pagination.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    courses: {
        type: Object,
        required: true,
    },
});

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
        month: 'long',
        year: 'numeric',
    });
};
</script>

<template>
    <Head title="Manajemen Kursus · Naiju Studio" />

    <AdminLayout>
        <Breadcrumbs :items="[
            { label: 'Naiju Studio', href: route('dashboard.overview') },
            { label: 'Daftar Kursus' }
        ]" />

        <div class="flex flex-col mb-10 animate-fade-in">
            <div class="w-full flex flex-col sm:flex-row justify-between items-start sm:items-end gap-6">
                <div class="flex flex-col gap-2">
                    <h1 class="font-black text-3xl lg:text-4xl tracking-tight text-[#0A090B] dark:text-white leading-tight">
                        Manajemen Kursus & Asesmen
                    </h1>
                    <p class="text-slate-500 dark:text-slate-400 font-medium text-base">
                        Terdapat <span class="text-[#D95300] font-bold">{{ courses.total }}</span> modul ujian aktif dalam kurikulum Anda.
                    </p>
                </div>
                <Link :href="route('dashboard.courses.create')"
                    class="px-7 py-4 bg-[#D95300] hover:bg-[#b84600] text-white rounded-2xl font-bold uppercase tracking-wider text-xs transition-all duration-300 shadow-lg shadow-[#D95300]/25 hover:scale-[1.02] active:scale-95 flex items-center justify-center gap-2.5 shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 5v14M5 12h14" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Tambah Kursus Baru
                </Link>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 pb-20">
            <!-- Table Header (Desktop Only) -->
            <div class="hidden lg:flex items-center px-8 py-3.5 bg-slate-50 dark:bg-slate-800/40 rounded-2xl border border-slate-200/80 dark:border-slate-800 text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">
                <div class="w-[45%]">Informasi Kursus & Soal</div>
                <div class="w-[20%] text-center">Kategori</div>
                <div class="w-[20%] text-center">Tanggal Pembuatan</div>
                <div class="w-[15%] text-right">Aksi Tindakan</div>
            </div>

            <!-- Course Rows -->
            <div v-for="course in courses.data" :key="course.id"
                class="group relative bg-white dark:bg-[#111116] p-6 lg:p-7 rounded-3xl border border-slate-200/80 dark:border-slate-800 hover:border-[#D95300]/40 dark:hover:border-[#D95300]/40 hover:shadow-lg hover:shadow-black/5 transition-all duration-300 flex flex-col lg:flex-row lg:items-center animate-slide-up">

                <!-- Info Section -->
                <div class="lg:w-[45%] flex items-center gap-5">
                    <div class="w-16 h-16 flex shrink-0 overflow-hidden rounded-2xl border border-slate-100 dark:border-slate-800 group-hover:scale-105 transition-transform duration-300 bg-slate-100 dark:bg-slate-800">
                        <img v-if="course.cover" :src="'/storage/' + course.cover" class="object-cover w-full h-full" alt="thumbnail">
                        <div v-else class="w-full h-full flex items-center justify-center font-bold text-[#D95300] text-lg">
                            {{ course.name ? course.name.charAt(0).toUpperCase() : 'C' }}
                        </div>
                    </div>
                    <div class="flex flex-col gap-1 min-w-0">
                        <p class="font-bold text-lg text-[#0A090B] dark:text-white group-hover:text-[#D95300] dark:group-hover:text-[#D95300] transition-colors truncate">
                            {{ course.name }}
                        </p>
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <p class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Aktif & Siap Ujian</p>
                        </div>
                    </div>
                </div>

                <!-- Category Section -->
                <div class="mt-4 lg:mt-0 lg:w-[20%] flex justify-center">
                    <div v-if="course.category"
                        class="px-3.5 py-1.5 rounded-xl font-bold text-xs uppercase tracking-wider border bg-slate-50 dark:bg-slate-800/80 text-slate-700 dark:text-slate-300 border-slate-200 dark:border-slate-700"
                    >
                        {{ course.category.name }}
                    </div>
                    <p v-else class="text-slate-300 dark:text-slate-600 font-bold">---</p>
                </div>

                <!-- Date Section -->
                <div class="mt-4 lg:mt-0 lg:w-[20%] flex flex-col items-center">
                    <p class="text-sm font-bold text-[#0A090B] dark:text-slate-200">
                        {{ formatDate(course.created_at) }}
                    </p>
                    <p class="text-[10px] font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Terdaftar</p>
                </div>

                <!-- Actions Section -->
                <div class="mt-6 lg:mt-0 lg:w-[15%] flex justify-end gap-2.5">
                    <Link :href="route('dashboard.courses.show', course.id)"
                        title="Lihat Detail & Soal"
                        class="w-11 h-11 flex items-center justify-center bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-xl hover:bg-[#0A090B] dark:hover:bg-slate-700 hover:text-white transition-all active:scale-95 shadow-xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2.5"/>
                            <path d="M2.458 12C3.732 7.943 7.523 5 12 5c3.55 0 6.703 1.86 8.596 4.675a.966.966 0 010 1.15C18.703 13.64 15.55 15.5 12 15.5c-4.477 0-8.268-2.943-9.542-7z" stroke-width="2.5"/>
                        </svg>
                    </Link>
                    <Link :href="route('dashboard.courses.edit', course.id)"
                        title="Edit Modul"
                        class="w-11 h-11 flex items-center justify-center bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-xl hover:bg-[#D95300] hover:text-white transition-all active:scale-95 shadow-xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </Link>
                    <button @click="confirmDeleteCourse(course.id)"
                        title="Hapus Modul"
                        class="w-11 h-11 flex items-center justify-center bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-rose-500 rounded-xl hover:bg-rose-500 hover:text-white hover:border-rose-500 transition-all active:scale-95 shadow-xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Empty State -->
            <div v-if="courses.data.length === 0" class="py-24 px-8 bg-white dark:bg-[#111116] rounded-3xl text-center border-2 border-dashed border-slate-200 dark:border-slate-800 animate-fade-in">
                <div class="w-20 h-20 bg-slate-100 dark:bg-slate-800 rounded-2xl shadow-xs flex items-center justify-center mx-auto mb-6 text-slate-400">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.168.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.168.477-4.5 1.253" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-[#0A090B] dark:text-white mb-2">Belum Ada Kursus Dibuat</h3>
                <p class="text-slate-500 dark:text-slate-400 text-sm mb-8 max-w-md mx-auto">Mulai susun bank soal dan parameter asesmen dengan membuat kursus pertama Anda.</p>
                <Link :href="route('dashboard.courses.create')" class="inline-flex items-center gap-2.5 px-8 py-4 bg-[#D95300] hover:bg-[#b84600] text-white font-bold text-xs uppercase tracking-wider rounded-2xl shadow-lg shadow-[#D95300]/25 transition-all">
                    <span>Buat Kursus Pertama</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M17 8l4 4m0 0l-4 4m4-4H3" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </Link>
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                <Pagination :links="courses.links" />
            </div>
        </div>

        <AlertDialog
            :show="isDeleteDialogOpen"
            title="Hapus kursus ini?"
            message="Tindakan ini akan menghapus modul kursus beserta seluruh bank soal dan catatan jawaban terkait secara permanen."
            confirm-text="Ya, Hapus Kursus"
            cancel-text="Batalkan"
            type="danger"
            @close="isDeleteDialogOpen = false"
            @confirm="deleteCourse"
        />
    </AdminLayout>
</template>

<style scoped>
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
@keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
.animate-fade-in { animation: fadeIn 0.6s ease-out forwards; }
.animate-slide-up { animation: slideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
</style>