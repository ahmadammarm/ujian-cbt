<script setup>
import StudentLayout from '@/Components/Templates/StudentLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    courses: Array
});
</script>

<template>
    <Head title="My Courses" />

    <StudentLayout>
        <div class="flex flex-col gap-10">
            <div class="flex items-center justify-between">
                <div class="flex flex-col gap-2">
                    <h2 class="font-bold text-[32px] leading-[48px]">My Courses</h2>
                    <p class="text-gray-500">Assess your skills and track your learning progress.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div v-for="course in courses" :key="course.id" class="flex flex-col bg-white border border-[#EEEEEE] rounded-[32px] overflow-hidden transition-all duration-300 hover:shadow-xl hover:shadow-gray-100 group">
                    <div class="relative w-full h-[200px] overflow-hidden">
                        <img v-if="course.cover" :src="'/storage/' + course.cover" :alt="course.name" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div v-else class="w-full h-full bg-[#2B82FE]/10 flex items-center justify-center">
                            <span class="text-[#2B82FE] font-bold text-4xl uppercase">{{ course.name.substring(0, 2) }}</span>
                        </div>
                        <div class="absolute top-4 left-4">
                            <span class="bg-white/90 backdrop-blur-sm text-[#0A090B] text-[12px] font-bold px-4 py-2 rounded-full shadow-sm">{{ course.category.name }}</span>
                        </div>
                    </div>
                    
                    <div class="p-6 flex flex-col gap-6">
                        <div class="flex flex-col gap-2">
                            <h3 class="text-xl font-bold text-[#0A090B] line-clamp-1">{{ course.name }}</h3>
                            <div class="flex items-center gap-2">
                                <img src="/assets/images/icons/note-favorite.svg" class="w-4 h-4 opacity-40" alt="icon">
                                <span class="text-sm text-gray-400 font-medium">{{ course.questions_count }} Questions</span>
                            </div>
                        </div>
                        
                        <div v-if="course.latest_assessment" class="p-4 bg-[#FBFBFB] rounded-2xl border border-[#EEEEEE] flex items-center justify-between">
                            <div class="flex flex-col">
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Latest Score</p>
                                <p class="text-lg font-bold" :class="course.latest_assessment.score >= 70 ? 'text-[#06BC65]' : 'text-[#D95300]'">
                                    {{ course.latest_assessment.score ?? '---' }}%
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Status</p>
                                <p class="text-[12px] font-bold" :class="course.latest_assessment.score >= 70 ? 'text-[#06BC65]' : 'text-[#D95300]'">
                                    {{ course.latest_assessment.score >= 70 ? 'PASSED' : 'RETAKE' }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 mt-auto">
                            <Link 
                                :href="route('dashboard.learning.start', course.id)" 
                                method="post" 
                                as="button"
                                class="flex-1 inline-flex justify-center items-center px-6 py-4 bg-[#0A090B] text-white rounded-2xl font-bold text-sm hover:bg-[#2B82FE] transition-all duration-300 shadow-lg shadow-gray-200"
                            >
                                {{ course.latest_assessment ? 'Retake Test' : 'Start Test' }}
                            </Link>
                            <Link 
                                v-if="course.latest_assessment"
                                :href="route('dashboard.learning.report', course.latest_assessment.id)"
                                class="w-14 h-14 flex items-center justify-center bg-white border border-[#EEEEEE] rounded-2xl hover:bg-gray-50 transition-all duration-300"
                            >
                                <img src="/assets/images/icons/receipt-text.svg" class="w-6 h-6" alt="icon">
                            </Link>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="courses.length === 0" class="flex flex-col items-center justify-center py-20 bg-[#FBFBFB] border-2 border-dashed border-[#EEEEEE] rounded-[32px]">
                <img src="/assets/images/icons/note-favorite.svg" class="w-16 h-16 opacity-10 mb-4" alt="icon">
                <p class="text-gray-400 font-bold">No courses available at the moment.</p>
            </div>
        </div>
    </StudentLayout>
</template>
