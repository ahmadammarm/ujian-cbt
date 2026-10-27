<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/Atoms/ApplicationLogo.vue';
import InkButton from '@/Components/Atoms/InkButton.vue';

defineProps({
    canLogin: {
        type: Boolean,
        default: true,
    },
});

const sections = [
    { href: '#persiapan', label: 'Hari ujian' },
    { href: '#aturan', label: 'Aturan' },
    { href: '#tanya', label: 'Tanya jawab' },
];

const isMenuOpen = ref(false);

const closeMenu = () => {
    isMenuOpen.value = false;
};

const handleKeydown = (event) => {
    if (event.key === 'Escape') {
        closeMenu();
    }
};

onMounted(() => window.addEventListener('keydown', handleKeydown));
onUnmounted(() => window.removeEventListener('keydown', handleKeydown));
</script>

<template>
    <header class="sticky top-0 z-40 border-b border-rule bg-paper/90 backdrop-blur">
        <div class="mx-auto flex h-16 max-w-6xl items-center justify-between gap-3 px-6 sm:pl-24 sm:pr-8">
            <Link href="/" class="flex items-center gap-2.5 rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pen">
                <span class="flex size-9 items-center justify-center rounded-lg bg-ink text-paper">
                    <ApplicationLogo class="size-5" />
                </span>
                <span class="font-hand text-2xl font-extrabold text-ink">Naiju</span>
            </Link>

            <nav aria-label="Bagian halaman" class="hidden items-center gap-8 md:flex">
                <a
                    v-for="section in sections"
                    :key="section.href"
                    :href="section.href"
                    class="font-legible text-sm font-bold text-ink-soft underline-offset-8 hover:text-ink hover:underline hover:decoration-pen hover:decoration-2 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pen"
                >{{ section.label }}</a>
            </nav>

            <div class="flex items-center gap-2 sm:gap-3">
                <template v-if="canLogin">
                    <InkButton v-if="$page.props.auth.user" :href="route('dashboard')" size="sm">Dashboard</InkButton>
                    <InkButton v-else :href="route('login')" size="sm">Masuk</InkButton>
                </template>

                <button
                    type="button"
                    class="flex size-10 items-center justify-center rounded-lg text-ink transition-colors hover:bg-rule/50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pen active:scale-95 md:hidden"
                    :aria-expanded="isMenuOpen"
                    aria-controls="landing-menu"
                    :aria-label="isMenuOpen ? 'Tutup menu' : 'Buka menu'"
                    @click="isMenuOpen = !isMenuOpen"
                >
                    <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" aria-hidden="true">
                        <path v-if="isMenuOpen" d="M6 6l12 12M18 6L6 18" />
                        <path v-else d="M4 7h16M4 12h16M4 17h10" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile menu -->
        <Transition
            enter-active-class="transition duration-200 ease-out motion-reduce:transition-none"
            enter-from-class="-translate-y-2 opacity-0"
            leave-active-class="transition duration-150 ease-in motion-reduce:transition-none"
            leave-to-class="-translate-y-2 opacity-0"
        >
            <nav
                v-show="isMenuOpen"
                id="landing-menu"
                aria-label="Menu utama"
                class="absolute inset-x-0 top-full border-b border-rule bg-paper shadow-[0_16px_32px_-20px_rgba(27,42,107,0.45)] md:hidden"
            >
                <ul class="mx-auto max-w-6xl px-6 py-2 sm:pl-24 sm:pr-8">
                    <li v-for="section in sections" :key="section.href">
                        <a
                            :href="section.href"
                            class="flex items-center justify-between border-b border-dashed border-rule py-4 font-hand text-xl font-bold text-ink focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pen"
                            @click="closeMenu"
                        >
                            {{ section.label }}
                            <span aria-hidden="true" class="text-pen">→</span>
                        </a>
                    </li>
                    <li v-if="canLogin && !$page.props.auth.user" class="py-4">
                        <Link
                            :href="route('password.request')"
                            class="font-legible text-sm font-bold text-ink-soft underline decoration-pen/50 decoration-2 underline-offset-4 hover:text-ink focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pen"
                        >
                            Lupa password?
                        </Link>
                    </li>
                </ul>
            </nav>
        </Transition>
    </header>
</template>
