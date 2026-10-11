<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import axios from 'axios';
import CountdownTimer from '@/Components/Molecules/CountdownTimer.vue';
import QuestionCard from '@/Components/Organisms/QuestionCard.vue';
import ThemeToggle from '@/Components/Atoms/ThemeToggle.vue';
import ExamSubmitModal from '@/Components/Organisms/ExamSubmitModal.vue';
import ProctoringModal from '@/Components/Organisms/ProctoringModal.vue';

const props = defineProps({
    course: Object,
    assessment: Object,
    serverTime: String,
    maxViolationsAllowed: {
        type: Number,
        default: 3,
    },
});

const currentQuestionIndex = ref(0);
const answers = ref({}); // Local state for all answers {questionId: answerText}
const isSaving = ref(false);
const isConfirmDialogOpen = ref(false);
const isSubmittingExam = ref(false);

// Proctoring & Fullscreen State
const isFullscreen = ref(false);
const hasStartedExam = ref(false);
const violationCount = ref(props.assessment.violations_count || 0);
const proctoringState = ref('pre_exam'); // 'pre_exam' | 'warning' | 'limit_reached'
const showProctoringModal = ref(true);
const lastViolationTimestamp = ref(0);

// Keys for localStorage to persist state across sessions
const storageKey = computed(() => `assessment_progress_${props.assessment.id}`);
const indexKey = computed(() => `assessment_index_${props.assessment.id}`);
const violationKey = computed(() => `assessment_violations_${props.assessment.id}`);
const startedKey = computed(() => `assessment_started_${props.assessment.id}`);

// Request Fullscreen on Document
const enterFullscreen = async () => {
    try {
        const elem = document.documentElement;
        if (elem.requestFullscreen) {
            await elem.requestFullscreen();
        } else if (elem.webkitRequestFullscreen) {
            await elem.webkitRequestFullscreen();
        }
        isFullscreen.value = true;
        return true;
    } catch (err) {
        console.warn('Fullscreen request could not be granted:', err);
        return false;
    }
};

// Start exam and enter fullscreen
const handleStartFullscreen = async () => {
    await enterFullscreen();
    hasStartedExam.value = true;
    localStorage.setItem(startedKey.value, 'true');
    showProctoringModal.value = false;
};

// Resume exam from warning
const handleResumeFullscreen = async () => {
    await enterFullscreen();
    showProctoringModal.value = false;
};

// Trigger violation with 1500ms debounce to prevent double-counting across blur/visibilitychange/fullscreenchange
const triggerViolation = (reason = '') => {
    if (!hasStartedExam.value || isSubmittingExam.value) {
        return;
    }

    const now = Date.now();
    if (now - lastViolationTimestamp.value < 1500) {
        return;
    }
    lastViolationTimestamp.value = now;

    violationCount.value++;
    localStorage.setItem(violationKey.value, violationCount.value.toString());

    // Asynchronously record violation to the server
    axios.post(route('dashboard.learning.violation', props.assessment.id))
        .catch((err) => {
            console.error('Gagal mencatat pelanggaran ke server:', err);
        });

    if (violationCount.value > props.maxViolationsAllowed) {
        proctoringState.value = 'limit_reached';
        showProctoringModal.value = true;

        // Auto submit exam after short grace display
        setTimeout(() => {
            submitExam('violation_limit');
        }, 1500);
    } else {
        proctoringState.value = 'warning';
        showProctoringModal.value = true;
    }
};

// Event Listeners for Proctoring
const handleFullscreenChange = () => {
    isFullscreen.value = !!document.fullscreenElement;
    if (hasStartedExam.value && !document.fullscreenElement && !isSubmittingExam.value) {
        triggerViolation('Keluar dari mode layar penuh');
    }
};

const handleVisibilityChange = () => {
    if (document.hidden && hasStartedExam.value && !isSubmittingExam.value) {
        triggerViolation('Berpindah tab atau browser diminimalkan');
    }
};

const handleWindowBlur = () => {
    if (hasStartedExam.value && !isSubmittingExam.value) {
        triggerViolation('Jendela browser kehilangan fokus');
    }
};

// Block shortcut keys (F12, DevTools, View Source, Print, Save)
const handleKeydown = (e) => {
    if (e.key === 'F12') {
        e.preventDefault();
        e.stopPropagation();
        return false;
    }

    const isCtrlOrMeta = e.ctrlKey || e.metaKey;

    // DevTools: Ctrl+Shift+I, Ctrl+Shift+J, Ctrl+Shift+C
    if (isCtrlOrMeta && e.shiftKey && ['I', 'i', 'J', 'j', 'C', 'c'].includes(e.key)) {
        e.preventDefault();
        e.stopPropagation();
        return false;
    }

    // View source: Ctrl+U, Print: Ctrl+P, Save: Ctrl+S
    if (isCtrlOrMeta && ['u', 'U', 's', 'S', 'p', 'P'].includes(e.key)) {
        e.preventDefault();
        e.stopPropagation();
        return false;
    }
};

const preventDefaultAction = (e) => {
    e.preventDefault();
};

onMounted(() => {
    // Restore answers and index from localStorage
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

    const savedViolations = localStorage.getItem(violationKey.value);
    if (savedViolations) {
        violationCount.value = Math.max(violationCount.value, parseInt(savedViolations));
    }

    // Check if previously started
    const savedStarted = localStorage.getItem(startedKey.value);
    if (savedStarted === 'true') {
        hasStartedExam.value = true;
    }

    // Fullscreen validation on mount
    if (!document.fullscreenElement) {
        isFullscreen.value = false;
        showProctoringModal.value = true;
        proctoringState.value = hasStartedExam.value ? 'warning' : 'pre_exam';
    } else {
        isFullscreen.value = true;
        if (hasStartedExam.value) {
            showProctoringModal.value = false;
        }
    }

    // Register Proctoring & Security Listeners
    document.addEventListener('fullscreenchange', handleFullscreenChange);
    document.addEventListener('visibilitychange', handleVisibilityChange);
    window.addEventListener('blur', handleWindowBlur);
    window.addEventListener('keydown', handleKeydown);
    document.addEventListener('contextmenu', preventDefaultAction);
    document.addEventListener('copy', preventDefaultAction);
    document.addEventListener('cut', preventDefaultAction);
    document.addEventListener('paste', preventDefaultAction);
});

onUnmounted(() => {
    document.removeEventListener('fullscreenchange', handleFullscreenChange);
    document.removeEventListener('visibilitychange', handleVisibilityChange);
    window.removeEventListener('blur', handleWindowBlur);
    window.removeEventListener('keydown', handleKeydown);
    document.removeEventListener('contextmenu', preventDefaultAction);
    document.removeEventListener('copy', preventDefaultAction);
    document.removeEventListener('cut', preventDefaultAction);
    document.removeEventListener('paste', preventDefaultAction);
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
    submitExam('timeout');
};

const submitExam = (reason = 'normal') => {
    isSubmittingExam.value = true;

    if (document.fullscreenElement) {
        try {
            document.exitFullscreen().catch(() => {});
        } catch (e) {}
    }

    router.post(route('dashboard.learning.finish', props.assessment.id), {
        answers: answers.value,
        violations_count: violationCount.value,
        submitted_reason: reason,
    }, {
        onSuccess: () => {
            // Clear progress on success
            localStorage.removeItem(storageKey.value);
            localStorage.removeItem(indexKey.value);
            localStorage.removeItem(violationKey.value);
            localStorage.removeItem(startedKey.value);
        },
        onFinish: () => {
            isSubmittingExam.value = false;
        },
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
    <Head :title="'Ruang Ujian: ' + course.name" />

    <div class="min-h-screen bg-[#F8F9FA] dark:bg-[#0A090B] font-poppins text-[#0A090B] dark:text-slate-100 transition-colors select-none">
        <!-- Proctoring Modal (Pre-Exam, Warning, Limit Reached) -->
        <ProctoringModal
            :show="showProctoringModal"
            :state="proctoringState"
            :currentViolation="violationCount"
            :maxAllowed="maxViolationsAllowed"
            :courseName="course.name"
            :isSubmitting="isSubmittingExam"
            @start-fullscreen="handleStartFullscreen"
            @resume-fullscreen="handleResumeFullscreen"
        />

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
                            Proctoring Aktif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Right Controls: Violation Badge, Timer, Theme Toggle, End Exam -->
            <div class="flex items-center gap-3 sm:gap-5">
                <!-- Violation Counter Badge -->
                <div
                    v-if="violationCount > 0"
                    class="hidden md:flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold transition-all border"
                    :class="violationCount >= maxViolationsAllowed
                        ? 'bg-rose-500/10 border-rose-500/25 text-rose-600 dark:text-rose-400'
                        : 'bg-amber-500/10 border-amber-500/25 text-amber-600 dark:text-amber-400'"
                >
                    <span class="w-2 h-2 rounded-full" :class="violationCount >= maxViolationsAllowed ? 'bg-rose-500 animate-ping' : 'bg-amber-500'"></span>
                    <span>Pelanggaran: {{ violationCount }}/{{ maxViolationsAllowed }}</span>
                </div>

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
                    class="px-5 py-2.5 bg-rose-500 hover:bg-rose-600 text-white rounded-xl font-bold text-xs uppercase tracking-wider transition-all shadow-md shadow-rose-500/20 active:scale-95 shrink-0 cursor-pointer"
                >
                    Selesaikan Ujian
                </button>
            </div>
        </header>

        <!-- Main Workspace -->
        <main class="py-8 px-6 lg:px-10 max-w-7xl mx-auto flex flex-col lg:flex-row gap-8">
            <!-- Left Column: Question Workspace -->
            <div class="flex-1 flex flex-col gap-6">
                <!-- Mobile Timer & Violation Bar -->
                <div class="sm:hidden flex items-center justify-between p-4 bg-white dark:bg-[#111116] border border-slate-200/80 dark:border-slate-800 rounded-2xl">
                    <div class="flex flex-col">
                        <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase">Sisa Waktu</span>
                        <span class="text-xs font-semibold text-slate-700 dark:text-slate-300">Pengerjaan</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span
                            v-if="violationCount > 0"
                            class="text-[10px] font-bold px-2 py-0.5 rounded-md"
                            :class="violationCount >= maxViolationsAllowed ? 'bg-rose-500/15 text-rose-600' : 'bg-amber-500/15 text-amber-600'"
                        >
                            {{ violationCount }}/{{ maxViolationsAllowed }}
                        </span>
                        <CountdownTimer
                            :startTime="assessment.started_at"
                            :durationHours="90"
                            @timeout="handleTimeout"
                        />
                    </div>
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
                        class="px-6 py-3.5 bg-white dark:bg-[#111116] border border-slate-200/80 dark:border-slate-800 rounded-2xl font-bold text-xs uppercase tracking-wider text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800/80 transition-all disabled:opacity-40 disabled:pointer-events-none shadow-xs flex items-center gap-2 cursor-pointer"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                        </svg>
                        <span>Soal Sebelumnya</span>
                    </button>

                    <button
                        v-if="currentQuestionIndex < course.questions.length - 1"
                        @click="nextQuestion"
                        class="px-7 py-3.5 bg-[#2B82FE] hover:bg-blue-600 text-white rounded-2xl font-bold text-xs uppercase tracking-wider transition-colors active:scale-95 flex items-center gap-2 cursor-pointer"
                    >
                        <span>Soal Berikutnya</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                    <button
                        v-else
                        @click="finishTest"
                        class="px-8 py-3.5 bg-emerald-600 hover:bg-emerald-500 text-white rounded-2xl font-bold text-xs uppercase tracking-wider transition-colors active:scale-95 flex items-center gap-2 cursor-pointer"
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
                            class="w-full aspect-square rounded-xl flex items-center justify-center text-xs font-bold transition-all border relative cursor-pointer"
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

        <!-- Final CBT Exam Submit Confirmation Modal -->
        <ExamSubmitModal
            :show="isConfirmDialogOpen"
            :totalQuestions="course.questions.length"
            :totalAnswered="totalAnswered"
            :courseName="course.name"
            :isSubmitting="isSubmittingExam"
            @close="isConfirmDialogOpen = false"
            @confirm="submitExam('normal')"
        />
    </div>
</template>
