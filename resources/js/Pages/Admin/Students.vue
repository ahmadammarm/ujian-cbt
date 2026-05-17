<script setup>
import AdminLayout from '@/Components/Templates/AdminLayout.vue';
import Breadcrumbs from '@/Components/Molecules/Breadcrumbs.vue';
import Pagination from '@/Components/Molecules/Pagination.vue';
import AlertDialog from '@/Components/Organisms/AlertDialog.vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps({
    students: Object, // Paginated object
    filters: Object,
});

const search = ref(props.filters.search || '');
const isSuspensionDialogOpen = ref(false);
const selectedStudent = ref(null);

// Debounced search
let timeout = null;
watch(search, (value) => {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
        router.get(route('dashboard.students.index'), { search: value }, {
            preserveState: true,
            replace: true,
        });
    }, 500);
});

const confirmToggleSuspension = (student) => {
    selectedStudent.value = student;
    isSuspensionDialogOpen.value = true;
};

const suspensionForm = useForm({});
const toggleSuspension = () => {
    suspensionForm.post(route('dashboard.students.toggle-suspension', selectedStudent.value.id), {
        onSuccess: () => {
            isSuspensionDialogOpen.value = false;
            selectedStudent.value = null;
        },
    });
};

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('id-ID', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
    });
};
</script>

<template>
    <Head title="Students" />
    <AdminLayout>
        <Breadcrumbs :items="[
            { label: 'Dashboard', href: route('dashboard.overview') },
            { label: 'Students' }
        ]" />
        
        <div class="flex flex-col gap-2 animate-slide-up">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-12">
                <div class="flex flex-col gap-1">
                    <h1 class="font-black text-[32px] tracking-tight text-[#0A090B]">Students</h1>
                    <p class="text-[#7F8190] font-medium text-lg">Managing <span class="text-[#0A090B] font-bold">{{ students.total }}</span> students across the platform.</p>
                </div>
                
                <div class="relative w-full lg:w-[400px]">
                    <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-[#A5ABB2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <input v-model="search" type="text" placeholder="Search name or email..." 
                        class="w-full h-[60px] pl-14 pr-6 bg-white border border-gray-100 rounded-[20px] focus:ring-2 focus:ring-[#6436F1] focus:border-transparent transition-all font-medium text-[#0A090B]">
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 pb-20">
                <!-- Table Header -->
                <div class="hidden lg:flex items-center px-10 py-4 bg-gray-50/50 rounded-2xl border border-gray-100 mb-2">
                    <div class="w-[30%] text-[11px] font-black text-[#A5ABB2] uppercase tracking-[0.2em]">Student Information</div>
                    <div class="w-[20%] text-[11px] font-black text-[#A5ABB2] uppercase tracking-[0.2em] text-center">Courses</div>
                    <div class="w-[20%] text-[11px] font-black text-[#A5ABB2] uppercase tracking-[0.2em] text-center">Avg Score</div>
                    <div class="w-[15%] text-[11px] font-black text-[#A5ABB2] uppercase tracking-[0.2em] text-center">Status</div>
                    <div class="w-[15%] text-[11px] font-black text-[#A5ABB2] uppercase tracking-[0.2em] text-right">Actions</div>
                </div>

                <!-- Student Rows -->
                <div v-for="student in students.data" :key="student.id" 
                    class="group bg-white p-6 lg:p-8 rounded-[32px] border border-gray-100 hover:border-[#6436F1]/20 hover:shadow-[0_15px_40px_rgb(0,0,0,0.02)] transition-all duration-500 flex flex-col lg:flex-row lg:items-center">
                    
                    <div class="lg:w-[30%] flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-[#F4F4F4] flex items-center justify-center font-black text-[#0A090B] text-lg">
                            {{ student.name.charAt(0) }}
                        </div>
                        <div class="flex flex-col">
                            <p class="font-black text-[#0A090B]">{{ student.name }}</p>
                            <p class="text-sm font-medium text-[#7F8190]">{{ student.email }}</p>
                        </div>
                    </div>

                    <div class="mt-4 lg:mt-0 lg:w-[20%] flex flex-col items-center">
                        <p class="font-black text-lg">{{ student.courses_count }}</p>
                        <p class="text-[10px] font-black text-[#A5ABB2] uppercase tracking-widest">Enrolled</p>
                    </div>

                    <div class="mt-4 lg:mt-0 lg:w-[20%] flex flex-col items-center">
                        <p v-if="student.assessments_avg_score !== null" :class="['font-black text-lg', student.assessments_avg_score >= 70 ? 'text-[#28A745]' : 'text-[#FD445E]']">
                            {{ Math.round(student.assessments_avg_score) }}%
                        </p>
                        <p v-else class="font-black text-sm text-[#7F8190] py-1">
                            Not yet taken
                        </p>
                        <p class="text-[10px] font-black text-[#A5ABB2] uppercase tracking-widest">Average</p>
                    </div>

                    <div class="mt-4 lg:mt-0 lg:w-[15%] flex justify-center">
                        <span :class="['px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest', student.is_active ? 'bg-[#E6F9E6] text-[#28A745]' : 'bg-[#FDEBEA] text-[#FD445E]']">
                            {{ student.is_active ? 'Active' : 'Suspended' }}
                        </span>
                    </div>

                    <div class="mt-6 lg:mt-0 lg:w-[15%] flex justify-end gap-3">
                         <button @click="confirmToggleSuspension(student)"
                            :title="student.is_active ? 'Suspend Student' : 'Activate Student'"
                            :class="['w-10 h-10 flex items-center justify-center rounded-xl transition-all duration-300', student.is_active ? 'bg-gray-50 text-[#FD445E] hover:bg-[#FD445E] hover:text-white' : 'bg-[#E6F9E6] text-[#28A745] hover:bg-[#28A745] hover:text-white']">
                            <svg v-if="student.is_active" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Empty State -->
                <div v-if="students.data.length === 0" class="py-32 px-10 bg-gray-50/50 rounded-[40px] text-center border-2 border-dashed border-gray-100">
                    <p class="text-[#7F8190] font-black text-xl">No students found matching your search.</p>
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    <Pagination :links="students.links" />
                </div>
            </div>
        </div>

        <AlertDialog
            :show="isSuspensionDialogOpen"
            :title="selectedStudent?.is_active ? 'Suspend Student?' : 'Activate Student?'"
            :message="selectedStudent?.is_active 
                ? `Are you sure you want to suspend ${selectedStudent?.name}? They will no longer be able to log in.` 
                : `Are you sure you want to reactivate ${selectedStudent?.name}?`"
            :confirm-text="selectedStudent?.is_active ? 'Yes, Suspend' : 'Yes, Activate'"
            cancel-text="Cancel"
            :type="selectedStudent?.is_active ? 'danger' : 'success'"
            @close="isSuspensionDialogOpen = false"
            @confirm="toggleSuspension"
        />
    </AdminLayout>
</template>

<style scoped>
@keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
.animate-slide-up { animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
</style>
