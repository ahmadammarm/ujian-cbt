<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
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

// Interactive state for the live CBT examination simulation
const activeWorkspaceTab = ref('studio');
const activeQuestionNumber = ref(14);
const timeRemaining = ref(2658); // 44 minutes 18 seconds
const isSaving = ref(false);
const lastSavedTime = ref('10:45:29');
let timerInterval = null;
let saveTimeout = null;

onMounted(() => {
    timerInterval = setInterval(() => {
        if (timeRemaining.value > 0) {
            timeRemaining.value--;
        }
    }, 1000);
});

onUnmounted(() => {
    if (timerInterval) clearInterval(timerInterval);
    if (saveTimeout) clearTimeout(saveTimeout);
});

const formattedTime = computed(() => {
    const mins = Math.floor(timeRemaining.value / 60);
    const secs = timeRemaining.value % 60;
    return `${String(mins).padStart(2, '0')} : ${String(secs).padStart(2, '0')}`;
});

// Interactive question dataset for the live exam simulator
const questions = ref([
    {
        num: 1,
        title: 'Manakah HTTP method yang bersifat idempotent dan digunakan untuk memperbarui seluruh representasi resource?',
        options: [
            { id: 'A', text: 'POST' },
            { id: 'B', text: 'PUT' },
            { id: 'C', text: 'PATCH' },
            { id: 'D', text: 'DELETE' },
        ],
        selected: 'B',
        isFlagged: false,
    },
    {
        num: 2,
        title: 'Mekanisme keamanan apa yang digunakan untuk mencegah serangan Cross-Site Request Forgery (CSRF) pada form web?',
        options: [
            { id: 'A', text: 'Penyimpanan password menggunakan MD5 hash' },
            { id: 'B', text: 'Penggunaan token rahasia berbasis sesi yang divalidasi per request' },
            { id: 'C', text: 'Pembatasan ukuran upload file HTTP' },
            { id: 'D', text: 'Menonaktifkan protokol HTTPS pada server lokal' },
        ],
        selected: 'B',
        isFlagged: false,
    },
    {
        num: 3,
        title: 'Dalam indeks database relasional, struktur data apakah yang paling umum digunakan untuk mempercepat query pencarian range dan equality?',
        options: [
            { id: 'A', text: 'B-Tree / B+ Tree' },
            { id: 'B', text: 'Adjacency Matrix' },
            { id: 'C', text: 'Circular Linked List' },
            { id: 'D', text: 'Stack FIFO' },
        ],
        selected: 'A',
        isFlagged: false,
    },
    {
        num: 4,
        title: 'Apa tujuan utama dari penerapan Content Security Policy (CSP) pada HTTP header?',
        options: [
            { id: 'A', text: 'Mempercepat kompresi gambar PNG' },
            { id: 'B', text: 'Membatasi sumber resource yang dapat dieksekusi browser untuk mencegah XSS' },
            { id: 'C', text: 'Mengalihkan traffic dari HTTP port 80 ke HTTPS port 443' },
            { id: 'D', text: 'Menghubungkan browser ke proxy reverse Nginx' },
        ],
        selected: 'B',
        isFlagged: false,
    },
    {
        num: 5,
        title: 'Pada arsitektur RESTful API, status code HTTP 403 Forbidden mengindikasikan bahwa:',
        options: [
            { id: 'A', text: 'Resource tidak ditemukan pada server' },
            { id: 'B', text: 'Server mengalami crash internal yang tidak tertangani' },
            { id: 'C', text: 'Klien terautentikasi namun tidak memiliki izin akses ke resource tersebut' },
            { id: 'D', text: 'Format body request tidak valid' },
        ],
        selected: 'C',
        isFlagged: false,
    },
    {
        num: 6,
        title: 'Apa fungsi dari penggunaan prepared statement atau parameterized queries pada layer database?',
        options: [
            { id: 'A', text: 'Mencegah eksekusi SQL Injection dengan memisahkan kode query dari data input' },
            { id: 'B', text: 'Membuat backup data harian secara otomatis' },
            { id: 'C', text: 'Menggantikan seluruh kebutuhan indeks database' },
            { id: 'D', text: 'Mematikan koneksi database jika traffic tinggi' },
        ],
        selected: 'A',
        isFlagged: false,
    },
    {
        num: 7,
        title: 'Dalam protokol TLS/HTTPS, proses handshake asimetris bertujuan untuk:',
        options: [
            { id: 'A', text: 'Menghitung skor ujian siswa secara real-time' },
            { id: 'B', text: 'Menyepakati kunci simetris rahasia dan memverifikasi sertifikat server' },
            { id: 'C', text: 'Menghapus file log pada web server' },
            { id: 'D', text: 'Membatasi jumlah koneksi simultan per IP' },
        ],
        selected: 'B',
        isFlagged: false,
    },
    {
        num: 8,
        title: 'Perbedaan mendasar antara proses otentikasi (Authentication) dan otorisasi (Authorization) adalah:',
        options: [
            { id: 'A', text: 'Otentikasi menentukan siapa Anda; Otorisasi menentukan apa hak akses Anda' },
            { id: 'B', text: 'Otentikasi hanya berlaku pada server; Otorisasi hanya berlaku pada browser' },
            { id: 'C', text: 'Otentikasi membutuhkan database NoSQL; Otorisasi membutuhkan SQL' },
            { id: 'D', text: 'Tidak ada perbedaan teknis antara keduanya' },
        ],
        selected: 'A',
        isFlagged: false,
    },
    {
        num: 9,
        title: 'Pada basis data relasional, kondisi Third Normal Form (3NF) terpenuhi apabila:',
        options: [
            { id: 'A', text: 'Setiap tabel memiliki minimal lima puluh kolom' },
            { id: 'B', text: 'Memenuhi 2NF dan tidak memiliki ketergantungan transitif antar atribut non-kunci' },
            { id: 'C', text: 'Semua query dijalankan tanpa klausa WHERE' },
            { id: 'D', text: 'Seluruh foreign key disimpan dalam satu file JSON terpisah' },
        ],
        selected: 'B',
        isFlagged: false,
    },
    {
        num: 10,
        title: 'Manakah dari berikut ini yang merupakan karakteristik utama arsitektur stateless pada REST API?',
        options: [
            { id: 'A', text: 'Server tidak menyimpan konteks sesi klien antar request' },
            { id: 'B', text: 'Klien tidak diperbolehkan mengirim header HTTP' },
            { id: 'C', text: 'Setiap request harus mengembalikan kode status 200' },
            { id: 'D', text: 'Database tidak boleh menyimpan catatan riwayat transaksi' },
        ],
        selected: 'A',
        isFlagged: false,
    },
    {
        num: 11,
        title: 'Pada framework modern, fungsi rate limiting berbasis Token Bucket atau Leaky Bucket adalah:',
        options: [
            { id: 'A', text: 'Membatasi frekuensi request per unit waktu untuk melindungi kapasitas server' },
            { id: 'B', text: 'Menghitung sisa kuota internet pengguna' },
            { id: 'C', text: 'Mengompres ukuran payload JSON sebelum dikirim' },
            { id: 'D', text: 'Menghapus cache browser secara paksa' },
        ],
        selected: 'A',
        isFlagged: false,
    },
    {
        num: 12,
        title: 'Dalam pengujian perangkat lunak, apa yang dimaksud dengan Unit Testing?',
        options: [
            { id: 'A', text: 'Pengujian integrasi menyeluruh pada server produksi' },
            { id: 'B', text: 'Pengujian terhadap komponen atau fungsi terkecil secara terisolasi' },
            { id: 'C', text: 'Pengujian beban traffic menggunakan ribuan bot simultan' },
            { id: 'D', text: 'Pengujian manual oleh pengguna akhir tanpa skenario' },
        ],
        selected: 'B',
        isFlagged: false,
    },
    {
        num: 13,
        title: 'Dalam protokol HTTP, apakah fungsi dari header Cache-Control: no-store?',
        options: [
            { id: 'A', text: 'Menginstruksikan browser dan proxy untuk tidak menyimpan respons ke media penyimpanan apapun' },
            { id: 'B', text: 'Menyimpan respons di browser selama 24 jam' },
            { id: 'C', text: 'Menonaktifkan eksekusi JavaScript pada halaman' },
            { id: 'D', text: 'Mengompres payload menggunakan algoritma Brotli' },
        ],
        selected: 'A',
        isFlagged: false,
    },
    {
        num: 14,
        title: 'Dalam arsitektur web modern, apakah fungsi utama dari lapisan Middleware pada siklus pemrosesan HTTP request?',
        options: [
            { id: 'A', text: 'Menghubungkan aplikasi langsung ke database tanpa validasi sesi' },
            { id: 'B', text: 'Memfilter dan memeriksa HTTP request sebelum mencapai controller aplikasi' },
            { id: 'C', text: 'Mengkompilasi file blade menjadi template JavaScript statis' },
            { id: 'D', text: 'Menggantikan peran Eloquent ORM dalam query data transaksi' },
        ],
        selected: 'B',
        isFlagged: false,
    },
    {
        num: 15,
        title: 'Mengapa enkripsi kata sandi menggunakan fungsi hash satu arah dengan salt (seperti bcrypt atau Argon2) sangat penting?',
        options: [
            { id: 'A', text: 'Memungkinkan administrator membaca password asli siswa jika lupa kata sandi' },
            { id: 'B', text: 'Melindungi nilai password asli dari pencocokan rainbow table meskipun database bocor' },
            { id: 'C', text: 'Mempercepat proses kompilasi asset CSS dan JS' },
            { id: 'D', text: 'Menghindari kebutuhan kolom database berukuran lebih dari 10 karakter' },
        ],
        selected: null,
        isFlagged: false,
    },
    {
        num: 16,
        title: 'Pada sistem manajemen basis data, apa arti properti Atomicity dalam konsep ACID?',
        options: [
            { id: 'A', text: 'Seluruh operasi dalam transaksi harus berhasil dieksekusi atau semuanya dibatalkan' },
            { id: 'B', text: 'Transaksi harus dijalankan dalam waktu kurang dari satu milidetik' },
            { id: 'C', text: 'Tabel database hanya boleh menyimpan data numerik' },
            { id: 'D', text: 'Data transaksi dapat dibaca oleh user lain sebelum di-commit' },
        ],
        selected: null,
        isFlagged: false,
    },
    {
        num: 17,
        title: 'Apa fungsi utama dari protokol DNS (Domain Name System) dalam jaringan komputer?',
        options: [
            { id: 'A', text: 'Menerjemahkan nama domain manusiawi menjadi alamat IP numerik perangkat' },
            { id: 'B', text: 'Mengenkripsi data transmisi perbankan' },
            { id: 'C', text: 'Menghubungkan kabel fiber optik fisik ke router' },
            { id: 'D', text: 'Menghitung waktu pengerjaan ujian secara offline' },
        ],
        selected: null,
        isFlagged: false,
    },
    {
        num: 18,
        title: 'Dalam arsitektur Single Page Application (SPA), bagaimana komunikasi data antara klien dan server umumnya dilakukan?',
        options: [
            { id: 'A', text: 'Server mengirimkan full-page HTML reload pada setiap klik navigasi' },
            { id: 'B', text: 'Klien bertukar payload data asinkron (JSON) melalui protokol HTTP/Fetch API' },
            { id: 'C', text: 'Klien menulis data langsung ke harddisk server web' },
            { id: 'D', text: 'Browser tidak memerlukan koneksi internet setelah halaman pertama dimuat' },
        ],
        selected: null,
        isFlagged: false,
    },
    {
        num: 19,
        title: 'Manakah algoritma hashing kriptografis yang saat ini dianggap usang dan tidak aman untuk verifikasi integritas data kritis?',
        options: [
            { id: 'A', text: 'SHA-256' },
            { id: 'B', text: 'MD5' },
            { id: 'C', text: 'SHA-512' },
            { id: 'D', text: 'Argon2id' },
        ],
        selected: null,
        isFlagged: false,
    },
    {
        num: 20,
        title: 'Dalam arsitektur MVC (Model-View-Controller), peran utama dari layer Model adalah:',
        options: [
            { id: 'A', text: 'Menangani tata letak antarmuka pengguna dan styling visual' },
            { id: 'B', text: 'Mengelola struktur data, aturan validasi bisnis, dan interaksi dengan database' },
            { id: 'C', text: 'Menerima input URL browser dan menentukan routing aplikasi' },
            { id: 'D', text: 'Mengatur ukuran resolusi layar perangkat klien' },
        ],
        selected: null,
        isFlagged: false,
    },
]);

const currentQuestion = computed(() => {
    return questions.value.find((q) => q.num === activeQuestionNumber.value) || questions.value[0];
});

const selectAnswer = (optionId) => {
    currentQuestion.value.selected = optionId;
    isSaving.value = true;
    if (saveTimeout) clearTimeout(saveTimeout);
    saveTimeout = setTimeout(() => {
        isSaving.value = false;
        const now = new Date();
        lastSavedTime.value = `${String(now.getHours()).padStart(2, '0')}:${String(now.getMinutes()).padStart(2, '0')}:${String(now.getSeconds()).padStart(2, '0')}`;
    }, 380);
};

const toggleFlag = () => {
    currentQuestion.value.isFlagged = !currentQuestion.value.isFlagged;
};

const goToPrevious = () => {
    if (activeQuestionNumber.value > 1) {
        activeQuestionNumber.value--;
    }
};

const goToNext = () => {
    if (activeQuestionNumber.value < questions.value.length) {
        activeQuestionNumber.value++;
    }
};

const answeredCount = computed(() => {
    return questions.value.filter((q) => q.selected !== null).length;
});

const progressPercentage = computed(() => {
    return Math.round((answeredCount.value / questions.value.length) * 100);
});
</script>

<template>
    <Head title="Naiju - Platform Ujian & Asesmen Digital" />

    <div class="min-h-screen bg-[#F8FAFC] text-[#0A090B] font-sans antialiased selection:bg-[#D95300] selection:text-white">
        <!-- Institutional Navigation Header -->
        <header class="fixed top-0 inset-x-0 z-50 bg-white/95 backdrop-blur-sm border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
                <!-- Brand Lockup -->
                <Link :href="route('dashboard')" class="flex items-center gap-3.5 group">
                    <div class="w-10 h-10 bg-[#D95300] rounded-xl flex items-center justify-center text-white shrink-0 shadow-sm transition-transform group-hover:scale-105">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                            <path d="M4 3.5H8.2L15.8 15.3V3.5H20V20.5H15.8L8.2 8.7V20.5H4V3.5Z" />
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xl font-extrabold tracking-tight text-[#0A090B]">Naiju</span>
                        <span class="text-[10px] font-semibold text-slate-500 uppercase tracking-wider">Platform Ujian &amp; Asesmen Digital</span>
                    </div>
                </Link>

                <!-- Navigation Destinations -->
                <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-slate-600">
                    <a href="#simulasi" class="hover:text-[#D95300] transition-colors">Simulasi Ujian</a>
                    <a href="#spesifikasi" class="hover:text-[#D95300] transition-colors">Spesifikasi Sistem</a>
                    <a href="#ruang-kerja" class="hover:text-[#D95300] transition-colors">Ruang Kerja</a>
                    <a href="#keamanan" class="hover:text-[#D95300] transition-colors">Integritas Server</a>
                </nav>

                <!-- Access Controls -->
                <div v-if="canLogin" class="flex items-center gap-3">
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('dashboard')"
                        class="px-5 py-2.5 bg-[#0A090B] text-white text-sm font-semibold rounded-xl hover:bg-slate-800 transition-colors shadow-sm"
                    >
                        Buka Dashboard
                    </Link>

                    <template v-else>
                        <Link
                            :href="route('login')"
                            class="px-4 py-2.5 text-sm font-semibold text-slate-700 hover:text-[#D95300] rounded-xl hover:bg-slate-100 transition-colors"
                        >
                            Masuk
                        </Link>

                        <Link
                            v-if="canRegister"
                            :href="route('register')"
                            class="px-5 py-2.5 bg-[#D95300] text-white text-sm font-semibold rounded-xl hover:bg-[#BF4900] transition-colors shadow-sm"
                        >
                            Daftar Peserta
                        </Link>
                    </template>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="pt-28 lg:pt-36">
            <!-- Hero Section: Grounded Institutional Introduction -->
            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16 lg:pb-24">
                <div class="grid lg:grid-cols-12 gap-12 lg:gap-8 items-start">
                    <!-- Left: Problem Statement & Practical Core Value -->
                    <div class="lg:col-span-5 space-y-6 lg:pt-4">
                        <div class="text-xs font-bold uppercase tracking-wider text-[#D95300]">
                            Standar Asesmen Digital Berintegritas
                        </div>

                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-[#0A090B] tracking-tight leading-[1.15]">
                            Infrastruktur Ujian Digital Terproteksi untuk Sekolah &amp; Kampus.
                        </h1>

                        <p class="text-base text-slate-600 leading-relaxed font-normal">
                            Naiju menyederhanakan manajemen bank soal pengajar, pengawasan ujian real-time, dan evaluasi hasil otomatis. Kunci jawaban dilindungi secara ketat di sisi server untuk menjamin kejujuran asesmen.
                        </p>

                        <!-- Primary Direct Actions -->
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 pt-2">
                            <Link
                                v-if="$page.props.auth.user"
                                :href="route('dashboard')"
                                class="px-6 py-3.5 bg-[#D95300] text-white font-bold text-sm rounded-xl text-center hover:bg-[#BF4900] transition-colors shadow-sm"
                            >
                                Menuju Portal Dashboard
                            </Link>

                            <Link
                                v-else
                                :href="route('login')"
                                class="px-6 py-3.5 bg-[#D95300] text-white font-bold text-sm rounded-xl text-center hover:bg-[#BF4900] transition-colors shadow-sm"
                            >
                                Masuk Portal Ujian
                            </Link>

                            <a
                                href="#simulasi"
                                class="px-6 py-3.5 bg-white text-slate-700 font-bold text-sm border border-slate-300 rounded-xl text-center hover:bg-slate-50 hover:text-slate-900 transition-colors shadow-sm"
                            >
                                Uji Simulasi Interaktif
                            </a>
                        </div>

                        <!-- Technical Highlights Grid -->
                        <div class="pt-6 border-t border-slate-200 grid grid-cols-2 gap-4 text-left">
                            <div class="p-4 bg-white border border-slate-200 rounded-xl space-y-1.5 shadow-xs">
                                <span class="text-xs font-bold text-slate-900 block">Server-Side Sanitization</span>
                                <p class="text-xs text-slate-500 leading-normal">
                                    Atribut <code class="text-[11px] bg-slate-100 px-1 py-0.5 rounded text-[#D95300]">is_correct</code> disaring di level query database sebelum dikirim ke browser.
                                </p>
                            </div>
                            <div class="p-4 bg-white border border-slate-200 rounded-xl space-y-1.5 shadow-xs">
                                <span class="text-xs font-bold text-slate-900 block">Penyimpanan Asinkron</span>
                                <p class="text-xs text-slate-500 leading-normal">
                                    Jawaban tersimpan otomatis per butir soal untuk mengamankan progres dari kendala koneksi.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Authentic Interactive CBT Examination Window -->
                    <div id="simulasi" class="lg:col-span-7">
                        <div class="bg-white rounded-2xl border border-slate-300 shadow-md overflow-hidden">
                            <!-- Real Institutional Exam App Header -->
                            <div class="px-6 py-3.5 bg-[#0A090B] text-white flex flex-wrap items-center justify-between gap-3 border-b border-slate-800">
                                <div class="flex items-center gap-3">
                                    <div class="w-2.5 h-2.5 rounded-full bg-emerald-400"></div>
                                    <span class="text-xs font-mono font-bold tracking-wider text-slate-200">NAIJU EXAM · SESI AKTIF</span>
                                    <span class="text-xs text-slate-400 border-l border-slate-700 pl-3">Mata Uji: Rekayasa Web</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="px-2.5 py-1 bg-slate-800 border border-slate-700 rounded text-xs font-mono font-bold text-emerald-400">
                                        Sisa Waktu: {{ formattedTime }}
                                    </div>
                                    <span class="text-[11px] font-semibold text-slate-400">50 Butir Soal</span>
                                </div>
                            </div>

                            <!-- Session Meta Bar & Real-Time Sync Indicator -->
                            <div class="px-6 py-2.5 bg-slate-50 border-b border-slate-200 flex flex-wrap items-center justify-between gap-2 text-xs text-slate-600">
                                <div class="flex items-center gap-2">
                                    <span>Peserta: <strong class="text-slate-900 font-semibold">Ahmad Ammar</strong> (ID #ST-0042)</span>
                                </div>

                                <!-- Live Auto-Save Indicator -->
                                <div class="flex items-center gap-2 font-mono">
                                    <span v-if="isSaving" class="text-amber-600 font-semibold flex items-center gap-1.5">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                        Menyinkronkan jawaban...
                                    </span>
                                    <span v-else class="text-emerald-700 font-semibold flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                            <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>
                                        Tersimpan di server ({{ lastSavedTime }})
                                    </span>
                                </div>
                            </div>

                            <!-- Progress Meter -->
                            <div class="w-full bg-slate-100 h-1">
                                <div
                                    class="bg-emerald-500 h-full transition-all duration-300"
                                    :style="{ width: `${progressPercentage}%` }"
                                ></div>
                            </div>

                            <!-- Interactive Question Workspace -->
                            <div class="p-6 sm:p-7 space-y-6">
                                <!-- Question Prompt & Points -->
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">
                                            Butir Pertanyaan {{ currentQuestion.num }} dari 50
                                        </span>
                                        <span class="text-xs font-semibold px-2 py-0.5 bg-slate-100 text-slate-700 rounded border border-slate-200">
                                            Bobot: 2.0 Poin
                                        </span>
                                    </div>
                                    <p class="text-base sm:text-lg font-bold text-[#0A090B] leading-relaxed">
                                        {{ currentQuestion.title }}
                                    </p>
                                </div>

                                <!-- Interactive Multiple Choice Options with Hardware Keycap Aesthetic -->
                                <div class="space-y-2.5">
                                    <div
                                        v-for="opt in currentQuestion.options"
                                        :key="opt.id"
                                        @click="selectAnswer(opt.id)"
                                        :class="[
                                            'p-3.5 sm:p-4 rounded-xl border text-sm flex items-start gap-3.5 cursor-pointer transition-all',
                                            currentQuestion.selected === opt.id
                                                ? 'bg-[#FFF4EC] border-[#D95300] text-slate-900 shadow-xs'
                                                : 'bg-white border-slate-200 hover:border-slate-300 text-slate-700'
                                        ]"
                                    >
                                        <!-- Keycap Tile -->
                                        <div
                                            :class="[
                                                'w-7 h-7 rounded-lg flex items-center justify-center font-mono font-bold text-xs shrink-0 mt-0.5 border transition-colors shadow-xs',
                                                currentQuestion.selected === opt.id
                                                    ? 'bg-[#D95300] border-[#BF4900] text-white'
                                                    : 'bg-slate-100 border-slate-200 text-slate-700'
                                            ]"
                                        >
                                            {{ opt.id }}
                                        </div>
                                        <span class="font-medium leading-snug pt-0.5">{{ opt.text }}</span>
                                    </div>
                                </div>

                                <!-- Examination Toolbar Controls -->
                                <div class="pt-3 flex items-center justify-between border-t border-slate-200 text-xs">
                                    <button
                                        type="button"
                                        @click="toggleFlag"
                                        :class="[
                                            'inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg font-semibold border transition-colors',
                                            currentQuestion.isFlagged
                                                ? 'bg-amber-50 text-amber-900 border-amber-300'
                                                : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50'
                                        ]"
                                    >
                                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                        </svg>
                                        <span>{{ currentQuestion.isFlagged ? 'Ditandai Ragu-ragu' : 'Tandai Ragu-ragu' }}</span>
                                    </button>

                                    <div class="flex items-center gap-2">
                                        <button
                                            type="button"
                                            @click="goToPrevious"
                                            :disabled="activeQuestionNumber === 1"
                                            class="px-4 py-2 rounded-lg border border-slate-200 text-slate-600 font-semibold hover:bg-slate-50 disabled:opacity-40 disabled:cursor-not-allowed transition-colors"
                                        >
                                            Sebelumnya
                                        </button>
                                        <button
                                            type="button"
                                            @click="goToNext"
                                            :disabled="activeQuestionNumber === questions.length"
                                            class="px-4 py-2 rounded-lg bg-[#0A090B] text-white font-semibold hover:bg-slate-800 disabled:opacity-40 disabled:cursor-not-allowed transition-colors shadow-xs"
                                        >
                                            Berikutnya
                                        </button>
                                    </div>
                                </div>

                                <!-- Question Sheet Navigator Palette -->
                                <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl space-y-3">
                                    <div class="flex items-center justify-between text-xs font-semibold text-slate-600">
                                        <span>Navigasi Lembar Jawaban (Pilih Nomor)</span>
                                        <div class="flex items-center gap-3 text-[11px]">
                                            <span class="flex items-center gap-1.5">
                                                <span class="w-2.5 h-2.5 rounded bg-emerald-600"></span>
                                                <span>{{ answeredCount }} Terjawab</span>
                                            </span>
                                            <span class="flex items-center gap-1.5">
                                                <span class="w-2.5 h-2.5 rounded bg-amber-400"></span>
                                                <span>Ragu</span>
                                            </span>
                                            <span class="flex items-center gap-1.5">
                                                <span class="w-2.5 h-2.5 rounded bg-white border border-slate-300"></span>
                                                <span>Kosong</span>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-10 gap-1.5 text-center">
                                        <button
                                            v-for="item in questions"
                                            :key="item.num"
                                            @click="activeQuestionNumber = item.num"
                                            type="button"
                                            :class="[
                                                'h-7 rounded text-[11px] font-bold flex items-center justify-center transition-colors',
                                                item.num === activeQuestionNumber
                                                    ? 'bg-[#D95300] text-white ring-2 ring-[#D95300]/40'
                                                    : item.isFlagged
                                                    ? 'bg-amber-100 text-amber-900 border border-amber-300'
                                                    : item.selected !== null
                                                    ? 'bg-emerald-100 text-emerald-900 border border-emerald-200'
                                                    : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-100'
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

            <!-- Technical Specifications Grid: Verifiable, Concrete Architecture -->
            <section id="spesifikasi" class="border-y border-slate-200 bg-white py-16">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="max-w-3xl mb-12 space-y-2">
                        <div class="text-xs font-bold uppercase tracking-wider text-slate-500">
                            Spesifikasi &amp; Standar Teknis
                        </div>
                        <h2 class="text-2xl sm:text-3xl font-black text-[#0A090B] tracking-tight">
                            Parameter Arsitektur Sistem Asesmen Naiju
                        </h2>
                        <p class="text-sm text-slate-600">
                            Setiap modul dibangun dengan batasan teknis yang terukur untuk menjamin stabilitas saat ujian massal diselenggarakan.
                        </p>
                    </div>

                    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="p-6 rounded-2xl border border-slate-200 bg-slate-50 space-y-2">
                            <span class="text-xs font-mono font-bold text-slate-400 uppercase tracking-wider block">01 · KAPASITAS SESI</span>
                            <div class="text-2xl font-black text-[#0A090B]">50 Butir Soal</div>
                            <p class="text-xs text-slate-600 leading-normal">
                                Bobot 2 poin per butir untuk total skala 100 dengan batas Kriteria Ketuntasan Minimal (KKM) standar 70.
                            </p>
                        </div>

                        <div class="p-6 rounded-2xl border border-slate-200 bg-slate-50 space-y-2">
                            <span class="text-xs font-mono font-bold text-slate-400 uppercase tracking-wider block">02 · KEAMANAN DATA</span>
                            <div class="text-2xl font-black text-[#0A090B]">Zero-Payload Leak</div>
                            <p class="text-xs text-slate-600 leading-normal">
                                Endpoint ujian hanya menyajikan array pilihan tanpa atribut validasi kebenaran, meniadakan kecurangan inspect element.
                            </p>
                        </div>

                        <div class="p-6 rounded-2xl border border-slate-200 bg-slate-50 space-y-2">
                            <span class="text-xs font-mono font-bold text-slate-400 uppercase tracking-wider block">03 · TRAFFIC CONTROLS</span>
                            <div class="text-2xl font-black text-[#0A090B]">Dual-Tier Throttling</div>
                            <p class="text-xs text-slate-600 leading-normal">
                                Pembatasan rate 60 request/menit untuk simpan jawaban dan 10 request/menit untuk penyerahan akhir ujian.
                            </p>
                        </div>

                        <div class="p-6 rounded-2xl border border-slate-200 bg-slate-50 space-y-2">
                            <span class="text-xs font-mono font-bold text-slate-400 uppercase tracking-wider block">04 · KONSISTENSI DATA</span>
                            <div class="text-2xl font-black text-[#0A090B]">DB::transaction</div>
                            <p class="text-xs text-slate-600 leading-normal">
                                Rekapitulasi nilai dan penguncian sesi dieksekusi secara atomik untuk mencegah inkonsistensi data skor.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Workspace Showcase: Naiju Studio vs Naiju Exam -->
            <section id="ruang-kerja" class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl mb-10 space-y-2">
                    <div class="text-xs font-bold uppercase tracking-wider text-slate-500">
                        Pemisahan Ruang Lingkup
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-black text-[#0A090B] tracking-tight">
                        Lingkungan Pengajar dan Siswa yang Terisolasi
                    </h2>
                    <p class="text-sm text-slate-600">
                        Akses sistem dibagi tegas berdasarkan peran pengguna guna memastikan pengajar memiliki kontrol penuh atas bank materi dan siswa fokus mengerjakan ujian.
                    </p>
                </div>

                <!-- Workspace Role Tab Controls -->
                <div class="flex items-center gap-3 mb-8 border-b border-slate-200">
                    <button
                        type="button"
                        @click="activeWorkspaceTab = 'studio'"
                        :class="[
                            'pb-3.5 px-4 text-sm font-bold border-b-2 transition-colors flex items-center gap-2',
                            activeWorkspaceTab === 'studio'
                                ? 'border-[#D95300] text-[#D95300]'
                                : 'border-transparent text-slate-500 hover:text-slate-800'
                        ]"
                    >
                        <span>Naiju Studio (Ruang Pengajar)</span>
                    </button>
                    <button
                        type="button"
                        @click="activeWorkspaceTab = 'exam'"
                        :class="[
                            'pb-3.5 px-4 text-sm font-bold border-b-2 transition-colors flex items-center gap-2',
                            activeWorkspaceTab === 'exam'
                                ? 'border-[#2B82FE] text-[#2B82FE]'
                                : 'border-transparent text-slate-500 hover:text-slate-800'
                        ]"
                    >
                        <span>Naiju Exam (Portal Siswa)</span>
                    </button>
                </div>

                <!-- Teacher Workspace Live Showcase -->
                <div v-if="activeWorkspaceTab === 'studio'" class="grid lg:grid-cols-12 gap-8 items-start">
                    <div class="lg:col-span-7 bg-white rounded-2xl border border-slate-300 p-6 sm:p-7 space-y-6 shadow-xs">
                        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                            <div>
                                <span class="text-xs font-mono font-bold text-[#D95300] uppercase tracking-wider">KURSUS AKTIF</span>
                                <h3 class="text-lg font-bold text-slate-900">Rekayasa Web &amp; Arsitektur Backend</h3>
                            </div>
                            <span class="text-xs font-semibold px-2.5 py-1 bg-[#FFF4EC] text-[#D95300] rounded-lg border border-[#FED7AA]">
                                Pengajar: Jackson, S.Kom
                            </span>
                        </div>

                        <!-- Teacher Overview Mock Controls -->
                        <div class="grid grid-cols-3 gap-3 text-center">
                            <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">
                                <span class="text-xs text-slate-500 font-medium block">Bank Soal</span>
                                <span class="text-lg font-bold text-slate-900">50 Butir</span>
                            </div>
                            <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">
                                <span class="text-xs text-slate-500 font-medium block">Peserta Terdaftar</span>
                                <span class="text-lg font-bold text-slate-900">42 Siswa</span>
                            </div>
                            <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">
                                <span class="text-xs text-slate-500 font-medium block">Standar KKM</span>
                                <span class="text-lg font-bold text-emerald-700">70 Poin</span>
                            </div>
                        </div>

                        <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl space-y-2">
                            <div class="flex items-center justify-between text-xs font-semibold">
                                <span class="text-slate-700">Status Validasi Bank Soal:</span>
                                <span class="text-emerald-700 font-bold">100% Lengkap (50 dari 50 soal terverifikasi)</span>
                            </div>
                            <div class="w-full bg-slate-200 h-2 rounded-full overflow-hidden">
                                <div class="bg-[#D95300] h-full w-full"></div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-5 space-y-4">
                        <div class="bg-white p-5 rounded-xl border border-slate-200 space-y-1.5 shadow-xs">
                            <h4 class="text-sm font-bold text-slate-900">Isolasi Kepemilikan Materi</h4>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Setiap pengajar hanya memiliki hak akses penuh terhadap kursus yang diciptakannya (<code class="bg-slate-100 px-1 py-0.5 rounded text-xs">teacher_id = auth()->id()</code>), menjaga kerahasiaan materi antar-instruktur.
                            </p>
                        </div>
                        <div class="bg-white p-5 rounded-xl border border-slate-200 space-y-1.5 shadow-xs">
                            <h4 class="text-sm font-bold text-slate-900">Kontrol Enrolment Siswa</h4>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Hanya peserta didik yang didaftarkan ke tabel pivot kursus yang dapat memulai sesi asesmen resmi.
                            </p>
                        </div>
                        <div class="bg-white p-5 rounded-xl border border-slate-200 space-y-1.5 shadow-xs">
                            <h4 class="text-sm font-bold text-slate-900">Analitik Kelulusan Otomatis</h4>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Grafik performa nilai rata-rata, rasio kelulusan KKM, dan distribusi skor tersedia langsung tanpa rekap manual.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Student Workspace Live Showcase -->
                <div v-else class="grid lg:grid-cols-12 gap-8 items-start">
                    <div class="lg:col-span-7 bg-white rounded-2xl border border-slate-300 p-6 sm:p-7 space-y-6 shadow-xs">
                        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                            <div>
                                <span class="text-xs font-mono font-bold text-[#2B82FE] uppercase tracking-wider">HASIL UJIAN SISWA</span>
                                <h3 class="text-lg font-bold text-slate-900">Lembar Rapor Digital (learning_rapport)</h3>
                            </div>
                            <span class="text-xs font-semibold px-2.5 py-1 bg-emerald-50 text-emerald-800 rounded-lg border border-emerald-200">
                                Status: Tuntas / Lulus KKM
                            </span>
                        </div>

                        <!-- Score Metric Badge -->
                        <div class="flex items-center gap-6 p-4 bg-slate-50 border border-slate-200 rounded-xl">
                            <div class="w-20 h-20 bg-emerald-600 text-white rounded-2xl flex flex-col items-center justify-center font-black shrink-0 shadow-sm">
                                <span class="text-2xl leading-none">84</span>
                                <span class="text-[10px] font-medium opacity-80 pt-1">SKOR AKHIR</span>
                            </div>
                            <div class="space-y-1 text-xs">
                                <div class="font-bold text-slate-900">Pencapaian: Melampaui Batas KKM (70)</div>
                                <p class="text-slate-500">42 jawaban benar dari total 50 butir soal (Bobot 2.0 poin per butir). Durasi pengerjaan: 38 menit 42 detik.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3 text-center text-xs">
                            <div class="p-3 bg-white border border-slate-200 rounded-xl">
                                <span class="text-slate-500 block">Jawaban Benar</span>
                                <span class="text-base font-bold text-emerald-700">42 Butir</span>
                            </div>
                            <div class="p-3 bg-white border border-slate-200 rounded-xl">
                                <span class="text-slate-500 block">Jawaban Salah</span>
                                <span class="text-base font-bold text-rose-600">8 Butir</span>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-5 space-y-4">
                        <div class="bg-white p-5 rounded-xl border border-slate-200 space-y-1.5 shadow-xs">
                            <h4 class="text-sm font-bold text-slate-900">Fokus Pengerjaan Bebas Distraksi</h4>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Antarmuka ujian dirancang tanpa elemen dekoratif berlebih agar peserta didik dapat berkonsentrasi penuh pada materi evaluasi.
                            </p>
                        </div>
                        <div class="bg-white p-5 rounded-xl border border-slate-200 space-y-1.5 shadow-xs">
                            <h4 class="text-sm font-bold text-slate-900">Perlindungan dari Gangguan Jaringan</h4>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Setiap klik opsi tersimpan asinkron ke server, memastikan progres ujian tidak terhapus apabila terjadi gangguan konektivitas lokal.
                            </p>
                        </div>
                        <div class="bg-white p-5 rounded-xl border border-slate-200 space-y-1.5 shadow-xs">
                            <h4 class="text-sm font-bold text-slate-900">Transparansi Penilaian Instan</h4>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Begitu tombol selesaikan ujian ditekan, sistem langsung memvalidasi skor akhir dan menampilkan ulasan performa belajar.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Technical Security Audit: Side-by-Side Payload Defense Proof -->
            <section id="keamanan" class="py-20 bg-[#0A090B] text-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="max-w-3xl mb-12 space-y-2">
                        <div class="text-xs font-mono font-bold uppercase tracking-wider text-amber-400">
                            Audit Integritas Data &amp; Server
                        </div>
                        <h2 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
                            Perbandingan Payload Respon JSON Ujian
                        </h2>
                        <p class="text-sm text-slate-400">
                            Mengapa sistem ujian konvensional rentan terhadap kecurangan inspect element dan bagaimana Naiju meniadakannya secara total.
                        </p>
                    </div>

                    <div class="grid lg:grid-cols-2 gap-6">
                        <!-- Payload Left: Vulnerable Architecture -->
                        <div class="bg-slate-900 border border-rose-900/40 rounded-2xl p-6 space-y-4">
                            <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                                <span class="text-xs font-mono font-bold text-rose-400 uppercase tracking-wider">
                                    Celah Rentan: Platform Konvensional
                                </span>
                                <span class="text-[11px] font-mono text-rose-300 bg-rose-950/60 px-2 py-0.5 rounded border border-rose-800/40">
                                    BOCOR VIA NETWORK TAB
                                </span>
                            </div>

                            <pre class="p-4 bg-slate-950 rounded-xl text-xs font-mono text-slate-300 overflow-x-auto leading-relaxed border border-slate-800"><code>{
  "question_id": 14,
  "options": [
    { "id": "A", "text": "...", <span class="text-rose-400 font-bold">"is_correct": false</span> },
    { "id": "B", "text": "...", <span class="text-rose-400 font-bold">"is_correct": true</span> } <span class="text-rose-500">// Kunci terbaca DevTools</span>
  ]
}</code></pre>

                            <p class="text-xs text-slate-400 leading-relaxed">
                                Aplikasi mengirim atribut validasi kebenaran langsung ke browser klien. Siswa cukup menekan tombol Inspect Element / Network Tab untuk melihat jawaban benar sebelum memilih.
                            </p>
                        </div>

                        <!-- Payload Right: Naiju Protected Architecture -->
                        <div class="bg-slate-900 border border-emerald-900/40 rounded-2xl p-6 space-y-4">
                            <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                                <span class="text-xs font-mono font-bold text-emerald-400 uppercase tracking-wider">
                                    Arsitektur Naiju: Zero-Leakage Sanitized
                                </span>
                                <span class="text-[11px] font-mono text-emerald-300 bg-emerald-950/60 px-2 py-0.5 rounded border border-emerald-800/40">
                                    QUERY-LEVEL MASKING
                                </span>
                            </div>

                            <pre class="p-4 bg-slate-950 rounded-xl text-xs font-mono text-slate-300 overflow-x-auto leading-relaxed border border-slate-800"><code>{
  "question_id": 14,
  "options": [
    { "id": "A", "text": "..." },
    { "id": "B", "text": "..." } <span class="text-emerald-400 font-bold">// Tanpa boolean kunci jawaban</span>
  ]
}</code></pre>

                            <p class="text-xs text-slate-400 leading-relaxed">
                                Query controller hanya mengambil kolom <code class="text-amber-300 bg-slate-800 px-1 py-0.5 rounded text-[11px]">['id', 'course_question_id', 'answer']</code>. Atribut penentu kunci tidak pernah meninggalkan database sampai sesi ditutup dan dievaluasi di server.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Direct Getting Started Pathways -->
            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                <div class="bg-white border border-slate-300 rounded-3xl p-8 sm:p-12 lg:p-16 shadow-xs">
                    <div class="max-w-2xl space-y-4">
                        <div class="text-xs font-bold uppercase tracking-wider text-slate-500">
                            Akses Portal Sistem
                        </div>
                        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-[#0A090B] tracking-tight">
                            Mulai Gunakan Platform Asesmen Naiju
                        </h2>
                        <p class="text-sm text-slate-600 leading-relaxed">
                            Masuk dengan akun pengajar untuk mulai mengelola kursus dan bank soal, atau masuk dengan akun peserta untuk mengikuti ujian yang telah dijadwalkan.
                        </p>

                        <div class="flex flex-col sm:flex-row gap-3 pt-4">
                            <Link
                                v-if="!$page.props.auth.user"
                                :href="route('login')"
                                class="px-6 py-3.5 bg-[#D95300] text-white text-sm font-bold rounded-xl text-center hover:bg-[#BF4900] transition-colors shadow-sm"
                            >
                                Masuk ke Akun
                            </Link>

                            <Link
                                v-if="!$page.props.auth.user && canRegister"
                                :href="route('register')"
                                class="px-6 py-3.5 bg-slate-100 text-slate-800 text-sm font-bold rounded-xl text-center hover:bg-slate-200 transition-colors"
                            >
                                Daftar Akun Peserta Baru
                            </Link>

                            <Link
                                v-if="$page.props.auth.user"
                                :href="route('dashboard')"
                                class="px-6 py-3.5 bg-[#0A090B] text-white text-sm font-bold rounded-xl text-center hover:bg-slate-800 transition-colors shadow-sm"
                            >
                                Buka Dashboard
                            </Link>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <!-- Institutional Footer -->
        <footer class="bg-white border-t border-slate-200 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                    <!-- Brand Identifier -->
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-[#D95300] rounded-lg flex items-center justify-center text-white shrink-0">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                <path d="M4 3.5H8.2L15.8 15.3V3.5H20V20.5H15.8L8.2 8.7V20.5H4V3.5Z" />
                            </svg>
                        </div>
                        <span class="font-extrabold text-base tracking-tight text-[#0A090B]">Naiju</span>
                        <span class="text-xs text-slate-500 pl-3 border-l border-slate-200">Platform Ujian &amp; Asesmen Digital</span>
                    </div>

                    <!-- Navigation Jump Links -->
                    <div class="flex flex-wrap items-center gap-6 text-xs font-semibold text-slate-600">
                        <a href="#simulasi" class="hover:text-[#D95300] transition-colors">Simulasi Ujian</a>
                        <a href="#spesifikasi" class="hover:text-[#D95300] transition-colors">Spesifikasi</a>
                        <a href="#ruang-kerja" class="hover:text-[#D95300] transition-colors">Ruang Kerja</a>
                        <a href="#keamanan" class="hover:text-[#D95300] transition-colors">Keamanan</a>
                    </div>

                    <!-- Copyright Notice -->
                    <div class="text-xs text-slate-500 font-medium">
                        &copy; {{ new Date().getFullYear() }} Naiju. Hak Cipta Dilindungi.
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>
