<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Analytics" />
    <AdminLayout>
        <Breadcrumbs :items="[
            { label: 'Dashboard', href: route('dashboard.overview') },
            { label: 'Analytics' }
        ]" />
        
        <div class="flex flex-col gap-2 animate-slide-up">
            <h1 class="font-black text-[32px] tracking-tight text-[#0A090B]">Analytics</h1>
            <p class="text-[#7F8190] font-medium text-lg">Real-time data insights and platform performance.</p>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-12">
                <div class="h-64 bg-gray-50 rounded-[40px] border-2 border-dashed border-gray-100 flex items-center justify-center">
                    <p class="text-gray-400 font-bold uppercase tracking-widest text-xs">Course Performance Chart</p>
                </div>
                <div class="h-64 bg-gray-50 rounded-[40px] border-2 border-dashed border-gray-100 flex items-center justify-center">
                    <p class="text-gray-400 font-bold uppercase tracking-widest text-xs">Student Growth Chart</p>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<style scoped>
@keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
.animate-slide-up { animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
</style>
