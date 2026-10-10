<script setup>
import { ref, computed, onMounted } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import CountdownTimer from '@/Components/Molecules/CountdownTimer.vue';
import QuestionCard from '@/Components/Organisms/QuestionCard.vue';
import ThemeToggle from '@/Components/Atoms/ThemeToggle.vue';
import AlertDialog from '@/Components/Organisms/AlertDialog.vue';

const props = defineProps({
    course: Object,
    assessment: Object,
    serverTime: String
});

const currentQuestionIndex = ref(0);
const answers = ref({}); // Local state for all answers {questionId: answerText}
const isSaving = ref(false);
const isConfirmDialogOpen = ref(false);

// Key for localStorage to prevent conflicts between assessments
const storageKey = computed(() => `assessment_progress_${props.assessment.id}`);
const indexKey = computed(() => `assessment_index_${props.assessment.id}`);

// Load answers and last index from localStorage on mount
onMounted(() => {
    const savedProgress = localStorage.getItem(storageKey.value);
    if (savedProgress) {
        try {
            answers.value = JSON.parse(savedProgress);
        } catch (e) {
            console.error('Gagal memuat progres ujian tersimpan', e);
        }
    }

    const savedIndex = localStorage.getItem(indexKey.value);
    if (savedIndex) {
        currentQuestionIndex.value = parseInt(savedIndex);
    }
});

const currentQuestion = computed(() => props.course.questions[currentQuestionIndex.value]);

// Check if a question has been answered
const isAnswered = (questionId) => {
    return !!answers.value[questionId];
};

const totalAnswered = computed(() => {
    return Object.keys(answers.value).filter(k => !!answers.value[k]).length;
});

const handleSaveAnswer = (answer) => {
    isSaving.value = true;
    answers.value[currentQuestion.value.id] = answer;
    // Persist to localStorage
    localStorage.setItem(storageKey.value, JSON.stringify(answers.value));
    setTimeout(() => {
        isSaving.value = false;
    }, 400);
};

const handleTimeout = () => {
    submitExam();
};

const submitExam = () => {
    router.post(route('dashboard.learning.finish', props.assessment.id), {
        answers: answers.value
    }, {
        onSuccess: () => {
            // Clear progress on success
            localStorage.removeItem(storageKey.value);
            localStorage.removeItem(indexKey.value);
        }
    });
};

const nextQuestion = () => {
    if (currentQuestionIndex.value < props.course.questions.length - 1) {
        currentQuestionIndex.value++;
        localStorage.setItem(indexKey.value, currentQuestionIndex.value);
    }
};

const prevQuestion = () => {
    if (currentQuestionIndex.value > 0) {
        currentQuestionIndex.value--;
        localStorage.setItem(indexKey.value, currentQuestionIndex.value);
    }
};

const goToQuestion = (idx) => {
    currentQuestionIndex.value = idx;
    localStorage.setItem(indexKey.value, currentQuestionIndex.value);
};

const finishTest = () => {
    isConfirmDialogOpen.value = true;
};
</script>

<template>
    <Head :title="'Ruang Ujian: ' + course.name + ' · Naiju Exam'" />

    <div class="min-h-screen bg-[#F8F9FA] dark:bg-[#0A090B] font-poppins text-[#0A090B] dark:text-slate-100 transition-colors">
        <!-- CBT Distraction-Free Top Bar -->
        <header class="sticky top-0 z-50 bg-white/80 dark:bg-[#0E0E12]/80 backdrop-blur-md border-b border-slate-200/80 dark:border-slate-800 h-20 px-6 lg:px-10 flex items-center justify-between transition-colors">
            <!-- Brand & Course Info -->
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-[#2B82FE] rounded-xl flex items-center justify-center text-white shrink-0">
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                        <path d="M4 3.5H8.2L15.8 15.3V3.5H20V20.5H15.8L8.2 8.7V20.5H4V3.5Z" />
                    </svg>
                </div>
                <div class="flex flex-col">
                    <div class="flex items-center gap-2">
                        <h2 class="font-bold text-base lg:text-lg leading-tight text-[#0A090B] dark:text-white truncate max-w-[200px] sm:max-w-xs md:max-w-md">
                            {{ course.name }}
                        </h2>
                        <span class="hidden sm:inline-flex px-2 py-0.5 rounded-md text-[10px] font-bold bg-[#2B82FE]/10 text-[#2B82FE] border border-[#2B82FE]/20 uppercase tracking-wider">
                            CBT Aktif
                        </span>
                    </div>
                    <div class="flex items-center gap-2 text-xs text-slate-400 dark:text-slate-500 font-medium">
                        <span>Portal Ujian Siswa</span>
                        <span>•</span>
                        <span class="inline-flex items-center gap-1.5 text-emerald-500">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            Tersinkronisasi
                        </span>
                    </div>
                </div>
            </div>

            <!-- Right Controls: Timer, Theme Toggle, End Exam -->
            <div class="flex items-center gap-3 sm:gap-5">
                <div class="hidden sm:flex flex-col text-right">
                    <span class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider">Sisa Waktu</span>
                    <CountdownTimer
                        :startTime="assessment.started_at"
                        :durationHours="90"
                        @timeout="handleTimeout"
                    />
                </div>

                <div class="h-8 w-[1px] bg-slate-200 dark:bg-slate-800 hidden sm:block"></div>

                <!-- Global Theme Toggle -->
                <ThemeToggle />

                <div class="h-8 w-[1px] bg-slate-200 dark:bg-slate-800 hidden sm:block"></div>

                <!-- Finish Exam Button -->
                <button
                    @click="finishTest"
                    class="px-5 py-2.5 bg-rose-500 hover:bg-rose-600 text-white rounded-xl font-bold text-xs uppercase tracking-wider transition-all shadow-md shadow-rose-500/20 active:scale-95 shrink-0"
                >
                    Selesaikan Ujian
                </button>
            </div>
        </header>

        <!-- Main Workspace -->
        <main class="py-8 px-6 lg:px-10 max-w-7xl mx-auto flex flex-col lg:flex-row gap-8">
            <!-- Left Column: Question Workspace -->
            <div class="flex-1 flex flex-col gap-6">
                <!-- Mobile Timer Bar -->
                <div class="sm:hidden flex items-center justify-between p-4 bg-white dark:bg-[#111116] border border-slate-200/80 dark:border-slate-800 rounded-2xl">
                    <div class="flex flex-col">
                        <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase">Sisa Waktu</span>
                        <span class="text-xs font-semibold text-slate-700 dark:text-slate-300">Pengerjaan</span>
                    </div>
                    <CountdownTimer
                        :startTime="assessment.started_at"
                        :durationHours="90"
                        @timeout="handleTimeout"
                    />
                </div>

                <!-- Status & Progress Bar -->
                <div class="bg-white dark:bg-[#111116] p-5 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs flex flex-col gap-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-sm text-[#0A090B] dark:text-white">Progres Lembar Soal</span>
                            <span class="text-xs font-semibold text-slate-400 dark:text-slate-500">
                                ({{ totalAnswered }} dari {{ course.questions.length }} dijawab)
                            </span>
                        </div>
                        <span class="text-xs font-mono font-bold text-[#2B82FE]">
                            {{ Math.round((totalAnswered / course.questions.length) * 100) }}%
                        </span>
                    </div>
                    <div class="w-full bg-slate-100 dark:bg-slate-800 rounded-full h-2 overflow-hidden">
                        <div
                            class="bg-[#2B82FE] h-full transition-all duration-300 rounded-full"
                            :style="{ width: ((totalAnswered / course.questions.length) * 100) + '%' }"
                        ></div>
                    </div>
                </div>

                <!-- Question Card -->
                <QuestionCard
                    :key="currentQuestion.id"
                    :question="currentQuestion"
                    :index="currentQuestionIndex"
                    :selectedAnswer="answers[currentQuestion.id] || ''"
                    :saving="isSaving"
                    @save="handleSaveAnswer"
                />

                <!-- Navigation Action Buttons -->
                <div class="flex items-center justify-between gap-4 pt-2">
                    <button
                        @click="prevQuestion"
                        :disabled="currentQuestionIndex === 0"
                        class="px-6 py-3.5 bg-white dark:bg-[#111116] border border-slate-200/80 dark:border-slate-800 rounded-2xl font-bold text-xs uppercase tracking-wider text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800/80 transition-all disabled:opacity-40 disabled:pointer-events-none shadow-xs flex items-center gap-2"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                        </svg>
                        <span>Soal Sebelumnya</span>
                    </button>

                    <button
                        v-if="currentQuestionIndex < course.questions.length - 1"
                        @click="nextQuestion"
                        class="px-7 py-3.5 bg-[#2B82FE] hover:bg-blue-600 text-white rounded-2xl font-bold text-xs uppercase tracking-wider transition-colors active:scale-95 flex items-center gap-2"
                    >
                        <span>Soal Berikutnya</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                    <button
                        v-else
                        @click="finishTest"
                        class="px-8 py-3.5 bg-emerald-600 hover:bg-emerald-500 text-white rounded-2xl font-bold text-xs uppercase tracking-wider transition-colors active:scale-95 flex items-center gap-2"
                    >
                        <span>Kumpulkan Ujian</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Right Column: Question Navigator Palette -->
            <aside class="w-full lg:w-[340px] flex flex-col gap-6">
                <div class="bg-white dark:bg-[#111116] border border-slate-200/80 dark:border-slate-800 rounded-3xl p-6 lg:p-7 flex flex-col gap-6 sticky top-28 shadow-xs">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800/80">
                        <h4 class="font-bold text-base text-[#0A090B] dark:text-white">Navigasi Butir Soal</h4>
                        <span class="text-xs font-bold text-[#2B82FE] bg-[#2B82FE]/10 px-2.5 py-1 rounded-lg">
                            {{ course.questions.length }} Butir
                        </span>
                    </div>

                    <!-- Number Grid -->
                    <div class="grid grid-cols-5 gap-2.5 max-h-[360px] overflow-y-auto pr-1">
                        <button
                            v-for="(question, idx) in course.questions"
                            :key="idx"
                            @click="goToQuestion(idx)"
                            class="w-full aspect-square rounded-xl flex items-center justify-center text-xs font-bold transition-all border relative"
                            :class="[
                                currentQuestionIndex === idx
                                ? 'bg-[#2B82FE] border-[#2B82FE] text-white scale-105 z-10'
                                : (isAnswered(question.id)
                                    ? 'bg-emerald-500/10 dark:bg-emerald-500/20 border-emerald-500/40 text-emerald-600 dark:text-emerald-400 font-extrabold'
                                    : 'bg-slate-50 dark:bg-slate-800/60 border-slate-200/80 dark:border-slate-800 text-slate-500 dark:text-slate-400 hover:border-[#2B82FE] hover:text-[#2B82FE]')
                            ]"
                        >
                            {{ idx + 1 }}
                            <div v-if="isAnswered(question.id) && currentQuestionIndex !== idx" class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-emerald-500 rounded-full border-2 border-white dark:border-[#111116]"></div>
                        </button>
                    </div>

                    <!-- Color Status Legend -->
                    <div class="pt-4 border-t border-slate-100 dark:border-slate-800/80 flex flex-col gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-3.5 h-3.5 rounded-md bg-[#2B82FE]"></div>
                            <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Sedang Dikerjakan</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-3.5 h-3.5 rounded-md bg-emerald-500"></div>
                            <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Sudah Terjawab</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-3.5 h-3.5 rounded-md bg-slate-100 dark:bg-slate-800 border border-slate-300 dark:border-slate-700"></div>
                            <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Belum Terjawab</span>
                        </div>
                    </div>
                </div>
            </aside>
        </main>

        <!-- Final Confirmation Modal -->
        <AlertDialog
            :show="isConfirmDialogOpen"
            title="Selesaikan Ujian Sekarang?"
            :message="'Anda telah menjawab ' + totalAnswered + ' dari ' + course.questions.length + ' soal. Setelah dikumpulkan, lembar jawaban akan langsung dinilai oleh sistem.'"
            confirm-text="Ya, Kumpulkan Jawaban"
            cancel-text="Lanjut Mengerjakan"
            type="primary"
            @close="isConfirmDialogOpen = false"
            @confirm="submitExam"
        />
    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap');
.font-poppins { font-family: 'Poppins', sans-serif; }
</style>