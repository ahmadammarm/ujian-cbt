<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div class="mb-10">
            <h1 class="text-5xl font-bold text-gray-900 mb-3">Selamat Datang</h1>
            <p class="text-gray-500 font-medium text-lg">Masuk ke akun Anda untuk melanjutkan</p>
        </div>

        <div v-if="status" class="mb-6 p-4 rounded-xl bg-green-50 text-sm text-green-600 border border-green-100">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div class="space-y-6">
                <div>
                    <InputLabel for="email" value="Alamat Email" />
                    <TextInput
                        id="email"
                        type="email"
                        v-model="form.email"
                        required
                        autofocus
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
                        autocomplete="current-password"
                        placeholder="Kata Sandi Anda"
                    />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>
            </div>

            <div class="flex items-center justify-between mt-6">
                <div class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ms-3 text-sm font-medium text-gray-600">Ingat saya</span>
                </div>
                
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="text-sm font-bold text-[#D95300] hover:underline"
                >
                    Lupa Kata Sandi?
                </Link>
            </div>

            <div class="mt-10">
                <PrimaryButton :class="{ 'opacity-50': form.processing }" :disabled="form.processing">
                    Masuk
                </PrimaryButton>
            </div>

            <div class="mt-10 text-center text-lg">
                <span class="text-gray-600 font-medium">Belum punya akun?</span>
                <Link
                    :href="route('register')"
                    class="ms-2 font-bold text-[#D95300] hover:underline"
                >
                    Daftar
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>
