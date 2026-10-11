<script setup>
import AdminLayout from '@/Components/Templates/AdminLayout.vue';
import Breadcrumbs from '@/Components/Molecules/Breadcrumbs.vue';
import Pagination from '@/Components/Molecules/Pagination.vue';
import SearchBar from '@/Components/Molecules/SearchBar.vue';
import StudentRow from '@/Components/Organisms/StudentRow.vue';
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
                        Direktori &amp; Status Siswa
                    </h1>
                    <p class="text-slate-500 dark:text-slate-400 font-medium text-base">
                        Mengelola <span class="text-[#D95300] font-bold">{{ students.total }}</span> akun siswa terdaftar di seluruh platform.
                    </p>
                </div>

                <div class="w-full lg:w-[380px]">
                    <SearchBar
                        v-model="search"
                        placeholder="Cari berdasarkan nama atau email..."
                        theme="teacher"
                    />
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
                <StudentRow
                    v-for="student in students.data"
                    :key="student.id"
                    :student="student"
                    @toggle-suspension="confirmToggleSuspension"
                />

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
