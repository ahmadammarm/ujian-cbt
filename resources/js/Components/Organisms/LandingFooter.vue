<script setup>
import { Link } from '@inertiajs/vue3';

const currentYear = new Date().getFullYear();
</script>

<template>
    <footer class="bg-[#0A090B] dark:bg-[#070709] text-white pt-16 pb-12 border-t border-white/10 dark:border-slate-800 transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            <!-- Pahamify Multi-Column Grid Layout -->
            <div class="grid grid-cols-2 md:grid-cols-12 gap-8 lg:gap-12">
                <!-- Col 1: Brand & Version Buttons (Pahamify Style) -->
                <div class="col-span-2 md:col-span-4 space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-[#D95300] text-white rounded-xl flex items-center justify-center font-black text-xl shadow-md shrink-0">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                <path d="M4 3.5H8.2L15.8 15.3V3.5H20V20.5H15.8L8.2 8.7V20.5H4V3.5Z" />
                            </svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-2xl font-black tracking-tight text-white">Naiju</span>
                            <span class="text-[10px] font-bold text-orange-200/90 dark:text-slate-400 uppercase tracking-wider">Platform CBT &amp; Asesmen Digital</span>
                        </div>
                    </div>

                    <p class="text-xs text-slate-400 leading-relaxed font-normal">
                        Platform ujian berbasis komputer (CBT) modern untuk sekolah, madrasah, dan kampus. Aman dari kebocoran kunci jawaban, hemat kertas, dan dilengkapi sistem proctoring anti-contek.
                    </p>

                    <!-- Web & Mobile Version Access Badges -->
                    <div class="space-y-2 pt-1">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">
                            Akses Web Portal:
                        </span>
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-slate-900 border border-slate-800 text-xs font-bold text-slate-200 hover:border-slate-700 transition-all cursor-pointer">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                            </svg>
                            <span>Web App Naiju CBT</span>
                        </div>
                    </div>
                </div>

                <!-- Col 2: Perusahaan -->
                <div class="col-span-1 md:col-span-2 space-y-3">
                    <h4 class="text-xs font-black uppercase tracking-wider text-[#FF8A4C] dark:text-orange-400">
                        Platform
                    </h4>
                    <ul class="space-y-2 text-xs text-slate-400 font-medium">
                        <li><a href="#keunggulan" class="hover:text-white transition-colors">Keunggulan CBT</a></li>
                        <li><a href="#spesifikasi" class="hover:text-white transition-colors">Spesifikasi Sistem</a></li>
                        <li><a href="#alur-kerja" class="hover:text-white transition-colors">Alur Ujian Sekolah</a></li>
                        <li><a href="#pilar" class="hover:text-white transition-colors">3 Ruang Kerja</a></li>
                    </ul>
                </div>

                <!-- Col 3: Panduan -->
                <div class="col-span-1 md:col-span-2 space-y-3">
                    <h4 class="text-xs font-black uppercase tracking-wider text-[#FF8A4C] dark:text-orange-400">
                        Panduan
                    </h4>
                    <ul class="space-y-2 text-xs text-slate-400 font-medium">
                        <li><a href="#simulasi" class="hover:text-white transition-colors">Simulasi CBT Siswa</a></li>
                        <li><a href="#pilar" class="hover:text-white transition-colors">Naiju Studio Guru</a></li>
                        <li><a href="#keamanan" class="hover:text-white transition-colors">Sistem Proctoring</a></li>
                        <li><a href="#faq" class="hover:text-white transition-colors">Tanya Jawab &amp; Bantuan</a></li>
                    </ul>
                </div>

                <!-- Col 4: Kebijakan & Privasi -->
                <div class="col-span-1 md:col-span-2 space-y-3">
                    <h4 class="text-xs font-black uppercase tracking-wider text-[#FF8A4C] dark:text-orange-400">
                        Hak Cipta
                    </h4>
                    <ul class="space-y-2 text-xs text-slate-400 font-medium">
                        <li><a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Syarat &amp; Ketentuan</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Keamanan Data Nilai</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Lisensi Sekolah</a></li>
                    </ul>
                </div>

                <!-- Col 5: Kontak & Bantuan -->
                <div class="col-span-1 md:col-span-2 space-y-3">
                    <h4 class="text-xs font-black uppercase tracking-wider text-[#FF8A4C] dark:text-orange-400">
                        Kontak Kami
                    </h4>
                    <ul class="space-y-2.5 text-xs text-slate-400 font-medium">
                        <li class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            <span>WhatsApp CS</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span>cs@naijucbt.id</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>Indonesia</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Copyright Divider -->
            <div class="pt-8 border-t border-white/10 dark:border-slate-800/80 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500 font-medium">
                <div>
                    &copy; {{ currentYear }} Naiju CBT. Hak cipta dilindungi.
                </div>
                <div class="flex items-center gap-4 text-[11px]">
                    <span class="text-orange-400 font-semibold">Naiju CBT Platform</span>
                    <span>·</span>
                    <span>Sistem Ujian &amp; Asesmen Digital</span>
                </div>
            </div>
        </div>
    </footer>
</template>
