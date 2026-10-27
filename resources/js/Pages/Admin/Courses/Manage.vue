<script setup>
import { ref, computed } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Components/Templates/AdminLayout.vue';
import CourseThumbnail from '@/Components/Atoms/CourseThumbnail.vue';
import GhostButton from '@/Components/Atoms/GhostButton.vue';
import Icon from '@/Components/Atoms/Icon.vue';
import InkButton from '@/Components/Atoms/InkButton.vue';
import StatusBadge from '@/Components/Atoms/StatusBadge.vue';
import Breadcrumbs from '@/Components/Molecules/Breadcrumbs.vue';
import EmptyState from '@/Components/Molecules/EmptyState.vue';
import Pagination from '@/Components/Molecules/Pagination.vue';
import SearchBar from '@/Components/Molecules/SearchBar.vue';
import AlertDialog from '@/Components/Organisms/AlertDialog.vue';
import Modal from '@/Components/Organisms/Modal.vue';
import { formatDate } from '@/Utils/exam';

const props = defineProps({
    course: {
        type: Object,
        required: true,
    },
    students: {
        type: Object,
        required: true,
    },
    questions: {
        type: Object,
        required: true,
    },
    availableStudents: {
        type: Array,
        default: () => [],
    },
});

// Open the students tab when paginating it, so the paginator does not jump back to questions
const activeTab = ref(new URLSearchParams(window.location.search).has('students_page') ? 'students' : 'questions');
const isDeleteDialogOpen = ref(false);
const selectedQuestionId = ref(null);

const isEnrollModalOpen = ref(false);
const studentSearchQuery = ref('');
const selectedStudentIds = ref([]);
const isUnenrollDialogOpen = ref(false);
const studentToUnenroll = ref(null);

const enrollForm = useForm({
    student_ids: [],
});

const unenrollForm = useForm({});

const filteredCandidates = computed(() => {
    if (!studentSearchQuery.value.trim()) {
        return props.availableStudents;
    }
    const q = studentSearchQuery.value.toLowerCase();
    return props.availableStudents.filter(s =>
        s.name.toLowerCase().includes(q) || s.email.toLowerCase().includes(q)
    );
});

const unenrolledCandidates = computed(() => {
    return props.availableStudents.filter(s => !s.is_enrolled);
});

const isAllUnenrolledSelected = computed(() => {
    const unenrolled = unenrolledCandidates.value;
    if (unenrolled.length === 0) return false;
    return unenrolled.every(s => selectedStudentIds.value.includes(s.id));
});

const toggleSelectAllUnenrolled = () => {
    if (isAllUnenrolledSelected.value) {
        selectedStudentIds.value = [];
    } else {
        selectedStudentIds.value = unenrolledCandidates.value.map(s => s.id);
    }
};

const toggleStudentSelection = (studentId, isEnrolled) => {
    if (isEnrolled) return;
    const idx = selectedStudentIds.value.indexOf(studentId);
    if (idx === -1) {
        selectedStudentIds.value.push(studentId);
    } else {
        selectedStudentIds.value.splice(idx, 1);
    }
};

const openEnrollModal = () => {
    studentSearchQuery.value = '';
    selectedStudentIds.value = [];
    isEnrollModalOpen.value = true;
};

const submitEnrollment = () => {
    if (selectedStudentIds.value.length === 0) return;
    enrollForm.student_ids = selectedStudentIds.value;
    enrollForm.post(route('dashboard.courses.enroll-students', props.course.id), {
        onSuccess: () => {
            isEnrollModalOpen.value = false;
            selectedStudentIds.value = [];
            studentSearchQuery.value = '';
        },
    });
};

const confirmUnenroll = (student) => {
    studentToUnenroll.value = student;
    isUnenrollDialogOpen.value = true;
};

const submitUnenroll = () => {
    if (!studentToUnenroll.value) return;
    unenrollForm.delete(route('dashboard.courses.unenroll-student', {
        course: props.course.id,
        student: studentToUnenroll.value.id,
    }), {
        onSuccess: () => {
            isUnenrollDialogOpen.value = false;
            studentToUnenroll.value = null;
        },
    });
};

const confirmDeleteQuestion = (id) => {
    selectedQuestionId.value = id;
    isDeleteDialogOpen.value = true;
};

const deleteForm = useForm({});

const deleteQuestion = () => {
    deleteForm.delete(route('dashboard.course.question.delete', {
        courseId: props.course.id,
        questionId: selectedQuestionId.value
    }), {
        onSuccess: () => {
            isDeleteDialogOpen.value = false;
            selectedQuestionId.value = null;
        },
    });
};

const tabs = computed(() => [
    { key: 'questions', label: 'Soal', count: props.questions.total },
    { key: 'students', label: 'Siswa', count: props.students.total },
]);
</script>

<template>
    <Head :title="`Kelola kursus: ${course.name}`" />

    <AdminLayout>
        <div class="flex flex-col gap-8">
            <Breadcrumbs :items="[
                { label: 'Kursus', href: route('dashboard.courses.index') },
                { label: course.name },
            ]" />

            <!-- Course header -->
            <header class="flex flex-col gap-5 rounded-md border border-rule bg-paper p-5 sm:flex-row sm:items-center sm:p-6">
                <div class="aspect-video w-full shrink-0 overflow-hidden rounded-md border border-rule sm:w-44">
                    <CourseThumbnail :src="course.cover" :name="course.name" monogram-class="text-3xl" />
                </div>
                <div class="min-w-0 flex-1">
                    <p v-if="course.category" class="font-form text-[11px] font-semibold uppercase tracking-[0.16em] text-pen">{{ course.category.name }}</p>
                    <h1 class="mt-1 font-hand text-3xl font-extrabold leading-tight text-ink">{{ course.name }}</h1>
                    <p class="mt-1 font-form text-xs text-ink-soft">
                        Dibuat {{ formatDate(course.created_at, { day: 'numeric', month: 'short', year: 'numeric' }) }} · {{ questions.total }} soal · {{ students.total }} siswa
                    </p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <GhostButton :href="route('dashboard.courses.edit', course.id)" size="sm">
                        <Icon name="edit" class="size-4" />
                        Ubah info
                    </GhostButton>
                    <InkButton :href="route('dashboard.course.question.create', course.id)" size="sm">
                        <Icon name="plus" class="size-4" />
                        Tambah soal
                    </InkButton>
                </div>
            </header>

            <!-- Notebook index tabs -->
            <div role="tablist" aria-label="Isi kursus" class="flex gap-1 border-b-2 border-rule">
                <button
                    v-for="tab in tabs"
                    :id="`tab-${tab.key}`"
                    :key="tab.key"
                    type="button"
                    role="tab"
                    :aria-selected="activeTab === tab.key"
                    :aria-controls="`panel-${tab.key}`"
                    :class="[
                        '-mb-0.5 flex items-center gap-2 rounded-t-md border-b-2 px-4 py-2.5 text-[15px] transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pen motion-reduce:transition-none',
                        activeTab === tab.key ? 'border-ink bg-stabilo/60 font-bold text-ink' : 'border-transparent text-ink-soft hover:text-ink',
                    ]"
                    @click="activeTab = tab.key"
                >
                    {{ tab.label }}
                    <span class="rounded-full bg-paper px-2 font-form text-xs">{{ tab.count }}</span>
                </button>
            </div>

            <!-- Questions panel -->
            <section v-show="activeTab === 'questions'" id="panel-questions" role="tabpanel" aria-labelledby="tab-questions" class="flex flex-col gap-4">
                <ol v-if="questions.data.length > 0" class="divide-y divide-rule overflow-hidden rounded-md border border-rule bg-paper">
                    <li v-for="(question, index) in questions.data" :key="question.id" class="flex items-start gap-4 px-4 py-4 sm:px-5">
                        <span class="w-8 shrink-0 pt-0.5 text-right font-form text-sm font-semibold text-pen">
                            {{ (questions.current_page - 1) * questions.per_page + index + 1 }}
                        </span>
                        <p class="min-w-0 flex-1 leading-7 text-ink">{{ question.question }}</p>
                        <div class="flex shrink-0 items-center gap-1">
                            <Link
                                :href="route('dashboard.course.question.edit', { courseId: course.id, questionId: question.id })"
                                aria-label="Ubah soal"
                                class="flex size-9 items-center justify-center rounded-md text-ink-soft transition-colors hover:bg-rule/50 hover:text-ink focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pen motion-reduce:transition-none"
                            >
                                <Icon name="edit" class="size-4" />
                            </Link>
                            <button
                                type="button"
                                aria-label="Hapus soal"
                                class="flex size-9 items-center justify-center rounded-md text-pen transition-colors hover:bg-pen/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pen motion-reduce:transition-none"
                                @click="confirmDeleteQuestion(question.id)"
                            >
                                <Icon name="trash" class="size-4" />
                            </button>
                        </div>
                    </li>
                </ol>
                <EmptyState
                    v-else
                    icon="clipboard"
                    title="Belum ada soal."
                    description="Tambahkan soal pilihan ganda. Siswa baru bisa mengerjakan kursus ini setelah ada soalnya."
                >
                    <InkButton :href="route('dashboard.course.question.create', course.id)" size="sm">Tambah soal pertama</InkButton>
                </EmptyState>
                <Pagination :links="questions.links" />
            </section>

            <!-- Students panel -->
            <section v-show="activeTab === 'students'" id="panel-students" role="tabpanel" aria-labelledby="tab-students" class="flex flex-col gap-4">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <p class="text-sm text-ink-soft">Hanya siswa terdaftar yang bisa mengerjakan ujian kursus ini.</p>
                    <InkButton type="button" size="sm" @click="openEnrollModal">
                        <Icon name="plus" class="size-4" />
                        Daftarkan siswa
                    </InkButton>
                </div>

                <ul v-if="students.data.length > 0" class="divide-y divide-rule overflow-hidden rounded-md border border-rule bg-paper">
                    <li v-for="student in students.data" :key="student.id" class="flex flex-wrap items-center gap-4 px-4 py-3.5 sm:px-5">
                        <span class="flex size-10 shrink-0 items-center justify-center rounded-full bg-rule/60 font-hand text-lg font-bold text-ink">
                            {{ student.name.charAt(0).toUpperCase() }}
                        </span>
                        <div class="min-w-0 flex-1">
                            <p class="truncate font-bold text-ink">{{ student.name }}</p>
                            <p class="truncate text-sm text-ink-soft">{{ student.email }}</p>
                        </div>
                        <GhostButton size="sm" variant="danger" @click="confirmUnenroll(student)">Keluarkan</GhostButton>
                    </li>
                </ul>
                <EmptyState
                    v-else
                    icon="users"
                    title="Belum ada siswa."
                    description="Daftarkan siswa supaya kursus ini muncul di menu Ujian saya mereka."
                />
                <Pagination :links="students.links" />
            </section>
        </div>

        <!-- Enroll students -->
        <Modal :show="isEnrollModalOpen" max-width="2xl" @close="isEnrollModalOpen = false">
            <div class="flex max-h-[85vh] flex-col">
                <div class="border-b border-rule p-5 sm:p-6">
                    <p class="font-form text-[11px] font-semibold uppercase tracking-[0.16em] text-pen">{{ course.name }}</p>
                    <h2 class="mt-1 font-hand text-2xl font-extrabold text-ink">Daftarkan siswa</h2>
                    <p class="mt-1 text-sm text-ink-soft">{{ unenrolledCandidates.length }} siswa belum terdaftar di kursus ini.</p>
                    <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center">
                        <div class="flex-1">
                            <SearchBar v-model="studentSearchQuery" label="Cari siswa" placeholder="Cari nama atau email…" />
                        </div>
                        <GhostButton size="sm" :disabled="unenrolledCandidates.length === 0" @click="toggleSelectAllUnenrolled">
                            {{ isAllUnenrolledSelected ? 'Batalkan semua' : 'Pilih semua yang belum terdaftar' }}
                        </GhostButton>
                    </div>
                </div>

                <ul v-if="filteredCandidates.length > 0" class="flex-1 divide-y divide-rule overflow-y-auto">
                    <li v-for="student in filteredCandidates" :key="student.id">
                        <label
                            :class="[
                                'flex items-center gap-4 px-5 py-3 sm:px-6',
                                student.is_enrolled ? 'cursor-not-allowed opacity-60' : 'cursor-pointer hover:bg-rule/20',
                                selectedStudentIds.includes(student.id) ? 'bg-stabilo/30' : '',
                            ]"
                        >
                            <input
                                type="checkbox"
                                class="size-5 rounded-[4px] border-2 border-ink-soft text-ink focus:ring-2 focus:ring-pen focus:ring-offset-2 focus:ring-offset-paper disabled:opacity-50"
                                :checked="student.is_enrolled || selectedStudentIds.includes(student.id)"
                                :disabled="student.is_enrolled"
                                @change="toggleStudentSelection(student.id, student.is_enrolled)"
                            />
                            <span class="min-w-0 flex-1">
                                <span class="block truncate font-bold text-ink">{{ student.name }}</span>
                                <span class="block truncate text-sm text-ink-soft">{{ student.email }}</span>
                            </span>
                            <StatusBadge v-if="student.is_enrolled" variant="info">Sudah terdaftar</StatusBadge>
                        </label>
                    </li>
                </ul>
                <p v-else class="flex-1 px-6 py-10 text-center text-ink-soft">
                    Tidak ada siswa yang cocok dengan “{{ studentSearchQuery }}”.
                </p>

                <div class="flex flex-col-reverse gap-3 border-t border-rule p-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                    <p class="font-form text-xs text-ink-soft">{{ selectedStudentIds.length }} dipilih</p>
                    <div class="flex flex-col-reverse gap-3 sm:flex-row">
                        <GhostButton size="sm" @click="isEnrollModalOpen = false">Batal</GhostButton>
                        <InkButton
                            type="button"
                            size="sm"
                            :disabled="selectedStudentIds.length === 0 || enrollForm.processing"
                            @click="submitEnrollment"
                        >
                            {{ enrollForm.processing ? 'Mendaftarkan…' : `Daftarkan ${selectedStudentIds.length} siswa` }}
                        </InkButton>
                    </div>
                </div>
            </div>
        </Modal>

        <AlertDialog
            :show="isDeleteDialogOpen"
            title="Hapus soal ini?"
            message="Soal dan pilihan jawabannya terhapus permanen dari kursus ini."
            confirm-text="Hapus soal"
            type="danger"
            @close="isDeleteDialogOpen = false"
            @confirm="deleteQuestion"
        />

        <AlertDialog
            :show="isUnenrollDialogOpen"
            title="Keluarkan siswa ini?"
            :message="studentToUnenroll ? `${studentToUnenroll.name} tidak bisa lagi mengerjakan ujian kursus ini. Riwayat nilainya tetap tersimpan.` : ''"
            confirm-text="Keluarkan"
            type="danger"
            @close="isUnenrollDialogOpen = false"
            @confirm="submitUnenroll"
        />
    </AdminLayout>
</template>
