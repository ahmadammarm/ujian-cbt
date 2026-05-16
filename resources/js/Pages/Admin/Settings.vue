<script setup>
import AdminLayout from '@/Components/Templates/AdminLayout.vue';
import Breadcrumbs from '@/Components/Molecules/Breadcrumbs.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Settings" />
    <AdminLayout>
        <Breadcrumbs :items="[
            { label: 'Dashboard', href: route('dashboard.overview') },
            { label: 'Settings' }
        ]" />
        
        <div class="flex flex-col gap-2 animate-slide-up">
            <h1 class="font-black text-[32px] tracking-tight text-[#0A090B]">Settings</h1>
            <p class="text-[#7F8190] font-medium text-lg">Configure your platform preferences and account.</p>
            
            <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-8 pb-20">
                <Link :href="route('profile.edit')" class="p-10 bg-white border border-gray-100 rounded-[40px] shadow-[0_8px_30px_rgb(0,0,0,0.02)] hover:shadow-xl hover:shadow-indigo-100/20 transition-all group active:scale-[0.99]">
                    <div class="w-16 h-16 bg-gray-50 rounded-[24px] flex items-center justify-center mb-8 group-hover:bg-indigo-50 transition-colors">
                        <img src="/assets/images/icons/setting-2.svg" class="w-8 h-8 opacity-40 group-hover:opacity-100 transition-opacity" alt="icon">
                    </div>
                    <h2 class="text-2xl font-black text-[#0A090B] mb-2 font-poppins">Account Settings</h2>
                    <p class="text-gray-400 font-medium text-poppins">Update your password, email, and personal information.</p>
                </Link>
                
                <div class="p-10 bg-white border border-gray-100 rounded-[40px] shadow-[0_8px_30px_rgb(0,0,0,0.02)] hover:shadow-xl hover:shadow-[#D95300]/5 transition-all group active:scale-[0.99] cursor-pointer">
                    <div class="w-16 h-16 bg-gray-50 rounded-[24px] flex items-center justify-center mb-8 group-hover:bg-[#FFF2E6] transition-colors">
                        <img src="/assets/images/icons/setting-2.svg" class="w-8 h-8 opacity-40 group-hover:opacity-100 transition-opacity" alt="icon">
                    </div>
                    <h2 class="text-2xl font-black text-[#0A090B] mb-2 font-poppins text-poppins">Platform Config</h2>
                    <p class="text-gray-400 font-medium text-poppins">Adjust system-wide settings, branding, and API integrations.</p>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap');
.font-poppins { font-family: 'Poppins', sans-serif; }
@keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
.animate-slide-up { animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
</style>

