<script setup>
const currentYear = new Date().getFullYear();
</script>

<template>
    <footer class="bg-white dark:bg-[#0A090B] border-t border-slate-200 dark:border-slate-800 py-12 transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <!-- Brand Identifier -->
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-[#D95300] rounded-lg flex items-center justify-center text-white shrink-0">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path d="M4 3.5H8.2L15.8 15.3V3.5H20V20.5H15.8L8.2 8.7V20.5H4V3.5Z" />
                        </svg>
                    </div>
                    <span class="font-extrabold text-base tracking-tight text-[#0A090B] dark:text-white">Naiju</span>
                    <span class="text-xs text-slate-500 dark:text-slate-400 pl-3 border-l border-slate-200 dark:border-slate-800">Aplikasi Ujian Online &amp; CBT Sekolah</span>
                </div>

                <!-- Navigation Jump Links -->
                <div class="flex flex-wrap items-center gap-6 text-xs font-semibold text-slate-600 dark:text-slate-300">
                    <a href="#simulasi" class="hover:text-[#D95300] dark:hover:text-[#D95300] transition-colors">Simulasi Ujian</a>
                    <a href="#keunggulan" class="hover:text-[#D95300] dark:hover:text-[#D95300] transition-colors">Keunggulan CBT</a>
                    <a href="#ruang-kerja" class="hover:text-[#D95300] dark:hover:text-[#D95300] transition-colors">Portal Guru &amp; Siswa</a>
                    <a href="#keamanan" class="hover:text-[#D95300] dark:hover:text-[#D95300] transition-colors">Anti-Curang</a>
                    <a href="#faq" class="hover:text-[#D95300] dark:hover:text-[#D95300] transition-colors">Tanya Jawab</a>
                </div>

                <!-- Copyright Notice -->
                <div class="text-xs text-slate-500 dark:text-slate-400 font-medium">
                    &copy; {{ currentYear }} Naiju. Hak Cipta Dilindungi.
                </div>
            </div>
        </div>
    </footer>
</template>
