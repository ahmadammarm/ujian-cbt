<script setup>
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';

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

// Interactive state for the live mockup
const activeQuestionTab = ref('teacher');
const selectedAnswer = ref('B');
const isFlagged = ref(false);
const activeQuestionNumber = ref(14);

const mockQuestions = [
    { num: 1, status: 'done' },
    { num: 2, status: 'done' },
    { num: 3, status: 'done' },
    { num: 4, status: 'done' },
    { num: 5, status: 'done' },
    { num: 6, status: 'done' },
    { num: 7, status: 'done' },
    { num: 8, status: 'done' },
    { num: 9, status: 'done' },
    { num: 10, status: 'done' },
    { num: 11, status: 'done' },
    { num: 12, status: 'done' },
    { num: 13, status: 'done' },
    { num: 14, status: 'active' },
    { num: 15, status: 'pending' },
    { num: 16, status: 'pending' },
    { num: 17, status: 'pending' },
    { num: 18, status: 'pending' },
    { num: 19, status: 'pending' },
    { num: 20, status: 'pending' },
];

const mockOptions = [
    { id: 'A', text: 'Menghubungkan aplikasi langsung ke database tanpa validasi sesi' },
    { id: 'B', text: 'Memfilter dan memeriksa HTTP request sebelum mencapai controller aplikasi' },
    { id: 'C', text: 'Mengkompilasi file blade menjadi template JavaScript statis' },
    { id: 'D', text: 'Menggantikan peran Eloquent ORM dalam query data transaksi' },
];
</script>

<template>
    <Head title="Ujian CBT - Platform Ujian Digital Terpercaya" />

    <div class="min-h-screen bg-[#F8FAFC] text-[#0A090B] font-sans antialiased selection:bg-[#D95300] selection:text-white">
        <!-- Navigation Bar -->
        <header class="fixed top-0 inset-x-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-200/80">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
                <!-- Brand Identity -->
                <Link :href="route('dashboard')" class="flex items-center gap-3.5 group">
                    <div class="w-11 h-11 bg-[#D95300] rounded-xl flex items-center justify-center shadow-md shadow-[#D95300]/15 group-hover:bg-[#BF4900] transition-colors">
                        <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xl font-extrabold tracking-tight text-[#0A090B]">Ujian CBT</span>
                        <span class="text-[10px] font-semibold text-slate-500 uppercase tracking-wider">Computer Based Test</span>
                    </div>
                </Link>

                <!-- Navigation Links -->
                <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-slate-600">
                    <a href="#simulasi" class="hover:text-[#D95300] transition-colors">Simulasi Ujian</a>
                    <a href="#fitur" class="hover:text-[#D95300] transition-colors">Fitur & Peran</a>
                    <a href="#keamanan" class="hover:text-[#D95300] transition-colors">Integritas Keamanan</a>
                    <a href="#alur" class="hover:text-[#D95300] transition-colors">Alur Pelaksanaan</a>
                </nav>

                <!-- Auth Actions -->
                <div v-if="canLogin" class="flex items-center gap-3.5">
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('dashboard')"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#0A090B] text-white text-sm font-semibold rounded-xl hover:bg-slate-800 transition-all shadow-sm"
                    >
                        <span>Buka Dashboard</span>
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </Link>

                    <template v-else>
                        <Link
                            :href="route('login')"
                            class="px-5 py-2.5 text-sm font-semibold text-slate-700 hover:text-[#D95300] rounded-xl hover:bg-slate-100 transition-all"
                        >
                            Masuk
                        </Link>

                        <Link
                            v-if="canRegister"
                            :href="route('register')"
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#D95300] text-white text-sm font-semibold rounded-xl shadow-md shadow-[#D95300]/15 hover:bg-[#BF4900] active:scale-[0.98] transition-all"
                        >
                            <span>Daftar Peserta</span>
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </Link>
                    </template>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="pt-28 lg:pt-36">
            <!-- Hero Section -->
            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20 lg:pb-28">
                <div class="grid lg:grid-cols-12 gap-12 lg:gap-8 items-center">
                    <!-- Left: Hero Text & Value Proposition -->
                    <div class="lg:col-span-6 space-y-8">
                        <div class="inline-flex items-center gap-2.5 px-3.5 py-1.5 bg-[#FFF4EC] border border-[#FED7AA] rounded-full text-xs font-bold text-[#D95300] tracking-wide">
                            <span class="w-2 h-2 rounded-full bg-[#D95300] ring-4 ring-[#D95300]/20"></span>
                            <span>Sistem CBT Standar Institusi & Akademik</span>
                        </div>

                        <div class="space-y-4">
                            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-[#0A090B] tracking-tight leading-[1.12]">
                                Platform Ujian Digital <span class="text-[#D95300]">Terproteksi</span> & Presisi.
                            </h1>
                            <p class="text-lg text-slate-600 leading-relaxed font-normal max-w-xl">
                                Selenggarakan asesmen online berstandar tinggi dengan perlindungan kunci jawaban di sisi server, pencatatan jawaban real-time, dan analitik evaluasi belajar yang komprehensif.
                            </p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 pt-2">
                            <Link
                                v-if="$page.props.auth.user"
                                :href="route('dashboard')"
                                class="inline-flex justify-center items-center gap-2.5 px-7 py-3.5 bg-[#D95300] text-white font-bold text-sm rounded-xl shadow-lg shadow-[#D95300]/20 hover:bg-[#BF4900] active:scale-[0.98] transition-all"
                            >
                                <span>Menuju Portal Dashboard</span>
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                                    <path d="M5 12h14M12 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </Link>
                            <Link
                                v-else
                                :href="route('register')"
                                class="inline-flex justify-center items-center gap-2.5 px-7 py-3.5 bg-[#D95300] text-white font-bold text-sm rounded-xl shadow-lg shadow-[#D95300]/20 hover:bg-[#BF4900] active:scale-[0.98] transition-all"
                            >
                                <span>Mulai Registrasi Peserta</span>
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                                    <path d="M5 12h14M12 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </Link>

                            <a
                                href="#simulasi"
                                class="inline-flex justify-center items-center gap-2.5 px-7 py-3.5 bg-white text-slate-800 font-bold text-sm border border-slate-300 rounded-xl hover:bg-slate-50 hover:border-slate-400 active:scale-[0.98] transition-all shadow-sm"
                            >
                                <span>Pelajari Alur Sistem</span>
                                <svg class="w-4 h-4 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>

                        <!-- Trust Markers -->
                        <div class="pt-6 border-t border-slate-200/80 grid grid-cols-2 sm:grid-cols-3 gap-4 text-left">
                            <div class="space-y-1">
                                <div class="text-xs font-bold text-[#0A090B] flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-[#D95300]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                    <span>Anti-Key Leak</span>
                                </div>
                                <p class="text-[11px] text-slate-500 leading-tight">Kunci jawaban diobfuskasi di sisi server</p>
                            </div>
                            <div class="space-y-1">
                                <div class="text-xs font-bold text-[#0A090B] flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-[#2B82FE]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                    <span>Auto-Save Aktif</span>
                                </div>
                                <p class="text-[11px] text-slate-500 leading-tight">Sinkronisasi jawaban per butir soal</p>
                            </div>
                            <div class="space-y-1 col-span-2 sm:col-span-1">
                                <div class="text-xs font-bold text-[#0A090B] flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                    <span>Rapor Otomatis</span>
                                </div>
                                <p class="text-[11px] text-slate-500 leading-tight">Evaluasi skor instan setelah submit</p>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Interactive CBT Mockup Card -->
                    <div id="simulasi" class="lg:col-span-6">
                        <div class="bg-white rounded-2xl border border-slate-300/80 shadow-xl overflow-hidden transition-all">
                            <!-- Mockup Window Header -->
                            <div class="px-5 py-3.5 bg-slate-900 border-b border-slate-800 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex items-center gap-1.5">
                                        <div class="w-3 h-3 rounded-full bg-rose-500"></div>
                                        <div class="w-3 h-3 rounded-full bg-amber-500"></div>
                                        <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                                    </div>
                                    <span class="text-xs font-mono text-slate-400 pl-2 border-l border-slate-700">SESI UJIAN: AKTIF</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="px-2.5 py-1 bg-slate-800 border border-slate-700 rounded-md flex items-center gap-1.5 text-xs font-mono text-emerald-400">
                                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <polyline points="12 6 12 12 16 14"></polyline>
                                        </svg>
                                        <span>44 : 18</span>
                                    </div>
                                    <span class="text-[11px] font-semibold text-slate-400 bg-slate-800 px-2 py-1 rounded">50 Butir Soal</span>
                                </div>
                            </div>

                            <!-- Mockup Subheader Info -->
                            <div class="px-6 py-3 bg-[#FFF4EC] border-b border-[#FED7AA]/60 flex items-center justify-between text-xs">
                                <div class="font-bold text-[#D95300] flex items-center gap-2">
                                    <span>Mata Uji: Rekayasa Web & Arsitektur Backend</span>
                                </div>
                                <div class="text-slate-600 font-medium">
                                    Peserta: <strong class="text-slate-900">Ahmad Ammar</strong> (ID #ST-0042)
                                </div>
                            </div>

                            <!-- Mockup Question Body -->
                            <div class="p-6 sm:p-7 space-y-6">
                                <!-- Question Prompt -->
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Pertanyaan {{ activeQuestionNumber }} dari 50</span>
                                        <span class="text-[11px] font-semibold px-2 py-0.5 bg-slate-100 text-slate-600 rounded">Bobot: 2.0 Poin</span>
                                    </div>
                                    <p class="text-base sm:text-lg font-bold text-[#0A090B] leading-relaxed">
                                        Dalam arsitektur web modern berbasis framework, apakah fungsi utama dari lapisan Middleware pada siklus pemrosesan HTTP request?
                                    </p>
                                </div>

                                <!-- Interactive Options -->
                                <div class="space-y-3">
                                    <div
                                        v-for="opt in mockOptions"
                                        :key="opt.id"
                                        @click="selectedAnswer = opt.id"
                                        :class="[
                                            'p-3.5 sm:p-4 rounded-xl border text-sm flex items-start gap-3.5 cursor-pointer transition-all',
                                            selectedAnswer === opt.id
                                                ? 'bg-[#FFF4EC] border-[#D95300] shadow-sm text-slate-900 ring-1 ring-[#D95300]'
                                                : 'bg-white border-slate-200 hover:border-slate-300 text-slate-700'
                                        ]"
                                    >
                                        <div
                                            :class="[
                                                'w-6 h-6 rounded-lg flex items-center justify-center font-bold text-xs shrink-0 mt-0.5 transition-colors',
                                                selectedAnswer === opt.id
                                                    ? 'bg-[#D95300] text-white'
                                                    : 'bg-slate-100 text-slate-600'
                                            ]"
                                        >
                                            {{ opt.id }}
                                        </div>
                                        <span class="font-medium leading-snug">{{ opt.text }}</span>
                                    </div>
                                </div>

                                <!-- Actions Toolbar -->
                                <div class="pt-2 flex items-center justify-between border-t border-slate-100 text-xs">
                                    <button
                                        type="button"
                                        @click="isFlagged = !isFlagged"
                                        :class="[
                                            'inline-flex items-center gap-1.5 px-3 py-2 rounded-lg font-semibold transition-colors',
                                            isFlagged
                                                ? 'bg-amber-100 text-amber-800 border border-amber-300'
                                                : 'bg-slate-100 text-slate-600 hover:bg-slate-200'
                                        ]"
                                    >
                                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                        </svg>
                                        <span>{{ isFlagged ? 'Ditandai Ragu' : 'Tandai Ragu-ragu' }}</span>
                                    </button>

                                    <div class="flex items-center gap-2">
                                        <button
                                            type="button"
                                            class="px-3.5 py-2 rounded-lg border border-slate-200 text-slate-600 font-semibold hover:bg-slate-50 transition-colors"
                                        >
                                            Sebelumnya
                                        </button>
                                        <button
                                            type="button"
                                            class="px-4 py-2 rounded-lg bg-[#0A090B] text-white font-semibold hover:bg-slate-800 transition-colors"
                                        >
                                            Berikutnya
                                        </button>
                                    </div>
                                </div>

                                <!-- Navigator Numbers Palette -->
                                <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-xl space-y-2">
                                    <div class="flex items-center justify-between text-[11px] font-semibold text-slate-500">
                                        <span>Navigasi Lembar Jawaban (Klik Butir)</span>
                                        <span class="text-emerald-700">13 Terjawab</span>
                                    </div>
                                    <div class="grid grid-cols-10 gap-1.5 text-center">
                                        <button
                                            v-for="item in mockQuestions"
                                            :key="item.num"
                                            @click="activeQuestionNumber = item.num"
                                            type="button"
                                            :class="[
                                                'h-7 rounded text-[11px] font-bold flex items-center justify-center transition-all',
                                                item.num === activeQuestionNumber
                                                    ? 'bg-[#D95300] text-white ring-2 ring-[#D95300]/30 shadow-sm'
                                                    : item.status === 'done'
                                                    ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200'
                                                    : 'bg-white border border-slate-200 text-slate-500 hover:bg-slate-100'
                                            ]"
                                        >
                                            {{ item.num }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Metrics & Statistics Ribbon -->
            <section class="border-y border-slate-200/90 bg-white py-12">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-8 lg:gap-12">
                        <div class="space-y-1.5 border-l-2 border-[#D95300] pl-4">
                            <span class="text-3xl sm:text-4xl font-black text-[#0A090B] tracking-tight">99.9%</span>
                            <div class="text-xs font-bold text-slate-800 uppercase tracking-wider">Tingkat Uptime</div>
                            <p class="text-xs text-slate-500">Stabilitas konkurensi tinggi saat ribuan siswa aktif bersamaan</p>
                        </div>

                        <div class="space-y-1.5 border-l-2 border-[#2B82FE] pl-4">
                            <span class="text-3xl sm:text-4xl font-black text-[#0A090B] tracking-tight">50 Soal</span>
                            <div class="text-xs font-bold text-slate-800 uppercase tracking-wider">Kapasitas Sesi</div>
                            <p class="text-xs text-slate-500">Standar evaluasi kurikulum terstruktur per mata pelajaran</p>
                        </div>

                        <div class="space-y-1.5 border-l-2 border-emerald-600 pl-4">
                            <span class="text-3xl sm:text-4xl font-black text-[#0A090B] tracking-tight">0%</span>
                            <div class="text-xs font-bold text-slate-800 uppercase tracking-wider">Kebocoran Kunci</div>
                            <p class="text-xs text-slate-500">Proteksi payload mencegah pembongkaran jawaban via DevTools</p>
                        </div>

                        <div class="space-y-1.5 border-l-2 border-slate-800 pl-4">
                            <span class="text-3xl sm:text-4xl font-black text-[#0A090B] tracking-tight">&lt; 250ms</span>
                            <div class="text-xs font-bold text-slate-800 uppercase tracking-wider">Latensi Simpan</div>
                            <p class="text-xs text-slate-500">Pencatatan jawaban instan dengan proteksi throttling adaptif</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Role-Based Capabilities (Teacher & Student) -->
            <section id="fitur" class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16 space-y-4">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-slate-100 border border-slate-200 rounded-full text-xs font-bold text-slate-700 uppercase tracking-wider">
                        Fitur Terstruktur Berdasarkan Peran
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-black text-[#0A090B] tracking-tight">
                        Dirancang Khusus untuk Pengajar dan Peserta Didik
                    </h2>
                    <p class="text-base text-slate-600 leading-relaxed">
                        Sistem memisahkan ruang kerja pengajar dan lingkungan ujian siswa secara ketat guna menjaga integritas dan kenyamanan asesmen.
                    </p>

                    <!-- Interactive Switcher -->
                    <div class="pt-4 flex justify-center">
                        <div class="inline-flex p-1 bg-slate-200/80 rounded-xl border border-slate-300">
                            <button
                                type="button"
                                @click="activeQuestionTab = 'teacher'"
                                :class="[
                                    'px-6 py-2.5 rounded-lg text-xs font-bold transition-all',
                                    activeQuestionTab === 'teacher'
                                        ? 'bg-white text-[#D95300] shadow-sm'
                                        : 'text-slate-600 hover:text-slate-900'
                                ]"
                            >
                                Ruang Kerja Pengajar (Teacher)
                            </button>
                            <button
                                type="button"
                                @click="activeQuestionTab = 'student'"
                                :class="[
                                    'px-6 py-2.5 rounded-lg text-xs font-bold transition-all',
                                    activeQuestionTab === 'student'
                                        ? 'bg-white text-[#2B82FE] shadow-sm'
                                        : 'text-slate-600 hover:text-slate-900'
                                ]"
                            >
                                Lingkungan Siswa (Student)
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Teacher Features Grid -->
                <div v-if="activeQuestionTab === 'teacher'" class="grid md:grid-cols-3 gap-8">
                    <div class="bg-white p-8 rounded-2xl border border-slate-200 hover:border-slate-300 shadow-sm transition-all space-y-4">
                        <div class="w-12 h-12 rounded-xl bg-[#FFF4EC] text-[#D95300] flex items-center justify-center font-bold">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="3" y1="9" x2="21" y2="9"></line>
                                <line x1="9" y1="21" x2="9" y2="9"></line>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-[#0A090B]">Manajemen Bank Soal Lengkap</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">
                            Buat, perbarui, dan atur pilihan ganda hingga 50 pertanyaan per modul kursus dengan penentuan kunci jawaban yang aman dan terisolasi.
                        </p>
                        <div class="pt-2 text-xs font-bold text-[#D95300] flex items-center gap-1.5">
                            <span>Kapasitas penuh 50 butir</span>
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M5 12h14M12 5l7 7-7 7" />
                            </svg>
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded-2xl border border-slate-200 hover:border-slate-300 shadow-sm transition-all space-y-4">
                        <div class="w-12 h-12 rounded-xl bg-[#FFF4EC] text-[#D95300] flex items-center justify-center font-bold">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-[#0A090B]">Isolasi Kursus Multi-Tenant</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">
                            Setiap guru memiliki kontrol penuh atas bank soal dan kursus masing-masing. Akses data antar-pengajar dijaga terisolasi tanpa tumpang tindih.
                        </p>
                        <div class="pt-2 text-xs font-bold text-[#D95300] flex items-center gap-1.5">
                            <span>Kepemilikan kursus privat</span>
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M5 12h14M12 5l7 7-7 7" />
                            </svg>
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded-2xl border border-slate-200 hover:border-slate-300 shadow-sm transition-all space-y-4">
                        <div class="w-12 h-12 rounded-xl bg-[#FFF4EC] text-[#D95300] flex items-center justify-center font-bold">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="18" y1="20" x2="18" y2="10"></line>
                                <line x1="12" y1="20" x2="12" y2="4"></line>
                                <line x1="6" y1="20" x2="6" y2="14"></line>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-[#0A090B]">Analitik Hasil & Kelulusan</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">
                            Pantau rasio kelulusan peserta (ambang batas skor 70), rata-rata nilai kelas, serta tren partisipasi bulanan melalui dashboard analitik.
                        </p>
                        <div class="pt-2 text-xs font-bold text-[#D95300] flex items-center gap-1.5">
                            <span>Rekapitulasi otomatis</span>
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M5 12h14M12 5l7 7-7 7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Student Features Grid -->
                <div v-else class="grid md:grid-cols-3 gap-8">
                    <div class="bg-white p-8 rounded-2xl border border-slate-200 hover:border-slate-300 shadow-sm transition-all space-y-4">
                        <div class="w-12 h-12 rounded-xl bg-[#EFF6FF] text-[#2B82FE] flex items-center justify-center font-bold">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-[#0A090B]">Pengatur Waktu Otomatis</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">
                            Sistem menghitung mundur secara sinkron dengan jam server, mencegah manipulasi waktu lokal browser dan melakukan auto-finish bila batas waktu habis.
                        </p>
                        <div class="pt-2 text-xs font-bold text-[#2B82FE] flex items-center gap-1.5">
                            <span>Sinkronisasi jam server</span>
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M5 12h14M12 5l7 7-7 7" />
                            </svg>
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded-2xl border border-slate-200 hover:border-slate-300 shadow-sm transition-all space-y-4">
                        <div class="w-12 h-12 rounded-xl bg-[#EFF6FF] text-[#2B82FE] flex items-center justify-center font-bold">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                <polyline points="7 3 7 8 15 8"></polyline>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-[#0A090B]">Penyimpanan Jawaban Instan</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">
                            Tiap pilihan opsi tersimpan seketika ke database secara asynchronous. Bila browser tertutup tanpa sengaja, progres ujian tetap tersimpan aman.
                        </p>
                        <div class="pt-2 text-xs font-bold text-[#2B82FE] flex items-center gap-1.5">
                            <span>Auto-save per butir</span>
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M5 12h14M12 5l7 7-7 7" />
                            </svg>
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded-2xl border border-slate-200 hover:border-slate-300 shadow-sm transition-all space-y-4">
                        <div class="w-12 h-12 rounded-xl bg-[#EFF6FF] text-[#2B82FE] flex items-center justify-center font-bold">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-[#0A090B]">Rapor Skor Transparan</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">
                            Begitu ujian selesai diserahkan, kalkulasi nilai berbasis 50 butir soal langsung diterbitkan bersama rekapitulasi performa ujian yang jelas.
                        </p>
                        <div class="pt-2 text-xs font-bold text-[#2B82FE] flex items-center gap-1.5">
                            <span>Laporan evaluasi instan</span>
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M5 12h14M12 5l7 7-7 7" />
                            </svg>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Three Pillars of Security & Architecture -->
            <section id="keamanan" class="py-24 bg-slate-900 text-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="max-w-3xl space-y-4 mb-16">
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-slate-800 border border-slate-700 rounded-full text-xs font-bold text-amber-400 uppercase tracking-wider">
                            Arsitektur Keamanan Lapis Ganda
                        </div>
                        <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-white">
                            Fondasi Integritas Asesmen Tanpa Kompromi
                        </h2>
                        <p class="text-base text-slate-400 leading-relaxed">
                            Dikembangkan dengan standar pengamanan senior untuk mencegah kecurangan digital, kebocoran kunci, dan serangan saturasi traffic.
                        </p>
                    </div>

                    <div class="grid md:grid-cols-3 gap-8">
                        <!-- Pillar 1 -->
                        <div class="bg-slate-800/80 p-8 rounded-2xl border border-slate-700 space-y-5">
                            <div class="w-12 h-12 rounded-xl bg-slate-700 border border-slate-600 flex items-center justify-center text-[#D95300]">
                                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-white">Obfuskasi Kunci Sisi Server</h3>
                            <p class="text-sm text-slate-400 leading-relaxed">
                                Endpoint pengambilan soal hanya mengirimkan field ID, ID Pertanyaan, dan Teks Jawaban. Atribut boolean penentu kebenaran (<code class="text-xs bg-slate-900 px-1.5 py-0.5 rounded text-amber-300">is_correct</code>) sepenuhnya disaring di level Eloquent query sebelum mencapai browser peserta.
                            </p>
                            <div class="text-xs font-semibold text-emerald-400 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                <span>Zero-Leakage Guarantee</span>
                            </div>
                        </div>

                        <!-- Pillar 2 -->
                        <div class="bg-slate-800/80 p-8 rounded-2xl border border-slate-700 space-y-5">
                            <div class="w-12 h-12 rounded-xl bg-slate-700 border border-slate-600 flex items-center justify-center text-[#2B82FE]">
                                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-white">Multi-Layer Rate Throttling</h3>
                            <p class="text-sm text-slate-400 leading-relaxed">
                                Jalur simpan jawaban dibatasi pada 60 request/menit untuk mencegah spam bot, sementara tindakan penyerahan akhir dibatasi pada 10 request/menit. Seluruh rute dilindungi pembatasan menyeluruh untuk menangkal potensi DoS.
                            </p>
                            <div class="text-xs font-semibold text-blue-400 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span>
                                <span>Perlindungan DoS & Brute-force</span>
                            </div>
                        </div>

                        <!-- Pillar 3 -->
                        <div class="bg-slate-800/80 p-8 rounded-2xl border border-slate-700 space-y-5">
                            <div class="w-12 h-12 rounded-xl bg-slate-700 border border-slate-600 flex items-center justify-center text-emerald-400">
                                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                    <path d="m9 12 2 2 4-4"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-white">Browser Security Headers</h3>
                            <p class="text-sm text-slate-400 leading-relaxed">
                                Middleware kustom menerapkan Content Security Policy (CSP), proteksi X-Frame-Options guna mencegah serangan clickjacking, proteksi X-XSS, dan pemaksaan isolasi atribut mass-assignment via allow-list Eloquent.
                            </p>
                            <div class="text-xs font-semibold text-amber-400 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                <span>Enforced HTTP Headers</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Examination Workflow Sequence -->
            <section id="alur" class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-16 space-y-4">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-slate-100 border border-slate-200 rounded-full text-xs font-bold text-slate-700 uppercase tracking-wider">
                        Alur Pelaksanaan Ujian
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-black text-[#0A090B] tracking-tight">
                        Empat Langkah Menuju Ujian Digital yang Tertib
                    </h2>
                    <p class="text-base text-slate-600 leading-relaxed">
                        Pengalaman terintegrasi dari penyusunan materi oleh penguji hingga penyerahan lembar jawaban oleh peserta.
                    </p>
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="p-6 bg-white rounded-2xl border border-slate-200 shadow-sm space-y-4">
                        <div class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center font-black text-sm">
                            1
                        </div>
                        <h4 class="text-base font-bold text-[#0A090B]">Penyusunan Bank Soal</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Pengajar mengunggah materi, menentukan kategori ujian, dan memasukkan hingga 50 pertanyaan dengan opsi jawaban.
                        </p>
                    </div>

                    <div class="p-6 bg-white rounded-2xl border border-slate-200 shadow-sm space-y-4">
                        <div class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center font-black text-sm">
                            2
                        </div>
                        <h4 class="text-base font-bold text-[#0A090B]">Pendaftaran Siswa</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Peserta login ke portal dan didaftarkan pada kursus ujian resmi yang diampu oleh pengajar bersangkutan.
                        </p>
                    </div>

                    <div class="p-6 bg-white rounded-2xl border border-slate-200 shadow-sm space-y-4">
                        <div class="w-10 h-10 rounded-xl bg-[#D95300] text-white flex items-center justify-center font-black text-sm">
                            3
                        </div>
                        <h4 class="text-base font-bold text-[#0A090B]">Pengerjaan Real-Time</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Siswa menyelesaikan ujian dengan countdown timer otomatis dan penyimpanan jawaban langsung per butir soal.
                        </p>
                    </div>

                    <div class="p-6 bg-white rounded-2xl border border-slate-200 shadow-sm space-y-4">
                        <div class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center font-black text-sm">
                            4
                        </div>
                        <h4 class="text-base font-bold text-[#0A090B]">Evaluasi & Rekap Skor</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Sistem menghitung persentase skor secara instan dan memperbarui statistik kelulusan pada dashboard pengajar.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Call to Action Banner -->
            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">
                <div class="bg-gradient-to-r from-slate-950 via-slate-900 to-slate-950 text-white rounded-3xl p-8 sm:p-12 lg:p-16 border border-slate-800 shadow-xl relative overflow-hidden">
                    <div class="max-w-2xl space-y-6 relative z-10">
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-[#D95300]/20 border border-[#D95300]/40 rounded-full text-xs font-bold text-[#D95300]">
                            Siap Menjalankan Asesmen Digital?
                        </div>
                        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight leading-tight">
                            Mulai Gunakan Ujian CBT untuk Institusi Anda Hari Ini.
                        </h2>
                        <p class="text-sm sm:text-base text-slate-400 leading-relaxed">
                            Daftarkan akun peserta untuk mulai mencoba ujian, atau masuk menggunakan kredensial pengajar untuk mengelola bank soal dan memantau kemajuan siswa.
                        </p>

                        <div class="flex flex-col sm:flex-row gap-4 pt-2">
                            <Link
                                v-if="!$page.props.auth.user"
                                :href="route('register')"
                                class="inline-flex justify-center items-center gap-2 px-8 py-4 bg-[#D95300] text-white text-sm font-bold rounded-xl shadow-lg shadow-[#D95300]/20 hover:bg-[#BF4900] active:scale-[0.98] transition-all"
                            >
                                <span>Daftar Akun Baru</span>
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                                    <path d="M5 12h14M12 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </Link>

                            <Link
                                :href="route('login')"
                                class="inline-flex justify-center items-center gap-2 px-8 py-4 bg-slate-800 text-white text-sm font-bold rounded-xl border border-slate-700 hover:bg-slate-700 active:scale-[0.98] transition-all"
                            >
                                <span>Masuk ke Akun</span>
                            </Link>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <!-- Institutional Footer -->
        <footer class="bg-white border-t border-slate-200/90 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-[#D95300] rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                            </svg>
                        </div>
                        <span class="font-extrabold text-base tracking-tight text-[#0A090B]">Ujian CBT</span>
                        <span class="text-xs text-slate-400 pl-3 border-l border-slate-200">Modern Computer Based Test Platform</span>
                    </div>

                    <div class="flex flex-wrap items-center gap-6 text-xs font-semibold text-slate-500">
                        <a href="#simulasi" class="hover:text-[#D95300] transition-colors">Simulasi</a>
                        <a href="#fitur" class="hover:text-[#D95300] transition-colors">Fitur</a>
                        <a href="#keamanan" class="hover:text-[#D95300] transition-colors">Keamanan</a>
                        <a href="#alur" class="hover:text-[#D95300] transition-colors">Alur Ujian</a>
                    </div>

                    <div class="text-xs text-slate-500 font-medium">
                        &copy; {{ new Date().getFullYear() }} Ujian CBT. Hak Cipta Dilindungi.
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>
