<script setup>
const faqs = [
    {
        q: 'Aku lupa password. Gimana?',
        a: 'Tekan "Lupa password?" di halaman masuk, lalu cek email untuk tautan reset. Kalau emailnya tidak sampai, minta guru atau wali kelas mengecek akunmu.',
    },
    {
        q: 'Halaman ke-refresh atau internet putus di tengah ujian. Jawabanku hilang?',
        a: 'Tidak. Jawabanmu disimpan di browser perangkat yang kamu pakai. Buka lagi ujiannya dari perangkat dan browser yang sama untuk melanjutkan. Waktunya tetap berjalan, jadi jangan lama-lama.',
    },
    {
        q: 'Bisa ngerjain dari HP?',
        a: 'Bisa lewat browser, tapi laptop atau komputer lebih nyaman karena soal dan pilihan jawabannya lebih lega. Pakai Chrome, Edge, atau Firefox versi terbaru supaya mode layar penuh berjalan normal.',
    },
    {
        q: 'Kapan nilaiku keluar?',
        a: 'Begitu kamu menekan Selesaikan Ujian. Kamu lulus kalau skornya 70 atau lebih.',
    },
    {
        q: 'Kenapa aku tidak bisa salin-tempel atau klik kanan?',
        a: 'Fitur itu dimatikan selama ujian supaya soal tidak keluar dari halaman dan semua peserta mengerjakan dengan cara yang sama.',
    },
    {
        q: 'Aku guru. Masuknya lewat mana?',
        a: 'Lewat tombol Masuk yang sama. Akun guru otomatis diarahkan ke Naiju Studio untuk mengatur soal, siswa, dan nilai.',
    },
];
</script>

<template>
    <section id="tanya" class="scroll-mt-24 py-16 sm:py-24">
        <div class="mx-auto max-w-6xl px-6 sm:pl-24 sm:pr-8">
            <h2 class="font-hand text-3xl font-extrabold leading-tight text-ink sm:text-5xl">
                Yang sering ditanyain.
            </h2>

            <div class="mt-10 max-w-3xl divide-y divide-rule border-y border-rule">
                <details v-for="faq in faqs" :key="faq.q" class="group">
                    <summary class="flex cursor-pointer list-none items-start justify-between gap-4 py-4 font-legible text-base font-bold leading-7 sm:gap-6 sm:py-5 sm:text-lg sm:leading-8 text-ink marker:hidden focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pen [&::-webkit-details-marker]:hidden">
                        <span>{{ faq.q }}</span>
                        <span aria-hidden="true" class="mt-1 font-hand text-2xl leading-none text-pen transition-transform group-open:rotate-45 motion-reduce:transition-none">+</span>
                    </summary>
                    <p class="pb-5 pr-6 font-legible text-sm leading-7 sm:pb-6 sm:pr-10 sm:text-base sm:leading-8 text-ink-soft">
                        {{ faq.a }}
                    </p>
                </details>
            </div>
        </div>
    </section>
</template>
