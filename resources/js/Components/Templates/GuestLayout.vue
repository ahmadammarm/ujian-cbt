<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen flex flex-col md:flex-row bg-white font-sans selection:bg-[#D95300]/20">
        <!-- Left Section: Image (Hidden on mobile) -->
        <div class="hidden md:flex md:w-[55%] lg:w-[60%] relative h-screen sticky top-0 overflow-hidden">
            <img 
                src="https://images.unsplash.com/photo-1434030216411-0b793f4b4173?q=80&w=2070&auto=format&fit=crop" 
                alt="Auth Background"
                class="absolute inset-0 w-full h-full object-cover brightness-[0.4]"
            />
            
            <!-- Logo top left -->
            <div class="absolute top-10 left-10">
                <div class="w-14 h-14 bg-white p-2.5 rounded-2xl shadow-2xl flex items-center justify-center text-[#D95300]">
                    <svg class="w-8 h-8 fill-current" viewBox="0 0 24 24">
                        <path d="M4 3.5H8.2L15.8 15.3V3.5H20V20.5H15.8L8.2 8.7V20.5H4V3.5Z" />
                    </svg>
                </div>
            </div>

            <!-- Text bottom left -->
            <div class="absolute bottom-16 left-12 pr-12 animate-fade-in space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 backdrop-blur-md rounded-full text-xs font-semibold text-white/90">
                    Platform Ujian & Asesmen Digital
                </div>
                <h2 class="text-4xl lg:text-5xl font-bold text-white leading-tight">
                    Selamat datang di <span class="text-[#D95300]">Naiju</span>
                </h2>
            </div>
        </div>

        <!-- Right Section: Form -->
        <div class="flex-1 flex flex-col justify-center items-center px-6 py-12 sm:px-12 lg:px-20 bg-white">
            <div class="w-full max-w-[440px] animate-slide-up">
                <slot />

                <p class="mt-12 text-center text-sm text-gray-400 font-medium">
                    &copy; {{ new Date().getFullYear() }} Naiju. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</template>

<style>
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fadeIn 1s ease-out forwards;
}

.animate-slide-up {
    animation: slideUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
</style>

