<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    course: {
        type: Object,
        required: true,
    },
    courseQuestion: {
        type: Object,
        required: true,
    },
});

const initialCorrectAnswer = props.courseQuestion.answers.findIndex(a => a.is_correct);

const form = useForm({
    question: props.courseQuestion.question,
    answers: props.courseQuestion.answers.map(a => a.answer),
    correct_answer: initialCorrectAnswer !== -1 ? initialCorrectAnswer : null,
    _method: 'PUT',
});

const submit = () => {
    form.post(route('dashboard.course.question.update', { 
        courseId: props.course.id, 
        questionId: props.courseQuestion.id 
    }));
};
</script>

<template>
    <Head title="Edit Question" />

    <AdminLayout>
        <div class="flex flex-col gap-10 px-5 mt-5 text-sm">
            <div class="breadcrumb flex items-center gap-[30px]">
                <Link :href="route('dashboard')" class="text-[#7F8190] last:text-[#0A090B] last:font-semibold text-sm">Home</Link>
                <span class="text-[#7F8190] last:text-[#0A090B]">/</span>
                <Link :href="route('dashboard.courses.show', course.id)" class="text-[#7F8190] last:text-[#0A090B] last:font-semibold text-sm">Course Details</Link>
                <span class="text-[#7F8190] last:text-[#0A090B]">/</span>
                <p class="text-[#7F8190] last:text-[#0A090B] last:font-semibold text-sm">Edit Question</p>
            </div>
        </div>
        <div class="header ml-[70px] pr-[70px] w-[940px] flex items-center justify-between mt-10">
            <div class="flex gap-6 items-center">
                <div class="w-[150px] h-[150px] flex shrink-0 relative overflow-hidden">
                    <img :src="'/storage/' + course.cover" class="w-full h-full object-contain" alt="icon">
                </div>
                <div class="flex flex-col gap-5">
                    <h1 class="font-extrabold text-[30px] leading-[45px]">
                        {{ course.name }}
                    </h1>
                </div>
            </div>
        </div>

        <div v-if="Object.keys(form.errors).length > 0" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mx-[70px] mt-5" role="alert">
            <strong class="font-bold">Whoops!</strong>
            <ul class="mt-2">
                <li v-for="error in form.errors" :key="error">{{ error }}</li>
            </ul>
        </div>

        <form @submit.prevent="submit" id="add-question" class="mx-[70px] mt-[30px] flex flex-col gap-5 pb-10">
            <h2 class="font-bold text-2xl">Edit Question</h2>
            <div class="flex flex-col gap-[10px]">
                <p class="font-semibold">Question</p>
                <div class="flex items-center w-[500px] h-[52px] p-[14px_16px] rounded-full border border-[#EEEEEE] focus-within:border-2 focus-within:border-[#0A090B]">
                    <div class="mr-[14px] w-6 h-6 flex items-center justify-center overflow-hidden">
                        <img src="/assets/images/icons/note-text.svg" class="h-full w-full object-contain" alt="icon">
                    </div>
                    <input v-model="form.question" type="text" class="font-semibold placeholder:text-[#7F8190] placeholder:font-normal w-full outline-none" placeholder="Write the question" required>
                </div>
            </div>
            <div class="flex flex-col gap-[10px]">
                <p class="font-semibold">Answers</p>

                <div v-for="(answer, index) in form.answers" :key="index" class="flex items-center gap-4">
                    <div class="flex items-center w-[500px] h-[52px] p-[14px_16px] rounded-full border border-[#EEEEEE] focus-within:border-2 focus-within:border-[#0A090B]">
                        <div class="mr-[14px] w-6 h-6 flex items-center justify-center overflow-hidden">
                            <img src="/assets/images/icons/edit.svg" class="h-full w-full object-contain" alt="icon">
                        </div>
                        <input v-model="form.answers[index]" type="text" class="font-semibold placeholder:text-[#7F8190] placeholder:font-normal w-full outline-none" placeholder="Write better answer option" required>
                    </div>
                    <label class="font-semibold flex items-center gap-[10px]">
                        <input
                            v-model="form.correct_answer"
                            type="radio"
                            :value="index"
                            class="w-[24px] h-[24px] appearance-none checked:border-[3px] checked:border-solid checked:border-white rounded-full checked:bg-[#2B82FE] ring ring-[#EEEEEE]"
                            required
                        />
                        Correct
                    </label>
                </div>
            </div>
            <button type="submit" :disabled="form.processing" class="w-[500px] h-[52px] p-[14px_20px] bg-[#6436F1] rounded-full font-bold text-white transition-all duration-300 hover:shadow-[0_4px_15px_0_#6436F14D] text-center disabled:opacity-50">Update Question</button>
        </form>
    </AdminLayout>
</template>
