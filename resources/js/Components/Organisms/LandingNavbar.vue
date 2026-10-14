<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import ThemeToggle from '@/Components/Atoms/ThemeToggle.vue';

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

const isMobileMenuOpen = ref(false);
</script>

<template>
    <header class="fixed top-0 inset-x-0 z-50 bg-[#0A090B]/95 dark:bg-[#070709]/95 backdrop-blur-md border-b border-white/10 dark:border-slate-800 transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Brand Lockup -->
            <Link :href="route('dashboard')" class="flex items-center gap-3.5 group">
                <div class="w-10 h-10 bg-[#D95300] text-white rounded-xl flex items-center justify-center shrink-0 shadow-sm transition-transform group-hover:scale-105">
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                        <path d="M4 3.5H8.2L15.8 15.3V3.5H20V20.5H15.8L8.2 8.7V20.5H4V3.5Z" />
                    </svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-xl font-black tracking-tight text-white">Naiju</span>
                    <span class="text-[10px] font-bold text-orange-200/90 dark:text-slate-400 uppercase tracking-wider">Platform CBT &amp; Asesmen</span>
                </div>
            </Link>

            <!-- Desktop Navigation Destinations (Pahamify Style) -->
            <nav class="hidden lg:flex items-center gap-7 text-sm font-semibold text-white/90">
                <a href="#keunggulan" class="hover:text-[#FF8A4C] transition-colors">Keunggulan</a>
                <a href="#spesifikasi" class="hover:text-[#FF8A4C] transition-colors">Spesifikasi</a>
                <a href="#alur-kerja" class="hover:text-[#FF8A4C] transition-colors">Alur Ujian</a>
                <a href="#pilar" class="hover:text-[#FF8A4C] transition-colors">Ruang Kerja</a>
                <a href="#keamanan" class="hover:text-[#FF8A4C] transition-colors">Keamanan</a>
                <a href="#faq" class="hover:text-[#FF8A4C] transition-colors">Tanya Jawab</a>
            </nav>

            <!-- Access Controls & Theme Switcher -->
            <div class="hidden sm:flex items-center gap-3">
                <ThemeToggle class="text-white" />

                <template v-if="canLogin">
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('dashboard')"
                        class="px-5 py-2.5 bg-[#D95300] hover:bg-[#BF4900] text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-sm transition-all hover:scale-105"
                    >
                        Buka Dashboard
                    </Link>

                    <template v-else>
                        <Link
                            :href="route('login')"
                            class="px-5 py-2 text-xs font-bold text-white hover:text-white border border-white/20 hover:bg-white/10 rounded-full transition-all"
                        >
                            Masuk
                        </Link>

                        <a
                            href="#simulasi"
                            class="px-5 py-2 bg-[#D95300] hover:bg-[#BF4900] text-white text-xs font-extrabold uppercase tracking-wider rounded-full shadow-md shadow-orange-950/30 hover:scale-105 transition-all"
                        >
                            Coba Simulasi
                        </a>
                    </template>
                </template>
            </div>

            <!-- Mobile Hamburger Button -->
            <div class="flex items-center gap-2 lg:hidden">
                <ThemeToggle class="text-white" />
                <button
                    type="button"
                    @click="isMobileMenuOpen = !isMobileMenuOpen"
                    class="p-2 rounded-xl text-white hover:bg-white/15 focus:outline-none transition-colors"
                    aria-label="Toggle Navigation Menu"
                >
                    <svg v-if="!isMobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Drawer Navigation -->
        <div
            v-if="isMobileMenuOpen"
            class="lg:hidden bg-[#0A090B] dark:bg-[#070709] border-b border-white/10 dark:border-slate-800 px-6 py-6 space-y-4 animate-slide-up"
        >
            <nav class="flex flex-col space-y-3 text-sm font-semibold text-white/90">
                <a @click="isMobileMenuOpen = false" href="#keunggulan" class="hover:text-[#FF8A4C] py-1">Keunggulan</a>
                <a @click="isMobileMenuOpen = false" href="#spesifikasi" class="hover:text-[#FF8A4C] py-1">Spesifikasi</a>
                <a @click="isMobileMenuOpen = false" href="#alur-kerja" class="hover:text-[#FF8A4C] py-1">Alur Ujian</a>
                <a @click="isMobileMenuOpen = false" href="#pilar" class="hover:text-[#FF8A4C] py-1">Ruang Kerja</a>
                <a @click="isMobileMenuOpen = false" href="#keamanan" class="hover:text-[#FF8A4C] py-1">Keamanan</a>
                <a @click="isMobileMenuOpen = false" href="#faq" class="hover:text-[#FF8A4C] py-1">Tanya Jawab</a>
            </nav>

            <div class="pt-4 border-t border-white/10 dark:border-slate-800 flex flex-col gap-3">
                <template v-if="canLogin">
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('dashboard')"
                        class="w-full text-center py-3 bg-[#D95300] text-white font-bold text-xs uppercase tracking-wider rounded-full shadow-sm"
                    >
                        Buka Dashboard
                    </Link>
                    <template v-else>
                        <Link
                            :href="route('login')"
                            class="w-full text-center py-2.5 border border-white/30 text-white font-bold text-sm rounded-full"
                        >
                            Masuk
                        </Link>
                        <a
                            href="#simulasi"
                            @click="isMobileMenuOpen = false"
                            class="w-full text-center py-2.5 bg-[#D95300] text-white font-bold text-sm rounded-full shadow-md"
                        >
                            Coba Simulasi CBT
                        </a>
                    </template>
                </template>
            </div>
        </div>
    </header>
</template>
