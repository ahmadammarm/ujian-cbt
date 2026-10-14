<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';

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
            { id: 'C', text: 'Klien tidak memiliki hak akses/otorisasi terhadap resource meskipun telah terautentikasi' },
            { id: 'D', text: 'Format request JSON tidak valid secara sintaksis' },
        ],
        selected: 'C',
        isFlagged: false,
    },
    {
        num: 6,
        title: 'Dalam CSS modern, properti apakah yang digunakan untuk mengatur perataan item secara vertikal di sepanjang cross-axis pada flex container?',
        options: [
            { id: 'A', text: 'justify-content' },
            { id: 'B', text: 'align-items' },
            { id: 'C', text: 'flex-direction' },
            { id: 'D', text: 'flex-wrap' },
        ],
        selected: 'B',
        isFlagged: false,
    },
    {
        num: 7,
        title: 'Manakah fitur JavaScript ES6 yang memungkinkan ekstraksi nilai dari array atau properti objek ke dalam variabel terpisah secara ringkas?',
        options: [
            { id: 'A', text: 'Destructuring Assignment' },
            { id: 'B', text: 'Prototypal Inheritance' },
            { id: 'C', text: 'Event Bubbling' },
            { id: 'D', text: 'Hoisting' },
        ],
        selected: 'A',
        isFlagged: false,
    },
    {
        num: 8,
        title: 'Pada protokol TCP/IP, proses three-way handshake saat inisiasi koneksi terdiri dari pertukaran paket:',
        options: [
            { id: 'A', text: 'FIN, FIN-ACK, ACK' },
            { id: 'B', text: 'SYN, SYN-ACK, ACK' },
            { id: 'C', text: 'PING, PONG, ACK' },
            { id: 'D', text: 'RST, ACK, FIN' },
        ],
        selected: 'B',
        isFlagged: false,
    },
    {
        num: 9,
        title: 'Apa fungsi utama dari git rebase dalam manajemen version control?',
        options: [
            { id: 'A', text: 'Menghapus commit history secara permanen' },
            { id: 'B', text: 'Memindahkan atau mengaplikasikan kembali serangkaian commit ke basis commit baru secara linier' },
            { id: 'C', text: 'Mengunggah file biner ke server FTP jarak jauh' },
            { id: 'D', text: 'Mengunci repository agar tidak dapat diubah developer lain' },
        ],
        selected: 'B',
        isFlagged: false,
    },
    {
        num: 10,
        title: 'Dalam normalisasi database, bentuk normal ketiga (3NF) mensyaratkan bahwa tabel harus memenuhi 2NF dan:',
        options: [
            { id: 'A', text: 'Memiliki minimal dua primary key dalam satu tabel' },
            { id: 'B', text: 'Tidak memiliki ketergantungan transitif (non-prime attributes tidak bergantung pada non-prime attributes lain)' },
            { id: 'C', text: 'Setiap kolom hanya boleh menyimpan tipe data teks string' },
            { id: 'D', text: 'Semua foreign key harus diindeks dengan B+ Tree ganda' },
        ],
        selected: 'B',
        isFlagged: false,
    },
    {
        num: 11,
        title: 'Perintah SQL manakah yang tergolong ke dalam Data Definition Language (DDL)?',
        options: [
            { id: 'A', text: 'INSERT INTO' },
            { id: 'B', text: 'SELECT WHERE' },
            { id: 'C', text: 'ALTER TABLE' },
            { id: 'D', text: 'UPDATE SET' },
        ],
        selected: 'C',
        isFlagged: false,
    },
    {
        num: 12,
        title: 'Apa keuntungan utama penggunaan Redis sebagai in-memory data store dibandingkan database disk relasional konvensional?',
        options: [
            { id: 'A', text: 'Mendukung query join kompleks di puluhan tabel relasional' },
            { id: 'B', text: 'Latensi pembacaan dan penulisan sub-milidetik karena data disimpan langsung di RAM' },
            { id: 'C', text: 'Kapasitas penyimpanan tidak terbatas tanpa memerlukan hardware server' },
            { id: 'D', text: 'Dapat dijalankan tanpa sistem operasi Linux atau Windows' },
        ],
        selected: 'B',
        isFlagged: false,
    },
    {
        num: 13,
        title: 'Manakah dari berikut ini yang merupakan karakteristik utama arsitektur Microservices?',
        options: [
            { id: 'A', text: 'Seluruh modul aplikasi dibangun dalam satu basis kode dan basis data monolitik tunggal' },
            { id: 'B', text: 'Layanan didekomposisi berdasarkan domain bisnis mandiri dengan basis data dan proses deploy terpisah' },
            { id: 'C', text: 'Semua layanan wajib ditulis menggunakan satu bahasa pemrograman yang sama persis' },
            { id: 'D', text: 'Tidak memerlukan jaringan internet untuk berkomunikasi antar service' },
        ],
        selected: 'B',
        isFlagged: false,
    },
    {
        num: 14,
        title: 'Dalam perancangan REST API, HTTP method manakah yang paling tepat digunakan untuk memperbarui sebagian (partial update) field dari suatu resource?',
        options: [
            { id: 'A', text: 'GET' },
            { id: 'B', text: 'PUT' },
            { id: 'C', text: 'PATCH' },
            { id: 'D', text: 'POST' },
        ],
        selected: 'C',
        isFlagged: false,
    },
    {
        num: 15,
        title: 'Prinsip SOLID manakah yang menyatakan bahwa suatu kelas turunan harus dapat menggantikan kelas induknya tanpa mengubah kebenaran program?',
        options: [
            { id: 'A', text: 'Single Responsibility Principle' },
            { id: 'B', text: 'Open/Closed Principle' },
            { id: 'C', text: 'Liskov Substitution Principle' },
            { id: 'D', text: 'Dependency Inversion Principle' },
        ],
        selected: 'C',
        isFlagged: false,
    },
    {
        num: 16,
        title: 'Konsep reactive state pada Vue 3 Composition API umumnya diinisialisasi menggunakan:',
        options: [
            { id: 'A', text: 'ref() atau reactive()' },
            { id: 'B', text: 'document.querySelector()' },
            { id: 'C', text: 'window.localStorage' },
            { id: 'D', text: 'eval()' },
        ],
        selected: 'A',
        isFlagged: false,
    },
    {
        num: 17,
        title: 'Untuk mencegah serangan SQL Injection pada aplikasi web modern, pendekatan standar yang wajib diterapkan adalah:',
        options: [
            { id: 'A', text: 'Menggabungkan input pengguna langsung menggunakan konkatenasi string' },
            { id: 'B', text: 'Menggunakan Prepared Statements dan Parameterized Queries (PDO/ORM)' },
            { id: 'C', text: 'Mengubah nama database secara berkala' },
            { id: 'D', text: 'Menghapus seluruh kolom bernilai numerik pada database' },
        ],
        selected: 'B',
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
    <div id="simulasi" class="relative">
        <!-- Precision Device Hardware Chassis (Authentic School Lab Computer / Tablet Frame) -->
        <div class="p-3 sm:p-4 bg-[#0A090B] rounded-[28px] border border-white/20 dark:border-slate-800 shadow-2xl shadow-black/50 transition-all">
            <!-- Hardware Bezel Top Sensor & Camera Dot -->
            <div class="hidden sm:flex items-center justify-between px-2 pb-2.5 text-[10px] text-slate-400 font-mono">
                <div class="flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>PROCTORING CLIENT: ACTIVE</span>
                </div>
                <!-- Camera dot -->
                <div class="w-2 h-2 rounded-full bg-slate-800 border border-slate-700/80"></div>
                <div>SECURE CBT TERMINAL</div>
            </div>

            <div class="bg-white dark:bg-[#111116] rounded-2xl border border-slate-200 dark:border-slate-800 shadow-md overflow-hidden transition-colors">
                <!-- Institutional Exam App Header -->
                <div class="px-5 py-3 bg-[#0A090B] dark:bg-black text-white flex flex-wrap items-center justify-between gap-3 border-b border-slate-800">
                    <div class="flex items-center gap-2.5">
                        <div class="w-2.5 h-2.5 rounded-full bg-emerald-400"></div>
                        <span class="text-xs font-mono font-bold tracking-wider text-slate-200">NAIJU CBT · CLIENT SIMULATOR</span>
                        <span class="hidden sm:inline text-xs text-slate-400 border-l border-slate-700 pl-2.5">Mata Uji: Rekayasa Web</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <div class="px-2.5 py-1 bg-slate-800 border border-slate-700 rounded text-xs font-mono font-bold text-emerald-400">
                            Sisa: {{ formattedTime }}
                        </div>
                        <span class="text-[11px] font-semibold text-slate-400">50 Soal</span>
                    </div>
                </div>

                <!-- Session Meta Bar & Real-Time Sync Indicator -->
                <div class="px-5 py-2.5 bg-slate-50 dark:bg-slate-900/90 border-b border-slate-200 dark:border-slate-800 flex flex-wrap items-center justify-between gap-2 text-xs text-slate-600 dark:text-slate-400">
                    <div class="flex items-center gap-2">
                        <span>Peserta: <strong class="text-slate-900 dark:text-slate-100 font-semibold">Ahmad Ammar</strong> (ID #ST-0042)</span>
                    </div>

                    <!-- Live Auto-Save Indicator -->
                    <div class="flex items-center gap-2 font-mono text-[11px]">
                        <span v-if="isSaving" class="text-amber-600 dark:text-amber-400 font-semibold flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                            Menyimpan jawaban...
                        </span>
                        <span v-else class="text-emerald-700 dark:text-emerald-400 font-semibold flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                            Tersimpan ({{ lastSavedTime }})
                        </span>
                    </div>
                </div>

                <!-- Progress Meter -->
                <div class="w-full bg-slate-100 dark:bg-slate-800 h-1">
                    <div
                        class="bg-emerald-500 h-full transition-all duration-300"
                        :style="{ width: `${progressPercentage}%` }"
                    ></div>
                </div>

                <!-- Interactive Question Workspace -->
                <div class="p-5 sm:p-6 space-y-5">
                    <!-- Question Prompt & Points -->
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold uppercase tracking-wider text-[#D95300] dark:text-orange-400">
                                Butir Soal {{ currentQuestion.num }} dari 50
                            </span>
                            <span class="text-xs font-semibold px-2 py-0.5 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded border border-slate-200 dark:border-slate-700">
                                Bobot: 2.0 Poin
                            </span>
                        </div>
                        <p class="text-sm sm:text-base font-bold text-[#0A090B] dark:text-white leading-relaxed">
                            {{ currentQuestion.title }}
                        </p>
                    </div>

                    <!-- Interactive Multiple Choice Options -->
                    <div class="space-y-2">
                        <div
                            v-for="opt in currentQuestion.options"
                            :key="opt.id"
                            @click="selectAnswer(opt.id)"
                            :class="[
                                'p-3 rounded-xl border text-xs sm:text-sm flex items-start gap-3 cursor-pointer transition-all',
                                currentQuestion.selected === opt.id
                                    ? 'bg-orange-50/80 dark:bg-[#D95300]/15 border-[#D95300] dark:border-[#D95300] text-slate-900 dark:text-white shadow-xs'
                                    : 'bg-slate-50/70 dark:bg-slate-900/60 border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700 text-slate-700 dark:text-slate-300'
                            ]"
                        >
                            <span
                                :class="[
                                    'w-6 h-6 rounded-lg flex items-center justify-center font-bold text-xs shrink-0 transition-colors',
                                    currentQuestion.selected === opt.id
                                        ? 'bg-[#D95300] text-white'
                                        : 'bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-300'
                                ]"
                            >
                                {{ opt.id }}
                            </span>
                            <span class="pt-0.5 leading-relaxed">{{ opt.text }}</span>
                        </div>
                    </div>

                    <!-- Action Controls & Flag Toggle -->
                    <div class="pt-3 border-t border-slate-200 dark:border-slate-800 flex flex-wrap items-center justify-between gap-3 text-xs">
                        <button
                            type="button"
                            @click="toggleFlag"
                            :class="[
                                'px-3 py-1.5 rounded-lg border font-semibold flex items-center gap-1.5 transition-colors cursor-pointer',
                                currentQuestion.isFlagged
                                    ? 'bg-amber-100 dark:bg-amber-950/60 border-amber-300 dark:border-amber-700 text-amber-900 dark:text-amber-200'
                                    : 'border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800'
                            ]"
                        >
                            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                                <path d="M5 21V4C5 4 7 3 12 3C17 3 19 5 19 5V14C19 14 17 12 12 12C7 12 5 14 5 14V21Z" />
                            </svg>
                            <span>{{ currentQuestion.isFlagged ? 'Ditandai Ragu' : 'Tandai Ragu' }}</span>
                        </button>

                        <div class="flex items-center gap-2">
                            <button
                                type="button"
                                @click="goToPrevious"
                                :disabled="activeQuestionNumber === 1"
                                class="px-3.5 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 font-semibold hover:bg-slate-50 dark:hover:bg-slate-800 disabled:opacity-40 disabled:cursor-not-allowed transition-colors cursor-pointer"
                            >
                                Sebelumnya
                            </button>
                            <button
                                type="button"
                                @click="goToNext"
                                :disabled="activeQuestionNumber === questions.length"
                                class="px-3.5 py-1.5 rounded-lg bg-[#0A090B] dark:bg-white text-white dark:text-[#0A090B] font-semibold hover:bg-slate-800 dark:hover:bg-slate-100 disabled:opacity-40 disabled:cursor-not-allowed transition-colors shadow-xs cursor-pointer"
                            >
                                Berikutnya
                            </button>
                        </div>
                    </div>

                    <!-- Question Sheet Navigator Palette -->
                    <div class="p-3 bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 rounded-xl space-y-2">
                        <div class="flex items-center justify-between text-xs font-semibold text-slate-600 dark:text-slate-400">
                            <span class="text-[11px]">Navigasi Soal:</span>
                            <div class="flex items-center gap-2 text-[10px]">
                                <span class="flex items-center gap-1">
                                    <span class="w-2 h-2 rounded bg-emerald-600"></span>
                                    <span>{{ answeredCount }} Terjawab</span>
                                </span>
                                <span class="flex items-center gap-1">
                                    <span class="w-2 h-2 rounded bg-amber-400"></span>
                                    <span>Ragu</span>
                                </span>
                                <span class="flex items-center gap-1">
                                    <span class="w-2 h-2 rounded bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700"></span>
                                    <span>Kosong</span>
                                </span>
                            </div>
                        </div>

                        <div class="grid grid-cols-10 gap-1 text-center">
                            <button
                                v-for="item in questions"
                                :key="item.num"
                                @click="activeQuestionNumber = item.num"
                                type="button"
                                :class="[
                                    'h-6 rounded text-[10px] font-bold flex items-center justify-center transition-colors cursor-pointer',
                                    item.num === activeQuestionNumber
                                        ? 'bg-[#D95300] text-white ring-2 ring-[#D95300]/40'
                                        : item.isFlagged
                                        ? 'bg-amber-100 dark:bg-amber-950/60 text-amber-900 dark:text-amber-200 border border-amber-300 dark:border-amber-700'
                                        : item.selected !== null
                                        ? 'bg-emerald-100 dark:bg-emerald-950/60 text-emerald-900 dark:text-emerald-200 border border-emerald-200 dark:border-emerald-800'
                                        : 'bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800'
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
</template>
