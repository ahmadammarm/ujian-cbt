<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    canRegister: {
        type: Boolean,
        default: true,
    },
});
</script>

<template>
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
        <!-- Pahamify-Style Vibrant Terracotta Rounded CTA Banner -->
        <div class="relative overflow-hidden bg-gradient-to-r from-[#B83E00] via-[#D95300] to-[#EA580C] rounded-[32px] p-8 sm:p-12 lg:p-16 shadow-2xl text-white">
            <!-- Decorative Aura Background Circles -->
            <div class="absolute -top-24 -right-24 w-80 h-80 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -left-24 w-80 h-80 rounded-full bg-amber-300/20 blur-2xl pointer-events-none"></div>

            <div class="relative z-10 max-w-2xl space-y-5">
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight leading-tight">
                    Siap Mewujudkan Ujian Sekolah yang Praktis &amp; Bebas Curang?
                </h2>

                <p class="text-sm sm:text-base text-orange-50/95 leading-relaxed font-normal">
                    Mulai selenggarakan ujian online dengan bank soal guru yang aman, koreksi nilai instan, dan proses pengerjaan yang bebas contek. Hemat kertas, hemat waktu, dan hasil belajar terukur akurat.
                </p>

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3.5 pt-3">
                    <a
                        href="#simulasi"
                        class="px-8 py-4 bg-[#0A090B] hover:bg-black text-white text-sm font-black uppercase tracking-wider rounded-full text-center shadow-2xl shadow-black/40 hover:scale-105 active:scale-95 transition-all cursor-pointer"
                    >
                        Coba Simulasi CBT Sekarang
                    </a>

                    <Link
                        v-if="!$page.props.auth.user"
                        :href="route('login')"
                        class="px-6 py-4 bg-white/15 hover:bg-white/25 text-white font-bold text-sm rounded-full border border-white/30 backdrop-blur-sm text-center transition-all"
                    >
                        Masuk ke Portal Ujian
                    </Link>

                    <Link
                        v-else
                        :href="route('dashboard')"
                        class="px-6 py-4 bg-white text-[#D95300] hover:bg-orange-50 font-bold text-sm rounded-full text-center shadow-md transition-all"
                    >
                        Buka Dashboard
                    </Link>
                </div>
            </div>
        </div>
    </section>
</template>
