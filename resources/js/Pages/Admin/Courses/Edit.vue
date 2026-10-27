<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Components/Templates/AdminLayout.vue';
import GhostButton from '@/Components/Atoms/GhostButton.vue';
import InkButton from '@/Components/Atoms/InkButton.vue';
import Breadcrumbs from '@/Components/Molecules/Breadcrumbs.vue';
import PageHeader from '@/Components/Molecules/PageHeader.vue';
import CourseForm from '@/Components/Organisms/CourseForm.vue';

const props = defineProps({
    course: {
        type: Object,
        required: true,
    },
    categories: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    name: props.course.name,
    category_id: props.course.category_id,
    cover: null,
    course_type: 'Onboarding',
    publish_date: 'Active Now',
    access: 'Invitation Only',
    tnc: true,
    _method: 'PUT',
});

const submit = () => {
    form.post(route('dashboard.courses.update', props.course.id), {
        forceFormData: true,
    });
};
</script>

<template>
    <Head :title="`Ubah kursus: ${course.name}`" />

    <AdminLayout>
        <div class="mx-auto flex max-w-3xl flex-col gap-8">
            <div>
                <Breadcrumbs :items="[
                    { label: 'Kursus', href: route('dashboard.courses.index') },
                    { label: course.name, href: route('dashboard.courses.show', course.id) },
                    { label: 'Ubah' },
                ]" />
                <PageHeader
                    eyebrow="Ubah kursus"
                    :title="course.name"
                    description="Sampul lama tetap dipakai kalau kamu tidak memilih gambar baru."
                />
            </div>

            <CourseForm :form="form" :categories="categories" :existing-cover="course.cover" @submit="submit">
                <template #actions>
                    <GhostButton :href="route('dashboard.courses.show', course.id)">Batal</GhostButton>
                    <InkButton :disabled="form.processing">
                        {{ form.processing ? 'Menyimpan…' : 'Simpan perubahan' }}
                    </InkButton>
                </template>
            </CourseForm>
        </div>
    </AdminLayout>
</template>
