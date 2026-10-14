<script setup>
const specs = [
    {
        type: 'scale',
        value: '50 Butir',
        label: 'Skala Soal Terstandarisasi',
        desc: 'Arsitektur paket soal pilihan ganda berbobot poin proporsional',
        accent: 'text-[#D95300] dark:text-orange-400',
        iconBg: 'bg-orange-50 dark:bg-orange-950/60 text-[#D95300] dark:text-orange-400 border border-orange-200 dark:border-orange-800/60',
    },
    {
        type: 'kkm',
        value: '70% KKM',
        label: 'Ambang Kelulusan Otomatis',
        desc: 'Verifikasi kelulusan instan tercetak langsung pada lembar hasil belajar',
        accent: 'text-emerald-600 dark:text-emerald-400',
        iconBg: 'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/60',
    },
    {
        type: 'debounce',
        value: '1.500 ms',
        label: 'Debounce Sensor Proctoring',
        desc: 'Filter latensi cerdas pada event blur jendela sebelum dialog peringatan',
        accent: 'text-[#1D71EF] dark:text-blue-400',
        iconBg: 'bg-blue-50 dark:bg-blue-950/60 text-[#1D71EF] dark:text-blue-400 border border-blue-200 dark:border-blue-800/60',
    },
    {
        type: 'autosave',
        value: 'Real-Time',
        label: 'Auto-Save per Opsi Klik',
        desc: 'Penyimpanan langsung ke database terisolasi saat opsi dipilih siswa',
        accent: 'text-purple-600 dark:text-purple-400',
        iconBg: 'bg-purple-50 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 border border-purple-200 dark:border-purple-800/60',
    },
];
</script>

<template>
    <section id="spesifikasi" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- System Telemetry & Operational Parameters Strip -->
        <div class="bg-white dark:bg-[#111116] rounded-3xl border border-slate-200/90 dark:border-slate-800 shadow-xl p-8 sm:p-10 lg:p-12 transition-all">
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-6 divide-y sm:divide-y-0 sm:divide-x divide-slate-100 dark:divide-slate-800">
                <div
                    v-for="(spec, idx) in specs"
                    :key="idx"
                    :class="[
                        'flex flex-col items-start space-y-2',
                        idx > 0 ? 'pt-6 sm:pt-0 sm:pl-6 lg:pl-8' : ''
                    ]"
                >
                    <div :class="['w-12 h-12 rounded-2xl flex items-center justify-center mb-1 shadow-xs', spec.iconBg]">
                        <!-- Scale icon -->
                        <svg v-if="spec.type === 'scale'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>

                        <!-- KKM icon -->
                        <svg v-else-if="spec.type === 'kkm'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>

                        <!-- Debounce icon -->
                        <svg v-else-if="spec.type === 'debounce'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>

                        <!-- Autosave icon -->
                        <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                        </svg>
                    </div>

                    <div :class="['text-3xl sm:text-4xl font-black tracking-tight font-mono', spec.accent]">
                        {{ spec.value }}
                    </div>
                    <div class="text-sm font-bold text-slate-900 dark:text-white">
                        {{ spec.label }}
                    </div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed font-normal">
                        {{ spec.desc }}
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>
