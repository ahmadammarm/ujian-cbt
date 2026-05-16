<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Rewards" />
    <AdminLayout>
        <Breadcrumbs :items="[
            { label: 'Dashboard', href: route('dashboard.overview') },
            { label: 'Rewards' }
        ]" />
        
        <div class="flex flex-col gap-2 animate-slide-up">
            <h1 class="font-black text-[32px] tracking-tight text-[#0A090B]">Rewards</h1>
            <p class="text-[#7F8190] font-medium text-lg">Configure student incentives and gamification rules.</p>
            
            <div class="mt-12 p-20 bg-[#FFF2E6] rounded-[40px] border-2 border-dashed border-[#F6770B]/20 text-center">
                <div class="w-20 h-20 bg-white rounded-3xl shadow-sm flex items-center justify-center mx-auto mb-6">
                    <img src="/assets/images/icons/3dcube.svg" class="w-10 h-10 text-[#F6770B]" alt="icon">
                </div>
                <p class="text-[#D95300] font-black text-xl text-poppins">Rewards System</p>
                <p class="text-[#D95300]/60 font-medium mt-2 max-w-sm mx-auto">This feature is coming soon to help you boost student engagement.</p>
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
