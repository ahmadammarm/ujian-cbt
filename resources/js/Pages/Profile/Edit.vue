<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
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
            <!-- Breadcrumbs -->
            <nav class="flex mb-8 text-sm font-medium text-gray-500 animate-fade-in">
                <Link :href="route('dashboard.overview')" class="hover:text-[#D95300] transition-colors">Dashboard</Link>
                <span class="mx-3 text-gray-300">/</span>
                <span class="text-gray-900 font-bold font-poppins">Settings</span>
                <span class="mx-3 text-gray-300">/</span>
                <span class="text-gray-900 font-bold font-poppins">Profile</span>
            </nav>

            <div class="header mb-12 animate-slide-up">
                <h1 class="text-4xl font-extrabold text-[#0A090B] tracking-tight leading-tight mb-2 font-poppins">
                    Account <span class="text-[#D95300]">Settings</span>
                </h1>
                <p class="text-gray-500 text-lg font-medium font-poppins">
                    Manage your personal information, security, and account preferences.
                </p>
            </div>

            <div class="space-y-12 pb-20 animate-slide-up delay-200">
                <!-- Profile Info -->
                <div class="bg-white p-8 sm:p-10 rounded-[32px] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-50 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-50/30 rounded-bl-[100px] -mr-10 -mt-10 group-hover:scale-110 transition-transform duration-700"></div>
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        class="max-w-2xl relative z-10"
                    />
                </div>

                <!-- Password -->
                <div class="bg-white p-8 sm:p-10 rounded-[32px] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-50 relative overflow-hidden group text-poppins">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-orange-50/30 rounded-bl-[100px] -mr-10 -mt-10 group-hover:scale-110 transition-transform duration-700"></div>
                    <UpdatePasswordForm class="max-w-2xl relative z-10" />
                </div>

                <!-- Danger Zone -->
                <div class="bg-red-50/30 p-8 sm:p-10 rounded-[32px] border border-red-100/50 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-red-100/20 rounded-bl-[100px] -mr-10 -mt-10 group-hover:scale-110 transition-transform duration-700"></div>
                    <DeleteUserForm class="max-w-2xl relative z-10" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap');
.font-poppins {
    font-family: 'Poppins', sans-serif;
}
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
@keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
.animate-fade-in { animation: fadeIn 0.8s ease-out forwards; }
.animate-slide-up { animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
.delay-200 { animation-delay: 200ms; }
</style>
