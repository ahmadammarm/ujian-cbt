<script setup>
import { ref, computed } from 'vue';
import AnswerBubble from '@/Components/Atoms/AnswerBubble.vue';
import ScoreMark from '@/Components/Atoms/ScoreMark.vue';

const OPTIONS = ['A', 'B', 'C', 'D', 'E'];
const ANSWER_KEY = ['C', 'A', 'D', 'B', 'E', 'A', 'C', 'B', 'D', 'A'];
const FILL_START_MS = 500;
const FILL_STEP_MS = 110;
const STUDENT_NAME = 'NADIA'.padEnd(10, ' ').split('');

// Nomor 7 is deliberately wrong so the visitor has something to fix
const answers = ref(ANSWER_KEY.map((key, idx) => (idx === 6 ? 'D' : key)));
const hasInteracted = ref(false);

const rows = computed(() =>
    answers.value.map((selected, idx) => ({
        number: idx + 1,
        selected,
        isCorrect: selected === ANSWER_KEY[idx],
    }))
);

const correctCount = computed(() => rows.value.filter((row) => row.isCorrect).length);
const score = computed(() => Math.round((correctCount.value / ANSWER_KEY.length) * 100));
const marksDelay = FILL_START_MS + ANSWER_KEY.length * FILL_STEP_MS;

const fillDelay = (idx) => (hasInteracted.value ? 0 : FILL_START_MS + idx * FILL_STEP_MS);

const selectAnswer = (idx, option) => {
    hasInteracted.value = true;
    answers.value[idx] = option;
};
</script>

<template>
    <div class="relative mx-auto w-full max-w-[34rem]">
        <div
            class="relative rounded-md border border-pen/25 bg-paper p-4 text-graphite shadow-[0_1px_0_rgba(27,42,107,0.06),0_24px_48px_-24px_rgba(27,42,107,0.45)] sm:p-7 lg:rotate-[1.2deg]"
        >
            <!-- Printed header -->
            <div class="flex items-baseline justify-between gap-4 border-b-2 border-pen pb-2 font-form text-[11px] font-semibold uppercase tracking-[0.18em] text-pen">
                <span>Lembar jawaban</span>
                <span class="hidden sm:inline">Naiju Exam</span>
            </div>

            <!-- Identity fields -->
            <div class="mt-4 space-y-3">
                <div class="flex items-center gap-3">
                    <span class="w-10 shrink-0 font-form text-[10px] font-semibold uppercase tracking-widest text-pen sm:w-12">Nama</span>
                    <div class="flex flex-1 overflow-hidden">
                        <span
                            v-for="(letter, idx) in STUDENT_NAME"
                            :key="idx"
                            class="-ml-px flex h-7 min-w-0 flex-1 items-center justify-center border border-pen/50 font-hand text-sm sm:text-base font-semibold text-ink first:ml-0"
                        >{{ letter }}</span>
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-x-6 gap-y-3">
                    <div class="flex items-center gap-3">
                        <span class="w-12 shrink-0 font-form text-[10px] font-semibold uppercase tracking-widest text-pen">Kelas</span>
                        <span class="border-b border-dashed border-pen/50 px-2 font-hand text-base font-semibold text-ink">XI-3</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="font-form text-[10px] font-semibold uppercase tracking-widest text-pen">Mapel</span>
                        <span class="border-b border-dashed border-pen/50 px-2 font-hand text-base font-semibold text-ink">Biologi</span>
                    </div>
                </div>
            </div>

            <!-- Answer grid -->
            <div class="mt-5 grid gap-x-4 gap-y-1.5 border-t border-pen/30 pt-4 sm:grid-cols-2 lg:grid-cols-1 xl:grid-cols-2">
                <fieldset
                    v-for="(row, idx) in rows"
                    :key="row.number"
                    class="flex items-center gap-1"
                >
                    <legend class="sr-only">Nomor {{ row.number }}</legend>
                    <span aria-hidden="true" class="w-6 shrink-0 text-right font-form text-xs font-semibold text-pen">{{ row.number }}</span>
                    <div class="flex">
                        <AnswerBubble
                            v-for="option in OPTIONS"
                            :key="option"
                            :name="`ljk-${row.number}`"
                            :value="option"
                            :label="`Nomor ${row.number}, pilihan ${option}`"
                            :checked="row.selected === option"
                            :delay="fillDelay(idx)"
                            @select="selectAnswer(idx, $event)"
                        />
                    </div>
                    <span
                        class="ml-1 w-5 font-hand text-lg font-bold leading-none text-pen motion-safe:animate-fade-in motion-safe:[animation-fill-mode:both]"
                        :style="{ animationDelay: `${marksDelay}ms` }"
                    >
                        <span aria-hidden="true">{{ row.isCorrect ? '✓' : '✗' }}</span>
                        <span class="sr-only">{{ row.isCorrect ? 'benar' : 'salah' }}</span>
                    </span>
                </fieldset>
            </div>

            <!-- Red-pen grading -->
            <div class="mt-5 flex items-end justify-between gap-4 border-t border-pen/30 pt-4">
                <p class="max-w-[15rem] font-hand text-sm leading-snug text-ink/80">
                    Klik bulatan mana saja. Nilainya langsung dihitung ulang, sama seperti saat kamu kirim jawaban.
                </p>
                <div aria-live="polite">
                    <ScoreMark :score="score" />
                </div>
            </div>
        </div>
    </div>
</template>
