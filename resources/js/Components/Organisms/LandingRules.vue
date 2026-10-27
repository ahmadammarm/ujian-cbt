<script setup>
import StickyNote from '@/Components/Atoms/StickyNote.vue';
import TallyMarks from '@/Components/Atoms/TallyMarks.vue';

const tallies = [
    { count: 1, label: 'Peringatan pertama' },
    { count: 2, label: 'Peringatan kedua' },
    { count: 3, label: 'Peringatan terakhir' },
    { count: 4, label: 'Jawabanmu otomatis dikirim', isFinal: true },
];

const triggers = [
    'Keluar dari layar penuh',
    'Pindah ke tab atau aplikasi lain',
    'Klik di luar jendela ujian',
];

const disabled = ['Klik kanan', 'Salin, potong, dan tempel', 'Shortcut seperti F12 atau Ctrl+P'];
</script>

<template>
    <section id="aturan" class="scroll-mt-24 py-16 sm:py-24">
        <div class="mx-auto grid max-w-6xl items-center gap-12 px-6 sm:gap-16 sm:pl-24 sm:pr-8 lg:grid-cols-12">
            <div class="lg:col-span-5">
                <h2 class="font-hand text-3xl font-extrabold leading-tight text-ink sm:text-5xl">
                    Aturan mainnya cuma satu: tetap di halaman ujian.
                </h2>
                <p class="mt-4 font-legible text-base leading-8 text-ink-soft">
                    Bukan buat menakut-nakuti. Aturan ini ada supaya nilai yang jujur tidak kalah dengan yang mencontek.
                </p>

                <div class="mt-8 grid gap-8 sm:grid-cols-2 lg:grid-cols-1">
                    <div>
                        <h3 class="font-form text-xs font-semibold uppercase tracking-[0.16em] text-pen">Dihitung pelanggaran</h3>
                        <ul class="mt-2 space-y-1">
                            <li v-for="item in triggers" :key="item" class="font-legible text-base leading-8 text-ink">{{ item }}</li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-form text-xs font-semibold uppercase tracking-[0.16em] text-pen">Dimatikan selama ujian</h3>
                        <ul class="mt-2 space-y-1">
                            <li v-for="item in disabled" :key="item" class="font-legible text-base leading-8 text-ink">{{ item }}</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Sticky note with tally marks -->
            <div class="lg:col-span-6 lg:col-start-7">
                <StickyNote>

                    <p class="font-hand text-2xl font-bold">Hitung pelanggaranmu</p>

                    <ol class="mt-6 space-y-4">
                        <li v-for="tally in tallies" :key="tally.count" class="flex items-center gap-5">
                            <TallyMarks :count="tally.count" :highlight-last="tally.isFinal" class="w-16 shrink-0" />
                            <span :class="['font-hand text-xl', tally.isFinal ? 'font-extrabold text-pen' : 'font-semibold']">
                                <span class="sr-only">Pelanggaran ke-{{ tally.count }}: </span>{{ tally.label }}
                            </span>
                        </li>
                    </ol>

                    <p class="mt-8 font-legible text-sm leading-6 text-graphite/80">
                        Peringatan muncul di layar, jadi kamu selalu tahu sudah berapa kali. Jawaban yang sudah kamu isi tetap dinilai.
                    </p>
                </StickyNote>
            </div>
        </div>
    </section>
</template>
