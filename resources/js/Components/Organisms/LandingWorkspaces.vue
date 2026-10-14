<script setup>
const pillars = [
    {
        title: 'Naiju Studio',
        subtitle: 'Ruang Kerja Guru & Dosen',
        badge: 'PORTAL PENGAJAR',
        theme: 'orange',
        colorClass: 'text-[#D95300] dark:text-orange-400',
        badgeClass: 'bg-orange-50 dark:bg-orange-950/60 text-[#D95300] dark:text-orange-400 border-orange-200 dark:border-orange-800/60',
        borderHover: 'hover:border-orange-400 dark:hover:border-orange-600/60',
        iconBg: 'bg-orange-100 dark:bg-orange-950/60 text-[#D95300] dark:text-orange-400',
        summary: 'Pusat kendali penyusunan paket ujian dan pengelolaan peserta sekolah.',
        features: [
            'Bank soal dinamis dengan editor pilihan ganda fleksibel',
            'Pendaftaran dan pencabutan peserta ujian per kelas mandiri',
            'Kunci jawaban diamankan di server tanpa kebocoran payload',
            'Statistik analitik kelas dan pemantauan status siswa aktif',
        ],
    },
    {
        title: 'Naiju Exam',
        subtitle: 'Portal Siswa Terproteksi',
        badge: 'PORTAL SISWA',
        theme: 'blue',
        colorClass: 'text-[#1D71EF] dark:text-blue-400',
        badgeClass: 'bg-blue-50 dark:bg-blue-950/60 text-[#1D71EF] dark:text-blue-400 border-blue-200 dark:border-blue-800/60',
        borderHover: 'hover:border-blue-400 dark:hover:border-blue-600/60',
        iconBg: 'bg-blue-100 dark:bg-blue-950/60 text-[#1D71EF] dark:text-blue-400',
        summary: 'Antarmuka pengerjaan ujian terisolasi dengan anti-cheat proctoring.',
        features: [
            'Prasyarat layar penuh wajib (Fullscreen Lock) sebelum mulai',
            'Deteksi perpindahan tab & window blur dengan toleransi 3x',
            'Penyimpanan otomatis (Auto-save) real-time di setiap klik opsi',
            'Blokir Inspect Element (F12), tombol pintas contek, dan klik kanan',
        ],
    },
    {
        title: 'Smart Analytics',
        subtitle: 'Mesin Evaluasi & Kelulusan',
        badge: 'RAPOR OTOMATIS',
        theme: 'emerald',
        colorClass: 'text-emerald-600 dark:text-emerald-400',
        badgeClass: 'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 border-emerald-200 dark:border-emerald-800/60',
        borderHover: 'hover:border-emerald-400 dark:hover:border-emerald-600/60',
        iconBg: 'bg-emerald-100 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400',
        summary: 'Penilaian instan dan evaluasi rapor hasil belajar tanpa koreksi manual.',
        features: [
            'Perhitungan skor otomatis skala 50 dan persentase kelulusan',
            'Standar ambang KKM 70% otomatis tercantum pada rapor hasil',
            'Audit trail durasi pengerjaan serta log riwayat pelanggaran',
            'Rekapitulasi nilai terstruktur siap ekspor untuk arsip sekolah',
        ],
    },
];
</script>

<template>
    <section id="pilar" class="py-16 sm:py-24 bg-white dark:bg-[#0A090B] transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Center Header -->
            <div class="text-center max-w-3xl mx-auto mb-14 space-y-3">
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-[#0A090B] dark:text-white tracking-tight">
                    3 Ruang Kerja Terpadu Platform CBT
                </h2>
                <p class="text-sm sm:text-base text-slate-600 dark:text-slate-400 font-normal leading-relaxed">
                    Pemisahan peran terisolasi antara portal penyusunan guru, lingkungan ujian terproteksi siswa, dan mesin analitik evaluasi nilai.
                </p>
            </div>

            <!-- 3-Column Profile-Style Cards (Pahamify Layout) -->
            <div class="grid md:grid-cols-3 gap-6 sm:gap-8">
                <div
                    v-for="(pilar, idx) in pillars"
                    :key="idx"
                    :class="[
                        'bg-slate-50/80 dark:bg-[#111116] rounded-3xl p-7 sm:p-8 border border-slate-200/90 dark:border-slate-800 shadow-md flex flex-col justify-between transition-all group',
                        pilar.borderHover
                    ]"
                >
                    <div class="space-y-5">
                        <!-- Top Header with Badge -->
                        <div class="flex items-center justify-between">
                            <span :class="['text-[11px] font-black uppercase tracking-wider px-3 py-1 rounded-full border', pilar.badgeClass]">
                                {{ pilar.badge }}
                            </span>
                            <div :class="['w-10 h-10 rounded-xl flex items-center justify-center font-bold text-sm shrink-0', pilar.iconBg]">
                                <svg v-if="pilar.theme === 'orange'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                <svg v-else-if="pilar.theme === 'blue'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                        </div>

                        <!-- Pillar Title & Subtitle -->
                        <div>
                            <h3 :class="['text-2xl font-black tracking-tight leading-tight', pilar.colorClass]">
                                {{ pilar.title }}
                            </h3>
                            <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 block mt-0.5">
                                {{ pilar.subtitle }}
                            </span>
                        </div>

                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed font-normal">
                            {{ pilar.summary }}
                        </p>

                        <!-- Feature Checklist Bullets (Pahamify Profile Bullet Style) -->
                        <div class="pt-4 border-t border-slate-200/80 dark:border-slate-800 space-y-2.5">
                            <div
                                v-for="(feat, fIdx) in pilar.features"
                                :key="fIdx"
                                class="flex items-start gap-2.5 text-xs text-slate-700 dark:text-slate-300 leading-normal"
                            >
                                <div class="w-1.5 h-1.5 rounded-full bg-[#D95300] dark:bg-orange-400 shrink-0 mt-1.5"></div>
                                <span>{{ feat }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
