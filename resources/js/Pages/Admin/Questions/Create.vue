<script setup>
import AdminLayout from '@/Components/Templates/AdminLayout.vue';
import Breadcrumbs from '@/Components/Molecules/Breadcrumbs.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import InputError from '@/Components/Atoms/InputError.vue';
import InputLabel from '@/Components/Atoms/InputLabel.vue';

const props = defineProps({
    course: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    question: '',
    answers: ['', '', '', ''],
    correct_answer: null,
    action: 'create_another',
});

const optionLetters = ['A', 'B', 'C', 'D'];

const selectCorrectAnswer = (index) => {
    form.correct_answer = index;
};

const submitWithAction = (actionType) => {
    form.action = actionType;
    form.post(route('dashboard.course.question.store', props.course.id));
};

const isFormValid = computed(() => {
    return form.question.trim().length > 0 &&
        form.answers.every(a => a.trim().length > 0) &&
        form.correct_answer !== null;
});
</script>

<template>
    <Head :title="'Tambah Soal: ' + course.name + ' · Naiju Studio'" />

    <AdminLayout>
        <div class="max-w-7xl mx-auto pb-20">
            <Breadcrumbs :items="[
                { label: 'Naiju Studio', href: route('dashboard.overview') },
                { label: 'Daftar Kursus', href: route('dashboard.courses.index') },
                { label: course.name, href: route('dashboard.courses.show', course.id) },
                { label: 'Tambah Soal' }
            ]" />

            <!-- Course Mini Bar -->
            <div class="w-full flex items-center justify-between mb-8 p-5 bg-white dark:bg-[#111116] rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs">
                <div class="flex items-center gap-4 min-w-0">
                    <div class="w-12 h-12 rounded-xl overflow-hidden shrink-0 bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                        <img v-if="course.cover" :src="'/storage/' + course.cover" class="w-full h-full object-cover" alt="cover">
                        <div v-else class="w-full h-full flex items-center justify-center font-black text-lg text-[#D95300]">
                            {{ course.name.charAt(0).toUpperCase() }}
                        </div>
                    </div>
                    <div class="min-w-0">
                        <span class="text-[10px] font-extrabold uppercase tracking-wider text-[#D95300]">Modul Asesmen</span>
                        <h2 class="font-bold text-base text-[#0A090B] dark:text-white truncate">{{ course.name }}</h2>
                    </div>
                </div>
                <Link
                    :href="route('dashboard.courses.show', course.id)"
                    class="px-3.5 py-1.5 rounded-lg text-xs font-bold text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                >
                    Kembali ke Detail Kursus
                </Link>
            </div>

            <!-- Error Banner -->
            <div v-if="Object.keys(form.errors).length > 0" class="mb-8 p-5 bg-rose-500/10 border border-rose-500/20 rounded-2xl">
                <div class="flex items-center gap-2.5 text-rose-600 dark:text-rose-400 font-bold mb-2 text-xs">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <span>Silakan perbaiki kesalahan berikut sebelum menyimpan:</span>
                </div>
                <ul class="text-[11px] text-rose-600 dark:text-rose-400 space-y-1 ml-6 list-disc font-semibold">
                    <li v-for="error in form.errors" :key="error">{{ error }}</li>
                </ul>
            </div>

            <!-- Split-Screen Grid: Form Input (Left) & Live Preview (Right) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <!-- Left: Form Input (7 Cols) -->
                <div class="lg:col-span-7 bg-white dark:bg-[#111116] p-7 lg:p-9 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-8 animate-slide-up">
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800/80 pb-5">
                        <div>
                            <h1 class="font-black text-xl lg:text-2xl text-[#0A090B] dark:text-white tracking-tight">
                                Editor Butir Soal Baru
                            </h1>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                                Masukkan pertanyaan pilihan ganda dan tentukan satu kunci jawaban benar.
                            </p>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-[#D95300]/10 text-[#D95300]">
                            Form Input
                        </span>
                    </div>

                    <form @submit.prevent="submitWithAction('create_another')" class="space-y-8">
                        <!-- Question Textarea -->
                        <div class="space-y-2.5">
                            <div class="flex items-center justify-between">
                                <InputLabel for="question" value="Naskah Pertanyaan" class="text-xs uppercase tracking-wider text-slate-600 dark:text-slate-300 font-bold" />
                                <span
                                    :class="[
                                        'text-[11px] font-semibold',
                                        form.question.length > 240 ? 'text-rose-500 font-bold' : 'text-slate-400 dark:text-slate-500'
                                    ]"
                                >
                                    {{ form.question.length }} / 255 karakter
                                </span>
                            </div>
                            <textarea
                                id="question"
                                v-model="form.question"
                                rows="4"
                                maxlength="255"
                                required
                                autofocus
                                placeholder="Tuliskan naskah soal secara jelas dan terstruktur..."
                                class="w-full p-4 bg-slate-50 dark:bg-[#141419] border border-slate-200 dark:border-slate-800 rounded-2xl text-slate-800 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-600 focus:outline-none focus:border-[#D95300] focus:ring-1 focus:ring-[#D95300] font-semibold text-sm transition-all leading-relaxed resize-none"
                            ></textarea>
                            <InputError :message="form.errors.question" />
                        </div>

                        <!-- Answer Options -->
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <InputLabel value="Opsi Pilihan Jawaban" class="text-xs uppercase tracking-wider text-slate-600 dark:text-slate-300 font-bold" />
                                    <p class="text-[11px] text-slate-400 dark:text-slate-500">Klik tombol di sisi kanan opsi untuk menetapkan kunci jawaban.</p>
                                </div>
                                <span v-if="form.correct_answer !== null" class="text-[10px] font-extrabold uppercase tracking-wider text-emerald-600 dark:text-emerald-400 px-2 py-0.5 rounded bg-emerald-500/10">
                                    Kunci: Opsi [{{ optionLetters[form.correct_answer] }}]
                                </span>
                            </div>

                            <div class="space-y-3.5">
                                <div
                                    v-for="(answer, idx) in form.answers"
                                    :key="idx"
                                    :class="[
                                        'flex items-center gap-3 p-3 rounded-2xl border transition-all duration-200',
                                        form.correct_answer === idx
                                            ? 'border-emerald-500 bg-emerald-500/5 dark:bg-emerald-500/10 ring-1 ring-emerald-500/30'
                                            : 'border-slate-200/80 dark:border-slate-800 bg-slate-50/50 dark:bg-[#141419]/50 hover:border-slate-300 dark:hover:border-slate-700'
                                    ]"
                                >
                                    <!-- Keycap [A], [B], [C], [D] Badge -->
                                    <div
                                        :class="[
                                            'w-10 h-10 rounded-xl flex items-center justify-center font-extrabold text-sm shrink-0 border transition-all',
                                            form.correct_answer === idx
                                                ? 'bg-emerald-500 text-white border-emerald-500 shadow-sm'
                                                : 'bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300'
                                        ]"
                                    >
                                        {{ optionLetters[idx] }}
                                    </div>

                                    <!-- Option Text Input -->
                                    <input
                                        type="text"
                                        v-model="form.answers[idx]"
                                        :placeholder="'Ketik teks pilihan ' + optionLetters[idx] + '...'"
                                        required
                                        class="flex-1 bg-transparent border-none text-slate-800 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-600 focus:outline-none font-semibold text-sm py-2 px-1"
                                    />

                                    <!-- Correct Answer Toggle Button -->
                                    <button
                                        type="button"
                                        @click="selectCorrectAnswer(idx)"
                                        :class="[
                                            'px-3 py-2 rounded-xl text-xs font-bold transition-all shrink-0 flex items-center gap-1.5',
                                            form.correct_answer === idx
                                                ? 'bg-emerald-500 text-white shadow-xs'
                                                : 'bg-slate-200/70 dark:bg-slate-800 hover:bg-emerald-500/20 text-slate-600 dark:text-slate-400 hover:text-emerald-600 dark:hover:text-emerald-400'
                                        ]"
                                    >
                                        <svg v-if="form.correct_answer === idx" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span>{{ form.correct_answer === idx ? 'Kunci Jawaban' : 'Tandai Kunci' }}</span>
                                    </button>
                                </div>
                            </div>
                            <InputError :message="form.errors.answers" />
                            <InputError :message="form.errors.correct_answer" />
                        </div>

                        <!-- Action Buttons: Aksi Ganda Cepat -->
                        <div class="pt-6 border-t border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-3">
                            <Link
                                :href="route('dashboard.courses.show', course.id)"
                                class="px-5 py-3 text-center bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold rounded-xl text-xs uppercase tracking-wider transition-all active:scale-95"
                            >
                                Batal
                            </Link>

                            <button
                                type="button"
                                @click="submitWithAction('finish')"
                                :disabled="form.processing || !isFormValid"
                                class="px-5 py-3 bg-white dark:bg-[#141419] border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-200 font-bold rounded-xl text-xs uppercase tracking-wider transition-all active:scale-95 disabled:opacity-50"
                            >
                                Simpan &amp; Selesai
                            </button>

                            <button
                                type="button"
                                @click="submitWithAction('create_another')"
                                :disabled="form.processing || !isFormValid"
                                class="px-6 py-3 bg-[#D95300] hover:bg-[#b84600] text-white font-bold rounded-xl text-xs uppercase tracking-wider transition-all shadow-md shadow-[#D95300]/20 hover:shadow-lg hover:shadow-[#D95300]/30 active:scale-95 flex items-center justify-center gap-2 disabled:opacity-50"
                            >
                                <span>Simpan &amp; Tambah Soal Berikutnya</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Right: Sticky Live Preview (5 Cols) -->
                <div class="lg:col-span-5 sticky top-8 space-y-4 animate-slide-up">
                    <div class="flex items-center justify-between px-2">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                Pratinjau Tampilan Siswa (CBT)
                            </span>
                        </div>
                        <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500">
                            Real-time Sync
                        </span>
                    </div>

                    <!-- Simulated CBT Question Card -->
                    <div class="bg-white dark:bg-[#111116] p-6 lg:p-7 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm relative overflow-hidden transition-all">
                        <!-- Card Header -->
                        <div class="flex items-center justify-between mb-5 pb-4 border-b border-slate-100 dark:border-slate-800/80">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-xl bg-[#2B82FE] text-white flex items-center justify-center font-black text-xs shadow-xs">
                                    ?
                                </div>
                                <div>
                                    <p class="text-[10px] font-extrabold uppercase tracking-widest text-[#2B82FE]">Naiju Exam</p>
                                    <p class="text-xs font-bold text-[#0A090B] dark:text-white">Simulasi Butir Ujian</p>
                                </div>
                            </div>
                            <span class="text-[10px] font-bold px-2 py-1 rounded bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 uppercase tracking-wider">
                                Pilihan Ganda
                            </span>
                        </div>

                        <!-- Live Question Text -->
                        <div class="mb-6">
                            <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-1.5">Pertanyaan</p>
                            <h3
                                :class="[
                                    'text-base font-bold leading-relaxed',
                                    form.question.trim()
                                        ? 'text-[#0A090B] dark:text-white'
                                        : 'text-slate-400 dark:text-slate-600 italic'
                                ]"
                            >
                                {{ form.question.trim() || 'Naskah soal akan tampil di sini saat Anda mengetik di formulir...' }}
                            </h3>
                        </div>

                        <!-- Live Answer Options Preview -->
                        <div class="space-y-2.5">
                            <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-1">Opsi Jawaban</p>
                            <div
                                v-for="(answer, idx) in form.answers"
                                :key="idx"
                                :class="[
                                    'flex items-center gap-3 p-3.5 rounded-xl border text-xs transition-all',
                                    form.correct_answer === idx
                                        ? 'border-emerald-500/70 bg-emerald-500/5 dark:bg-emerald-500/10'
                                        : 'border-slate-200/70 dark:border-slate-800 bg-slate-50/40 dark:bg-slate-800/20'
                                ]"
                            >
                                <div
                                    :class="[
                                        'w-7 h-7 rounded-lg flex items-center justify-center font-bold text-xs shrink-0 border',
                                        form.correct_answer === idx
                                            ? 'bg-emerald-500 text-white border-emerald-500 shadow-2xs'
                                            : 'bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300'
                                    ]"
                                >
                                    {{ optionLetters[idx] }}
                                </div>
                                <span
                                    :class="[
                                        'flex-1 font-semibold leading-snug',
                                        answer.trim()
                                            ? 'text-slate-700 dark:text-slate-200'
                                            : 'text-slate-400 dark:text-slate-600 italic'
                                    ]"
                                >
                                    {{ answer.trim() || 'Opsi jawaban ' + optionLetters[idx] }}
                                </span>
                                <span
                                    v-if="form.correct_answer === idx"
                                    class="text-[9px] font-extrabold uppercase tracking-wider text-emerald-600 dark:text-emerald-400 bg-emerald-500/10 px-1.5 py-0.5 rounded shrink-0"
                                >
                                    Kunci
                                </span>
                            </div>
                        </div>

                        <!-- Preview Status Footer -->
                        <div class="mt-6 pt-4 border-t border-slate-100 dark:border-slate-800/80 flex items-center justify-between text-[11px]">
                            <span class="text-slate-400 dark:text-slate-500">Status Validitas:</span>
                            <span
                                :class="[
                                    'font-bold',
                                    isFormValid ? 'text-emerald-600 dark:text-emerald-400' : 'text-amber-500'
                                ]"
                            >
                                {{ isFormValid ? 'Siap Disimpan' : 'Lengkapi naskah & kunci' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<style scoped>
@keyframes slideUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
.animate-slide-up { animation: slideUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
</style>
