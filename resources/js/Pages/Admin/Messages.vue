<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Messages" />
    <AdminLayout>
        <Breadcrumbs :items="[
            { label: 'Dashboard', href: route('dashboard.overview') },
            { label: 'Messages' }
        ]" />
        
        <div class="flex flex-col gap-2 animate-slide-up">
            <h1 class="font-black text-[32px] tracking-tight text-[#0A090B]">Messages</h1>
            <p class="text-[#7F8190] font-medium text-lg">Communications and notifications center.</p>
            
            <div class="mt-12 p-20 bg-gray-50 rounded-[40px] border-2 border-dashed border-gray-100 text-center">
                <div class="w-20 h-20 bg-white rounded-3xl shadow-sm flex items-center justify-center mx-auto mb-6">
                    <img src="/assets/images/icons/sms-tracking.svg" class="w-10 h-10 opacity-20" alt="icon">
                </div>
                <p class="text-[#7F8190] font-black text-xl">Your inbox is empty.</p>
                <p class="text-gray-400 font-medium mt-2">Check back later for new communications.</p>
            </div>
        </div>
    </AdminLayout>
</template>

<style scoped>
@keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
.animate-slide-up { animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
</style>
