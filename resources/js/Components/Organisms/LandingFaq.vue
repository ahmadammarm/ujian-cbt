<script setup>
import { ref } from 'vue';

const activeFaqIndex = ref(null);
const isStoryExpanded = ref(false);

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
    <section id="faq" class="py-16 sm:py-24 bg-slate-50/80 dark:bg-[#0E0E12] border-b border-slate-200/80 dark:border-slate-800 transition-colors">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
            <!-- FAQ Header & Accordion -->
            <div>
                <div class="text-center max-w-3xl mx-auto mb-12 space-y-3">
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-[#0A090B] dark:text-white tracking-tight">
                        Pertanyaan Seputar Platform CBT Naiju
                    </h2>
                    <p class="text-sm sm:text-base text-slate-600 dark:text-slate-400 font-normal leading-relaxed">
                        Jawaban teknis dan operasional mengenai implementasi ujian online berbasis komputer di sekolah dan madrasah.
                    </p>
                </div>

                <div class="space-y-3">
                    <div
                        v-for="(faq, idx) in faqs"
                        :key="idx"
                        class="bg-white dark:bg-[#111116] rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-xs transition-colors"
                    >
                        <button
                            type="button"
                            @click="toggleFaq(idx)"
                            class="w-full p-5 sm:p-6 text-left flex items-center justify-between gap-4 font-bold text-slate-900 dark:text-white hover:text-[#D95300] dark:hover:text-orange-400 transition-colors cursor-pointer"
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
                            v-if="activeFaqIndex === idx"
                            class="px-5 sm:px-6 pb-6 pt-0 text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed border-t border-slate-100 dark:border-slate-800/80 mt-1"
                        >
                            {{ faq.a }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Architecture & Operating Specification Box -->
            <div class="p-6 sm:p-8 bg-slate-100/70 dark:bg-[#111116] rounded-3xl border border-slate-200/90 dark:border-slate-800 space-y-3">
                <h3 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white">
                    Spesifikasi Platform Ujian &amp; Asesmen Digital CBT Naiju
                </h3>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed font-normal">
                    Naiju CBT dirancang untuk menjawab tantangan evaluasi akademik sekolah secara terstruktur dan efisien. Sistem mengombinasikan proctoring penegakan layar penuh (fullscreen lock), pencegahan manipulasi kode peramban di sisi server, serta pelaporan kelulusan berbasis KKM 70% yang terverifikasi.
                </p>

                <div v-if="isStoryExpanded" class="pt-2 text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed font-normal space-y-2 animate-fade-in">
                    <p>
                        Melalui dua ruang kerja terpisah — <strong>Naiju Studio</strong> untuk pengajar dan <strong>Naiju Exam</strong> untuk siswa — pengajar memiliki kendali terisolasi atas paket soal pilihan ganda, alokasi waktu hitung mundur, dan pengawasan kehadiran siswa secara terpusat tanpa kerumitan pencetakan fisik.
                    </p>
                    <p>
                        Arsitektur backend Laravel 11 mengamankan kunci jawaban tanpa pernah menyertakannya dalam payload browser siswa, memastikan setiap ujian berlangsung objektif, tertib, dan dapat dipertanggungjawabkan.
                    </p>
                </div>

                <button
                    type="button"
                    @click="isStoryExpanded = !isStoryExpanded"
                    class="inline-flex items-center gap-1.5 text-xs font-bold text-[#D95300] dark:text-orange-400 hover:underline pt-2 cursor-pointer"
                >
                    <span>{{ isStoryExpanded ? 'Tutup Spesifikasi' : 'Baca Spesifikasi Lengkap' }}</span>
                    <svg
                        :class="['w-4 h-4 transition-transform duration-200', isStoryExpanded ? 'rotate-180' : '']"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            </div>
        </div>
    </section>
</template>
