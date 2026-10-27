<script setup>
import LandingNavbar from '@/Components/Organisms/LandingNavbar.vue';
import LandingFooter from '@/Components/Organisms/LandingFooter.vue';

defineProps({
    canLogin: {
        type: Boolean,
        default: true,
    },
});
</script>

<template>
    <div class="relative min-h-screen overflow-x-clip bg-paper bg-notebook-lines font-legible text-ink antialiased selection:bg-stabilo selection:text-ink">
        <!-- Notebook margin line -->
        <span aria-hidden="true" class="pointer-events-none absolute inset-y-0 left-16 z-0 hidden w-px bg-pen/40 sm:block"></span>

        <LandingNavbar :canLogin="canLogin" />

        <main class="relative z-10">
            <slot />
        </main>

        <LandingFooter />
    </div>
</template>
