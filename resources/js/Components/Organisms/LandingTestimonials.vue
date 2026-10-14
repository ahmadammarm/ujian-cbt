<script setup>
const steps = [
    {
        num: '01',
        phase: 'Persiapan & Pengaturan',
        title: 'Penyusunan Paket Ujian di Naiju Studio',
        desc: 'Pengajar mengunggah bank soal pilihan ganda, mengatur batas waktu hitung mundur, menetapkan ambang KKM 70%, dan mendaftarkan kelas peserta tanpa perlu mencetak lembar kertas.',
        details: ['Editor soal fleksibel', 'Pengaturan bobot poin per soal', 'Daftar hadir siswa per kelas'],
        accent: 'border-l-4 border-orange-500',
    },
    {
        num: '02',
        phase: 'Pelaksanaan Terproteksi',
        title: 'Pengerjaan Ujian di Naiju Exam',
        desc: 'Siswa masuk menggunakan akun terdaftar, mengaktifkan prasyarat layar penuh (fullscreen lock), dan menjawab soal dengan auto-save real-time serta pengawasan sensor tab otomatis.',
        details: ['Wajib layar penuh sebelum mulai', 'Deteksi jendela & tab switch', 'Auto-save real-time per klik'],
        accent: 'border-l-4 border-blue-500',
    },
    {
        num: '03',
        phase: 'Evaluasi & Rapor',
        title: 'Koreksi Instan & Rekapitulasi Nilai',
        desc: 'Sistem langsung mengeksekusi penilaian atomik seketika siswa mengumpulkan ujian. Lembar hasil belajar, status kelulusan KKM, dan log integritas langsung siap diunduh.',
        details: ['Koreksi skor skala 50 poin', 'Status KKM 70% otomatis', 'Audit durasi & riwayat pelanggaran'],
        accent: 'border-l-4 border-emerald-500',
    },
];

const devices = [
    {
        name: 'Komputer Lab Sekolah',
        os: 'Windows 10/11 & Linux Ubuntu',
        note: 'Ideal untuk ujian serentak berbasis LAN atau internet sekolah',
    },
    {
        name: 'Chromebook Sekolah',
        os: 'ChromeOS & Browser Chromium',
        note: 'Dukungan penuh fullscreen lock dan deteksi tab browser',
    },
    {
        name: 'Tablet Edukasi',
        os: 'iPadOS & Android Tablet',
        note: 'Antarmuka responsif dan nyaman untuk pengerjaan layar sentuh',
    },
    {
        name: 'Smartphone Siswa',
        os: 'Android & iOS Mobile Web',
        note: 'Hemat kuota data dan dapat diakses tanpa unduh aplikasi tambahan',
    },
];
</script>

<template>
    <section id="alur-kerja" class="py-16 sm:py-24 bg-slate-50/70 dark:bg-[#0E0E12] border-y border-slate-200/80 dark:border-slate-800 transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
            <!-- Section Header -->
            <div class="max-w-3xl space-y-3">
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-[#0A090B] dark:text-white tracking-tight">
                    Alur 3 Tahap Penyelenggaraan Ujian Sekolah
                </h2>
                <p class="text-sm sm:text-base text-slate-600 dark:text-slate-400 font-normal leading-relaxed">
                    Dari penyusunan bank soal hingga distribusi nilai akhir, seluruh proses berjalan dalam satu sistem terintegrasi yang hemat waktu dan bebas dari manipulasi kertas.
                </p>
            </div>

            <!-- Workflow 3 Steps Grid -->
            <div class="grid md:grid-cols-3 gap-6 sm:gap-8">
                <div
                    v-for="step in steps"
                    :key="step.num"
                    :class="[
                        'bg-white dark:bg-[#111116] rounded-3xl p-7 sm:p-8 border border-slate-200 dark:border-slate-800 shadow-xs flex flex-col justify-between hover:shadow-md transition-all',
                        step.accent
                    ]"
                >
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-2xl font-black text-slate-400 dark:text-slate-600 font-mono">
                                {{ step.num }}
                            </span>
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-900 px-3 py-1 rounded-full">
                                {{ step.phase }}
                            </span>
                        </div>

                        <h3 class="text-lg font-bold text-slate-900 dark:text-white leading-snug">
                            {{ step.title }}
                        </h3>

                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed font-normal">
                            {{ step.desc }}
                        </p>
                    </div>

                    <div class="pt-5 mt-5 border-t border-slate-100 dark:border-slate-800/80 space-y-2">
                        <div
                            v-for="(detail, dIdx) in step.details"
                            :key="dIdx"
                            class="flex items-center gap-2 text-xs text-slate-700 dark:text-slate-300 font-medium"
                        >
                            <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>{{ detail }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Device Compatibility Sub-Section -->
            <div class="pt-6">
                <div class="p-7 sm:p-9 bg-white dark:bg-[#111116] rounded-3xl border border-slate-200/90 dark:border-slate-800/90 shadow-xs space-y-6">
                    <div class="max-w-2xl space-y-2">
                        <h3 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white">
                            Kompatibilitas Perangkat Laboratorium &amp; Personal Siswa
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                            Naiju CBT berjalan sepenuhnya melalui browser modern (Web-Based Client) tanpa perlu instalasi aplikasi khusus, mempermudah tim IT sekolah dalam persiapan teknis.
                        </p>
                    </div>

                    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 pt-2">
                        <div
                            v-for="(dev, idx) in devices"
                            :key="idx"
                            class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200/80 dark:border-slate-800 space-y-1.5"
                        >
                            <div class="text-sm font-bold text-slate-900 dark:text-white">
                                {{ dev.name }}
                            </div>
                            <div class="text-xs font-mono text-orange-600 dark:text-orange-400">
                                {{ dev.os }}
                            </div>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 leading-relaxed">
                                {{ dev.note }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
