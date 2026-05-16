<script setup>
import GuestLayout from '@/Components/Templates/GuestLayout.vue';
import InputError from '@/Components/Atoms/InputError.vue';
import InputLabel from '@/Components/Atoms/InputLabel.vue';
import PrimaryButton from '@/Components/Atoms/PrimaryButton.vue';
import TextInput from '@/Components/Atoms/TextInput.vue';
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
    <GuestLayout>
        <Head title="Forgot Password" />

        <div class="mb-10">
            <h1 class="text-4xl font-bold text-gray-900 mb-3">Lupa Kata Sandi</h1>
            <p class="text-gray-500 font-medium text-lg">Masukkan email Anda untuk menerima tautan reset kata sandi.</p>
        </div>

        <div v-if="status" class="mb-6 p-4 rounded-xl bg-green-50 text-sm text-green-600 border border-green-100">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
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

            <div class="mt-10 space-y-6">
                <PrimaryButton :class="{ 'opacity-50': form.processing }" :disabled="form.processing">
                    Kirim Tautan Reset
                </PrimaryButton>

                <p class="text-center text-lg font-medium">
                    <Link
                        :href="route('login')"
                        class="text-[#D95300] hover:underline"
                    >
                        Kembali ke Masuk
                    </Link>
                </p>
            </div>
        </form>
    </GuestLayout>
</template>

