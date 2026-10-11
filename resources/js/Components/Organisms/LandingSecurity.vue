<script setup>
</script>

<template>
    <section id="keamanan" class="py-20 bg-[#0A090B] text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mb-12 space-y-2">
                <div class="text-xs font-mono font-bold uppercase tracking-wider text-amber-400">
                    Jaminan Kejujuran Ujian
                </div>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
                    Bebas Bocor: Kunci Jawaban Tidak Pernah Dikirim ke Komputer Siswa
                </h2>
                <p class="text-sm text-slate-400">
                    Bandingkan bagaimana aplikasi CBT konvensional rentan dibobol dengan Inspect Element browser, dan bagaimana sistem Naiju melindunginya secara mutlak.
                </p>
            </div>

            <div class="grid lg:grid-cols-2 gap-6">
                <!-- Payload Left: Vulnerable Architecture -->
                <div class="bg-slate-900 border border-rose-900/40 rounded-2xl p-6 space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                        <span class="text-xs font-mono font-bold text-rose-400 uppercase tracking-wider">
                            Celah Rentan: Aplikasi CBT Biasa
                        </span>
                        <span class="text-[11px] font-mono text-rose-300 bg-rose-950/60 px-2 py-0.5 rounded border border-rose-800/40">
                            KUNCI BOCOR DI BROWSER
                        </span>
                    </div>

                    <pre class="p-4 bg-slate-950 rounded-xl text-xs font-mono text-slate-300 overflow-x-auto leading-relaxed border border-slate-800"><code>{
  "question_id": 14,
  "options": [
    { "id": "A", "text": "...", <span class="text-rose-400 font-bold">"is_correct": false</span> },
    { "id": "B", "text": "...", <span class="text-rose-400 font-bold">"is_correct": true</span> } <span class="text-rose-500">// Kunci terbaca via Inspect Element</span>
  ]
}</code></pre>

                    <p class="text-xs text-slate-400 leading-relaxed">
                        Banyak aplikasi mengirim tanda benar/salah langsung ke browser siswa. Siswa yang paham teknologi dapat membuka menu Inspect Element (F12) untuk menyontek kunci jawaban sebelum memilih opsi.
                    </p>
                </div>

                <!-- Payload Right: Naiju Protected Architecture -->
                <div class="bg-slate-900 border border-emerald-900/40 rounded-2xl p-6 space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                        <span class="text-xs font-mono font-bold text-emerald-400 uppercase tracking-wider">
                            Proteksi Server-Side Naiju
                        </span>
                        <span class="text-[11px] font-mono text-emerald-300 bg-emerald-950/60 px-2 py-0.5 rounded border border-emerald-800/40">
                            100% BEBAS DARI BOCOR
                        </span>
                    </div>

                    <pre class="p-4 bg-slate-950 rounded-xl text-xs font-mono text-slate-300 overflow-x-auto leading-relaxed border border-slate-800"><code>{
  "question_id": 14,
  "options": [
    { "id": "A", "text": "..." },
    { "id": "B", "text": "..." } <span class="text-emerald-400 font-bold">// Tanpa data kunci jawaban</span>
  ]
}</code></pre>

                    <p class="text-xs text-slate-400 leading-relaxed">
                        Server Naiju menyaring data dan hanya mengirim teks soal serta pilihan jawaban ke komputer siswa. Kunci jawaban tetap aman di server hingga ujian dikumpulkan dan dikoreksi otomatis.
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>
