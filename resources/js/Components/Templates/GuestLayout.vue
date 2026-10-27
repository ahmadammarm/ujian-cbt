<script setup>
import { Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/Atoms/ApplicationLogo.vue';

defineProps({
    sheetLabel: {
        type: String,
        required: true,
    },
    title: {
        type: String,
        required: true,
    },
    intro: {
        type: String,
        default: '',
    },
});

const currentYear = new Date().getFullYear();
</script>

<template>
    <div class="relative flex min-h-screen flex-col overflow-x-clip bg-paper bg-notebook-lines font-legible text-ink antialiased selection:bg-stabilo selection:text-ink">
        <!-- Notebook margin line -->
        <span aria-hidden="true" class="pointer-events-none absolute inset-y-0 left-16 z-0 hidden w-px bg-pen/40 sm:block"></span>

        <header class="relative z-10 border-b border-rule bg-paper/90 backdrop-blur">
            <div class="mx-auto flex h-16 max-w-6xl items-center justify-between gap-4 px-6 sm:pl-24 sm:pr-8">
                <Link href="/" class="flex items-center gap-2.5 rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pen">
                    <span class="flex size-9 items-center justify-center rounded-lg bg-ink text-paper">
                        <ApplicationLogo class="size-5" />
                    </span>
                    <span class="font-hand text-2xl font-extrabold text-ink">Naiju</span>
                </Link>
                <Link
                    href="/"
                    class="font-legible text-sm font-bold text-ink-soft underline-offset-8 hover:text-ink hover:underline hover:decoration-pen hover:decoration-2 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pen"
                >
                    <span aria-hidden="true">←</span> Beranda
                </Link>
            </div>
        </header>

        <main class="relative z-10 flex-1 py-10 sm:py-16">
            <div class="mx-auto grid max-w-6xl items-start gap-12 px-6 sm:pl-24 sm:pr-8 lg:grid-cols-12 lg:gap-10">
                <!-- Paper sheet -->
                <div
                    :class="[
                        'rounded-md border border-pen/25 bg-paper p-6 shadow-[0_1px_0_rgba(27,42,107,0.06),0_24px_48px_-24px_rgba(27,42,107,0.45)] motion-safe:animate-slide-up sm:p-10',
                        $slots.note ? 'lg:col-span-7 xl:col-span-6' : 'w-full max-w-xl lg:col-span-7',
                    ]"
                >
                    <div class="flex items-baseline justify-between gap-4 border-b-2 border-pen pb-2 font-form text-[11px] font-semibold uppercase tracking-[0.18em] text-pen">
                        <span>{{ sheetLabel }}</span>
                        <span class="hidden min-[400px]:inline">Naiju Exam</span>
                    </div>

                    <h1 class="mt-8 font-hand text-4xl font-extrabold leading-tight text-ink sm:text-5xl">{{ title }}</h1>
                    <p v-if="intro" class="mt-3 font-legible text-base leading-7 text-ink-soft sm:text-lg sm:leading-8">{{ intro }}</p>

                    <div class="mt-8">
                        <slot />
                    </div>
                </div>

                <aside v-if="$slots.note" class="lg:col-span-5 lg:pt-16 xl:col-start-8">
                    <slot name="note" />
                </aside>
            </div>
        </main>

        <footer class="relative z-10 py-8">
            <p class="mx-auto max-w-6xl px-6 font-legible text-sm text-ink-soft sm:pl-24 sm:pr-8">
                <span class="font-hand text-base font-bold text-ink">Naiju Exam</span> · portal ujian siswa · © {{ currentYear }}
            </p>
        </footer>
    </div>
</template>
