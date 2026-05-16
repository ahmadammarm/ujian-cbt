<script setup>
import GuestLayout from '@/Components/Templates/GuestLayout.vue';
import InputError from '@/Components/Atoms/InputError.vue';
import InputLabel from '@/Components/Atoms/InputLabel.vue';
import PrimaryButton from '@/Components/Atoms/PrimaryButton.vue';
import TextInput from '@/Components/Atoms/TextInput.vue';
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
    <GuestLayout>
        <Head title="Confirm Password" />

        <div class="mb-8">
            <h1 class="text-2xl font-semibold text-gray-900">Secure area</h1>
            <p class="text-gray-500 mt-2">Please confirm your password before continuing.</p>
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="password" value="Password" />
                <TextInput
                    id="password"
                    type="password"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                    autofocus
                    placeholder="••••••••"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-8">
                <PrimaryButton :class="{ 'opacity-50': form.processing }" :disabled="form.processing">
                    Confirm Access
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>

