<script setup>
import { computed } from 'vue';
import Icon from '@/Components/Atoms/Icon.vue';
import InkButton from '@/Components/Atoms/InkButton.vue';
import TallyMarks from '@/Components/Atoms/TallyMarks.vue';

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
            enter-active-class="ease-out duration-200 motion-reduce:transition-none"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="ease-in duration-150 motion-reduce:transition-none"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="show"
                class="fixed inset-0 z-[150] flex items-center justify-center overflow-y-auto px-4 py-6"
            >
                <!-- Near-opaque backdrop hides the questions while outside fullscreen -->
                <div class="fixed inset-0 bg-graphite/95"></div>

                <div
                    role="dialog"
                    aria-modal="true"
                    aria-labelledby="proctoring-title"
                    class="relative z-10 w-full max-w-lg rounded-md border border-pen/25 bg-paper p-6 font-legible text-ink shadow-[0_24px_48px_-20px_rgba(0,0,0,0.6)] sm:p-8"
                >
                    <!-- STATE 1: before the exam starts -->
                    <template v-if="state === 'pre_exam'">
                        <p class="border-b-2 border-pen pb-2 font-form text-[11px] font-semibold uppercase tracking-[0.16em] text-pen">Sebelum mulai</p>
                        <h2 id="proctoring-title" class="mt-6 font-hand text-3xl font-extrabold leading-tight">Siap mengerjakan {{ courseName }}?</h2>
                        <p class="mt-2 text-[15px] leading-7 text-ink-soft">Ujian ini dikerjakan dalam layar penuh. Baca aturannya dulu, ya.</p>

                        <ul class="mt-6 space-y-3 text-[15px] leading-7">
                            <li class="flex gap-3">
                                <Icon name="fullscreen" class="mt-1 size-5 shrink-0 text-ink" />
                                Tetap di layar penuh sampai kamu mengirim jawaban.
                            </li>
                            <li class="flex gap-3">
                                <Icon name="alert" class="mt-1 size-5 shrink-0 text-pen" />
                                Keluar dari layar penuh, pindah tab atau aplikasi, dan klik di luar jendela ujian dihitung pelanggaran.
                            </li>
                            <li class="flex gap-3">
                                <TallyMarks :count="maxAllowed + 1" size="sm" highlight-last class="mt-1.5 shrink-0" />
                                <span>Kamu dapat {{ maxAllowed }} peringatan. Pelanggaran berikutnya langsung mengirim jawabanmu.</span>
                            </li>
                            <li class="flex gap-3">
                                <Icon name="lock" class="mt-1 size-5 shrink-0 text-ink" />
                                Klik kanan, salin-tempel, dan shortcut seperti F12 dimatikan.
                            </li>
                        </ul>

                        <InkButton type="button" class="mt-8 w-full" @click="emit('start-fullscreen')">
                            <Icon name="fullscreen" class="size-5" />
                            Nyalakan layar penuh &amp; mulai
                        </InkButton>
                    </template>

                    <!-- STATE 2: warning after a violation -->
                    <template v-else-if="state === 'warning'">
                        <p class="border-b-2 border-pen pb-2 font-form text-[11px] font-semibold uppercase tracking-[0.16em] text-pen">
                            Peringatan {{ currentViolation }} dari {{ maxAllowed }}
                        </p>
                        <h2 id="proctoring-title" class="mt-6 font-hand text-3xl font-extrabold leading-tight">Kamu keluar dari halaman ujian.</h2>
                        <p class="mt-2 text-[15px] leading-7 text-ink-soft">
                            Layar penuh mati, atau kamu pindah ke tab atau aplikasi lain. Ini dicatat sebagai pelanggaran.
                        </p>

                        <div class="mt-6 flex items-center gap-4">
                            <TallyMarks :count="currentViolation" tone="graphite" :highlight-last="remainingChances === 0" />
                            <span class="font-hand text-xl font-bold">{{ currentViolation }} pelanggaran</span>
                        </div>

                        <p
                            :class="[
                                'mt-6 border-l-4 px-4 py-3 text-sm leading-6',
                                remainingChances === 0 ? 'border-pen bg-pen/10 font-bold text-pen' : 'border-ink bg-stabilo/50 text-graphite',
                            ]"
                        >
                            <template v-if="remainingChances === 0">
                                Ini peringatan terakhir. Pelanggaran berikutnya langsung mengirim jawabanmu.
                            </template>
                            <template v-else>
                                Sisa {{ remainingChances }} peringatan lagi sebelum jawabanmu dikirim otomatis.
                            </template>
                        </p>

                        <InkButton type="button" class="mt-8 w-full" @click="emit('resume-fullscreen')">
                            <Icon name="fullscreen" class="size-5" />
                            Kembali ke layar penuh
                        </InkButton>
                    </template>

                    <!-- STATE 3: limit exceeded, submission in progress -->
                    <template v-else>
                        <p class="border-b-2 border-pen pb-2 font-form text-[11px] font-semibold uppercase tracking-[0.16em] text-pen">Batas pelanggaran terlewati</p>
                        <h2 id="proctoring-title" class="mt-6 font-hand text-3xl font-extrabold leading-tight">Jawabanmu sedang dikirim.</h2>
                        <p class="mt-2 text-[15px] leading-7 text-ink-soft">
                            Kamu melewati batas {{ maxAllowed }} peringatan, jadi ujian ditutup. Jawaban yang sudah kamu isi tetap dinilai.
                        </p>

                        <div class="mt-6 flex items-center gap-4">
                            <TallyMarks :count="currentViolation" highlight-last />
                            <span class="font-hand text-xl font-bold text-pen">{{ currentViolation }} pelanggaran</span>
                        </div>

                        <p class="mt-8 flex items-center gap-3 font-bold text-ink" role="status">
                            <svg class="size-5 motion-safe:animate-spin" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="3" class="opacity-25" />
                                <path d="M21 12a9 9 0 0 0-9-9" stroke="currentColor" stroke-width="3" stroke-linecap="round" />
                            </svg>
                            Mengirim jawaban…
                        </p>
                    </template>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>
