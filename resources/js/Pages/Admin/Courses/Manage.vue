<script setup>
import AdminLayout from '@/Components/Templates/AdminLayout.vue';
import AlertDialog from '@/Components/Organisms/AlertDialog.vue';
import Breadcrumbs from '@/Components/Molecules/Breadcrumbs.vue';
import Pagination from '@/Components/Molecules/Pagination.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted } from 'vue';

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

const isDropdownOpen = ref(false);
const moreButton = ref(null);

const toggleDropdown = (e) => {
    e.stopPropagation();
    isDropdownOpen.value = !isDropdownOpen.value;
};

const closeDropdown = (e) => {
    if (moreButton.value && !moreButton.value.contains(e.target)) {
        isDropdownOpen.value = false;
    }
};

onMounted(() => {
    document.addEventListener('click', closeDropdown);
});

onUnmounted(() => {
    document.removeEventListener('click', closeDropdown);
});

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
    <Head :title="'Detail Kursus: ' + course.name + ' · Naiju Studio'" />

    <AdminLayout>
        <div class="flex flex-col">
            <Breadcrumbs :items="[
                { label: 'Naiju Studio', href: route('dashboard.overview') },
                { label: 'Daftar Kursus', href: route('dashboard.courses.index') },
                { label: course.name }
            ]" />
        </div>

        <!-- Header Card -->
        <div class="w-full flex flex-col lg:flex-row items-start lg:items-center justify-between mb-12 animate-slide-up gap-8 bg-white dark:bg-[#111116] p-7 lg:p-10 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-xs">
            <div class="flex flex-col lg:flex-row gap-8 items-center lg:items-start text-center lg:text-left">
                <div class="w-36 h-36 lg:w-44 lg:h-44 flex shrink-0 relative overflow-hidden rounded-3xl border border-slate-200 dark:border-slate-800 bg-slate-100 dark:bg-slate-800 group">
                    <img v-if="course.cover" :src="'/storage/' + course.cover" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="cover">
                    <div v-else class="w-full h-full flex items-center justify-center font-black text-4xl text-[#D95300]">
                        {{ course.name ? course.name.charAt(0).toUpperCase() : 'C' }}
                    </div>
                    <div v-if="course.category"
                        class="absolute bottom-3 left-1/2 -translate-x-1/2 px-3.5 py-1 rounded-full bg-white/95 dark:bg-[#111116]/95 backdrop-blur-md shadow-xs border border-slate-200/60 dark:border-slate-700">
                        <p class="font-extrabold text-[10px] text-[#D95300] uppercase tracking-widest whitespace-nowrap">
                            {{ course.category?.name }}
                        </p>
                    </div>
                </div>

                <div class="flex flex-col gap-6 max-w-xl">
                    <div class="space-y-2">
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 rounded-full border border-emerald-500/20">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span class="text-[10px] font-extrabold uppercase tracking-widest">Modul Aktif</span>
                        </div>
                        <h1 class="font-black text-2xl lg:text-4xl leading-tight text-[#0A090B] dark:text-white tracking-tight">
                            {{ course.name }}
                        </h1>
                    </div>

                    <div class="flex flex-wrap items-center justify-center lg:justify-start gap-8">
                        <div class="flex gap-3.5 items-center">
                            <div class="w-11 h-11 flex shrink-0 items-center justify-center bg-slate-100 dark:bg-slate-800 rounded-xl text-slate-500 dark:text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Tanggal Dibuat</p>
                                <p class="font-extrabold text-sm text-[#0A090B] dark:text-white">{{ formatDate(course.created_at) }}</p>
                            </div>
                        </div>
                        <div class="flex gap-3.5 items-center">
                            <div class="w-11 h-11 flex shrink-0 items-center justify-center bg-slate-100 dark:bg-slate-800 rounded-xl text-slate-500 dark:text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Total Siswa</p>
                                <p class="font-extrabold text-sm text-[#0A090B] dark:text-white">{{ students.total }} Peserta</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="relative self-center lg:self-start" ref="moreButton">
                <Link
                    :href="route('dashboard.courses.edit', course.id)"
                    class="px-5 py-3 bg-slate-100 dark:bg-slate-800 hover:bg-[#D95300] hover:text-white text-slate-700 dark:text-slate-200 rounded-2xl font-bold text-xs uppercase tracking-wider transition-all flex items-center gap-2"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Edit Informasi Kursus</span>
                </Link>
            </div>
        </div>

        <!-- Questions Section -->
        <div class="mt-8 pb-20">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
                <div class="flex flex-col gap-1">
                    <h2 class="font-black text-2xl lg:text-3xl text-[#0A090B] dark:text-white tracking-tight">Bank Soal & Asesmen</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-sm">Kelola butir soal pilihan ganda dan kunci jawaban untuk ujian ini.</p>
                </div>
                <div class="px-4 py-2 bg-[#0A090B] dark:bg-white text-white dark:text-[#0A090B] rounded-xl text-xs font-bold uppercase tracking-wider self-start sm:self-auto">
                    {{ questions.total }} Butir Soal Terdaftar
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5">
                <!-- Add New Question Card -->
                <Link :href="route('dashboard.course.question.create', course.id)"
                    class="w-full group bg-[#D95300] hover:bg-[#b84600] p-1 rounded-3xl shadow-lg shadow-[#D95300]/20 hover:shadow-xl hover:shadow-[#D95300]/30 transition-all active:scale-[0.99]">
                    <div class="w-full h-28 flex items-center justify-center p-6 border-2 border-dashed border-white/40 rounded-2xl group-hover:border-white/70 transition-colors">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-white text-[#D95300] flex items-center justify-center shadow-md group-hover:scale-105 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14" stroke-width="3" stroke-linecap="round"/></svg>
                            </div>
                            <div class="flex flex-col text-left">
                                <p class="font-black text-lg text-white">Buat Pertanyaan Baru</p>
                                <p class="text-white/80 font-semibold text-xs">Tambahkan butir soal beserta opsi pilihan jawaban</p>
                            </div>
                        </div>
                    </div>
                </Link>

                <!-- Question Rows -->
                <div
                    v-for="(question, index) in questions.data"
                    :key="question.id"
                    class="w-full flex flex-col lg:flex-row lg:items-center justify-between p-6 lg:p-7 bg-white dark:bg-[#111116] border border-slate-200/80 dark:border-slate-800 rounded-3xl hover:border-[#D95300]/40 dark:hover:border-[#D95300]/40 transition-all group animate-slide-up relative overflow-hidden"
                >
                    <div class="flex items-start lg:items-center gap-5 lg:w-[70%]">
                        <div class="w-12 h-12 shrink-0 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center font-black text-base text-slate-500 dark:text-slate-400 border border-slate-200 dark:border-slate-700 group-hover:bg-[#D95300]/10 group-hover:text-[#D95300] transition-colors">
                            {{ (questions.current_page - 1) * questions.per_page + index + 1 }}
                        </div>
                        <div class="flex flex-col gap-1.5 min-w-0">
                            <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Teks Pertanyaan</span>
                            <p class="font-bold text-base text-[#0A090B] dark:text-white leading-relaxed">{{ question.question }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2.5 mt-5 lg:mt-0 justify-end">
                        <Link
                            :href="route('dashboard.course.question.edit', { courseId: course.id, questionId: question.id })"
                            class="px-5 py-2.5 bg-slate-100 dark:bg-slate-800 hover:bg-[#D95300] hover:text-white text-slate-700 dark:text-slate-200 font-bold rounded-xl text-xs uppercase tracking-wider transition-all active:scale-95"
                        >
                            Edit Soal
                        </Link>
                        <button
                            @click="confirmDeleteQuestion(question.id)"
                            class="w-10 h-10 flex shrink-0 items-center justify-center rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-rose-500 hover:bg-rose-500 hover:text-white transition-all active:scale-95 shadow-xs"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Empty State -->
                <div v-if="questions.data.length === 0" class="py-20 bg-white dark:bg-[#111116] rounded-3xl text-center border-2 border-dashed border-slate-200 dark:border-slate-800">
                    <p class="text-slate-500 dark:text-slate-400 font-bold text-base">Belum ada butir soal dalam modul ujian ini.</p>
                    <p class="text-slate-400 dark:text-slate-500 text-xs mt-1">Mulai buat soal pilihan ganda di atas agar siswa dapat mengikuti ujian CBT.</p>
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    <Pagination :links="questions.links" />
                </div>
            </div>
        </div>

        <AlertDialog
            :show="isDeleteDialogOpen"
            title="Hapus Pertanyaan Ini?"
            message="Apakah Anda yakin ingin menghapus butir soal ini beserta seluruh opsi jawabannya? Tindakan ini tidak dapat dibatalkan."
            confirm-text="Ya, Hapus Soal"
            cancel-text="Batal"
            type="danger"
            @close="isDeleteDialogOpen = false"
            @confirm="deleteQuestion"
        />
    </AdminLayout>
</template>

<style scoped>
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
@keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
.animate-fade-in { animation: fadeIn 0.6s ease-out forwards; }
.animate-slide-up { animation: slideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
</style>