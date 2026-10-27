<script setup>
import { computed } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Components/Templates/AdminLayout.vue';
import StudentLayout from '@/Components/Templates/StudentLayout.vue';
import Breadcrumbs from '@/Components/Molecules/Breadcrumbs.vue';
import PageHeader from '@/Components/Molecules/PageHeader.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';

const TEACHER_ROLE = 'teacher';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const page = usePage();
const isTeacher = computed(() => page.props.auth.user.role === TEACHER_ROLE);
const layout = computed(() => (isTeacher.value ? AdminLayout : StudentLayout));
const homeCrumb = computed(() =>
    isTeacher.value
        ? { label: 'Ringkasan', href: route('dashboard.overview') }
        : { label: 'Beranda', href: route('dashboard') }
);
</script>

<template>
    <Head title="Profil saya" />

    <component :is="layout">
        <div class="mx-auto flex max-w-3xl flex-col gap-8">
            <div>
                <Breadcrumbs :items="[homeCrumb, { label: 'Profil saya' }]" />
                <PageHeader eyebrow="Akun" title="Profil saya." description="Atur nama, email, dan password akunmu." />
            </div>

            <section class="rounded-md border border-rule bg-paper p-5 sm:p-8">
                <UpdateProfileInformationForm :must-verify-email="mustVerifyEmail" :status="status" />
            </section>

            <section class="rounded-md border border-rule bg-paper p-5 sm:p-8">
                <UpdatePasswordForm />
            </section>

            <section class="rounded-md border border-pen/30 bg-paper p-5 sm:p-8">
                <DeleteUserForm />
            </section>
        </div>
    </component>
</template>
