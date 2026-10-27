<script setup>
import FormStatus from '@/Components/Atoms/FormStatus.vue';
import InkButton from '@/Components/Atoms/InkButton.vue';
import PenLink from '@/Components/Atoms/PenLink.vue';
import StickyNote from '@/Components/Atoms/StickyNote.vue';
import NotebookField from '@/Components/Molecules/NotebookField.vue';
import GuestLayout from '@/Components/Templates/GuestLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <GuestLayout
        sheet-label="Lupa password"
        title="Lupa password?"
        intro="Tulis email akunmu. Kami kirim tautan untuk membuat password baru."
    >
        <Head title="Lupa password" />

        <FormStatus v-if="status" class="mb-8">{{ status }}</FormStatus>

        <form class="space-y-7" @submit.prevent="submit">
            <NotebookField
                id="email"
                v-model="form.email"
                type="email"
                label="Email"
                placeholder="nama@email.com"
                autocomplete="username"
                :error="form.errors.email"
                required
                autofocus
            />

            <InkButton class="w-full" :disabled="form.processing">
                {{ form.processing ? 'Sedang mengirim…' : 'Kirim tautan reset' }}
            </InkButton>
        </form>

        <p class="mt-8 border-t border-dashed border-rule pt-6 font-legible text-sm text-ink-soft">
            Sudah ingat?
            <PenLink :href="route('login')">Kembali ke halaman masuk</PenLink>
        </p>

        <template #note>
            <StickyNote>
                <p class="font-hand text-2xl font-bold">Emailnya tidak sampai?</p>
                <p class="mt-3 font-legible text-base leading-7">
                    Cek folder spam atau promosi. Kalau tetap tidak ada, minta gurumu mengecek alamat email di akunmu.
                </p>
            </StickyNote>
        </template>
    </GuestLayout>
</template>
