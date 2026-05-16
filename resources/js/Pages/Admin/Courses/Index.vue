<script setup>
import AdminLayout from '@/Components/Templates/AdminLayout.vue';
import AlertDialog from '@/Components/Organisms/AlertDialog.vue';
import Breadcrumbs from '@/Components/Molecules/Breadcrumbs.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    courses: {
        type: Array,
        required: true,
    },
});

const isDeleteDialogOpen = ref(false);
const selectedCourseId = ref(null);

const confirmDeleteCourse = (id) => {
    selectedCourseId.value = id;
    isDeleteDialogOpen.value = true;
};

const deleteForm = useForm({});

const deleteCourse = () => {
    deleteForm.delete(route('dashboard.courses.destroy', selectedCourseId.value), {
        onSuccess: () => {
            isDeleteDialogOpen.value = false;
            selectedCourseId.value = null;
        },
    });
};

const toggleMaxHeight = (e) => {
    const menuDropdown = e.currentTarget.parentElement;
    menuDropdown.classList.toggle('max-h-fit');
    menuDropdown.classList.toggle('shadow-[0_10px_16px_0_#0A090B0D]');
    menuDropdown.classList.toggle('z-10');
};

const formatDate = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', {
        day: '2-digit',
        month: 'long',
        year: 'numeric',
    });
};
</script>

<template>
    <Head title="Manage Courses" />

    <AdminLayout>
        <Breadcrumbs :items="[
            { label: 'Dashboard', href: route('dashboard.overview') },
            { label: 'Manage Courses' }
        ]" />

        <div class="flex flex-col mb-12 animate-fade-in">
            <div class="w-full flex justify-between items-end">
                <div class="flex flex-col gap-2">
                    <h1 class="font-black text-[40px] tracking-tight text-[#0A090B] leading-none">Manage Courses</h1>
                    <p class="text-[#7F8190] font-medium text-lg">You have <span class="text-[#0A090B] font-bold">{{ courses.length }}</span> active courses in your catalog.</p>
                </div>
                <Link :href="route('dashboard.courses.create')"
                    class="h-[60px] p-[0_36px] bg-[#6436F1] text-white rounded-[20px] font-black uppercase tracking-widest text-[13px] transition-all duration-300 hover:shadow-[0_10px_30px_rgba(100,54,241,0.3)] hover:scale-[1.02] active:scale-95 flex items-center justify-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Add New Course
                </Link>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 pb-20">
            <!-- Table Header (Desktop Only) -->
            <div class="hidden lg:flex items-center px-10 py-4 bg-gray-50/50 rounded-2xl border border-gray-100 mb-2">
                <div class="w-[45%] text-[11px] font-black text-[#A5ABB2] uppercase tracking-[0.2em]">Course Information</div>
                <div class="w-[20%] text-[11px] font-black text-[#A5ABB2] uppercase tracking-[0.2em] text-center">Category</div>
                <div class="w-[20%] text-[11px] font-black text-[#A5ABB2] uppercase tracking-[0.2em] text-center">Date Created</div>
                <div class="w-[15%] text-[11px] font-black text-[#A5ABB2] uppercase tracking-[0.2em] text-right">Actions</div>
            </div>

            <!-- Course Rows -->
            <div v-for="course in courses" :key="course.id" 
                class="group relative bg-white p-6 lg:p-8 rounded-[32px] border border-gray-100 hover:border-[#2B82FE]/20 hover:shadow-[0_15px_40px_rgb(0,0,0,0.03)] transition-all duration-500 flex flex-col lg:flex-row lg:items-center animate-slide-up">
                
                <!-- Info Section -->
                <div class="lg:w-[45%] flex items-center gap-6">
                    <div class="w-20 h-20 flex shrink-0 overflow-hidden rounded-[24px] shadow-sm border border-gray-50 group-hover:scale-105 transition-transform duration-500">
                        <img :src="'/storage/' + course.cover" class="object-cover w-full h-full" alt="thumbnail">
                    </div>
                    <div class="flex flex-col gap-1">
                        <p class="font-black text-xl text-[#0A090B] group-hover:text-[#2B82FE] transition-colors line-clamp-1">
                            {{ course.name }}
                        </p>
                        <div class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                            <p class="text-[12px] font-bold text-[#A5ABB2] uppercase tracking-wider">Live & Active</p>
                        </div>
                    </div>
                </div>

                <!-- Category Section -->
                <div class="mt-6 lg:mt-0 lg:w-[20%] flex justify-center font-poppins">
                    <div v-if="course.category" 
                        :class="[
                            'px-4 py-2 rounded-xl font-black text-[11px] uppercase tracking-widest border',
                            course.category.name === 'Programming' ? 'bg-[#EAE8FE] text-[#6436F1] border-[#6436F1]/10' :
                            course.category.name === 'Design' ? 'bg-[#FDEBEA] text-[#FD445E] border-[#FD445E]/10' :
                            course.category.name === 'Marketing' ? 'bg-[#E6F9E6] text-[#28A745] border-[#28A745]/10' :
                            'bg-gray-50 text-gray-500 border-gray-100'
                        ]"
                    >
                        {{ course.category.name }}
                    </div>
                    <p v-else class="text-gray-300 font-bold">---</p>
                </div>

                <!-- Date Section -->
                <div class="mt-4 lg:mt-0 lg:w-[20%] flex flex-col items-center">
                    <p class="text-[15px] font-extrabold text-[#0A090B]">
                        {{ formatDate(course.created_at) }}
                    </p>
                    <p class="text-[11px] font-bold text-[#A5ABB2] uppercase tracking-tighter">Registration Date</p>
                </div>

                <!-- Actions Section -->
                <div class="mt-8 lg:mt-0 lg:w-[15%] flex justify-end gap-3">
                    <Link :href="route('dashboard.courses.show', course.id)"
                        class="w-12 h-12 flex items-center justify-center bg-gray-50 text-[#0A090B] rounded-2xl hover:bg-[#0A090B] hover:text-white transition-all duration-300 active:scale-90 shadow-sm group/btn">
                        <svg class="w-5 h-5 group-hover/btn:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2.5"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c3.55 0 6.703 1.86 8.596 4.675a.966.966 0 010 1.15C18.703 13.64 15.55 15.5 12 15.5c-4.477 0-8.268-2.943-9.542-7z" stroke-width="2.5"/></svg>
                    </Link>
                    <Link :href="route('dashboard.courses.edit', course.id)"
                        class="w-12 h-12 flex items-center justify-center bg-gray-50 text-[#0A090B] rounded-2xl hover:bg-[#6436F1] hover:text-white transition-all duration-300 active:scale-90 shadow-sm group/btn">
                        <svg class="w-5 h-5 group-hover/btn:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </Link>
                    <button @click="confirmDeleteCourse(course.id)"
                        class="w-12 h-12 flex items-center justify-center bg-white border border-gray-100 text-[#FD445E] rounded-2xl hover:bg-[#FD445E] hover:text-white transition-all duration-300 active:scale-90 shadow-sm group/btn">
                        <svg class="w-5 h-5 group-hover/btn:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                </div>
            </div>

            <!-- Empty State -->
            <div v-if="courses.length === 0" class="py-32 px-10 bg-gray-50/50 rounded-[40px] text-center border-2 border-dashed border-gray-100 animate-fade-in">
                <div class="w-24 h-24 bg-white rounded-[32px] shadow-sm flex items-center justify-center mx-auto mb-8">
                    <svg class="w-12 h-12 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.168.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.168.477-4.5 1.253" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <h3 class="text-[#0A090B] font-black text-2xl mb-2">No Courses Found</h3>
                <p class="text-[#7F8190] font-medium text-lg mb-10 max-w-sm mx-auto">Start building your educational empire by creating your first course today.</p>
                <Link :href="route('dashboard.courses.create')" class="inline-flex items-center gap-3 px-10 py-5 bg-[#6436F1] text-white font-black uppercase tracking-widest text-[13px] rounded-[20px] shadow-xl shadow-indigo-100 hover:scale-105 transition-all active:scale-95">
                    Create My First Course
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 8l4 4m0 0l-4 4m4-4H3" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </Link>
            </div>
        </div>

        <AlertDialog
            :show="isDeleteDialogOpen"
            title="Delete this course?"
            message="This will permanently remove the course and all associated questions. This action cannot be undone."
            confirm-text="Yes, Delete"
            cancel-text="Keep it"
            type="danger"
            @close="isDeleteDialogOpen = false"
            @confirm="deleteCourse"
        />
    </AdminLayout>
</template>

<style scoped>
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
@keyframes slideUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
.animate-fade-in { animation: fadeIn 0.8s ease-out forwards; }
.animate-slide-up { animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
</style>

