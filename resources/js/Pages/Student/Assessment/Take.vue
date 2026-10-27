<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import axios from 'axios';
import ApplicationLogo from '@/Components/Atoms/ApplicationLogo.vue';
import BubbleMark from '@/Components/Atoms/BubbleMark.vue';
import GhostButton from '@/Components/Atoms/GhostButton.vue';
import Icon from '@/Components/Atoms/Icon.vue';
import InkButton from '@/Components/Atoms/InkButton.vue';
import TallyMarks from '@/Components/Atoms/TallyMarks.vue';
import CountdownTimer from '@/Components/Molecules/CountdownTimer.vue';
import QuestionCard from '@/Components/Organisms/QuestionCard.vue';
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
    // Timeout, violation limit and manual submit can race; only the first one may post
    if (isSubmittingExam.value) {
        return;
    }
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

// Answer-sheet panel is collapsible on small screens only
const isAnswerSheetOpen = ref(false);
const progressPercent = computed(() =>
    props.course.questions.length > 0 ? Math.round((totalAnswered.value / props.course.questions.length) * 100) : 0
);
const isAtViolationLimit = computed(() => violationCount.value >= props.maxViolationsAllowed);
const isLastQuestion = computed(() => currentQuestionIndex.value >= props.course.questions.length - 1);
</script>

<template>
    <Head :title="`Ujian: ${course.name}`" />

    <div class="min-h-screen select-none bg-desk font-legible text-ink antialiased">
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

        <!-- Exam header: course, violations, timer -->
        <header class="sticky top-0 z-40 border-b border-rule bg-paper/95 backdrop-blur">
            <div class="mx-auto flex max-w-6xl items-center gap-3 px-4 py-3 sm:gap-5 sm:px-6 lg:px-8">
                <span class="hidden size-9 shrink-0 items-center justify-center rounded-lg bg-ink text-paper sm:flex">
                    <ApplicationLogo class="size-5" />
                </span>
                <div class="min-w-0 flex-1">
                    <p class="font-form text-[10px] font-semibold uppercase tracking-[0.16em] text-pen">Lembar ujian</p>
                    <h1 class="truncate text-base font-bold sm:text-lg">{{ course.name }}</h1>
                </div>

                <div
                    v-if="violationCount > 0"
                    :class="[
                        'flex shrink-0 items-center gap-2 rounded-md px-2.5 py-1.5',
                        isAtViolationLimit ? 'bg-pen/10 text-pen' : 'bg-stabilo/70 text-graphite',
                    ]"
                >
                    <TallyMarks :count="violationCount" size="sm" :tone="isAtViolationLimit ? 'pen' : 'graphite'" />
                    <span class="sr-only md:not-sr-only md:text-xs md:font-bold">{{ violationCount }}/{{ maxViolationsAllowed }} pelanggaran</span>
                </div>

                <CountdownTimer
                    :startTime="assessment.started_at"
                    :durationHours="90"
                    @timeout="handleTimeout"
                />

                <InkButton type="button" size="sm" class="hidden lg:inline-flex" @click="finishTest">
                    Selesaikan ujian
                </InkButton>
            </div>
        </header>

        <main class="mx-auto grid max-w-6xl gap-6 px-4 py-6 sm:px-6 lg:grid-cols-12 lg:gap-8 lg:px-8 lg:py-8">
            <!-- Question column -->
            <section class="flex flex-col gap-5 lg:col-span-8">
                <QuestionCard
                    :key="currentQuestion.id"
                    :question="currentQuestion"
                    :index="currentQuestionIndex"
                    :total="course.questions.length"
                    :selectedAnswer="answers[currentQuestion.id] || ''"
                    :saving="isSaving"
                    @save="handleSaveAnswer"
                />

                <div class="flex items-center justify-between gap-3">
                    <GhostButton size="sm" :disabled="currentQuestionIndex === 0" @click="prevQuestion">
                        <Icon name="arrow-left" class="size-4" />
                        Sebelumnya
                    </GhostButton>

                    <InkButton v-if="!isLastQuestion" type="button" size="sm" @click="nextQuestion">
                        Berikutnya
                        <Icon name="arrow-right" class="size-4" />
                    </InkButton>
                    <InkButton v-else type="button" size="sm" @click="finishTest">
                        Kumpulkan jawaban
                        <Icon name="check" class="size-4" />
                    </InkButton>
                </div>
            </section>

            <!-- Answer sheet (LJK) -->
            <aside class="lg:col-span-4">
                <div class="rounded-md border border-pen/25 bg-paper p-4 sm:p-5 lg:sticky lg:top-24">
                    <div class="flex items-baseline justify-between gap-3 border-b-2 border-pen pb-2">
                        <h2 class="font-form text-[11px] font-semibold uppercase tracking-[0.16em] text-pen">Lembar jawaban</h2>
                        <p class="font-form text-xs text-ink-soft">{{ totalAnswered }} dari {{ course.questions.length }} terisi</p>
                    </div>

                    <div class="mt-3 h-1.5 overflow-hidden rounded-full bg-rule" aria-hidden="true">
                        <div class="h-full rounded-full bg-ink transition-[width] duration-300 motion-reduce:transition-none" :style="{ width: `${progressPercent}%` }"></div>
                    </div>

                    <button
                        type="button"
                        class="mt-4 flex w-full items-center justify-between rounded-md px-1 py-1 text-sm font-bold text-ink focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pen lg:hidden"
                        :aria-expanded="isAnswerSheetOpen"
                        aria-controls="answer-sheet-grid"
                        @click="isAnswerSheetOpen = !isAnswerSheetOpen"
                    >
                        {{ isAnswerSheetOpen ? 'Sembunyikan nomor soal' : 'Lihat semua nomor soal' }}
                        <Icon name="chevron-down" :class="['size-4 transition-transform motion-reduce:transition-none', isAnswerSheetOpen ? 'rotate-180' : '']" />
                    </button>

                    <div id="answer-sheet-grid" :class="[isAnswerSheetOpen ? 'block' : 'hidden', 'lg:block']">
                        <ol class="mt-4 grid max-h-[50vh] grid-cols-4 gap-x-1 gap-y-1 overflow-y-auto pr-1 min-[400px]:grid-cols-5">
                            <li v-for="(question, idx) in course.questions" :key="question.id">
                                <button
                                    type="button"
                                    :aria-current="currentQuestionIndex === idx ? 'step' : undefined"
                                    :aria-label="`Soal ${idx + 1}, ${isAnswered(question.id) ? 'sudah dijawab' : 'belum dijawab'}`"
                                    :class="[
                                        'flex w-full items-center gap-1.5 rounded px-1.5 py-1.5 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pen motion-reduce:transition-none',
                                        currentQuestionIndex === idx ? 'bg-stabilo/70' : 'hover:bg-rule/40',
                                    ]"
                                    @click="goToQuestion(idx)"
                                >
                                    <span class="w-5 text-right font-form text-xs font-semibold text-pen">{{ idx + 1 }}</span>
                                    <BubbleMark size="sm" :filled="isAnswered(question.id)" :active="currentQuestionIndex === idx" />
                                </button>
                            </li>
                        </ol>

                        <ul class="mt-4 flex flex-wrap gap-x-4 gap-y-2 border-t border-dashed border-rule pt-3 text-xs text-ink-soft">
                            <li class="flex items-center gap-1.5"><BubbleMark size="sm" filled /> Sudah dijawab</li>
                            <li class="flex items-center gap-1.5"><BubbleMark size="sm" /> Belum dijawab</li>
                            <li class="flex items-center gap-1.5"><span class="h-3 w-5 rounded-sm bg-stabilo/70"></span> Sedang dibuka</li>
                        </ul>
                    </div>

                    <InkButton type="button" size="sm" class="mt-5 w-full lg:hidden" @click="finishTest">
                        Selesaikan ujian
                    </InkButton>
                </div>
            </aside>
        </main>

        <!-- Final submit confirmation -->
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
