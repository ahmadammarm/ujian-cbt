<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Components/Templates/AdminLayout.vue';
import GhostButton from '@/Components/Atoms/GhostButton.vue';
import InkButton from '@/Components/Atoms/InkButton.vue';
import Breadcrumbs from '@/Components/Molecules/Breadcrumbs.vue';
import PageHeader from '@/Components/Molecules/PageHeader.vue';
import CourseForm from '@/Components/Organisms/CourseForm.vue';

defineProps({
    categories: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    name: '',
    category_id: '',
    cover: null,
    action: 'add_questions',
    course_type: 'Onboarding',
    publish_date: 'Active Now',
    access: 'Invitation Only',
    tnc: true,
});

const submitWithAction = (actionType) => {
    form.action = actionType;
    form.post(route('dashboard.courses.store'), {
        forceFormData: true,
    });
};
</script>

<template>
    <Head title="Buat kursus" />

    <AdminLayout>
        <div class="mx-auto flex max-w-3xl flex-col gap-8">
            <div>
                <Breadcrumbs :items="[
                    { label: 'Kursus', href: route('dashboard.courses.index') },
                    { label: 'Buat kursus' },
                ]" />
                <PageHeader
                    eyebrow="Langkah 1 dari 2"
                    title="Buat kursus baru."
                    description="Isi nama, kategori, dan sampulnya. Setelah itu kamu bisa langsung menyusun soal."
                />
            </div>

            <CourseForm :form="form" :categories="categories" @submit="submitWithAction('add_questions')">
                <template #actions>
                    <GhostButton type="button" :disabled="form.processing" @click="submitWithAction('manage')">
                        Simpan saja
                    </GhostButton>
                    <InkButton :disabled="form.processing">
                        {{ form.processing ? 'Menyimpan…' : 'Simpan & tambah soal' }}
                    </InkButton>
                </template>
            </CourseForm>
        </div>
    </AdminLayout>
</template>
