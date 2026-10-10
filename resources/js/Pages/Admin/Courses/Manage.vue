<script setup>
import AdminLayout from '@/Components/Templates/AdminLayout.vue';
import AlertDialog from '@/Components/Organisms/AlertDialog.vue';
import Breadcrumbs from '@/Components/Molecules/Breadcrumbs.vue';
import Pagination from '@/Components/Molecules/Pagination.vue';
import CourseThumbnail from '@/Components/Atoms/CourseThumbnail.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

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
});

const activeTab = ref('questions');
const isDeleteDialogOpen = ref(false);
const selectedQuestionId = ref(null);

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

const formatDate = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
    });
};
</script>

<template>
    <Head :title="'Kelola Kursus: ' + course.name + ' · Naiju Studio'" />

    <AdminLayout>
        <div class="max-w-7xl mx-auto pb-20">
            <Breadcrumbs :items="[
                { label: 'Naiju Studio', href: route('dashboard.overview') },
                { label: 'Daftar Kursus', href: route('dashboard.courses.index') },
                { label: course.name }
            ]" />

            <!-- Header Card: Editorial & Industrial CBT -->
            <div class="w-full bg-white dark:bg-[#111116] p-7 lg:p-8 rounded-3xl border border-slate-200/80 dark:border-slate-800 mb-8 animate-slide-up">
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6 min-w-0">
                        <!-- Thumbnail Cover -->
                        <div class="w-24 h-24 lg:w-28 lg:h-28 rounded-2xl overflow-hidden shrink-0 border border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-800">
                            <CourseThumbnail
                                :src="course.cover"
                                :name="course.name"
                                theme="teacher"
                                monogramClass="text-2xl"
                            />
                        </div>

                        <!-- Meta Info -->
                        <div class="space-y-2 min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span v-if="course.category" class="px-2.5 py-0.5 rounded text-[10px] font-extrabold uppercase tracking-widest bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200/60 dark:border-slate-700">
                                    {{ course.category.name }}
                                </span>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded text-[10px] font-extrabold uppercase tracking-widest bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    <span>Modul Siap Uji</span>
                                </span>
                            </div>

                            <h1 class="font-black text-2xl lg:text-3xl text-[#0A090B] dark:text-white tracking-tight leading-snug">
                                {{ course.name }}
                            </h1>

                            <div class="flex items-center gap-6 text-xs text-slate-500 dark:text-slate-400 font-semibold pt-1">
                                <div>
                                    <span class="text-slate-400 dark:text-slate-500 font-normal">Dibuat:</span> {{ formatDate(course.created_at) }}
                                </div>
                                <div>
                                    <span class="text-slate-400 dark:text-slate-500 font-normal">Soal:</span> <span class="text-[#D95300] font-bold">{{ questions.total }}</span> Butir
                                </div>
                                <div>
                                    <span class="text-slate-400 dark:text-slate-500 font-normal">Peserta:</span> <span class="font-bold text-[#0A090B] dark:text-white">{{ students.total }}</span> Siswa
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Header Actions -->
                    <div class="flex items-center gap-3 self-stretch sm:self-auto justify-end">
                        <Link
                            :href="route('dashboard.courses.edit', course.id)"
                            class="px-4 py-2.5 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 rounded-xl font-bold text-xs uppercase tracking-wider transition-colors flex items-center gap-2"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span>Edit Kursus</span>
                        </Link>
                        <Link
                            :href="route('dashboard.course.question.create', course.id)"
                            class="px-5 py-2.5 bg-[#D95300] hover:bg-[#b84600] text-white rounded-xl font-bold text-xs uppercase tracking-wider transition-colors flex items-center gap-2"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M12 4v16m8-8H4" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span>Tambah Soal</span>
                        </Link>
                    </div>
                </div>
            </div>

            <!-- Tab Switcher -->
            <div class="flex items-center gap-2 p-1.5 bg-slate-100 dark:bg-[#141419] rounded-2xl border border-slate-200/80 dark:border-slate-800 w-fit mb-6">
                <button
                    @click="activeTab = 'questions'"
                    :class="[
                        'px-5 py-2 rounded-xl text-xs font-bold transition-all',
                        activeTab === 'questions'
                            ? 'bg-white dark:bg-[#111116] text-[#0A090B] dark:text-white shadow-xs'
                            : 'text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-white'
                    ]"
                >
                    Bank Soal &amp; Asesmen ({{ questions.total }})
                </button>
                <button
                    @click="activeTab = 'students'"
                    :class="[
                        'px-5 py-2 rounded-xl text-xs font-bold transition-all',
                        activeTab === 'students'
                            ? 'bg-white dark:bg-[#111116] text-[#0A090B] dark:text-white shadow-xs'
                            : 'text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-white'
                    ]"
                >
                    Peserta Didik Terdaftar ({{ students.total }})
                </button>
            </div>

            <!-- TAB 1: Bank Soal & Asesmen -->
            <div v-if="activeTab === 'questions'" class="space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="font-black text-xl text-[#0A090B] dark:text-white tracking-tight">Daftar Butir Pertanyaan</h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Seluruh pertanyaan pilihan ganda yang disajikan saat sesi ujian CBT berlangsung.</p>
                    </div>
                    <Link
                        :href="route('dashboard.course.question.create', course.id)"
                        class="px-4 py-2 bg-slate-100 dark:bg-slate-800 hover:bg-[#D95300] hover:text-white text-slate-700 dark:text-slate-200 rounded-xl text-xs font-bold transition-colors flex items-center gap-1.5"
                    >
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M12 4v16m8-8H4" stroke-width="2.5" stroke-linecap="round"/>
                        </svg>
                        <span>Buat Soal Baru</span>
                    </Link>
                </div>

                <!-- Questions List -->
                <div class="space-y-3 pt-2">
                    <div
                        v-for="(question, index) in questions.data"
                        :key="question.id"
                        class="p-5 lg:p-6 bg-white dark:bg-[#111116] rounded-2xl border border-slate-200/80 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700 transition-colors flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4"
                    >
                        <div class="flex items-start gap-4 flex-1 min-w-0">
                            <!-- Question Number Badge -->
                            <div class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center font-bold text-xs text-slate-600 dark:text-slate-300 shrink-0">
                                {{ (questions.current_page - 1) * questions.per_page + index + 1 }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-1">
                                    Butir Soal #{{ (questions.current_page - 1) * questions.per_page + index + 1 }}
                                </p>
                                <p class="font-bold text-sm text-[#0A090B] dark:text-white leading-relaxed">
                                    {{ question.question }}
                                </p>
                            </div>
                        </div>

                        <!-- Question Row Actions -->
                        <div class="flex items-center gap-2 self-end sm:self-center shrink-0">
                            <Link
                                :href="route('dashboard.course.question.edit', { courseId: course.id, questionId: question.id })"
                                class="px-3.5 py-1.5 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 text-xs font-bold rounded-lg transition-colors"
                            >
                                Edit Soal
                            </Link>
                            <button
                                @click="confirmDeleteQuestion(question.id)"
                                class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800 hover:bg-rose-500 hover:text-white text-rose-500 flex items-center justify-center transition-colors"
                                title="Hapus Soal"
                            >
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Empty State -->
                    <div v-if="questions.data.length === 0" class="py-16 bg-white dark:bg-[#111116] rounded-2xl text-center border border-slate-200/80 dark:border-slate-800">
                        <p class="font-bold text-base text-[#0A090B] dark:text-white">Belum ada butir soal dalam modul ini.</p>
                        <p class="text-xs text-slate-400 dark:text-slate-500 mt-1 mb-6">Mulai masukkan butir soal pilihan ganda agar modul ini dapat diujikan.</p>
                        <Link
                            :href="route('dashboard.course.question.create', course.id)"
                            class="px-5 py-2.5 bg-[#D95300] hover:bg-[#b84600] text-white text-xs font-bold uppercase tracking-wider rounded-xl transition-colors"
                        >
                            Buat Pertanyaan Pertama
                        </Link>
                    </div>

                    <!-- Pagination -->
                    <div class="pt-6">
                        <Pagination :links="questions.links" />
                    </div>
                </div>
            </div>

            <!-- TAB 2: Peserta Didik Terdaftar -->
            <div v-if="activeTab === 'students'" class="space-y-4">
                <div>
                    <h2 class="font-black text-xl text-[#0A090B] dark:text-white tracking-tight">Peserta Didik Terdaftar</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Daftar siswa yang memiliki hak akses untuk mengikuti sesi ujian modul ini.</p>
                </div>

                <div class="space-y-3 pt-2">
                    <div
                        v-for="student in students.data"
                        :key="student.id"
                        class="p-5 bg-white dark:bg-[#111116] rounded-2xl border border-slate-200/80 dark:border-slate-800 flex items-center justify-between"
                    >
                        <div class="flex items-center gap-3.5">
                            <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center font-bold text-xs text-slate-600 dark:text-slate-300">
                                {{ student.name.charAt(0).toUpperCase() }}
                            </div>
                            <div>
                                <p class="font-bold text-sm text-[#0A090B] dark:text-white">{{ student.name }}</p>
                                <p class="text-xs text-slate-400 dark:text-slate-500 font-medium">{{ student.email }}</p>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 rounded text-[10px] font-extrabold uppercase tracking-widest bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20">
                            Terdaftar
                        </span>
                    </div>

                    <div v-if="students.data.length === 0" class="py-16 bg-white dark:bg-[#111116] rounded-2xl text-center border border-slate-200/80 dark:border-slate-800">
                        <p class="font-bold text-base text-[#0A090B] dark:text-white">Belum ada siswa yang terdaftar dalam modul ini.</p>
                        <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">Siswa akan otomatis muncul setelah didaftarkan ke kursus.</p>
                    </div>

                    <!-- Pagination -->
                    <div class="pt-6">
                        <Pagination :links="students.links" />
                    </div>
                </div>
            </div>
        </div>

        <AlertDialog
            :show="isDeleteDialogOpen"
            title="Hapus Butir Soal Ini?"
            message="Butir pertanyaan ini beserta seluruh opsi jawabannya akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan."
            confirm-text="Hapus Soal"
            cancel-text="Batal"
            type="danger"
            @close="isDeleteDialogOpen = false"
            @confirm="deleteQuestion"
        />
    </AdminLayout>
</template>
