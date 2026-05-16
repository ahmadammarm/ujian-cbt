<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Students" />
    <AdminLayout>
        <div class="flex flex-col px-5 mt-5">
            <h1 class="font-extrabold text-[30px] leading-[45px]">Students</h1>
            <p class="text-[#7F8190]">Manage your students here</p>
        </div>
    </AdminLayout>
</template>
