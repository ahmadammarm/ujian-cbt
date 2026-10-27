<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/Atoms/ApplicationLogo.vue';
import InkButton from '@/Components/Atoms/InkButton.vue';

defineProps({
    code: {
        type: Number,
        required: true,
    },
    title: {
        type: String,
        required: true,
    },
    description: {
        type: String,
        required: true,
    },
});

const page = usePage();
const isSignedIn = computed(() => Boolean(page.props.auth?.user));
</script>

<template>
    <div class="relative flex min-h-screen items-center justify-center overflow-x-clip bg-paper bg-notebook-lines px-6 py-16 font-legible text-ink antialiased">
        <span aria-hidden="true" class="pointer-events-none absolute inset-y-0 left-16 hidden w-px bg-pen/40 sm:block"></span>

        <div class="relative w-full max-w-lg rounded-md border border-pen/25 bg-paper p-6 shadow-[0_1px_0_rgba(27,42,107,0.06),0_24px_48px_-24px_rgba(27,42,107,0.45)] sm:p-10">
            <div class="flex items-baseline justify-between gap-4 border-b-2 border-pen pb-2 font-form text-[11px] font-semibold uppercase tracking-[0.18em] text-pen">
                <span>Kode {{ code }}</span>
                <span class="flex items-center gap-1.5"><ApplicationLogo class="size-3.5" /> Naiju</span>
            </div>
            <h1 class="mt-8 font-hand text-4xl font-extrabold leading-tight sm:text-5xl">{{ title }}</h1>
            <p class="mt-3 text-base leading-7 text-ink-soft sm:text-lg sm:leading-8">{{ description }}</p>
            <InkButton :href="isSignedIn ? route('dashboard') : '/'" class="mt-8">
                {{ isSignedIn ? 'Kembali ke dashboard' : 'Kembali ke beranda' }}
            </InkButton>
        </div>
    </div>
</template>
