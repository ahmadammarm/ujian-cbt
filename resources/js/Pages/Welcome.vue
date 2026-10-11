<script setup>
import { Head } from '@inertiajs/vue3';
import LandingLayout from '@/Components/Templates/LandingLayout.vue';
import LandingHero from '@/Components/Organisms/LandingHero.vue';
import LandingExamSimulator from '@/Components/Organisms/LandingExamSimulator.vue';
import LandingFeatures from '@/Components/Organisms/LandingFeatures.vue';
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
    <Head title="Platform CBT & Ujian Online Modern">
        <meta name="description" content="Naiju adalah platform ujian online CBT (Computer Based Test) terpadu untuk sekolah dan kampus. Dilengkapi proteksi anti-curang, bank soal otomatis, auto-save real-time, dan rekapitulasi nilai instan." />
        <meta name="keywords" content="aplikasi ujian online, cbt sekolah, computer based test, platform ujian cbt, bank soal ujian, aplikasi asesmen digital, ujian sekolah bebas curang, ujian online otomatis" />
        <meta property="og:title" content="Naiju - Platform CBT & Ujian Online Modern" />
        <meta property="og:description" content="Platform ujian berbasis komputer (CBT) dan asesmen digital terpercaya untuk sekolah dan universitas. Aman dari kebocoran kunci jawaban, mudah digunakan guru dan siswa." />
        <meta property="og:type" content="website" />
    </Head>

    <LandingLayout :canLogin="canLogin" :canRegister="canRegister">
        <!-- Hero Section: Problem Statement & Live Interactive Simulator -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16 lg:pb-24">
            <div class="grid lg:grid-cols-12 gap-12 lg:gap-8 items-start">
                <LandingHero class="lg:col-span-5" />
                <LandingExamSimulator class="lg:col-span-7" />
            </div>
        </section>

        <!-- Features Pillar Section -->
        <LandingFeatures />

        <!-- Dual Workspaces Showcase Section -->
        <LandingWorkspaces />

        <!-- Server-side Security Defense Section -->
        <LandingSecurity />

        <!-- FAQ Section -->
        <LandingFaq />

        <!-- Getting Started CTA Section -->
        <LandingCta :canRegister="canRegister" />
    </LandingLayout>
</template>
