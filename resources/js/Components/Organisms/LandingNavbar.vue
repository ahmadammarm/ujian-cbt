<script setup>
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
</script>

<template>
    <header class="fixed top-0 inset-x-0 z-50 bg-white/95 dark:bg-[#0A090B]/95 backdrop-blur-sm border-b border-slate-200 dark:border-slate-800 transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Brand Lockup -->
            <Link :href="route('dashboard')" class="flex items-center gap-3.5 group">
                <div class="w-10 h-10 bg-[#D95300] rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs transition-transform group-hover:scale-105">
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                        <path d="M4 3.5H8.2L15.8 15.3V3.5H20V20.5H15.8L8.2 8.7V20.5H4V3.5Z" />
                    </svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-xl font-extrabold tracking-tight text-[#0A090B] dark:text-white">Naiju</span>
                    <span class="text-[10px] font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Platform Ujian &amp; Asesmen Digital</span>
                </div>
            </Link>

            <!-- Navigation Destinations -->
            <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-slate-600 dark:text-slate-300">
                <a href="#keunggulan" class="hover:text-[#D95300] dark:hover:text-[#D95300] transition-colors">Keunggulan</a>
                <a href="#ruang-kerja" class="hover:text-[#D95300] dark:hover:text-[#D95300] transition-colors">Portal Guru &amp; Siswa</a>
                <a href="#keamanan" class="hover:text-[#D95300] dark:hover:text-[#D95300] transition-colors">Proteksi Ujian</a>
                <a href="#faq" class="hover:text-[#D95300] dark:hover:text-[#D95300] transition-colors">Tanya Jawab</a>
            </nav>

            <!-- Access Controls & Theme Switcher -->
            <div class="flex items-center gap-3">
                <ThemeToggle />

                <template v-if="canLogin">
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('dashboard')"
                        class="px-5 py-2.5 bg-[#0A090B] dark:bg-white text-white dark:text-[#0A090B] text-sm font-semibold rounded-xl hover:bg-slate-800 dark:hover:bg-slate-100 transition-colors shadow-xs"
                    >
                        Buka Dashboard
                    </Link>

                    <template v-else>
                        <Link
                            :href="route('login')"
                            class="px-4 py-2.5 text-sm font-semibold text-slate-700 dark:text-slate-300 hover:text-[#D95300] dark:hover:text-[#D95300] rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                        >
                            Masuk
                        </Link>

                        <Link
                            v-if="canRegister"
                            :href="route('register')"
                            class="px-5 py-2.5 bg-[#D95300] text-white text-sm font-semibold rounded-xl hover:bg-[#BF4900] transition-colors shadow-xs"
                        >
                            Daftar Peserta
                        </Link>
                    </template>
                </template>
            </div>
        </div>
    </header>
</template>
