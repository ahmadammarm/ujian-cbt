<script setup>
import InkButton from '@/Components/Atoms/InkButton.vue';
import PenLink from '@/Components/Atoms/PenLink.vue';
import StickyNote from '@/Components/Atoms/StickyNote.vue';
import NotebookField from '@/Components/Molecules/NotebookField.vue';
import GuestLayout from '@/Components/Templates/GuestLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout
        sheet-label="Daftar"
        title="Bikin akun baru."
        intro="Pakai nama lengkap supaya gurumu gampang mengenalimu."
    >
        <Head title="Daftar" />

        <form class="space-y-7" @submit.prevent="submit">
            <NotebookField
                id="name"
                v-model="form.name"
                label="Nama lengkap"
                hint="Tulis seperti di daftar absen kelas."
                autocomplete="name"
                :error="form.errors.name"
                required
                autofocus
            />

            <NotebookField
                id="email"
                v-model="form.email"
                type="email"
                label="Email"
                placeholder="nama@email.com"
                autocomplete="username"
                :error="form.errors.email"
                required
            />

            <NotebookField
                id="password"
                v-model="form.password"
                type="password"
                label="Password"
                hint="Minimal 8 karakter."
                autocomplete="new-password"
                :error="form.errors.password"
                required
            />

            <NotebookField
                id="password_confirmation"
                v-model="form.password_confirmation"
                type="password"
                label="Ulangi password"
                autocomplete="new-password"
                :error="form.errors.password_confirmation"
                required
            />

            <InkButton class="w-full" :disabled="form.processing">
                {{ form.processing ? 'Sedang mendaftar…' : 'Daftar' }}
            </InkButton>
        </form>

        <p class="mt-8 border-t border-dashed border-rule pt-6 font-legible text-sm text-ink-soft">
            Sudah punya akun?
            <PenLink :href="route('login')">Masuk di sini</PenLink>
        </p>

        <template #note>
            <StickyNote>
                <p class="font-hand text-2xl font-bold">Setelah daftar</p>
                <p class="mt-3 font-legible text-base leading-7">
                    Akunmu belum terhubung ke mapel mana pun. Kasih tahu gurumu email yang kamu pakai supaya kamu dimasukkan ke ujiannya.
                </p>
                <p class="mt-4 font-legible text-sm leading-6 text-graphite/80">
                    Kalau gurumu sudah membuatkan akun, tidak perlu daftar lagi. Langsung masuk saja.
                </p>
            </StickyNote>
        </template>
    </GuestLayout>
</template>
