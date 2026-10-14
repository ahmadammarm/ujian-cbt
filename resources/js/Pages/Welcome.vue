<script setup>
import { Head } from '@inertiajs/vue3';
import LandingLayout from '@/Components/Templates/LandingLayout.vue';
import LandingHero from '@/Components/Organisms/LandingHero.vue';
import LandingExamSimulator from '@/Components/Organisms/LandingExamSimulator.vue';
import LandingFeatures from '@/Components/Organisms/LandingFeatures.vue';
import LandingStats from '@/Components/Organisms/LandingStats.vue';
import LandingTestimonials from '@/Components/Organisms/LandingTestimonials.vue';
import LandingWorkspaces from '@/Components/Organisms/LandingWorkspaces.vue';
import LandingSecurity from '@/Components/Organisms/LandingSecurity.vue';
import LandingFaq from '@/Components/Organisms/LandingFaq.vue';
import LandingCta from '@/Components/Organisms/LandingCta.vue';

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
    <Head title="Naiju CBT - Platform Ujian & Asesmen Digital Bebas Bocor">
        <meta name="description" content="Naiju adalah platform ujian online CBT (Computer Based Test) terpadu untuk sekolah dan kampus. Dilengkapi proteksi anti-curang, bank soal otomatis, auto-save real-time, dan rekapitulasi nilai instan." />
        <meta name="keywords" content="aplikasi ujian online, cbt sekolah, computer based test, platform ujian cbt, bank soal ujian, aplikasi asesmen digital, ujian sekolah bebas curang, ujian online otomatis" />
        <meta property="og:title" content="Naiju CBT - Platform Ujian & Asesmen Digital Bebas Bocor" />
        <meta property="og:description" content="Platform ujian berbasis komputer (CBT) dan asesmen digital terpercaya untuk sekolah dan universitas. Aman dari kebocoran kunci jawaban, mudah digunakan guru dan siswa." />
        <meta property="og:type" content="website" />
    </Head>

    <LandingLayout :canLogin="canLogin" :canRegister="canRegister">
        <!-- Hero Section with Pahamify-Style Vibrant Terracotta Gradient & Cloud Wave Bottom -->
        <div class="relative bg-gradient-to-b from-[#B83E00] via-[#D95300] to-[#EA580C] pt-28 sm:pt-32 lg:pt-36 overflow-hidden">
            <!-- Ambient Light Flares -->
            <div class="absolute top-10 left-1/4 w-96 h-96 rounded-full bg-white/10 blur-3xl pointer-events-none"></div>
            <div class="absolute top-40 right-10 w-96 h-96 rounded-full bg-amber-300/20 blur-3xl pointer-events-none"></div>

            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12 sm:pb-20 relative z-10">
                <div class="grid lg:grid-cols-12 gap-10 lg:gap-8 items-center">
                    <LandingHero class="lg:col-span-5" />
                    <LandingExamSimulator class="lg:col-span-7" />
                </div>
            </section>

            <!-- Pahamify-Style Organic Cloud Shape Divider at Bottom of Hero -->
            <div class="relative w-full overflow-hidden leading-none z-10 -mb-1">
                <svg
                    class="relative block w-full h-12 sm:h-20 lg:h-28 text-white dark:text-[#0A090B] fill-current"
                    viewBox="0 0 1440 180"
                    preserveAspectRatio="none"
                >
                    <path d="M0,64L48,80C96,96,192,128,288,128C384,128,480,96,576,90.7C672,85,768,107,864,117.3C960,128,1056,128,1152,112C1248,96,1344,64,1392,48L1440,32L1440,180L1392,180C1344,180,1248,180,1152,180C1056,180,960,180,864,180C768,180,672,180,576,180C480,180,384,180,288,180C192,180,96,180,48,180L0,180Z"></path>
                </svg>
            </div>
        </div>

        <!-- Section 1: Asymmetric Bento Grid (4 Core System Capabilities) -->
        <LandingFeatures />

        <!-- Section 2: System Specifications & Telemetry Strip -->
        <LandingStats />

        <!-- Section 3: 3-Stage School Exam Workflow & Device Compatibility -->
        <LandingTestimonials />

        <!-- Section 4: 3 Dedicated Workspaces (Pahamify-Style Cards) -->
        <LandingWorkspaces />

        <!-- Section 5: Server-side Security Defense (Payload Diff Comparison) -->
        <LandingSecurity />

        <!-- Section 6: FAQ & Technical Specifications -->
        <LandingFaq />

        <!-- Section 7: Vibrant Terracotta CTA Banner with Obsidian Black Pill Button -->
        <LandingCta :canRegister="canRegister" />
    </LandingLayout>
</template>
