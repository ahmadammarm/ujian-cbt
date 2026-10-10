<script setup>
import AdminLayout from '@/Components/Templates/AdminLayout.vue';
import Breadcrumbs from '@/Components/Molecules/Breadcrumbs.vue';
import Pagination from '@/Components/Molecules/Pagination.vue';
import AlertDialog from '@/Components/Organisms/AlertDialog.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps({
    students: Object, // Paginated object
    filters: Object,
});

const search = ref(props.filters.search || '');
const isSuspensionDialogOpen = ref(false);
const selectedStudent = ref(null);

// Debounced search
let timeout = null;
watch(search, (value) => {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
        router.get(route('dashboard.students.index'), { search: value }, {
            preserveState: true,
            replace: true,
        });
    }, 500);
});

const confirmToggleSuspension = (student) => {
    selectedStudent.value = student;
    isSuspensionDialogOpen.value = true;
};

const suspensionForm = useForm({});
const toggleSuspension = () => {
    suspensionForm.post(route('dashboard.students.toggle-suspension', selectedStudent.value.id), {
        onSuccess: () => {
            isSuspensionDialogOpen.value = false;
            selectedStudent.value = null;
        },
    });
};
</script>

<template>
    <Head title="Daftar Siswa" />

    <AdminLayout>
        <Breadcrumbs :items="[
            { label: 'Naiju Studio', href: route('dashboard.overview') },
            { label: 'Daftar Siswa' }
        ]" />

        <div class="flex flex-col gap-2 animate-slide-up">
            <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-10">
                <div class="flex flex-col gap-2">
                    <h1 class="font-black text-3xl lg:text-4xl tracking-tight text-[#0A090B] dark:text-white leading-tight">
                        Direktori & Status Siswa
                    </h1>
                    <p class="text-slate-500 dark:text-slate-400 font-medium text-base">
                        Mengelola <span class="text-[#D95300] font-bold">{{ students.total }}</span> akun siswa terdaftar di seluruh platform.
                    </p>
                </div>

                <div class="relative w-full lg:w-[380px]">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <input
                        v-model="search"
                        type="text"
                        placeholder="Cari berdasarkan nama atau email..."
                        class="w-full h-12 pl-12 pr-4 bg-white dark:bg-[#111116] border border-slate-200/80 dark:border-slate-800 rounded-2xl focus:ring-2 focus:ring-[#D95300] focus:border-transparent transition-all font-medium text-xs text-[#0A090B] dark:text-white placeholder:text-slate-400 dark:placeholder:text-slate-500"
                    >
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 pb-20">
                <!-- Table Header -->
                <div class="hidden lg:flex items-center px-8 py-3.5 bg-slate-50 dark:bg-slate-800/40 rounded-2xl border border-slate-200/80 dark:border-slate-800 text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">
                    <div class="w-[35%]">Identitas Siswa</div>
                    <div class="w-[15%] text-center">Kursus</div>
                    <div class="w-[20%] text-center">Rata-Rata Nilai</div>
                    <div class="w-[15%] text-center">Status Akun</div>
                    <div class="w-[15%] text-right">Aksi Akses</div>
                </div>

                <!-- Student Rows -->
                <div
                    v-for="student in students.data"
                    :key="student.id"
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
                        <span :class="['px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider', student.is_active ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' : 'bg-rose-500/10 text-rose-600 dark:text-rose-400']">
                            {{ student.is_active ? 'Aktif' : 'Ditangguhkan' }}
                        </span>
                    </div>

                    <!-- Action Button -->
                    <div class="mt-5 lg:mt-0 lg:w-[15%] flex justify-end">
                         <button
                            @click="confirmToggleSuspension(student)"
                            :title="student.is_active ? 'Tangguhkan Siswa' : 'Aktifkan Siswa'"
                            :class="[
                                'px-3.5 py-2 rounded-xl text-xs font-bold transition-all active:scale-95 flex items-center gap-1.5',
                                student.is_active
                                    ? 'bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 hover:bg-rose-500 hover:text-white'
                                    : 'bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-500 hover:text-white'
                            ]"
                        >
                            <svg v-if="student.is_active" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <svg v-else class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span>{{ student.is_active ? 'Tangguhkan' : 'Aktifkan' }}</span>
                        </button>
                    </div>
                </div>

                <!-- Empty State -->
                <div v-if="students.data.length === 0" class="py-24 px-8 bg-white dark:bg-[#111116] rounded-3xl text-center border-2 border-dashed border-slate-200 dark:border-slate-800">
                    <p class="text-slate-500 dark:text-slate-400 font-bold text-base">Tidak ada siswa yang cocok dengan kriteria pencarian Anda.</p>
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    <Pagination :links="students.links" />
                </div>
            </div>
        </div>

        <AlertDialog
            :show="isSuspensionDialogOpen"
            :title="selectedStudent?.is_active ? 'Tangguhkan Akses Siswa?' : 'Aktifkan Kembali Siswa?'"
            :message="selectedStudent?.is_active
                ? `Apakah Anda yakin ingin menangguhkan akun ${selectedStudent?.name}? Siswa ini tidak akan dapat login atau mengerjakan ujian.`
                : `Aktifkan kembali akses akun ${selectedStudent?.name}?`"
            :confirm-text="selectedStudent?.is_active ? 'Ya, Tangguhkan' : 'Ya, Aktifkan'"
            cancel-text="Batal"
            :type="selectedStudent?.is_active ? 'danger' : 'primary'"
            @close="isSuspensionDialogOpen = false"
            @confirm="toggleSuspension"
        />
    </AdminLayout>
</template>

<style scoped>
@keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
.animate-slide-up { animation: slideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
</style>