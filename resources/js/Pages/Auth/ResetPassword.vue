<script setup>
import InkButton from '@/Components/Atoms/InkButton.vue';
import NotebookField from '@/Components/Molecules/NotebookField.vue';
import GuestLayout from '@/Components/Templates/GuestLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    email: {
        type: String,
        required: true,
    },
    token: {
        type: String,
        required: true,
    },
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout
        sheet-label="Password baru"
        title="Bikin password baru."
        intro="Pakai password yang mudah kamu ingat, tapi sulit ditebak teman."
    >
        <Head title="Buat password baru" />

        <form class="space-y-7" @submit.prevent="submit">
            <NotebookField
                id="email"
                v-model="form.email"
                type="email"
                label="Email"
                autocomplete="username"
                :error="form.errors.email"
                required
            />

            <NotebookField
                id="password"
                v-model="form.password"
                type="password"
                label="Password baru"
                hint="Minimal 8 karakter."
                autocomplete="new-password"
                :error="form.errors.password"
                required
                autofocus
            />

            <NotebookField
                id="password_confirmation"
                v-model="form.password_confirmation"
                type="password"
                label="Ulangi password baru"
                autocomplete="new-password"
                :error="form.errors.password_confirmation"
                required
            />

            <InkButton class="w-full" :disabled="form.processing">
                {{ form.processing ? 'Sedang menyimpan…' : 'Simpan password baru' }}
            </InkButton>
        </form>
    </GuestLayout>
</template>
