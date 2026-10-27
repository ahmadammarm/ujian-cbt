<script setup>
import { Link } from '@inertiajs/vue3';
import Highlighter from '@/Components/Atoms/Highlighter.vue';
import InkButton from '@/Components/Atoms/InkButton.vue';

defineProps({
    canRegister: {
        type: Boolean,
        default: true,
    },
});
</script>

<template>
    <div class="space-y-6 sm:space-y-8">
        <p class="font-hand text-lg font-semibold text-pen">Naiju Exam · portal siswa</p>

        <h1 class="font-hand text-[2.6rem] font-extrabold leading-[1.05] tracking-tight text-ink min-[400px]:text-5xl sm:text-6xl xl:text-7xl">
            Ujian tanpa
            <Highlighter>pensil 2B.</Highlighter>
        </h1>

        <p class="max-w-md font-legible text-base leading-7 sm:text-lg sm:leading-8 text-ink-soft">
            Kerjakan ulangan dari laptop atau komputer sekolah. Tidak ada bulatan yang harus dihitamkan, tidak ada LJK yang terlipat, dan nilaimu muncul begitu kamu menekan kirim.
        </p>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
            <InkButton v-if="$page.props.auth.user" :href="route('dashboard')">
                Buka dashboard
            </InkButton>
            <template v-else>
                <InkButton :href="route('login')">
                    Masuk ke Naiju Exam
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M5 12h14M13 6l6 6-6 6" />
                    </svg>
                </InkButton>
                <Link
                    :href="route('password.request')"
                    class="self-start font-legible text-sm font-bold text-ink underline decoration-pen/50 decoration-2 underline-offset-4 hover:decoration-pen focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pen sm:self-auto"
                >
                    Lupa password?
                </Link>
            </template>
        </div>

        <p v-if="!$page.props.auth.user" class="max-w-md font-legible text-sm leading-6 text-ink-soft">
            Biasanya akunmu sudah dibuatkan guru, jadi tinggal masuk pakai email dan password darinya.
            <template v-if="canRegister">
                Belum punya akun?
                <Link
                    :href="route('register')"
                    class="font-bold text-ink underline decoration-pen/50 decoration-2 underline-offset-4 hover:decoration-pen focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pen"
                >Daftar di sini</Link>.
            </template>
        </p>
    </div>
</template>
