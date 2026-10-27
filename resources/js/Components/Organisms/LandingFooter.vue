<script setup>
import { Link } from '@inertiajs/vue3';

const currentYear = new Date().getFullYear();
</script>

<template>
    <footer class="border-t-2 border-double border-rule py-10">
        <div class="mx-auto flex max-w-6xl flex-col gap-6 px-6 sm:flex-row sm:items-center sm:justify-between sm:pl-24 sm:pr-8">
            <p class="font-legible text-sm text-ink-soft">
                <span class="font-hand text-base font-bold text-ink">Naiju Exam</span>
                · portal ujian siswa · © {{ currentYear }}
            </p>
            <nav aria-label="Tautan bawah" class="flex flex-wrap gap-x-6 gap-y-2 font-legible text-sm font-bold text-ink-soft">
                <Link :href="route('login')" class="hover:text-ink focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pen">Masuk</Link>
                <Link :href="route('password.request')" class="hover:text-ink focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pen">Lupa password</Link>
                <a href="#tanya" class="hover:text-ink focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pen">Tanya jawab</a>
            </nav>
        </div>
    </footer>
</template>
