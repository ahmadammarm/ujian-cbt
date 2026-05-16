<script setup>
import AuthenticatedLayout from '@/Components/Templates/AuthenticatedLayout.vue';
import Breadcrumbs from '@/Components/Molecules/Breadcrumbs.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>
    <Head title="My Profile" />

    <AuthenticatedLayout>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <Breadcrumbs :items="[
                { label: 'Dashboard', href: route('dashboard.overview') },
                { label: 'Settings', href: route('dashboard.settings') },
                { label: 'Profile' }
            ]" />

            <div class="header mb-12 animate-slide-up font-poppins">
                <h1 class="text-4xl font-black text-[#0A090B] tracking-tight leading-tight mb-2">
                    Account <span class="text-[#D95300]">Settings</span>
                </h1>
                <p class="text-gray-500 text-lg font-medium">
                    Manage your personal information, security, and account preferences.
                </p>
            </div>

            <div class="space-y-12 pb-20 animate-slide-up delay-200">
                <!-- Profile Info -->
                <div class="bg-white p-8 sm:p-10 rounded-[40px] shadow-[0_10px_40px_rgb(0,0,0,0.03)] border border-gray-50 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-50/30 rounded-bl-[100px] -mr-10 -mt-10 group-hover:scale-110 transition-transform duration-700"></div>
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        class="max-w-2xl relative z-10"
                    />
                </div>

                <!-- Password -->
                <div class="bg-white p-8 sm:p-10 rounded-[40px] shadow-[0_10px_40px_rgb(0,0,0,0.03)] border border-gray-50 relative overflow-hidden group font-poppins">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-orange-50/30 rounded-bl-[100px] -mr-10 -mt-10 group-hover:scale-110 transition-transform duration-700"></div>
                    <UpdatePasswordForm class="max-w-2xl relative z-10" />
                </div>

                <!-- Danger Zone -->
                <div class="bg-red-50/20 p-8 sm:p-10 rounded-[40px] border border-red-100/50 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-red-100/20 rounded-bl-[100px] -mr-10 -mt-10 group-hover:scale-110 transition-transform duration-700"></div>
                    <DeleteUserForm class="max-w-2xl relative z-10" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap');
.font-poppins {
    font-family: 'Poppins', sans-serif;
}
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
@keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
.animate-fade-in { animation: fadeIn 0.8s ease-out forwards; }
.animate-slide-up { animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
.delay-200 { animation-delay: 200ms; }
</style>

