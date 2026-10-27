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
});

const form = useForm({
    question: '',
    answers: ['', '', '', ''],
    correct_answer: null,
    action: 'create_another',
});

const submitWithAction = (actionType) => {
    form.action = actionType;
    form.post(route('dashboard.course.question.store', props.course.id));
};

const isFormValid = computed(() => {
    return form.question.trim().length > 0 &&
        form.answers.every(a => a.trim().length > 0) &&
        form.correct_answer !== null;
});
</script>

<template>
    <Head :title="`Tambah soal: ${course.name}`" />

    <AdminLayout>
        <div class="flex flex-col gap-8">
            <div>
                <Breadcrumbs :items="[
                    { label: 'Kursus', href: route('dashboard.courses.index') },
                    { label: course.name, href: route('dashboard.courses.show', course.id) },
                    { label: 'Tambah soal' },
                ]" />
                <PageHeader
                    :eyebrow="course.name"
                    title="Tambah soal."
                    description="Satu pertanyaan, empat pilihan, satu kunci jawaban."
                />
            </div>

            <QuestionForm :form="form" @submit="isFormValid && submitWithAction('create_another')">
                <template #actions>
                    <GhostButton :disabled="!isFormValid || form.processing" @click="submitWithAction('finish')">
                        Simpan &amp; selesai
                    </GhostButton>
                    <InkButton :disabled="!isFormValid || form.processing">
                        {{ form.processing ? 'Menyimpan…' : 'Simpan & tambah lagi' }}
                    </InkButton>
                </template>
            </QuestionForm>
        </div>
    </AdminLayout>
</template>
