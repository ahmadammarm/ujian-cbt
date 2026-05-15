<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import AlertDialog from '@/Components/AlertDialog.vue';
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
        <div class="flex flex-col gap-10 px-5 mt-5 text-sm">
            <div class="breadcrumb flex items-center gap-[30px]">
                <Link :href="route('dashboard')"
                    class="text-[#7F8190] last:text-[#0A090B] last:font-semibold">Home</Link>
                <span class="text-[#7F8190] last:text-[#0A090B]">/</span>
                <Link :href="route('dashboard.courses.index')"
                    class="text-[#7F8190] last:text-[#0A090B] last:font-semibold">Manage
                    Courses</Link>
                <span class="text-[#7F8190] last:text-[#0A090B]">/</span>
                <p class="text-[#7F8190] last:text-[#0A090B] last:font-semibold">Course Details</p>
            </div>
        </div>
        <div class="header ml-[70px] pr-[70px] w-[940px] flex items-center justify-between mt-10">
            <div class="flex gap-6 items-center">
                <div class="w-[150px] h-[150px] flex shrink-0 relative overflow-hidden">
                    <img :src="'/storage/' + course.cover" class="w-full h-full object-contain"
                        alt="icon">
                    <p v-if="course.category"
                        class="p-[8px_16px] rounded-full bg-[#FFF2E6] font-bold text-sm text-[#F6770B] absolute bottom-0 transform -translate-x-1/2 left-1/2 text-nowrap">
                        {{ course.category?.name }}</p>
                </div>

                <div class="flex flex-col gap-5">
                    <h1 class="font-extrabold text-[30px] leading-[45px]">
                        {{ course.name }}
                    </h1>
                    <div class="flex items-center gap-5">
                        <div class="flex gap-[10px] items-center">
                            <div class="w-6 h-6 flex shrink-0">
                                <img src="/assets/images/icons/calendar-outline.svg"
                                    alt="icon">
                            </div>
                            <p class="font-semibold">
                                {{ formatDate(course.created_at) }}
                            </p>
                        </div>
                        <div class="flex gap-[10px] items-center">
                            <div class="w-6 h-6 flex shrink-0">
                                <img src="/assets/images/icons/profile-2user-outline.svg"
                                    alt="icon">
                            </div>
                            <p class="font-semibold">
                                {{ students.length }} Students
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="relative" ref="moreButton">
                <button @click="toggleDropdown"
                    class="toggle-button w-[46px] h-[46px] flex shrink-0 rounded-full items-center justify-center border border-[#EEEEEE]">
                    <img src="/assets/images/icons/more.svg" alt="icon">
                </button>
                <div v-show="isDropdownOpen"
                    class="dropdown-menu absolute right-0 top-[66px] w-[270px] flex flex-col gap-4 p-5 border border-[#EEEEEE] bg-white rounded-[18px] transition-all duration-300 shadow-[0_10px_16px_0_#0A090B0D] z-20">
                    <a href="#" class="flex gap-[10px] items-center">
                        <div class="w-5 h-5">
                            <img src="/assets/images/icons/profile-2user-outline.svg"
                                alt="icon">
                        </div>
                        <span class="font-semibold text-sm">Add Students</span>
                    </a>
                    <Link :href="route('dashboard.courses.edit', course.id)" class="flex gap-[10px] items-center text-[#0A090B]">
                        <div class="w-5 h-5">
                            <img src="/assets/images/icons/note-favorite-outline.svg"
                                alt="icon">
                        </div>
                        <span class="font-semibold text-sm">Edit Course Details</span>
                    </Link>
                    <a href="#" class="flex gap-[10px] items-center">
                        <div class="w-5 h-5">
                            <img src="/assets/images/icons/crown-outline.svg" alt="icon">
                        </div>
                        <span class="font-semibold text-sm">Upload Certificate</span>
                    </a>
                    <button class="flex gap-[10px] items-center text-[#FD445E]">
                        <div class="w-5 h-5">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M17.5 4.98332C14.725 4.70832 11.9333 4.56665 9.15 4.56665C7.5 4.56665 5.85 4.64998 4.2 4.81665L2.5 4.98332"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M7.08325 4.14163L7.26659 3.04996C7.39992 2.25829 7.49992 1.66663 8.90825 1.66663H11.0916C12.4999 1.66663 12.6083 2.29163 12.7333 3.05829L12.9166 4.14163"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M15.7084 7.6167L15.1667 16.0084C15.0751 17.3167 15.0001 18.3334 12.6751 18.3334H7.32508C5.00008 18.3334 4.92508 17.3167 4.83341 16.0084L4.29175 7.6167"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M8.6084 13.75H11.3834" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M7.91675 10.4166H12.0834" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <span class="font-semibold text-sm">Delete Course</span>
                    </button>
                </div>
            </div>
        </div>
        <div id="course-test" class="mx-[70px] w-[870px] mt-[30px]">
            <h2 class="font-bold text-2xl">Course Tests</h2>
            <div class="flex flex-col gap-[30px] mt-2">
                <Link :href="route('dashboard.course.question.create', course.id)"
                    class="w-full h-[92px] flex items-center justify-center p-4 border-dashed border-2 border-[#0A090B] rounded-[20px]">
                    <div class="flex items-center gap-5">
                        <div>
                            <img src="/assets/images/icons/note-add.svg" alt="icon">
                        </div>
                        <p class="font-bold text-xl">New Question</p>
                    </div>
                </Link>
                <div v-for="question in questions" :key="question.id"
                    class="question-card w-full flex items-center justify-between p-4 border border-[#EEEEEE] rounded-[20px]">
                    <div class="flex flex-col gap-[6px]">
                        <p class="text-[#7F8190]">Question</p>
                        <p class="font-bold text-xl">{{ question.question }}</p>
                    </div>
                    <div class="flex items-center gap-[14px]">
                        <Link :href="route('dashboard.course.question.edit', { courseId: course.id, questionId: question.id })"
                            class="bg-[#0A090B] p-[14px_30px] rounded-full text-white font-semibold">Edit</Link>
                        <button @click="confirmDeleteQuestion(question.id)"
                            class="w-[52px] h-[52px] flex shrink-0 items-center justify-center rounded-full bg-[#FD445E]">
                            <img src="/assets/images/icons/trash.svg" alt="icon">
                        </button>
                    </div>
                </div>
                <p v-if="questions.length === 0" class="text-center text-[#7F8190]">No questions found for this course.</p>
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
