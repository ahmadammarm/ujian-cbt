<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Admin Overview" />

    <AdminLayout>
        <Breadcrumbs :items="[
            { label: 'Dashboard', href: route('dashboard.overview') },
            { label: 'Overview' }
        ]" />
        
        <div class="flex flex-col">
            <div class="w-full flex justify-between items-center">
                <div class="flex flex-col gap-1">
                    <p class="font-extrabold text-[30px] leading-[45px]">Admin Overview</p>
                    <p class="text-[#7F8190]">Monitor your platform's performance</p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-[30px] mt-[30px]">
                <div class="p-6 bg-white border border-[#EEEEEE] rounded-[24px] flex flex-col gap-4">
                    <div class="w-12 h-12 bg-[#EAE8FE] rounded-full flex items-center justify-center">
                        <img src="/assets/images/icons/note-favorite.svg" class="w-6 h-6" alt="icon">
                    </div>
                    <div>
                        <p class="text-[#7F8190] font-semibold">Total Courses</p>
                        <p class="text-3xl font-bold">120</p>
                    </div>
                </div>
                
                <div class="p-6 bg-white border border-[#EEEEEE] rounded-[24px] flex flex-col gap-4">
                    <div class="w-12 h-12 bg-[#FDEBEA] rounded-full flex items-center justify-center">
                        <img src="/assets/images/icons/profile-2user.svg" class="w-6 h-6" alt="icon">
                    </div>
                    <div>
                        <p class="text-[#7F8190] font-semibold">Total Students</p>
                        <p class="text-3xl font-bold">4,890</p>
                    </div>
                </div>

                <div class="p-6 bg-white border border-[#EEEEEE] rounded-[24px] flex flex-col gap-4">
                    <div class="w-12 h-12 bg-[#E6F9E6] rounded-full flex items-center justify-center">
                        <img src="/assets/images/icons/chart-2.svg" class="w-6 h-6" alt="icon">
                    </div>
                    <div>
                        <p class="text-[#7F8190] font-semibold">Daily Active</p>
                        <p class="text-3xl font-bold">342</p>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
