<script setup>
import { Head } from '@inertiajs/vue3';
import LandingLayout from '@/Components/Templates/LandingLayout.vue';
import LandingHero from '@/Components/Organisms/LandingHero.vue';
import LandingAnswerSheet from '@/Components/Organisms/LandingAnswerSheet.vue';
import LandingChecklist from '@/Components/Organisms/LandingChecklist.vue';
import LandingRules from '@/Components/Organisms/LandingRules.vue';
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
    <Head title="Naiju Exam · Ujian tanpa pensil 2B">
        <meta name="description" content="Naiju Exam adalah portal ujian online untuk siswa SMP dan SMA. Masuk dengan akun dari gurumu, kerjakan ulangan dari laptop, dan lihat nilaimu begitu kamu kirim jawaban." />
        <meta property="og:title" content="Naiju Exam · Ujian tanpa pensil 2B" />
        <meta property="og:description" content="Portal ujian online untuk siswa SMP dan SMA. Nilai langsung keluar setelah kamu kirim jawaban." />
        <meta property="og:type" content="website" />
    </Head>

    <LandingLayout :canLogin="canLogin">
        <section class="pb-16 pt-10 sm:pb-24 sm:pt-20">
            <div class="mx-auto grid max-w-6xl items-center gap-12 px-6 sm:pl-24 sm:pr-8 lg:grid-cols-12 lg:gap-10">
                <LandingHero class="lg:col-span-6" :canRegister="canRegister" />
                <LandingAnswerSheet class="lg:col-span-6" />
            </div>
        </section>

        <LandingChecklist />
        <LandingRules />
        <LandingFaq />
        <LandingCta />
    </LandingLayout>
</template>
