<script setup>
import GuestLayout from '@/Components/Templates/GuestLayout.vue';
import InputError from '@/Components/Atoms/InputError.vue';
import InputLabel from '@/Components/Atoms/InputLabel.vue';
import PrimaryButton from '@/Components/Atoms/PrimaryButton.vue';
import TextInput from '@/Components/Atoms/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

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
    <GuestLayout>
        <Head title="Register" />

        <div class="mb-10">
            <h1 class="text-5xl font-bold text-gray-900 mb-3">Daftar Akun</h1>
            <p class="text-gray-500 font-medium text-lg">Lengkapi data di bawah untuk mendaftar</p>
        </div>

        <form @submit.prevent="submit">
            <div class="space-y-6">
                <div>
                    <InputLabel for="name" value="Nama Lengkap" />
                    <TextInput
                        id="name"
                        type="text"
                        v-model="form.name"
                        required
                        autofocus
                        autocomplete="name"
                        placeholder="Nama Lengkap Anda"
                    />
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div>
                    <InputLabel for="email" value="Alamat Email" />
                    <TextInput
                        id="email"
                        type="email"
                        v-model="form.email"
                        required
                        autocomplete="username"
                        placeholder="Email Anda"
                    />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div>
                    <InputLabel for="password" value="Kata Sandi" />
                    <TextInput
                        id="password"
                        type="password"
                        v-model="form.password"
                        required
                        autocomplete="new-password"
                        placeholder="Kata Sandi Anda"
                    />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div>
                    <InputLabel for="password_confirmation" value="Konfirmasi Kata Sandi" />
                    <TextInput
                        id="password_confirmation"
                        type="password"
                        v-model="form.password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="Konfirmasi Kata Sandi Anda"
                    />
                    <InputError class="mt-2" :message="form.errors.password_confirmation" />
                </div>
            </div>

            <div class="mt-10">
                <PrimaryButton :class="{ 'opacity-50': form.processing }" :disabled="form.processing">
                    Daftar
                </PrimaryButton>
            </div>

            <div class="mt-10 text-center text-lg">
                <span class="text-gray-600 font-medium">Sudah punya akun?</span>
                <Link
                    :href="route('login')"
                    class="ms-2 font-bold text-[#D95300] hover:underline"
                >
                    Masuk
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>

