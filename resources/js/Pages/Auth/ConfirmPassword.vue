<script setup>
import InkButton from '@/Components/Atoms/InkButton.vue';
import NotebookField from '@/Components/Molecules/NotebookField.vue';
import GuestLayout from '@/Components/Templates/GuestLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    password: '',
});

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <GuestLayout
        sheet-label="Konfirmasi"
        title="Masukkan password lagi."
        intro="Bagian ini butuh konfirmasi password sebelum kamu lanjut."
    >
        <Head title="Konfirmasi password" />

        <form class="space-y-7" @submit.prevent="submit">
            <NotebookField
                id="password"
                v-model="form.password"
                type="password"
                label="Password"
                autocomplete="current-password"
                :error="form.errors.password"
                required
                autofocus
            />

            <InkButton class="w-full" :disabled="form.processing">
                {{ form.processing ? 'Sedang memeriksa…' : 'Lanjutkan' }}
            </InkButton>
        </form>
    </GuestLayout>
</template>
