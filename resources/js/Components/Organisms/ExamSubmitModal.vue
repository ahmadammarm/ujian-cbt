<script setup>
import { computed, watch, onMounted, onUnmounted } from 'vue';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    totalQuestions: {
        type: Number,
        required: true,
    },
    totalAnswered: {
        type: Number,
        required: true,
    },
    courseName: {
        type: String,
        default: 'Kursus',
    },
    isSubmitting: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['close', 'confirm']);

const totalUnanswered = computed(() => {
    return Math.max(0, props.totalQuestions - props.totalAnswered);
});

const answeredPercentage = computed(() => {
    if (props.totalQuestions <= 0) return 0;
    return Math.round((props.totalAnswered / props.totalQuestions) * 100);
});

const isAllAnswered = computed(() => {
    return totalUnanswered.value === 0;
});

// Manage body scroll locking
watch(
    () => props.show,
    (val) => {
        if (val) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = null;
        }
    }
);

const handleClose = () => {
    if (!props.isSubmitting) {
        emit('close');
    }
};

const handleConfirm = () => {
    emit('confirm');
};

const handleKeydown = (e) => {
    if (e.key === 'Escape' && props.show && !props.isSubmitting) {
        handleClose();
    }
};

onMounted(() => {
    document.addEventListener('keydown', handleKeydown);
});

onUnmounted(() => {
    document.removeEventListener('keydown', handleKeydown);
    document.body.style.overflow = null;
});
</script>

<template>
    <Teleport to="body">
        <Transition
            enter-active-class="ease-out duration-300"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="ease-in duration-200"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="show"
                class="fixed inset-0 z-[140] overflow-y-auto px-4 py-6 sm:px-0 flex items-center justify-center"
            >
                <!-- Backdrop -->
                <div
                    class="fixed inset-0 bg-[#0A090B]/60 backdrop-blur-md transition-all"
                    @click="handleClose"
                />

                <!-- Dialog Card -->
                <Transition
                    enter-active-class="ease-out duration-300"
                    enter-from-class="opacity-0 scale-95 translate-y-3"
                    enter-to-class="opacity-100 scale-100 translate-y-0"
                    leave-active-class="ease-in duration-200"
                    leave-from-class="opacity-100 scale-100 translate-y-0"
                    leave-to-class="opacity-0 scale-95 translate-y-3"
                >
                    <div
                        v-if="show"
                        class="relative z-10 w-full max-w-lg mx-auto bg-white dark:bg-[#111116] border border-slate-200/90 dark:border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl shadow-slate-900/10 dark:shadow-black/60 transition-all font-poppins flex flex-col gap-6"
                    >
                        <!-- Header & Icon Badge -->
                        <div class="flex flex-col items-center text-center gap-3">
                            <div
                                class="w-16 h-16 rounded-2xl flex items-center justify-center transition-all duration-300 border shadow-xs"
                                :class="isAllAnswered
                                    ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-600 dark:text-emerald-400'
                                    : 'bg-amber-500/10 border-amber-500/20 text-amber-600 dark:text-amber-400'"
                            >
                                <svg
                                    v-if="isAllAnswered"
                                    class="w-8 h-8 fill-none stroke-current"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <svg
                                    v-else
                                    class="w-8 h-8 fill-none stroke-current"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                                </svg>
                            </div>

                            <div class="flex flex-col gap-1.5">
                                <span class="inline-flex items-center justify-center mx-auto px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-[#2B82FE]/10 text-[#2B82FE] border border-[#2B82FE]/20">
                                    Konfirmasi Penyelesaian Ujian
                                </span>
                                <h3 class="text-xl sm:text-2xl font-black text-[#0A090B] dark:text-white tracking-tight">
                                    Kumpulkan Lembar Jawaban?
                                </h3>
                                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 leading-relaxed max-w-sm mx-auto">
                                    Periksa ringkasan jawaban Anda untuk <strong class="text-[#0A090B] dark:text-white">{{ courseName }}</strong> sebelum jawaban dikunci dan dinilai.
                                </p>
                            </div>
                        </div>

                        <!-- Statistics Grid (Answered vs Unanswered) -->
                        <div class="grid grid-cols-2 gap-3.5">
                            <!-- Answered Card -->
                            <div class="p-4 rounded-2xl bg-emerald-500/5 dark:bg-emerald-500/10 border border-emerald-500/20 flex flex-col gap-1">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">
                                        Sudah Terjawab
                                    </span>
                                    <span class="text-[10px] font-black px-1.5 py-0.5 rounded-md bg-emerald-500/15 text-emerald-600 dark:text-emerald-400">
                                        {{ answeredPercentage }}%
                                    </span>
                                </div>
                                <div class="flex items-baseline gap-1.5 mt-1">
                                    <span class="text-2xl font-black text-emerald-700 dark:text-emerald-300">
                                        {{ totalAnswered }}
                                    </span>
                                    <span class="text-xs font-semibold text-slate-400 dark:text-slate-500">
                                        / {{ totalQuestions }} soal
                                    </span>
                                </div>
                            </div>

                            <!-- Unanswered Card -->
                            <div
                                class="p-4 rounded-2xl border flex flex-col gap-1 transition-colors"
                                :class="isAllAnswered
                                    ? 'bg-slate-50 dark:bg-slate-800/40 border-slate-200/80 dark:border-slate-800'
                                    : 'bg-amber-500/5 dark:bg-amber-500/10 border-amber-500/25'"
                            >
                                <div class="flex items-center justify-between">
                                    <span
                                        class="text-[10px] font-bold uppercase tracking-wider"
                                        :class="isAllAnswered ? 'text-slate-400 dark:text-slate-500' : 'text-amber-600 dark:text-amber-400'"
                                    >
                                        Belum Dijawab
                                    </span>
                                    <span
                                        class="text-[10px] font-black px-1.5 py-0.5 rounded-md"
                                        :class="isAllAnswered ? 'bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400' : 'bg-amber-500/15 text-amber-600 dark:text-amber-400'"
                                    >
                                        {{ isAllAnswered ? 'Tuntas' : 'Perlu Diisi' }}
                                    </span>
                                </div>
                                <div class="flex items-baseline gap-1.5 mt-1">
                                    <span
                                        class="text-2xl font-black"
                                        :class="isAllAnswered ? 'text-slate-400 dark:text-slate-500' : 'text-amber-700 dark:text-amber-300'"
                                    >
                                        {{ totalUnanswered }}
                                    </span>
                                    <span class="text-xs font-semibold text-slate-400 dark:text-slate-500">
                                        butir soal
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Informative Notice Banner -->
                        <div
                            class="p-4 rounded-2xl border text-xs leading-relaxed flex items-start gap-3 transition-colors"
                            :class="isAllAnswered
                                ? 'bg-emerald-500/5 dark:bg-emerald-500/10 border-emerald-500/20 text-emerald-800 dark:text-emerald-300'
                                : 'bg-amber-500/5 dark:bg-amber-500/10 border-amber-500/25 text-amber-800 dark:text-amber-300'"
                        >
                            <span class="text-base shrink-0 leading-none mt-0.5">
                                {{ isAllAnswered ? '✅' : '⚠️' }}
                            </span>
                            <div class="flex flex-col gap-0.5 font-medium">
                                <span v-if="isAllAnswered">
                                    <strong>Semua butir soal telah terjawab.</strong> Setelah dikumpulkan, hasil nilai akan langsung dikalkulasi dan ditampilkan pada rapor ujian.
                                </span>
                                <span v-else>
                                    <strong>Perhatian: Masih ada {{ totalUnanswered }} butir soal kosong.</strong> Butir soal yang belum dijawab akan dihitung sebagai 0 poin.
                                </span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col-reverse sm:flex-row items-center gap-3 pt-1">
                            <button
                                type="button"
                                @click="handleClose"
                                :disabled="isSubmitting"
                                class="w-full sm:flex-1 py-3.5 px-5 bg-slate-100 dark:bg-slate-800/80 hover:bg-slate-200 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs uppercase tracking-wider rounded-2xl border border-transparent dark:border-slate-700/60 transition-all active:scale-95 disabled:opacity-40 disabled:pointer-events-none cursor-pointer text-center"
                            >
                                Lanjut Mengerjakan
                            </button>

                            <button
                                type="button"
                                @click="handleConfirm"
                                :disabled="isSubmitting"
                                class="w-full sm:flex-1 py-3.5 px-6 bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs uppercase tracking-wider rounded-2xl shadow-lg shadow-emerald-600/25 transition-all active:scale-95 disabled:opacity-50 disabled:pointer-events-none flex items-center justify-center gap-2 cursor-pointer"
                            >
                                <svg
                                    v-if="isSubmitting"
                                    class="w-4 h-4 animate-spin text-white"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z" />
                                </svg>
                                <svg
                                    v-else
                                    class="w-4 h-4 fill-none stroke-current"
                                    viewBox="0 0 24 24"
                                    stroke-width="2.5"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                                <span>{{ isSubmitting ? 'Mengumpulkan...' : 'Ya, Kumpulkan Ujian' }}</span>
                            </button>
                        </div>
                    </div>
                </Transition>
            </div>
        </Transition>
    </Teleport>
</template>
