<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>
    <Head title="Welcome" />
    <div class="min-h-screen bg-[#F9FAFB] font-sans selection:bg-[#D95300]/20">
        <!-- Navigation -->
        <nav class="fixed top-0 w-full z-50 bg-white/80 backdrop-blur-md border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-[#D95300] rounded-xl flex items-center justify-center shadow-lg shadow-[#D95300]/20">
                        <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-gray-900 tracking-tight text-[#0A090B]">Ujian CBT</span>
                </div>

                <div v-if="canLogin" class="flex items-center gap-6">
                    <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="text-sm font-bold text-gray-600 hover:text-[#D95300] transition-colors">
                        Dashboard
                    </Link>

                    <template v-else>
                        <Link :href="route('login')" class="text-sm font-bold text-gray-600 hover:text-[#D95300] transition-colors">
                            Masuk
                        </Link>

                        <Link v-if="canRegister" :href="route('register')" class="px-6 py-2.5 bg-[#D95300] text-white text-sm font-bold rounded-full shadow-lg shadow-[#D95300]/20 hover:bg-[#BF4900] transition-all active:scale-95">
                            Daftar Sekarang
                        </Link>
                    </template>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <main class="pt-32 pb-20">
            <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-16 items-center">
                <div class="animate-slide-up">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-[#FFF2E6] rounded-full mb-6">
                        <span class="w-2 h-2 bg-[#D95300] rounded-full animate-pulse"></span>
                        <span class="text-xs font-bold text-[#D95300] uppercase tracking-wider">Platform CBT Modern</span>
                    </div>
                    <h1 class="text-5xl lg:text-7xl font-extrabold text-[#0A090B] leading-[1.1] mb-8 text-poppins">
                        Sistem Ujian Online <span class="text-[#D95300]">Terpercaya.</span>
                    </h1>
                    <p class="text-xl text-[#7F8190] leading-relaxed mb-10 max-w-lg">
                        Kelola ujian, pertanyaan, dan pantau hasil belajar siswa dengan sistem yang aman, cepat, dan mudah digunakan.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <Link :href="route('register')" class="px-10 py-4 bg-[#0A090B] text-white font-bold rounded-full shadow-xl hover:bg-gray-800 transition-all active:scale-95 text-center">
                            Mulai Sekarang
                        </Link>
                        <a href="#features" class="px-10 py-4 bg-white text-[#0A090B] border border-gray-200 font-bold rounded-full hover:bg-gray-50 transition-all active:scale-95 text-center">
                            Pelajari Fitur
                        </a>
                    </div>
                </div>

                <div class="relative animate-fade-in delay-300">
                    <div class="absolute -top-10 -right-10 w-64 h-64 bg-[#D95300]/10 rounded-full blur-3xl opacity-60"></div>
                    <div class="absolute -bottom-10 -left-10 w-64 h-64 bg-[#2B82FE]/10 rounded-full blur-3xl opacity-60"></div>
                    
                    <div class="relative bg-white p-4 rounded-[40px] shadow-2xl border border-white">
                        <img 
                            src="https://images.unsplash.com/photo-1434030216411-0b793f4b4173?q=80&w=2070&auto=format&fit=crop" 
                            alt="Dashboard Preview"
                            class="rounded-[32px] w-full h-[500px] object-cover"
                        />
                    </div>
                </div>
            </div>
        </main>

        <!-- Stats -->
        <section id="features" class="py-20 bg-white border-y border-gray-100">
            <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-3 gap-12 text-center">
                <div>
                    <h3 class="text-4xl font-extrabold text-[#0A090B] mb-2">99.9%</h3>
                    <p class="text-[#7F8190] font-medium">Sistem Uptime</p>
                </div>
                <div>
                    <h3 class="text-4xl font-extrabold text-[#0A090B] mb-2">10k+</h3>
                    <p class="text-[#7F8190] font-medium">Siswa Terdaftar</p>
                </div>
                <div>
                    <h3 class="text-4xl font-extrabold text-[#0A090B] mb-2">500+</h3>
                    <p class="text-[#7F8190] font-medium">Kursus Tersedia</p>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="py-12">
            <div class="max-w-7xl mx-auto px-6 text-center">
                <p class="text-sm text-[#7F8190] font-medium">
                    &copy; {{ new Date().getFullYear() }} Ujian CBT. All rights reserved.
                </p>
            </div>
        </footer>
    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap');

.font-poppins {
    font-family: 'Poppins', sans-serif;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(40px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.animate-slide-up {
    animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

.animate-fade-in {
    animation: fadeIn 1.2s ease-out forwards;
}

.delay-300 {
    animation-delay: 300ms;
}
</style>
