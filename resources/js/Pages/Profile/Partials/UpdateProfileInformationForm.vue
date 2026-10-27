<script setup>
import { Link, useForm, usePage } from '@inertiajs/vue3';
import FormStatus from '@/Components/Atoms/FormStatus.vue';
import InkButton from '@/Components/Atoms/InkButton.vue';
import NotebookField from '@/Components/Molecules/NotebookField.vue';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
});
</script>

<template>
    <div>
        <header>
            <h2 class="text-xl font-bold text-ink">Data akun</h2>
            <p class="mt-1 text-[15px] text-ink-soft">Nama ini yang dilihat guru dan muncul di rapor.</p>
        </header>

        <form class="mt-6 space-y-7" @submit.prevent="form.patch(route('profile.update'))">
            <NotebookField
                id="name"
                v-model="form.name"
                label="Nama lengkap"
                autocomplete="name"
                :error="form.errors.name"
                required
            />

            <NotebookField
                id="email"
                v-model="form.email"
                type="email"
                label="Email"
                autocomplete="username"
                :error="form.errors.email"
                required
            />

            <div v-if="mustVerifyEmail && user.email_verified_at === null" class="space-y-3">
                <p class="text-sm text-ink">
                    Emailmu belum diverifikasi.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="rounded-sm font-bold underline decoration-pen/50 decoration-2 underline-offset-4 hover:decoration-pen focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pen"
                    >
                        Kirim ulang email verifikasi
                    </Link>
                </p>
                <FormStatus v-show="status === 'verification-link-sent'">Tautan verifikasi baru sudah dikirim ke emailmu.</FormStatus>
            </div>

            <div class="flex items-center gap-4">
                <InkButton size="sm" :disabled="form.processing">Simpan</InkButton>
                <Transition
                    enter-active-class="transition ease-in-out motion-reduce:transition-none"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out motion-reduce:transition-none"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" role="status" class="font-hand text-lg font-bold text-ink">Tersimpan.</p>
                </Transition>
            </div>
        </form>
    </div>
</template>
