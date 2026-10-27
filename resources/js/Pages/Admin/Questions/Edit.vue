<script setup>
import { computed } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Components/Templates/AdminLayout.vue';
import GhostButton from '@/Components/Atoms/GhostButton.vue';
import InkButton from '@/Components/Atoms/InkButton.vue';
import Breadcrumbs from '@/Components/Molecules/Breadcrumbs.vue';
import PageHeader from '@/Components/Molecules/PageHeader.vue';
import QuestionForm from '@/Components/Organisms/QuestionForm.vue';

const props = defineProps({
    course: {
        type: Object,
        required: true,
    },
    courseQuestion: {
        type: Object,
        required: true,
    },
});

const initialCorrectAnswer = props.courseQuestion.answers.findIndex(a => a.is_correct);

const form = useForm({
    question: props.courseQuestion.question,
    answers: props.courseQuestion.answers.map(a => a.answer),
    correct_answer: initialCorrectAnswer !== -1 ? initialCorrectAnswer : null,
    _method: 'PUT',
});

const submit = () => {
    form.post(route('dashboard.course.question.update', {
        courseId: props.course.id,
        questionId: props.courseQuestion.id
    }));
};

const isFormValid = computed(() => {
    return form.question.trim().length > 0 &&
        form.answers.every(a => a && a.trim().length > 0) &&
        form.correct_answer !== null;
});
</script>

<template>
    <Head :title="`Ubah soal: ${course.name}`" />

    <AdminLayout>
        <div class="flex flex-col gap-8">
            <div>
                <Breadcrumbs :items="[
                    { label: 'Kursus', href: route('dashboard.courses.index') },
                    { label: course.name, href: route('dashboard.courses.show', course.id) },
                    { label: 'Ubah soal' },
                ]" />
                <PageHeader
                    :eyebrow="course.name"
                    title="Ubah soal."
                    description="Ubah teks pertanyaan, pilihan jawaban, atau kuncinya."
                />
            </div>

            <QuestionForm :form="form" @submit="isFormValid && submit()">
                <template #actions>
                    <GhostButton :href="route('dashboard.courses.show', course.id)">Batal</GhostButton>
                    <InkButton :disabled="!isFormValid || form.processing">
                        {{ form.processing ? 'Menyimpan…' : 'Simpan perubahan' }}
                    </InkButton>
                </template>
            </QuestionForm>
        </div>
    </AdminLayout>
</template>
