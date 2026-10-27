<script setup>
import InkButton from '@/Components/Atoms/InkButton.vue';
</script>

<template>
    <section class="py-16 sm:py-24">
        <div class="mx-auto max-w-6xl px-6 sm:pl-24 sm:pr-8">
            <!-- Notebook cover label -->
            <div class="mx-auto max-w-xl rounded-[1.75rem] border-2 border-ink bg-paper p-2">
                <div class="rounded-[1.4rem] border border-ink/40 px-5 py-7 sm:px-10 sm:py-8 text-center">
                    <dl class="mx-auto max-w-xs space-y-3 text-left">
                        <div class="flex items-end gap-3">
                            <dt class="w-14 font-form text-[11px] font-semibold uppercase tracking-widest text-ink-soft">Nama</dt>
                            <dd class="flex-1 border-b border-dotted border-ink/50 font-hand text-lg sm:text-xl font-semibold text-ink">kamu</dd>
                        </div>
                        <div class="flex items-end gap-3">
                            <dt class="w-14 font-form text-[11px] font-semibold uppercase tracking-widest text-ink-soft">Mapel</dt>
                            <dd class="flex-1 border-b border-dotted border-ink/50 font-hand text-lg sm:text-xl font-semibold text-ink">yang diujikan hari ini</dd>
                        </div>
                    </dl>

                    <p class="mt-8 font-hand text-2xl font-extrabold text-ink sm:text-3xl">Sudah siap?</p>

                    <div class="mt-6">
                        <InkButton v-if="$page.props.auth.user" :href="route('dashboard')">Buka dashboard</InkButton>
                        <InkButton v-else :href="route('login')">Masuk ke Naiju Exam</InkButton>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
