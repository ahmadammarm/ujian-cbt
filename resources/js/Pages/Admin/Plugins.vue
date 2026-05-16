<script setup>
import AdminLayout from '@/Components/Templates/AdminLayout.vue';
import Breadcrumbs from '@/Components/Molecules/Breadcrumbs.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="A.I Plugins" />
    <AdminLayout>
        <Breadcrumbs :items="[
            { label: 'Dashboard', href: route('dashboard.overview') },
            { label: 'A.I Plugins' }
        ]" />
        
        <div class="flex flex-col gap-2 animate-slide-up">
            <h1 class="font-black text-[32px] tracking-tight text-[#0A090B]">A.I Plugins</h1>
            <p class="text-[#7F8190] font-medium text-lg">Extend platform capabilities with artificial intelligence.</p>
            
            <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="p-10 bg-gray-900 rounded-[40px] text-white relative overflow-hidden group hover:scale-[1.02] transition-all duration-500">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-500/20 rounded-bl-full"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center mb-6">
                            <img src="/assets/images/icons/code.svg" class="w-8 h-8 brightness-0 invert" alt="icon">
                        </div>
                        <h2 class="text-2xl font-black mb-2">Automated Proctoring</h2>
                        <p class="text-gray-400 font-medium mb-8">AI-powered eye tracking and background noise detection.</p>
                        <button class="px-6 py-3 bg-white text-gray-900 rounded-full font-black text-xs uppercase tracking-widest shadow-xl">Enable Plugin</button>
                    </div>
                </div>
                
                <div class="p-10 bg-white border border-gray-100 rounded-[40px] shadow-sm relative overflow-hidden group hover:scale-[1.02] transition-all duration-500">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-[#D95300]/5 rounded-bl-full"></div>
                    <div class="relative z-10 text-poppins">
                        <div class="w-14 h-14 bg-gray-50 rounded-2xl flex items-center justify-center mb-6">
                            <img src="/assets/images/icons/code.svg" class="w-8 h-8" alt="icon">
                        </div>
                        <h2 class="text-2xl font-black text-[#0A090B] mb-2">Question Generator</h2>
                        <p class="text-gray-400 font-medium mb-8">Automatically generate multiple choice questions from text.</p>
                        <button class="px-6 py-3 bg-[#0A090B] text-white rounded-full font-black text-xs uppercase tracking-widest shadow-xl">Enable Plugin</button>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap');
.text-poppins { font-family: 'Poppins', sans-serif; }
@keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
.animate-slide-up { animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
</style>

