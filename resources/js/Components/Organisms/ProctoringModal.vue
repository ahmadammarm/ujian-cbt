<script setup>
import { computed } from 'vue';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    state: {
        type: String,
        default: 'pre_exam', // 'pre_exam' | 'warning' | 'limit_reached'
        validator: (value) => ['pre_exam', 'warning', 'limit_reached'].includes(value),
    },
    currentViolation: {
        type: Number,
        default: 0,
    },
    maxAllowed: {
        type: Number,
        default: 3,
    },
    courseName: {
        type: String,
        default: 'Ujian CBT',
    },
    isSubmitting: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['start-fullscreen', 'resume-fullscreen']);

const remainingChances = computed(() => {
    return Math.max(0, props.maxAllowed - props.currentViolation);
});
</script>

<template>
    <Teleport to="body">
        <Transition
            enter-active-class="ease-out duration-300"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="ease-in duration-200"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-95"
        >
            <div
                v-if="show"
                class="fixed inset-0 z-[150] overflow-y-auto px-4 py-6 sm:px-0 flex items-center justify-center"
            >
                <!-- Lock Backdrop (Prevents view of exam content when out of fullscreen) -->
                <div class="fixed inset-0 bg-[#0A090B]/90 backdrop-blur-md transition-all" />

                <!-- Modal Dialog Container -->
                <div class="relative z-10 w-full max-w-lg mx-auto bg-white dark:bg-[#111116] border border-slate-200/90 dark:border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl transition-all">
                    <!-- STATE 1: PRE-EXAM FULLSCREEN REQUIREMENT -->
                    <div v-if="state === 'pre_exam'" class="flex flex-col gap-6 text-center">
                        <div class="mx-auto w-16 h-16 rounded-2xl bg-[#2B82FE]/10 border border-[#2B82FE]/20 text-[#2B82FE] flex items-center justify-center shadow-xs">
                            <svg class="w-8 h-8 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" />
                            </svg>
                        </div>

                        <div class="flex flex-col gap-2">
                            <span class="inline-flex items-center justify-center mx-auto px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-[#2B82FE]/10 text-[#2B82FE] border border-[#2B82FE]/20">
                                Sistem Pengawasan CBT Aktif
                            </span>
                            <h3 class="text-xl sm:text-2xl font-black text-[#0A090B] dark:text-white tracking-tight">
                                Wajib Mode Layar Penuh
                            </h3>
                            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 leading-relaxed">
                                Untuk menjaga integritas pengerjaan <strong class="text-[#0A090B] dark:text-white">{{ courseName }}</strong>, ujian harus diselesaikan dalam mode layar penuh (fullscreen).
                            </p>
                        </div>

                        <!-- Rules Grid -->
                        <div class="text-left bg-slate-50 dark:bg-slate-900/60 border border-slate-100 dark:border-slate-800 rounded-2xl p-4 flex flex-col gap-3">
                            <div class="flex items-start gap-3">
                                <div class="w-5 h-5 rounded-full bg-emerald-500/10 text-emerald-500 flex items-center justify-center shrink-0 mt-0.5 text-xs font-bold">✓</div>
                                <span class="text-xs text-slate-600 dark:text-slate-300 font-medium">Tetap berada di mode fullscreen hingga selesai.</span>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-5 h-5 rounded-full bg-rose-500/10 text-rose-500 flex items-center justify-center shrink-0 mt-0.5 text-xs font-bold">✕</div>
                                <span class="text-xs text-slate-600 dark:text-slate-300 font-medium">Dilarang berpindah tab, meminimalkan browser, atau membuka aplikasi lain.</span>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-5 h-5 rounded-full bg-amber-500/10 text-amber-500 flex items-center justify-center shrink-0 mt-0.5 text-xs font-bold">!</div>
                                <span class="text-xs text-slate-600 dark:text-slate-300 font-medium">Toleransi maksimal <strong class="text-[#0A090B] dark:text-white">{{ maxAllowed }} kali</strong> peringatan. Pelanggaran berikutnya akan otomatis mengumpulkan ujian.</span>
                            </div>
                        </div>

                        <button
                            type="button"
                            @click="emit('start-fullscreen')"
                            class="w-full py-4 px-6 bg-[#2B82FE] hover:bg-blue-600 text-white rounded-2xl font-bold text-sm tracking-wider uppercase transition-all shadow-lg shadow-[#2B82FE]/25 active:scale-95 flex items-center justify-center gap-2 cursor-pointer"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.347a1.125 1.125 0 0 1 0 1.972l-11.54 6.347a1.125 1.125 0 0 1-1.667-.986V5.653Z" />
                            </svg>
                            <span>Mulai Ujian & Masuk Layar Penuh</span>
                        </button>
                    </div>

                    <!-- STATE 2: VIOLATION WARNING (1 to 3) -->
                    <div v-else-if="state === 'warning'" class="flex flex-col gap-6 text-center">
                        <div class="mx-auto w-16 h-16 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-amber-500 flex items-center justify-center shadow-xs animate-pulse">
                            <svg class="w-8 h-8 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                            </svg>
                        </div>

                        <div class="flex flex-col gap-2">
                            <div class="inline-flex items-center justify-center mx-auto px-3.5 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-amber-500/15 text-amber-600 dark:text-amber-400 border border-amber-500/30">
                                Peringatan {{ currentViolation }} Dari {{ maxAllowed }}
                            </div>
                            <h3 class="text-xl sm:text-2xl font-black text-[#0A090B] dark:text-white tracking-tight">
                                Pelanggaran Terdeteksi!
                            </h3>
                            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 leading-relaxed">
                                Anda terdeteksi keluar dari mode layar penuh atau meninggalkan jendela ujian (berpindah tab / aplikasi).
                            </p>
                        </div>

                        <!-- Urgency Banner -->
                        <div
                            class="p-4 rounded-2xl border text-xs text-left"
                            :class="remainingChances === 0
                                ? 'bg-rose-500/10 border-rose-500/30 text-rose-600 dark:text-rose-400 font-semibold'
                                : 'bg-amber-500/10 border-amber-500/30 text-amber-700 dark:text-amber-300 font-medium'"
                        >
                            <span v-if="remainingChances === 0">
                                ⚠️ <strong>Peringatan Terakhir:</strong> Anda telah menggunakan seluruh toleransi! Pelanggaran berikutnya akan langsung menyelesaikan dan mengumpulkan ujian secara otomatis.
                            </span>
                            <span v-else>
                                Sisa kesempatan toleransi Anda: <strong class="text-[#0A090B] dark:text-white">{{ remainingChances }} kali</strong> lagi sebelum ujian disubmit paksa.
                            </span>
                        </div>

                        <button
                            type="button"
                            @click="emit('resume-fullscreen')"
                            class="w-full py-4 px-6 bg-amber-500 hover:bg-amber-600 text-white rounded-2xl font-bold text-sm tracking-wider uppercase transition-all shadow-lg shadow-amber-500/25 active:scale-95 flex items-center justify-center gap-2 cursor-pointer"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" />
                            </svg>
                            <span>Kembali ke Ujian & Masuk Layar Penuh</span>
                        </button>
                    </div>

                    <!-- STATE 3: VIOLATION LIMIT EXCEEDED / DISQUALIFIED -->
                    <div v-else class="flex flex-col gap-6 text-center">
                        <div class="mx-auto w-16 h-16 rounded-2xl bg-rose-500/10 border border-rose-500/20 text-rose-500 flex items-center justify-center shadow-xs">
                            <svg class="w-8 h-8 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
                            </svg>
                        </div>

                        <div class="flex flex-col gap-2">
                            <div class="inline-flex items-center justify-center mx-auto px-3.5 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-rose-500/15 text-rose-600 dark:text-rose-400 border border-rose-500/30">
                                Batas Toleransi Terlampaui
                            </div>
                            <h3 class="text-xl sm:text-2xl font-black text-[#0A090B] dark:text-white tracking-tight">
                                Ujian Dihentikan Otomatis
                            </h3>
                            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 leading-relaxed">
                                Anda telah melakukan pelanggaran lebih dari batas toleransi yang diizinkan (<strong class="text-rose-600 dark:text-rose-400">{{ maxAllowed }} kali</strong>). Lembar ujian Anda sedang disubmit ke server.
                            </p>
                        </div>

                        <div class="p-4 bg-slate-50 dark:bg-slate-900/60 rounded-2xl border border-slate-100 dark:border-slate-800 flex items-center justify-center gap-3">
                            <div class="w-5 h-5 border-2 border-rose-500 border-t-transparent rounded-full animate-spin"></div>
                            <span class="text-xs font-bold text-slate-700 dark:text-slate-300">Menyinkronkan dan mengumpulkan jawaban...</span>
                        </div>
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>
