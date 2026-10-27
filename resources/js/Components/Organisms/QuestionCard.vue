<script setup>
import { ref, watch } from 'vue';
import BubbleMark from '@/Components/Atoms/BubbleMark.vue';

const props = defineProps({
    question: Object,
    index: Number,
    total: {
        type: Number,
        default: null,
    },
    selectedAnswer: String,
    saving: Boolean,
});

const emit = defineEmits(['save']);

const localSelected = ref(props.selectedAnswer);

watch(() => props.selectedAnswer, (newVal) => {
    localSelected.value = newVal;
});

const handleSelect = (answer) => {
    localSelected.value = answer;
    emit('save', answer);
};

const optionLetters = ['A', 'B', 'C', 'D', 'E', 'F'];
</script>

<template>
    <article class="rounded-md border border-pen/25 bg-paper p-5 shadow-[0_1px_0_rgba(27,42,107,0.06)] sm:p-8">
        <div class="flex items-baseline justify-between gap-4 border-b-2 border-pen pb-2 font-form text-[11px] font-semibold uppercase tracking-[0.16em]">
            <span class="text-pen">Soal {{ index + 1 }}<template v-if="total"> dari {{ total }}</template></span>
            <span :class="localSelected ? 'text-ink' : 'text-ink-soft'">{{ localSelected ? 'Terjawab' : 'Pilih satu jawaban' }}</span>
        </div>

        <h2 class="mt-6 font-legible text-lg leading-8 text-ink sm:text-xl sm:leading-9">
            {{ question.question }}
        </h2>

        <fieldset class="mt-6">
            <legend class="sr-only">Pilihan jawaban soal {{ index + 1 }}</legend>
            <div class="space-y-2.5">
                <label
                    v-for="(answer, optIdx) in question.answers"
                    :key="answer.id"
                    :class="[
                        'flex cursor-pointer items-start gap-4 rounded-md border px-4 py-3.5 transition-colors motion-reduce:transition-none',
                        localSelected === answer.answer
                            ? 'border-ink bg-stabilo/40'
                            : 'border-rule hover:border-ink-soft hover:bg-rule/20',
                    ]"
                >
                    <input
                        type="radio"
                        :name="'question-' + question.id"
                        :value="answer.answer"
                        v-model="localSelected"
                        class="peer sr-only"
                        @change="handleSelect(answer.answer)"
                    >
                    <BubbleMark
                        size="lg"
                        :label="optionLetters[optIdx] || String(optIdx + 1)"
                        :filled="localSelected === answer.answer"
                        class="peer-focus-visible:ring-2 peer-focus-visible:ring-pen peer-focus-visible:ring-offset-2 peer-focus-visible:ring-offset-paper"
                    />
                    <span class="flex-1 pt-0.5 text-[15px] leading-7 text-ink sm:text-base">{{ answer.answer }}</span>
                </label>
            </div>
        </fieldset>
    </article>
</template>
