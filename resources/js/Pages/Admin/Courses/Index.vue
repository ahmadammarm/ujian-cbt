<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    courses: {
        type: Array,
        required: true,
    },
});

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

const deleteForm = useForm({});

const deleteCourse = (id) => {
    if (confirm('Are you sure you want to delete this course?')) {
        deleteForm.delete(route('dashboard.courses.destroy', id));
    }
};
</script>

<template>
    <Head title="Manage Courses" />

    <AdminLayout>
        <div class="flex flex-col px-5 mt-5">
            <div class="w-full flex justify-between items-center">
                <div class="flex flex-col gap-1">
                    <p class="font-extrabold text-[30px] leading-[45px]">Manage Course</p>
                    <p class="text-[#7F8190]">Provide high quality for best students</p>
                </div>
                <Link :href="route('dashboard.courses.create')"
                    class="h-[52px] p-[14px_20px] bg-[#6436F1] rounded-full font-bold text-white transition-all duration-300 hover:shadow-[0_4px_15px_0_#6436F14D]">Add
                    New Course</Link>
            </div>
        </div>
        <div class="course-list-container flex flex-col px-5 mt-[30px] gap-[30px]">
            <div class="course-list-header flex flex-nowrap justify-between pb-4 pr-10 border-b border-[#EEEEEE]">
                <div class="flex shrink-0 w-[300px]">
                    <p class="text-[#7F8190]">Course</p>
                </div>
                <div class="flex justify-center shrink-0 w-[150px]">
                    <p class="text-[#7F8190]">Date Created</p>
                </div>
                <div class="flex justify-center shrink-0 w-[170px]">
                    <p class="text-[#7F8190]">Category</p>
                </div>
                <div class="flex justify-center shrink-0 w-[120px]">
                    <p class="text-[#7F8190]">Action</p>
                </div>
            </div>
            
            <div v-for="course in courses" :key="course.id" class="list-items flex flex-nowrap justify-between pr-10">
                <div class="flex shrink-0 w-[300px]">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 flex shrink-0 overflow-hidden rounded-full">
                            <img :src="'/storage/' + course.cover" class="object-cover w-full h-full" alt="thumbnail">
                        </div>
                        <div class="flex flex-col gap-[2px]">
                            <p class="font-bold text-lg">
                                {{ course.name }}
                            </p>
                            <p class="text-[#7F8190]">
                                {{ course.category?.name }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="flex shrink-0 w-[150px] items-center justify-center">
                    <p class="font-semibold">
                        {{ formatDate(course.created_at) }}
                    </p>
                </div>
                <div class="flex shrink-0 w-[170px] items-center justify-center">
                    <p v-if="course.category?.name === 'Programming'" class="p-[8px_16px] rounded-full bg-[#EAE8FE] font-bold text-sm text-[#6436F1]">
                        {{ course.category?.name }}
                    </p>
                    <p v-else-if="course.category?.name === 'Design'" class="p-[8px_16px] rounded-full bg-[#FDEBEA] font-bold text-sm text-[#FD445E]">
                        {{ course.category?.name }}
                    </p>
                    <p v-else-if="course.category?.name === 'Marketing'" class="p-[8px_16px] rounded-full bg-[#E6F9E6] font-bold text-sm text-[#28A745]">
                        {{ course.category?.name }}
                    </p>
                    <p v-else-if="course.category" class="p-[8px_16px] rounded-full bg-gray-100 font-bold text-sm text-gray-600">
                        {{ course.category?.name }}
                    </p>
                </div>
                <div class="flex shrink-0 w-[120px] items-center">
                    <div class="relative h-[41px]">
                        <div class="menu-dropdown w-[120px] max-h-[41px] overflow-hidden absolute top-0 p-[10px_16px] bg-white flex flex-col gap-3 border border-[#EEEEEE] transition-all duration-300 hover:shadow-[0_10px_16px_0_#0A090B0D] rounded-[18px]">
                            <button @click="toggleMaxHeight"
                                class="flex items-center justify-between font-bold text-sm w-full">
                                menu
                                <img src="/assets/images/icons/arrow-down.svg" alt="icon">
                            </button>
                            <Link :href="route('dashboard.courses.show', course.id)"
                                class="flex items-center justify-between font-bold text-sm w-full">
                                Manage
                            </Link>
                            <a href="#" class="flex items-center justify-between font-bold text-sm w-full">
                                Students
                            </a>
                            <Link :href="route('dashboard.courses.edit', course.id)"
                                class="flex items-center justify-between font-bold text-sm w-full">
                                Edit Course
                            </Link>
                            <button @click="confirmDeleteCourse(course.id)" class="flex items-center justify-between font-bold text-sm w-full text-[#FD445E]">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="courses.length === 0" class="list-items flex flex-nowrap justify-between pr-10">
                <div class="flex shrink-0 w-[300px]">
                    <p class="text-center text-[#7F8190]">No courses available</p>
                </div>
                <div class="flex shrink-0 w-[150px] items-center justify-center">
                    <p class="text-center text-[#7F8190]">N/A</p>
                </div>
            </div>
        </div>

        <AlertDialog
            :show="isDeleteDialogOpen"
            title="Hapus Kursus?"
            message="Apakah Anda yakin ingin menghapus kursus ini? Tindakan ini tidak dapat dibatalkan."
            confirm-text="Ya, Hapus"
            cancel-text="Batal"
            type="danger"
            @close="isDeleteDialogOpen = false"
            @confirm="deleteCourse"
        />
    </AdminLayout>
</template>
