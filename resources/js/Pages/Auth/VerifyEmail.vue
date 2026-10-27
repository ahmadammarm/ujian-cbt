<script setup>
import { computed } from 'vue';
import FormStatus from '@/Components/Atoms/FormStatus.vue';
import InkButton from '@/Components/Atoms/InkButton.vue';
import GuestLayout from '@/Components/Templates/GuestLayout.vue';
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
    <GuestLayout
        sheet-label="Verifikasi email"
        title="Cek emailmu."
        intro="Kami sudah mengirim tautan verifikasi. Klik tautan itu untuk mengaktifkan akunmu, lalu kembali ke sini."
    >
        <Head title="Verifikasi email" />

        <FormStatus v-if="verificationLinkSent" class="mb-8">
            Tautan verifikasi baru sudah dikirim ke emailmu.
        </FormStatus>

        <form class="space-y-5" @submit.prevent="submit">
            <InkButton class="w-full" :disabled="form.processing">
                {{ form.processing ? 'Sedang mengirim…' : 'Kirim ulang email verifikasi' }}
            </InkButton>
        </form>

        <p class="mt-8 border-t border-dashed border-rule pt-6 font-legible text-sm text-ink-soft">
            Salah akun?
            <Link
                :href="route('logout')"
                method="post"
                as="button"
                class="rounded-sm font-legible font-bold text-ink underline decoration-pen/50 decoration-2 underline-offset-4 hover:decoration-pen focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pen"
            >
                Keluar
            </Link>
        </p>
    </GuestLayout>
</template>
