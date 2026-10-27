<script setup>
const steps = [
    {
        title: 'Masuk pakai akun dari gurumu.',
        detail: 'Email dan password biasanya dibagikan wali kelas atau guru mapel.',
    },
    {
        title: 'Buka menu Kursus & Ujian, lalu tekan Mulai Ujian.',
        detail: 'Hanya mapel yang kamu ikuti yang muncul di sini.',
    },
    {
        title: 'Nyalakan layar penuh.',
        detail: 'Soal baru tampil setelah layar penuh aktif. Waktu mulai dihitung sejak kamu menekan Mulai Ujian.',
    },
    {
        title: 'Jawab soal sesuai urutanmu sendiri.',
        detail: 'Loncat ke nomor mana pun lewat daftar nomor soal. Sisa waktu selalu terlihat di atas.',
    },
    {
        title: 'Tekan Selesaikan Ujian.',
        detail: 'Sebelum terkirim, kamu bisa melihat dulu nomor mana saja yang belum dijawab.',
    },
    {
        title: 'Lihat nilaimu.',
        detail: 'Skor, status lulus (batasnya 70), dan lama pengerjaan langsung muncul.',
    },
];
</script>

<template>
    <section id="persiapan" class="scroll-mt-24 py-16 sm:py-24">
        <div class="mx-auto grid max-w-6xl gap-12 px-6 sm:pl-24 sm:pr-8 lg:grid-cols-12">
            <div class="lg:col-span-4">
                <h2 class="font-hand text-3xl font-extrabold leading-tight text-ink sm:text-5xl">
                    Hari ujian, satu per satu.
                </h2>
                <p class="mt-4 font-legible text-base leading-8 text-ink-soft">
                    Begini urutannya dari masuk sampai nilai keluar, biar tidak ada yang bikin kaget.
                </p>
            </div>

            <ol class="space-y-6 sm:space-y-8 lg:col-span-8">
                <li v-for="step in steps" :key="step.title" class="flex gap-4 sm:gap-5">
                    <span aria-hidden="true" class="relative mt-1 flex size-6 shrink-0 items-center justify-center rounded-[4px] border-2 border-ink/70">
                        <svg class="absolute -top-2 left-0 size-8 text-pen" viewBox="0 0 32 32" fill="none">
                            <path d="M6 17c3 2 5 5 6 8 4-9 9-15 16-21" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    <div>
                        <p class="font-legible text-base font-bold leading-7 text-ink sm:text-lg sm:leading-8">{{ step.title }}</p>
                        <p class="font-legible text-sm leading-7 text-ink-soft sm:text-base sm:leading-8">{{ step.detail }}</p>
                    </div>
                </li>
            </ol>
        </div>
    </section>
</template>
