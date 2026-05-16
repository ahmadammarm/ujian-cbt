<script setup>
import AdminLayout from '@/Components/Templates/AdminLayout.vue';
import Breadcrumbs from '@/Components/Molecules/Breadcrumbs.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    course: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    question: '',
    answers: ['', '', '', ''],
    correct_answer: null,
});

const submit = () => {
    form.post(route('dashboard.course.question.store', props.course.id));
};
</script>

<template>
    <Head title="Add New Question" />

    <AdminLayout>
        <Breadcrumbs :items="[
            { label: 'Dashboard', href: route('dashboard.overview') },
            { label: 'Courses', href: route('dashboard.courses.index') },
            { label: 'Course Details', href: route('dashboard.courses.show', course.id) },
            { label: 'Add Question' }
        ]" />

        <div class="header w-full flex items-center justify-between mb-12 animate-slide-up">
            <div class="flex gap-8 items-center">
                <div class="w-[150px] h-[150px] flex shrink-0 relative overflow-hidden group border-4 border-white shadow-xl rounded-[32px]">
                    <img :src="'/storage/' + course.cover" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" alt="icon">
                </div>
                <div class="flex flex-col gap-4">
                    <h1 class="font-black text-[36px] leading-tight text-[#0A090B] tracking-tighter">
                        {{ course.name }}
                    </h1>
                    <p class="text-[#7F8190] font-bold text-lg uppercase tracking-widest">Adding New Question</p>
                </div>
            </div>
        </div>

        <div v-if="Object.keys(form.errors).length > 0" class="mb-10 p-6 bg-red-50 border border-red-100 rounded-[32px] max-w-3xl">
            <div class="flex items-center gap-3 text-red-600 font-black mb-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <span>Validation Error</span>
            </div>
            <ul class="text-xs text-red-500 space-y-1 ml-8 list-disc font-bold uppercase tracking-widest">
                <li v-for="error in form.errors" :key="error">{{ error }}</li>
            </ul>
        </div>

        <form @submit.prevent="submit" class="max-w-4xl bg-white p-10 rounded-[40px] shadow-[0_10px_40px_rgb(0,0,0,0.03)] border border-gray-50 animate-slide-up">
            <div class="space-y-10">
                <div class="space-y-4">
                    <h2 class="text-2xl font-black text-[#0A090B] flex items-center gap-3">
                        <span class="w-10 h-10 rounded-xl bg-gray-900 text-white flex items-center justify-center text-sm">1</span>
                        The Question
                    </h2>
                    <div class="relative group">
                        <div class="absolute left-5 top-5 w-6 h-6 text-gray-400 group-focus-within:text-[#D95300] transition-colors">
                            <img src="/assets/images/icons/note-text.svg" class="w-full h-full" alt="icon">
                        </div>
                        <textarea v-model="form.question" rows="3" class="w-full pl-16 pr-6 py-5 bg-gray-50/50 border-none ring-1 ring-gray-200 focus:ring-2 focus:ring-[#D95300] rounded-[24px] transition-all duration-300 font-bold text-gray-700 placeholder:text-gray-300" placeholder="Write your question clearly here..." required></textarea>
                    </div>
                </div>

                <div class="space-y-6">
                    <h2 class="text-2xl font-black text-[#0A090B] flex items-center gap-3">
                        <span class="w-10 h-10 rounded-xl bg-gray-900 text-white flex items-center justify-center text-sm">2</span>
                        Answer Options
                    </h2>
                    
                    <div class="grid grid-cols-1 gap-4">
                        <div v-for="(answer, index) in form.answers" :key="index" 
                            class="flex items-center gap-4 group/item">
                            <div class="flex-1 relative">
                                <div class="absolute left-5 top-1/2 -translate-y-1/2 w-6 h-6 text-gray-400 group-focus-within/item:text-[#D95300] transition-colors font-poppins">
                                    <img src="/assets/images/icons/edit.svg" class="w-full h-full" alt="icon">
                                </div>
                                <input v-model="form.answers[index]" type="text" 
                                    class="w-full pl-16 pr-6 py-4 bg-gray-50/50 border-none ring-1 ring-gray-200 focus:ring-2 focus:ring-[#D95300] rounded-2xl transition-all duration-300 font-bold text-gray-700" 
                                    :placeholder="'Option ' + (index + 1)" required>
                            </div>
                            <label class="cursor-pointer relative flex items-center">
                                <input
                                    v-model="form.correct_answer"
                                    type="radio"
                                    :value="index"
                                    class="peer sr-only"
                                    required
                                />
                                <div class="px-6 py-4 bg-gray-50 text-gray-400 font-black rounded-2xl border-2 border-transparent peer-checked:bg-green-50 peer-checked:text-green-600 peer-checked:border-green-500 transition-all uppercase tracking-widest text-[11px]">
                                    Correct
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="pt-6 flex items-center gap-5">
                    <Link :href="route('dashboard.courses.show', course.id)" 
                        class="flex-1 text-center py-5 bg-gray-100 hover:bg-gray-200 text-[#0A090B] font-black uppercase tracking-widest text-[13px] rounded-2xl transition-all">
                        Cancel
                    </Link>
                    <PrimaryButton class="flex-[2] py-5 text-[13px] font-black uppercase tracking-widest" :disabled="form.processing">
                        Save Question
                    </PrimaryButton>
                </div>
            </div>
        </form>
    </AdminLayout>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap');
.font-poppins {
    font-family: 'Poppins', sans-serif;
}
@keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
.animate-slide-up { animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
</style>

