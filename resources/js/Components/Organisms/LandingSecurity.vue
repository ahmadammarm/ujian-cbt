<script setup>
</script>

<template>
    <section id="keamanan" class="py-16 sm:py-24 bg-[#0A090B] text-white transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Center Header -->
            <div class="text-center max-w-3xl mx-auto mb-14 space-y-3">
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight text-white">
                    Bebas Bocor: Kunci Jawaban Tidak Pernah Dikirim ke Komputer Siswa
                </h2>
                <p class="text-sm sm:text-base text-slate-400 font-normal leading-relaxed">
                    Bandingkan bagaimana aplikasi CBT konvensional rentan dibobol dengan Inspect Element browser, dan bagaimana arsitektur Naiju melindunginya secara mutlak.
                </p>
            </div>

            <!-- Comparison Grid -->
            <div class="grid lg:grid-cols-2 gap-6 sm:gap-8">
                <!-- Payload Left: Vulnerable Architecture -->
                <div class="bg-slate-900/90 border border-rose-900/40 rounded-3xl p-6 sm:p-8 space-y-4 shadow-xl">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                        <span class="text-xs font-mono font-bold text-rose-400 uppercase tracking-wider">
                            Celah Rentan: Aplikasi CBT Biasa
                        </span>
                        <span class="text-[11px] font-mono font-bold text-rose-300 bg-rose-950/70 px-2.5 py-1 rounded-full border border-rose-800/40">
                            KUNCI BOCOR DI BROWSER
                        </span>
                    </div>

                    <pre class="p-4 sm:p-5 bg-slate-950 rounded-2xl text-xs font-mono text-slate-300 overflow-x-auto leading-relaxed border border-slate-800"><code>{
  "question_id": 14,
  "options": [
    { "id": "A", "text": "...", <span class="text-rose-400 font-bold">"is_correct": false</span> },
    { "id": "B", "text": "...", <span class="text-rose-400 font-bold">"is_correct": true</span> } <span class="text-rose-500">// Kunci terbaca via Inspect Element</span>
  ]
}</code></pre>

                    <p class="text-xs sm:text-sm text-slate-400 leading-relaxed font-normal">
                        Banyak aplikasi konvensional mengirim tanda benar/salah langsung ke browser siswa. Siswa yang paham teknologi dapat membuka menu Inspect Element (F12) untuk menyontek kunci jawaban sebelum memilih opsi.
                    </p>
                </div>

                <!-- Payload Right: Naiju Protected Architecture -->
                <div class="bg-slate-900/90 border border-emerald-900/40 rounded-3xl p-6 sm:p-8 space-y-4 shadow-xl">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                        <span class="text-xs font-mono font-bold text-emerald-400 uppercase tracking-wider">
                            Proteksi Server-Side Naiju
                        </span>
                        <span class="text-[11px] font-mono font-bold text-emerald-300 bg-emerald-950/70 px-2.5 py-1 rounded-full border border-emerald-800/40">
                            100% BEBAS DARI BOCOR
                        </span>
                    </div>

                    <pre class="p-4 sm:p-5 bg-slate-950 rounded-2xl text-xs font-mono text-slate-300 overflow-x-auto leading-relaxed border border-slate-800"><code>{
  "question_id": 14,
  "options": [
    { "id": "A", "text": "..." },
    { "id": "B", "text": "..." } <span class="text-emerald-400 font-bold">// Tanpa data kunci jawaban</span>
  ]
}</code></pre>

                    <p class="text-xs sm:text-sm text-slate-400 leading-relaxed font-normal">
                        Server Naiju memfilter data dan hanya mengirimkan teks soal serta pilihan jawaban ke komputer siswa. Kunci jawaban tetap aman di server hingga ujian dikumpulkan dan dikoreksi otomatis.
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>
