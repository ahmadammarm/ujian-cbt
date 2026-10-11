<script setup>
import LandingNavbar from '@/Components/Organisms/LandingNavbar.vue';
import LandingFooter from '@/Components/Organisms/LandingFooter.vue';

defineProps({
    canLogin: {
        type: Boolean,
        default: true,
    },
    canRegister: {
        type: Boolean,
        default: true,
    },
});
</script>

<template>
    <div class="min-h-screen bg-[#F8FAFC] dark:bg-[#09090B] text-[#0A090B] dark:text-slate-100 font-poppins antialiased selection:bg-[#D95300] selection:text-white transition-colors">
        <!-- Navigation Header -->
        <LandingNavbar :canLogin="canLogin" :canRegister="canRegister" />

        <!-- Main Content Slot -->
        <main class="pt-28 lg:pt-36">
            <slot />
        </main>

        <!-- Institutional Footer -->
        <LandingFooter />
    </div>
</template>
