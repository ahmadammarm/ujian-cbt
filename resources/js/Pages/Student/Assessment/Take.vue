<script setup>
import { ref, computed, onMounted } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import CountdownTimer from '@/Components/Molecules/CountdownTimer.vue';
import QuestionCard from '@/Components/Organisms/QuestionCard.vue';

const props = defineProps({
    course: Object,
    assessment: Object,
    serverTime: String
});

const currentQuestionIndex = ref(0);
const answers = ref({}); // Local state for all answers {questionId: answerText}

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
            console.error('Failed to parse saved progress', e);
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

const handleSaveAnswer = (answer) => {
    answers.value[currentQuestion.value.id] = answer;
    // Persist to localStorage
    localStorage.setItem(storageKey.value, JSON.stringify(answers.value));
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
    if (confirm('Are you sure you want to finish the test? Your answers will be submitted for scoring.')) {
        handleTimeout();
    }
};
</script>

<template>
    <Head :title="'Exam: ' + course.name" />

    <div class="min-h-screen bg-[#FBFBFB] font-poppins text-[#0A090B]">
        <!-- Top Bar -->
        <header class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-[#EEEEEE] h-20 px-6 lg:px-10 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-[#2B82FE] rounded-xl flex items-center justify-center shadow-lg shadow-[#2B82FE]/20">
                    <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="flex flex-col">
                    <h2 class="font-bold text-lg leading-tight">{{ course.name }}</h2>
                    <p class="text-xs text-gray-400 font-medium">CBT Assessment Mode</p>
                </div>
            </div>

            <div class="flex items-center gap-6">
                <div class="hidden md:flex flex-col text-right">
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Time Remaining</p>
                    <CountdownTimer 
                        :startTime="assessment.started_at" 
                        :durationHours="90"
                        @timeout="handleTimeout"
                    />
                </div>
                <div class="h-10 w-[1px] bg-[#EEEEEE] hidden md:block"></div>
                <button 
                    @click="finishTest"
                    class="px-6 py-3 bg-[#FD445E] text-white rounded-2xl font-bold text-sm hover:bg-red-600 transition-all shadow-lg shadow-red-100"
                >
                    End Test
                </button>
            </div>
        </header>

        <main class="py-10 px-6 lg:px-10 max-w-7xl mx-auto flex flex-col lg:flex-row gap-10">
            <!-- Left Side: Questions -->
            <div class="flex-1 flex flex-col gap-8">
                <!-- Mobile Timer -->
                <div class="md:hidden flex items-center justify-between p-4 bg-white border border-[#EEEEEE] rounded-2xl">
                    <p class="text-sm font-bold">Time Left</p>
                    <CountdownTimer 
                        :startTime="assessment.started_at" 
                        :durationHours="90"
                        @timeout="handleTimeout"
                    />
                </div>

                <div class="flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <h3 class="font-bold text-2xl">Question {{ currentQuestionIndex + 1 }}</h3>
                        <span class="text-sm font-bold text-gray-400">{{ currentQuestionIndex + 1 }} / {{ course.questions.length }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-1.5 overflow-hidden">
                        <div 
                            class="bg-[#2B82FE] h-full transition-all duration-500"
                            :style="{ width: ((currentQuestionIndex + 1) / course.questions.length * 100) + '%' }"
                        ></div>
                    </div>
                </div>

                <QuestionCard 
                    :key="currentQuestion.id"
                    :question="currentQuestion"
                    :index="currentQuestionIndex"
                    :selectedAnswer="answers[currentQuestion.id] || ''" 
                    @save="handleSaveAnswer"
                />

                <div class="flex items-center justify-between">
                    <button 
                        @click="prevQuestion"
                        :disabled="currentQuestionIndex === 0"
                        class="px-8 py-4 bg-white border border-[#EEEEEE] rounded-2xl font-bold text-[#0A090B] hover:bg-gray-50 transition-all disabled:opacity-30"
                    >
                        Previous
                    </button>
                    
                    <button 
                        v-if="currentQuestionIndex < course.questions.length - 1"
                        @click="nextQuestion"
                        class="px-8 py-4 bg-[#2B82FE] text-white rounded-2xl font-bold hover:bg-blue-600 transition-all shadow-lg shadow-blue-100"
                    >
                        Next Question
                    </button>
                    <button 
                        v-else
                        @click="finishTest"
                        class="px-8 py-4 bg-[#06BC65] text-white rounded-2xl font-bold hover:bg-green-600 transition-all shadow-lg shadow-green-100"
                    >
                        Submit Exam
                    </button>
                </div>
            </div>

            <!-- Right Side: Navigator -->
            <aside class="w-full lg:w-[360px] flex flex-col gap-6">
                <div class="bg-white border border-[#EEEEEE] rounded-[32px] p-8 flex flex-col gap-6 sticky top-32">
                    <h4 class="font-bold text-lg">Question Navigator</h4>
                    <div class="grid grid-cols-5 gap-3">
                        <button 
                            v-for="(question, idx) in course.questions" 
                            :key="idx"
                            @click="goToQuestion(idx)"
                            class="w-full aspect-square rounded-xl flex items-center justify-center text-sm font-bold transition-all border relative"
                            :class="[
                                currentQuestionIndex === idx 
                                ? 'bg-[#2B82FE] border-[#2B82FE] text-white shadow-lg shadow-blue-100' 
                                : (isAnswered(question.id) ? 'bg-green-50 border-[#06BC65] text-[#06BC65]' : 'bg-white border-[#EEEEEE] text-gray-400 hover:border-[#2B82FE] hover:text-[#2B82FE]')
                            ]"
                        >
                            {{ idx + 1 }}
                            <div v-if="isAnswered(question.id) && currentQuestionIndex !== idx" class="absolute -top-1 -right-1 w-3 h-3 bg-[#06BC65] rounded-full border-2 border-white"></div>
                        </button>
                    </div>
                    
                    <div class="pt-6 border-t border-[#EEEEEE] flex flex-col gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full bg-[#2B82FE]"></div>
                            <span class="text-xs font-bold text-gray-400">Current Question</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full bg-[#06BC65]"></div>
                            <span class="text-xs font-bold text-gray-400">Answered</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full bg-white border border-[#EEEEEE]"></div>
                            <span class="text-xs font-bold text-gray-400">Not Answered</span>
                        </div>
                    </div>
                </div>
            </aside>
        </main>
    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap');
.font-poppins { font-family: 'Poppins', sans-serif; }
</style>
