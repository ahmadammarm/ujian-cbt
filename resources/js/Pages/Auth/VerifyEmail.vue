<script setup>
import { computed } from 'vue';
import GuestLayout from '@/Components/Templates/GuestLayout.vue';
import PrimaryButton from '@/Components/Atoms/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    status: {
        type: String,
    },
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
    <GuestLayout>
        <Head title="Email Verification" />

        <div class="mb-8 text-center">
            <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-semibold text-gray-900">Verify your email</h1>
            <p class="text-gray-500 mt-2 px-4">
                We've sent a verification link to your email address. Please click it to confirm your account.
            </p>
        </div>

        <div v-if="verificationLinkSent" class="mb-6 p-4 rounded-xl bg-green-50 text-sm text-green-600 border border-green-100 text-center">
            A new verification link has been sent to your email.
        </div>

        <form @submit.prevent="submit">
            <div class="space-y-4">
                <PrimaryButton :class="{ 'opacity-50': form.processing }" :disabled="form.processing">
                    Resend Verification Email
                </PrimaryButton>

                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="w-full text-center text-sm text-gray-400 hover:text-gray-600 transition-colors py-2"
                >
                    Log Out
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>

