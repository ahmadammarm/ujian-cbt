<script setup>
import { computed } from 'vue';
import BubbleMark from '@/Components/Atoms/BubbleMark.vue';
import NotebookField from '@/Components/Molecules/NotebookField.vue';
import NotebookTextarea from '@/Components/Molecules/NotebookTextarea.vue';
import QuestionCard from '@/Components/Organisms/QuestionCard.vue';

// Must match the `question` max rule in Store/UpdateCourseQuestionRequest
const QUESTION_MAX_LENGTH = 255;
const OPTION_LETTERS = ['A', 'B', 'C', 'D'];

// `form` is the page's useForm() instance with question, answers[] and correct_answer
const props = defineProps({
    form: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(['submit']);

const selectCorrectAnswer = (index) => {
    props.form.correct_answer = index;
};

// What the student will see; the key is highlighted here only for the teacher
const previewQuestion = computed(() => ({
    id: 0,
    question: props.form.question.trim() || 'Pertanyaanmu akan tampil di sini.',
    answers: props.form.answers.map((answer, index) => ({
        id: index,
        answer: answer?.trim() || `Pilihan ${OPTION_LETTERS[index]}`,
    })),
}));

const previewSelected = computed(() =>
    props.form.correct_answer !== null ? previewQuestion.value.answers[props.form.correct_answer]?.answer ?? '' : ''
);
</script>

<template>
    <div class="grid gap-8 lg:grid-cols-12">
        <form class="rounded-md border border-rule bg-paper p-5 sm:p-8 lg:col-span-7" @submit.prevent="emit('submit')">
            <NotebookTextarea
                id="question"
                v-model="form.question"
                label="Pertanyaan"
                :rows="3"
                :maxlength="QUESTION_MAX_LENGTH"
                placeholder="Tulis pertanyaannya di sini…"
                :error="form.errors.question"
                required
            />

            <fieldset class="mt-10">
                <legend class="font-form text-[11px] font-semibold uppercase tracking-[0.16em] text-pen">Pilihan jawaban &amp; kunci</legend>
                <p class="mt-1 text-sm text-ink-soft">Hitamkan bulatan di samping jawaban yang benar. Siswa tidak bisa melihat kuncinya.</p>

                <div class="mt-5 space-y-6">
                    <div v-for="(answer, index) in form.answers" :key="index" class="flex items-end gap-4">
                        <label class="relative mb-2 inline-flex shrink-0 cursor-pointer">
                            <input
                                type="radio"
                                name="correct_answer"
                                class="peer sr-only"
                                :value="index"
                                :checked="form.correct_answer === index"
                                :aria-label="`Jadikan pilihan ${OPTION_LETTERS[index]} kunci jawaban`"
                                @change="selectCorrectAnswer(index)"
                            />
                            <BubbleMark
                                size="lg"
                                :label="OPTION_LETTERS[index]"
                                :filled="form.correct_answer === index"
                                class="peer-hover:border-pen peer-focus-visible:ring-2 peer-focus-visible:ring-pen peer-focus-visible:ring-offset-2 peer-focus-visible:ring-offset-paper"
                            />
                        </label>
                        <NotebookField
                            :id="`answer-${index}`"
                            v-model="form.answers[index]"
                            class="flex-1"
                            :label="form.correct_answer === index ? `Pilihan ${OPTION_LETTERS[index]} · kunci` : `Pilihan ${OPTION_LETTERS[index]}`"
                            :error="form.errors[`answers.${index}`]"
                            required
                        />
                    </div>
                </div>

                <p v-if="form.errors.correct_answer || form.errors.answers" class="mt-4 font-hand text-base font-semibold text-pen">
                    {{ form.errors.correct_answer || form.errors.answers }}
                </p>
            </fieldset>

            <div class="mt-10 flex flex-col-reverse gap-3 border-t border-dashed border-rule pt-6 sm:flex-row sm:justify-end">
                <slot name="actions" />
            </div>
        </form>

        <aside class="lg:col-span-5">
            <div class="lg:sticky lg:top-8">
                <p class="font-form text-[11px] font-semibold uppercase tracking-[0.16em] text-ink-soft">Pratinjau untuk siswa</p>
                <div class="mt-3" inert aria-hidden="true">
                    <QuestionCard :question="previewQuestion" :index="0" :selected-answer="previewSelected" />
                </div>
                <p class="mt-3 text-sm text-ink-soft">Sorotan kuning hanya muncul di pratinjau ini untuk menandai kunci jawaban.</p>
            </div>
        </aside>
    </div>
</template>
