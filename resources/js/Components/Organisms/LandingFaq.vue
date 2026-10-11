<script setup>
import { ref } from 'vue';

const activeFaqIndex = ref(null);

const toggleFaq = (index) => {
    activeFaqIndex.value = activeFaqIndex.value === index ? null : index;
};

const faqs = [
    {
        q: 'Apakah aplikasi ujian CBT Naiju bisa diakses dari HP atau laptop siswa?',
        a: 'Ya. Antarmuka Naiju dirancang responsif dan ringan, sehingga siswa dapat mengerjakan ujian dengan lancar menggunakan laptop, komputer laboratorium sekolah, tablet, maupun smartphone tanpa perlu mengunduh aplikasi tambahan.',
    },
    {
        q: 'Bagaimana jika koneksi internet siswa terputus saat ujian berlangsung?',
        a: 'Sistem Naiju menerapkan penyimpanan otomatis (auto-save) setiap kali opsi jawaban dipilih. Jika koneksi terputus atau baterai habis, siswa dapat masuk kembali dan melanjutkan ujian tanpa kehilangan jawaban yang telah tersimpan.',
    },
    {
        q: 'Apakah pengajar bisa membuat bank soal dan mengatur waktu ujian sendiri?',
        a: 'Tentu saja. Melalui portal Naiju Studio, setiap guru dan dosen memiliki kendali penuh untuk menyusun paket soal pilihan ganda, menentukan bobot penilaian, durasi hitung mundur, serta memilih kelas siswa yang berhak mengikuti ujian.',
    },
    {
        q: 'Apakah hasil ujian dan rekap nilai siswa langsung keluar setelah ujian selesai?',
        a: 'Ya. Segera setelah siswa menekan tombol selesaikan ujian, sistem mengoreksi lembar jawaban secara otomatis dan menyajikan perolehan skor akhir serta lembar evaluasi hasil belajar secara instan.',
    },
    {
        q: 'Apakah platform ujian ini aman dari kecurangan inspect element browser?',
        a: 'Sangat aman. Kunci jawaban tidak pernah dikirimkan ke browser siswa saat sesi ujian berlangsung. Seluruh proses validasi dan penilaian dieksekusi secara terproteksi di sisi server.',
    },
];
</script>

<template>
    <section id="faq" class="py-20 bg-slate-50 dark:bg-[#0E0E12] border-b border-slate-200 dark:border-slate-800 transition-colors">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mb-12 space-y-2">
                <div class="text-xs font-bold uppercase tracking-wider text-[#D95300]">
                    Tanya Jawab Seputar CBT
                </div>
                <h2 class="text-2xl sm:text-3xl font-black text-[#0A090B] dark:text-white tracking-tight">
                    Pertanyaan Seputar Aplikasi CBT Naiju
                </h2>
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    Jawaban lengkap atas pertanyaan yang sering diajukan mengenai implementasi ujian online di sekolah, madrasah, dan kampus.
                </p>
            </div>

            <div class="space-y-3">
                <div
                    v-for="(faq, idx) in faqs"
                    :key="idx"
                    class="bg-white dark:bg-[#111116] rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden transition-colors"
                >
                    <button
                        type="button"
                        @click="toggleFaq(idx)"
                        class="w-full p-5 sm:p-6 text-left flex items-center justify-between gap-4 font-bold text-slate-900 dark:text-white hover:text-[#D95300] dark:hover:text-[#D95300] transition-colors cursor-pointer"
                    >
                        <span class="text-sm sm:text-base leading-snug">{{ faq.q }}</span>
                        <span
                            :class="[
                                'w-7 h-7 rounded-lg flex items-center justify-center shrink-0 border transition-transform duration-200',
                                activeFaqIndex === idx
                                    ? 'bg-[#D95300] border-[#BF4900] text-white rotate-180'
                                    : 'bg-slate-100 dark:bg-slate-800 border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300'
                            ]"
                        >
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </span>
                    </button>

                    <div
                        v-show="activeFaqIndex === idx"
                        class="px-5 sm:px-6 pb-6 pt-1 text-sm text-slate-600 dark:text-slate-400 leading-relaxed border-t border-slate-100 dark:border-slate-800/60"
                    >
                        {{ faq.a }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
