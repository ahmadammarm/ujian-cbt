<script setup>
import { ref, watch } from 'vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Components/Templates/AdminLayout.vue';
import EmptyState from '@/Components/Molecules/EmptyState.vue';
import PageHeader from '@/Components/Molecules/PageHeader.vue';
import Pagination from '@/Components/Molecules/Pagination.vue';
import SearchBar from '@/Components/Molecules/SearchBar.vue';
import AlertDialog from '@/Components/Organisms/AlertDialog.vue';
import StudentRow from '@/Components/Organisms/StudentRow.vue';

const SEARCH_DEBOUNCE_MS = 500;

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
    }, SEARCH_DEBOUNCE_MS);
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
    <Head title="Siswa" />

    <AdminLayout>
        <div class="flex flex-col gap-8">
            <PageHeader
                eyebrow="Siswa"
                title="Semua siswa."
                :description="`${students.total} siswa terdaftar di Naiju. Nonaktifkan akun untuk mencegah siswa masuk.`"
            />

            <div class="w-full sm:max-w-sm">
                <SearchBar v-model="search" label="Cari siswa" placeholder="Cari nama atau email…" />
            </div>

            <ul v-if="students.data.length > 0" class="divide-y divide-rule overflow-hidden rounded-md border border-rule bg-paper">
                <li v-for="student in students.data" :key="student.id">
                    <StudentRow :student="student" @toggle-suspension="confirmToggleSuspension" />
                </li>
            </ul>

            <EmptyState
                v-else
                :icon="search ? 'search' : 'users'"
                :title="search ? 'Tidak ada yang cocok.' : 'Belum ada siswa.'"
                :description="search
                    ? `Tidak ada siswa dengan nama atau email “${search}”.`
                    : 'Siswa muncul di sini setelah mendaftar atau dibuatkan akun.'"
            />

            <Pagination :links="students.links" />
        </div>

        <AlertDialog
            :show="isSuspensionDialogOpen"
            :title="selectedStudent?.is_active ? 'Nonaktifkan akun ini?' : 'Aktifkan lagi akun ini?'"
            :message="selectedStudent?.is_active
                ? `${selectedStudent?.name} tidak bisa masuk ke Naiju sampai akunnya diaktifkan lagi.`
                : `${selectedStudent?.name} bisa masuk dan mengerjakan ujian lagi.`"
            :confirm-text="selectedStudent?.is_active ? 'Nonaktifkan' : 'Aktifkan'"
            cancel-text="Batal"
            :type="selectedStudent?.is_active ? 'danger' : 'primary'"
            @close="isSuspensionDialogOpen = false"
            @confirm="toggleSuspension"
        />
    </AdminLayout>
</template>
