<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    categories: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    name: '',
    category_id: '',
    cover: null,
    // Add other fields if necessary based on your model/schema
    course_type: 'Onboarding', // default
    publish_date: 'Active Now', // default
    access: 'Invitation Only', // default
    tnc: true,
});

const previewUrl = ref(null);
const fileInput = ref(null);

const onFileChange = (e) => {
    const file = e.target.files[0];
    form.cover = file;
    if (file) {
        previewUrl.value = URL.createObjectURL(file);
    } else {
        previewUrl.value = null;
    }
};

const submit = () => {
    form.post(route('dashboard.courses.store'), {
        forceFormData: true,
    });
};
</script>

<template>
    <Head title="New Course" />

    <AdminLayout>
        <div class="flex flex-col gap-10 px-5 mt-5">
            <div class="breadcrumb flex items-center gap-[30px]">
                <Link :href="route('dashboard')" class="text-[#7F8190] last:text-[#0A090B] last:font-semibold text-sm">Home</Link>
                <span class="text-[#7F8190] last:text-[#0A090B]">/</span>
                <Link :href="route('dashboard.courses.index')" class="text-[#7F8190] last:text-[#0A090B] last:font-semibold text-sm">Manage
                    Courses</Link>
                <span class="text-[#7F8190] last:text-[#0A090B]">/</span>
                <p class="text-[#7F8190] last:text-[#0A090B] last:font-semibold text-sm">New Course</p>
            </div>
        </div>
        <div class="header flex flex-col gap-1 px-5 mt-5">
            <h1 class="font-extrabold text-[30px] leading-[45px]">New Course</h1>
            <p class="text-[#7F8190]">Provide high quality for best students</p>
        </div>

        <div v-if="Object.keys(form.errors).length > 0" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mx-[70px] mt-5"
            role="alert">
            <strong class="font-bold">Whoops!</strong>
            <ul class="mt-2">
                <li v-for="error in form.errors" :key="error">{{ error }}</li>
            </ul>
        </div>

        <form @submit.prevent="submit" class="flex flex-col gap-[30px] w-[500px] mx-[70px] mt-10">
            <div class="flex gap-5 items-center">
                <input type="file" ref="fileInput" @change="onFileChange" class="hidden" accept="image/*">
                <div
                    class="relative w-[100px] h-[100px] rounded-full overflow-hidden border-[3px] border-dashed border-[#EEEEEE]"
                    :class="{'border-none': previewUrl}"
                >
                    <div v-if="previewUrl" class="relative z-10 w-full h-full">
                        <img :src="previewUrl" class="w-full h-full object-cover" alt="thumbnail">
                    </div>
                    <span v-else
                        class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 text-center font-semibold text-sm text-[#7F8190]">Icon
                        <br>Course</span>
                </div>
                <button type="button"
                    class="flex shrink-0 p-[8px_20px] h-fit items-center rounded-full bg-[#0A090B] font-semibold text-white"
                    @click="fileInput.click()">
                    Add Icon
                </button>
            </div>

            <div class="flex flex-col gap-[10px]">
                <p class="font-semibold">Course Name</p>
                <div
                    class="flex items-center w-[500px] h-[52px] p-[14px_16px] rounded-full border border-[#EEEEEE] transition-all duration-300 focus-within:border-2 focus-within:border-[#0A090B]">
                    <div class="mr-[14px] w-6 h-6 flex items-center justify-center overflow-hidden">
                        <img src="/assets/images/icons/note-favorite-outline.svg"
                            class="w-full h-full object-contain" alt="icon">
                    </div>
                    <input v-model="form.name" type="text"
                        class="font-semibold placeholder:text-[#7F8190] placeholder:font-normal w-full outline-none"
                        placeholder="Write your better course name" required>
                </div>
            </div>

            <div class="group/category flex flex-col gap-[10px]">
                <p class="font-semibold">Category</p>
                <div
                    class="peer flex items-center p-[12px_16px] rounded-full border border-[#EEEEEE] transition-all duration-300 focus-within:border-2 focus-within:border-[#0A090B]">
                    <div class="mr-[10px] w-6 h-6 flex items-center justify-center overflow-hidden">
                        <img src="/assets/images/icons/bill.svg"
                            class="w-full h-full object-contain" alt="icon">
                    </div>
                    <select v-model="form.category_id" id="category"
                        class="pl-1 font-semibold focus:outline-none w-full text-[#0A090B] appearance-none bg-[url('/assets/images/icons/arrow-down.svg')] bg-no-repeat bg-right pr-4"
                        required>
                        <option value="" disabled hidden>Choose one of category</option>
                        <option v-for="category in categories" :key="category.id" :value="category.id" class="font-semibold">
                            {{ category.name }}
                        </option>
                    </select>
                </div>
            </div>

            <div class="flex items-center gap-5 mt-4">
                <button type="button"
                    class="w-full h-[52px] p-[14px_20px] bg-[#0A090B] rounded-full font-semibold text-white transition-all duration-300 text-center">Add
                    to Draft</button>
                <button type="submit" :disabled="form.processing"
                    class="w-full h-[52px] p-[14px_20px] bg-[#6436F1] rounded-full font-bold text-white transition-all duration-300 hover:shadow-[0_4px_15px_0_#6436F14D] text-center disabled:opacity-50">Save
                    Course</button>
            </div>
        </form>
    </AdminLayout>
</template>
