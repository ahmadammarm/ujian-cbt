<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import AlertDialog from '@/Components/AlertDialog.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted } from 'vue';

const props = defineProps({
    course: {
        type: Object,
        required: true,
    },
    students: {
        type: Array,
        required: true,
    },
    questions: {
        type: Array,
        required: true,
    },
});

const isDeleteDialogOpen = ref(false);
const selectedQuestionId = ref(null);

const confirmDeleteQuestion = (id) => {
    selectedQuestionId.value = id;
    isDeleteDialogOpen.value = true;
};

const deleteForm = useForm({});

const deleteQuestion = () => {
    deleteForm.delete(route('dashboard.course.question.delete', { 
        courseId: props.course.id, 
        questionId: selectedQuestionId.value 
    }), {
        onSuccess: () => {
            isDeleteDialogOpen.value = false;
            selectedQuestionId.value = null;
        },
    });
};

const isDropdownOpen = ref(false);
const moreButton = ref(null);

const toggleDropdown = (e) => {
    e.stopPropagation();
    isDropdownOpen.value = !isDropdownOpen.value;
};

const closeDropdown = (e) => {
    if (moreButton.value && !moreButton.value.contains(e.target)) {
        isDropdownOpen.value = false;
    }
};

onMounted(() => {
    document.addEventListener('click', closeDropdown);
});

onUnmounted(() => {
    document.removeEventListener('click', closeDropdown);
});

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
    <Head title="Course Details" />

    <AdminLayout>
        <div class="flex flex-col">
            <Breadcrumbs :items="[
                { label: 'Dashboard', href: route('dashboard.overview') },
                { label: 'Courses', href: route('dashboard.courses.index') },
                { label: 'Course Details' }
            ]" />
        </div>

        <!-- Header Card -->
        <div class="header w-full flex flex-col lg:flex-row items-start lg:items-center justify-between mb-16 animate-slide-up gap-8 bg-white p-8 lg:p-12 rounded-[48px] border border-gray-100 shadow-[0_10px_40px_rgb(0,0,0,0.02)]">
            <div class="flex flex-col lg:flex-row gap-10 items-center lg:items-start text-center lg:text-left">
                <div class="w-[200px] h-[200px] flex shrink-0 relative overflow-hidden group">
                    <img :src="'/storage/' + course.cover" class="w-full h-full object-cover rounded-[40px] shadow-2xl border-4 border-white group-hover:scale-110 transition-transform duration-700" alt="icon">
                    <div v-if="course.category"
                        class="absolute bottom-4 left-1/2 -translate-x-1/2 px-5 py-2 rounded-full bg-white/90 backdrop-blur-md shadow-lg border border-orange-50 animate-fade-in">
                        <p class="font-black text-[11px] text-[#D95300] uppercase tracking-widest whitespace-nowrap">
                            {{ course.category?.name }}
                        </p>
                    </div>
                </div>

                <div class="flex flex-col gap-8 max-w-xl">
                    <div class="space-y-3">
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-green-50 text-green-600 rounded-full border border-green-100 mb-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                            <span class="text-[10px] font-black uppercase tracking-widest">Active Course</span>
                        </div>
                        <h1 class="font-black text-4xl lg:text-5xl leading-tight text-[#0A090B] tracking-tighter">
                            {{ course.name }}
                        </h1>
                    </div>
                    
                    <div class="flex flex-wrap items-center justify-center lg:justify-start gap-10 font-poppins">
                        <div class="flex gap-4 items-center group">
                            <div class="w-14 h-14 flex shrink-0 items-center justify-center bg-gray-50 rounded-[20px] group-hover:bg-[#FFF2E6] transition-all duration-300">
                                <img src="/assets/images/icons/calendar-outline.svg" class="w-6 h-6" alt="icon">
                            </div>
                            <div>
                                <p class="text-[11px] font-bold text-[#A5ABB2] uppercase tracking-[0.2em] mb-0.5">Launched</p>
                                <p class="font-black text-[#0A090B] text-lg">{{ formatDate(course.created_at) }}</p>
                            </div>
                        </div>
                        <div class="flex gap-4 items-center group">
                            <div class="w-14 h-14 flex shrink-0 items-center justify-center bg-gray-50 rounded-[20px] group-hover:bg-[#EAE8FE] transition-all duration-300">
                                <img src="/assets/images/icons/profile-2user-outline.svg" class="w-6 h-6" alt="icon">
                            </div>
                            <div>
                                <p class="text-[11px] font-bold text-[#A5ABB2] uppercase tracking-[0.2em] mb-0.5">Students</p>
                                <p class="font-black text-[#0A090B] text-lg">{{ students.length }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative self-center lg:self-start" ref="moreButton">
                <button @click="toggleDropdown"
                    class="w-16 h-16 flex shrink-0 rounded-[24px] items-center justify-center bg-white border border-gray-100 shadow-sm hover:shadow-xl hover:bg-gray-50 transition-all active:scale-95 group">
                    <img src="/assets/images/icons/more.svg" class="w-8 h-8 group-hover:rotate-90 transition-transform duration-500" alt="icon">
                </button>
                <div v-show="isDropdownOpen"
                    class="absolute right-0 top-[76px] w-[300px] flex flex-col gap-2 p-3 border border-gray-100 bg-white rounded-[32px] shadow-[0_20px_50px_rgba(0,0,0,0.1)] z-20 animate-slide-up">
                    <Link :href="route('dashboard.courses.edit', course.id)" class="flex gap-4 items-center p-5 hover:bg-gray-50 rounded-2xl transition-colors font-black text-[13px] text-gray-700 uppercase tracking-widest">
                        <img src="/assets/images/icons/note-favorite-outline.svg" class="w-5 h-5 opacity-40" alt="icon">
                        Edit Course
                    </Link>
                    <div class="h-[1px] bg-gray-50 mx-4"></div>
                    <button class="flex gap-4 items-center p-5 hover:bg-red-50 rounded-2xl transition-colors font-black text-[13px] text-[#FD445E] uppercase tracking-widest">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.5 4.98332C14.725 4.70832 11.9333 4.56665 9.15 4.56665C7.5 4.56665 5.85 4.64998 4.2 4.81665L2.5 4.98332" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M7.08325 4.14163L7.26659 3.04996C7.39992 2.25829 7.49992 1.66663 8.90825 1.66663H11.0916C12.4999 1.66663 12.6083 2.29163 12.7333 3.05829L12.9166 4.14163" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M15.7084 7.6167L15.1667 16.0084C15.0751 17.3167 15.0001 18.3334 12.6751 18.3334H7.32508C5.00008 18.3334 4.92508 17.3167 4.83341 16.0084L4.29175 7.6167" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M8.6084 13.75H11.3834" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M7.91675 10.4166H12.0834" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Delete Course
                    </button>
                </div>
            </div>
        </div>

        <div class="mt-20 pb-20">
            <div class="flex items-center justify-between mb-10">
                <div class="flex flex-col gap-1">
                    <h2 class="font-black text-[32px] text-[#0A090B] tracking-tight">Assessment Module</h2>
                    <p class="text-[#7F8190] font-medium">Manage questions and tests for this course.</p>
                </div>
                <div class="px-5 py-2.5 bg-[#0A090B] rounded-full text-[11px] font-black text-white uppercase tracking-[0.2em] shadow-xl shadow-gray-200">
                    {{ questions.length }} Questions Loaded
                </div>
            </div>

            <div class="grid grid-cols-1 gap-8">
                <!-- Add New Question Card -->
                <Link :href="route('dashboard.course.question.create', course.id)"
                    class="w-full group bg-[#6436F1] p-1.5 rounded-[40px] shadow-2xl shadow-indigo-100 hover:shadow-indigo-200 transition-all active:scale-[0.99] border-4 border-transparent hover:border-white">
                    <div class="w-full h-[140px] flex items-center justify-center p-8 border-2 border-dashed border-white/30 rounded-[36px] group-hover:border-white/60 transition-colors">
                        <div class="flex items-center gap-6">
                            <div class="w-16 h-16 rounded-[24px] bg-white text-[#6436F1] flex items-center justify-center shadow-xl group-hover:scale-110 transition-transform duration-500">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14" stroke-width="4" stroke-linecap="round"/></svg>
                            </div>
                            <div class="flex flex-col text-left">
                                <p class="font-black text-2xl text-white">Create New Question</p>
                                <p class="text-white/60 font-bold text-sm uppercase tracking-widest">Build your assessment database</p>
                            </div>
                        </div>
                    </div>
                </Link>

                <!-- Question Cards -->
                <div v-for="(question, index) in questions" :key="question.id"
                    class="w-full flex flex-col lg:flex-row lg:items-center justify-between p-8 lg:p-10 bg-white border border-gray-100 rounded-[40px] hover:shadow-2xl hover:shadow-gray-100/40 transition-all group animate-slide-up relative overflow-hidden"
                    :style="`animation-delay: ${index * 50}ms`"
                >
                    <div class="absolute top-0 left-0 w-2 h-full bg-[#6436F1] opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    
                    <div class="flex items-center gap-8 lg:w-[70%]">
                        <div class="w-16 h-16 shrink-0 rounded-2xl bg-gray-50 flex items-center justify-center font-black text-2xl text-[#A5ABB2] border border-gray-100 group-hover:bg-[#EAE8FE] group-hover:text-[#6436F1] transition-colors">
                            {{ index + 1 }}
                        </div>
                        <div class="flex flex-col gap-2">
                            <p class="text-[10px] font-black text-[#A5ABB2] uppercase tracking-[0.2em]">Question Description</p>
                            <p class="font-black text-2xl text-[#0A090B] leading-tight">{{ question.question }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-4 mt-8 lg:mt-0">
                        <Link :href="route('dashboard.course.question.edit', { courseId: course.id, questionId: question.id })"
                            class="px-10 py-5 bg-[#0A090B] text-white font-black rounded-[20px] text-[13px] uppercase tracking-widest hover:bg-[#6436F1] transition-all active:scale-95 shadow-lg shadow-gray-200">
                            Edit Content
                        </Link>
                        <button @click="confirmDeleteQuestion(question.id)"
                            class="w-[60px] h-[60px] flex shrink-0 items-center justify-center rounded-[20px] bg-white border border-gray-100 text-[#FD445E] hover:bg-[#FD445E] hover:text-white transition-all active:scale-95 shadow-sm group/trash">
                            <svg class="w-6 h-6 group-hover/trash:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Empty State -->
                <div v-if="questions.length === 0" class="py-24 bg-gray-50/50 rounded-[48px] text-center border-2 border-dashed border-gray-100">
                    <img src="/assets/images/icons/note-text.svg" class="w-16 h-16 mx-auto mb-6 opacity-10" alt="icon">
                    <p class="text-[#7F8190] font-black text-xl">No assessment modules found.</p>
                    <p class="text-gray-400 font-medium mt-2">Start adding questions to this course to begin testing students.</p>
                </div>
            </div>
        </div>

        <AlertDialog
            :show="isDeleteDialogOpen"
            title="Hapus Pertanyaan?"
            message="Apakah Anda yakin ingin menghapus pertanyaan ini? Tindakan ini tidak dapat dibatalkan."
            confirm-text="Ya, Hapus"
            cancel-text="Batal"
            type="danger"
            @close="isDeleteDialogOpen = false"
            @confirm="deleteQuestion"
        />
    </AdminLayout>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap');
.font-poppins {
    font-family: 'Poppins', sans-serif;
}
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
@keyframes slideUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in { animation: fadeIn 0.8s ease-out forwards; }
.animate-slide-up {
    animation: slideUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
