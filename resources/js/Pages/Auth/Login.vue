<script setup>
import Checkbox from '@/Components/Atoms/Checkbox.vue';
import FormStatus from '@/Components/Atoms/FormStatus.vue';
import InkButton from '@/Components/Atoms/InkButton.vue';
import PenLink from '@/Components/Atoms/PenLink.vue';
import StickyNote from '@/Components/Atoms/StickyNote.vue';
import NotebookField from '@/Components/Molecules/NotebookField.vue';
import GuestLayout from '@/Components/Templates/GuestLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

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
    <GuestLayout sheet-label="Masuk" title="Halo lagi." intro="Masuk pakai email dan password dari gurumu.">
        <Head title="Masuk" />

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

            <NotebookField
                id="password"
                v-model="form.password"
                type="password"
                label="Password"
                autocomplete="current-password"
                :error="form.errors.password"
                required
            />

            <div class="flex flex-wrap items-center justify-between gap-4">
                <label class="flex cursor-pointer items-center gap-3 font-legible text-sm font-bold text-ink">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    Ingat saya
                </label>
                <PenLink v-if="canResetPassword" :href="route('password.request')" class="text-sm">
                    Lupa password?
                </PenLink>
            </div>

            <InkButton class="w-full" :disabled="form.processing">
                {{ form.processing ? 'Sedang masuk…' : 'Masuk' }}
            </InkButton>
        </form>

        <p class="mt-8 border-t border-dashed border-rule pt-6 font-legible text-sm text-ink-soft">
            Belum punya akun?
            <PenLink :href="route('register')">Daftar di sini</PenLink>
        </p>

        <template #note>
            <StickyNote>
                <p class="font-hand text-2xl font-bold">Belum dapat akun?</p>
                <p class="mt-3 font-legible text-base leading-7">
                    Biasanya guru atau wali kelas yang membuatkan akunmu. Tanya mereka dulu sebelum daftar sendiri.
                </p>
                <p class="mt-4 font-legible text-sm leading-6 text-graphite/80">
                    Guru juga masuk dari halaman ini dan otomatis diarahkan ke Naiju Studio.
                </p>
            </StickyNote>
        </template>
    </GuestLayout>
</template>
