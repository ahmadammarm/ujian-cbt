<script setup>
</script>

<template>
    <section id="keunggulan" class="py-16 sm:py-24 bg-white dark:bg-[#0A090B] transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Institutional Section Header -->
            <div class="max-w-3xl mb-12 sm:mb-16 space-y-3">
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-[#0A090B] dark:text-white tracking-tight">
                    Keunggulan Arsitektur Sistem CBT Naiju
                </h2>
                <p class="text-sm sm:text-base text-slate-600 dark:text-slate-400 font-normal leading-relaxed">
                    Dirancang khusus untuk kehandalan ujian sekolah dan madrasah dengan proctoring berlapis, integritas kunci jawaban di sisi server, dan rekapitulasi nilai otomatis.
                </p>
            </div>

            <!-- Asymmetric Bento Grid (Human-Crafted Layout) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-7">
                <!-- Bento Card 1: Wide Card (Span 2) - Fullscreen & Proctoring -->
                <div class="md:col-span-2 bg-slate-50 dark:bg-[#111116] rounded-3xl p-7 sm:p-9 border border-slate-200/90 dark:border-slate-800/90 flex flex-col justify-between hover:border-slate-300 dark:hover:border-slate-700 transition-all">
                    <div class="space-y-4 max-w-xl">
                        <div class="w-12 h-12 rounded-2xl bg-orange-100 dark:bg-orange-950/60 text-[#D95300] dark:text-orange-400 flex items-center justify-center font-bold">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <h3 class="text-xl sm:text-2xl font-bold text-slate-900 dark:text-white tracking-tight">
                            Proteksi Layar Penuh &amp; Deteksi Perpindahan Tab
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed font-normal">
                            Sistem mewajibkan siswa mengaktifkan mode Fullscreen sebelum soal ditampilkan. Sensor proctoring memantau event <code>visibilitychange</code> dan <code>window.blur</code> secara real-time. Jika siswa mencoba berpindah jendela atau membuka aplikasi contek, sistem memberikan dialog peringatan terkunci hingga batas toleransi 3 kali sebelum penutupan otomatis.
                        </p>
                    </div>

                    <!-- Mini UI Visual: Proctoring Telemetry Strip -->
                    <div class="mt-8 pt-6 border-t border-slate-200/80 dark:border-slate-800 grid sm:grid-cols-3 gap-3 font-mono text-xs">
                        <div class="p-3 rounded-xl bg-white dark:bg-slate-900/90 border border-slate-200 dark:border-slate-800 space-y-1">
                            <span class="text-[10px] text-slate-500 uppercase tracking-wider block font-sans font-semibold">Mode Layar</span>
                            <span class="text-emerald-600 dark:text-emerald-400 font-bold flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                Fullscreen Lock
                            </span>
                        </div>
                        <div class="p-3 rounded-xl bg-white dark:bg-slate-900/90 border border-slate-200 dark:border-slate-800 space-y-1">
                            <span class="text-[10px] text-slate-500 uppercase tracking-wider block font-sans font-semibold">Sensor Tab</span>
                            <span class="text-blue-600 dark:text-blue-400 font-bold">Cooldown 1500ms</span>
                        </div>
                        <div class="p-3 rounded-xl bg-white dark:bg-slate-900/90 border border-slate-200 dark:border-slate-800 space-y-1">
                            <span class="text-[10px] text-slate-500 uppercase tracking-wider block font-sans font-semibold">Toleransi</span>
                            <span class="text-amber-600 dark:text-amber-400 font-bold">Maks. 3 Peringatan</span>
                        </div>
                    </div>
                </div>

                <!-- Bento Card 2: 1 Col - Server-Side Answer Key Security -->
                <div class="bg-slate-50 dark:bg-[#111116] rounded-3xl p-7 sm:p-9 border border-slate-200/90 dark:border-slate-800/90 flex flex-col justify-between hover:border-slate-300 dark:hover:border-slate-700 transition-all">
                    <div class="space-y-4">
                        <div class="w-12 h-12 rounded-2xl bg-blue-100 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight">
                            Kunci Jawaban Aman di Server
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed font-normal">
                            Payload soal yang dikirim ke browser siswa memfilter kunci jawaban secara total. Tidak ada atribut <code>is_correct</code> yang dapat diintip melalui Inspect Element (F12) browser.
                        </p>
                    </div>

                    <!-- Mini UI Code Chip -->
                    <div class="mt-6 p-3 rounded-xl bg-[#0A090B] text-slate-300 font-mono text-[11px] border border-slate-800">
                        <div class="text-slate-500">// Payload browser siswa:</div>
                        <div>options: [{ id: "A", text: "..." }]</div>
                        <div class="text-emerald-400 mt-1">// Tanpa kunci jawaban</div>
                    </div>
                </div>

                <!-- Bento Card 3: 1 Col - Auto-Save Real-Time -->
                <div class="bg-slate-50 dark:bg-[#111116] rounded-3xl p-7 sm:p-9 border border-slate-200/90 dark:border-slate-800/90 flex flex-col justify-between hover:border-slate-300 dark:hover:border-slate-700 transition-all">
                    <div class="space-y-4">
                        <div class="w-12 h-12 rounded-2xl bg-amber-100 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center font-bold">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight">
                            Penyimpanan Tiap Klik Pilihan
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed font-normal">
                            Sistem mencatat jawaban per butir soal seketika siswa memilih opsi. Jika komputer lab mati mendadak atau sambungan Wi-Fi terputus, sesi ujian dapat dilanjutkan tanpa kehilangan data jawaban.
                        </p>
                    </div>

                    <!-- Mini Status Pill -->
                    <div class="mt-6 flex items-center gap-2 p-3 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-xs font-mono">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span class="text-slate-700 dark:text-slate-300">Auto-save terkonfirmasi aktif</span>
                    </div>
                </div>

                <!-- Bento Card 4: Wide Card (Span 2) - Auto Grading & KKM 70% -->
                <div class="md:col-span-2 bg-slate-50 dark:bg-[#111116] rounded-3xl p-7 sm:p-9 border border-slate-200/90 dark:border-slate-800/90 flex flex-col justify-between hover:border-slate-300 dark:hover:border-slate-700 transition-all">
                    <div class="space-y-4 max-w-xl">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-100 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-bold">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl sm:text-2xl font-bold text-slate-900 dark:text-white tracking-tight">
                            Koreksi Nilai Otomatis &amp; Rapor Standar KKM 70%
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed font-normal">
                            Setelah siswa menyelesaikan ujian, sistem mengeksekusi koreksi otomatis di dalam database transaction yang atomik. Skor dihitung berdasarkan skala 50 poin dengan kalkulasi status kelulusan KKM yang terverifikasi, mengeliminasi proses koreksi lembar kertas manual.
                        </p>
                    </div>

                    <!-- Mini Score Breakdown Visual -->
                    <div class="mt-8 pt-6 border-t border-slate-200/80 dark:border-slate-800 flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white font-mono">
                                86.0 <span class="text-xs text-slate-500 font-sans font-normal">/ 100</span>
                            </div>
                            <span class="px-3 py-1 rounded-full bg-emerald-100 dark:bg-emerald-950/70 text-emerald-700 dark:text-emerald-400 text-xs font-bold font-mono border border-emerald-300 dark:border-emerald-800">
                                LULUS KKM (AMBANG &ge; 70%)
                            </span>
                        </div>
                        <div class="text-xs text-slate-500 dark:text-slate-400 font-mono">
                            43 Benar · 7 Salah · Durasi: 38 Menit
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
