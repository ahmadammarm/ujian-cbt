<script setup>
import StudentLayout from '@/Components/Templates/StudentLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    assessment: Object
});

const formatDate = (date) => {
    return new Date(date).toLocaleString();
};

const getDuration = () => {
    const start = new Date(props.assessment.started_at);
    const end = new Date(props.assessment.finished_at);
    const diff = end - start;
    
    const hours = Math.floor(diff / 3600000);
    const minutes = Math.floor((diff % 3600000) / 60000);
    const seconds = Math.floor((diff % 60000) / 1000);
    
    let result = '';
    if (hours > 0) result += `${hours}h `;
    result += `${minutes}m ${seconds}s`;
    return result;
};
</script>

<template>
    <Head title="Test Result" />

    <StudentLayout>
        <div class="flex flex-col gap-10">
            <div class="flex flex-col gap-2 text-center lg:text-left">
                <h2 class="font-bold text-[32px] leading-[48px]">Test Result</h2>
                <p class="text-gray-500">Congratulations on completing the assessment for <strong>{{ assessment.course.name }}</strong>.</p>
            </div>

            <div class="flex flex-col lg:flex-row gap-10">
                <!-- Score Card -->
                <div class="lg:w-[400px] flex flex-col gap-8 bg-white border border-[#EEEEEE] rounded-[32px] p-8 h-fit">
                    <div class="flex flex-col items-center gap-6">
                        <div class="w-32 h-32 rounded-full flex items-center justify-center border-8 transition-all duration-1000" :class="assessment.score >= 70 ? 'border-[#06BC65]/20 text-[#06BC65]' : 'border-[#FD445E]/20 text-[#FD445E]'">
                            <span class="text-4xl font-extrabold">{{ assessment.score }}%</span>
                        </div>
                        
                        <div class="text-center flex flex-col gap-2">
                            <h3 class="text-2xl font-bold">{{ assessment.score >= 70 ? 'You Passed!' : 'Try Again' }}</h3>
                            <p class="text-sm text-gray-400 font-medium">
                                {{ assessment.score >= 70 
                                    ? 'Great job! You have demonstrated strong mastery of this course material.' 
                                    : 'Don\'t worry, learning is a journey. Review the material and try again when you\'re ready.' 
                                }}
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-col gap-4">
                        <div class="flex items-center justify-between p-4 bg-[#FBFBFB] rounded-2xl border border-[#EEEEEE]">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Status</span>
                            <span class="text-sm font-bold" :class="assessment.score >= 70 ? 'text-[#06BC65]' : 'text-[#FD445E]'">
                                {{ assessment.score >= 70 ? 'CERTIFIED' : 'NOT PASSED' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between p-4 bg-[#FBFBFB] rounded-2xl border border-[#EEEEEE]">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Time Taken</span>
                            <span class="text-sm font-bold text-[#0A090B]">{{ getDuration() }}</span>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3">
                        <Link 
                            :href="route('dashboard.learning.start', assessment.course_id)" 
                            method="post" 
                            as="button"
                            class="w-full py-4 bg-[#2B82FE] text-white rounded-2xl font-bold text-sm hover:bg-blue-600 transition-all shadow-lg shadow-blue-100"
                        >
                            Retake Assessment
                        </Link>
                        <Link 
                            :href="route('dashboard.learning.index')"
                            class="w-full py-4 bg-white border border-[#EEEEEE] rounded-2xl font-bold text-sm text-[#0A090B] hover:bg-gray-50 transition-all text-center"
                        >
                            Back to Courses
                        </Link>
                    </div>
                </div>

                <!-- Detailed Stats -->
                <div class="flex-1 flex flex-col gap-8">
                    <div class="bg-white border border-[#EEEEEE] rounded-[32px] p-8 flex flex-col gap-8">
                        <h4 class="text-xl font-bold">Assessment Details</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex flex-col gap-3">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Course Category</p>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-[#FBFBFB] border border-[#EEEEEE] rounded-xl flex items-center justify-center">
                                        <img src="/assets/images/icons/note-favorite.svg" class="w-5 h-5 opacity-40" alt="icon">
                                    </div>
                                    <span class="font-bold">{{ assessment.course.category.name }}</span>
                                </div>
                            </div>
                            <div class="flex flex-col gap-3">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Completion Date</p>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-[#FBFBFB] border border-[#EEEEEE] rounded-xl flex items-center justify-center">
                                        <img src="/assets/images/icons/sms-tracking.svg" class="w-5 h-5 opacity-40" alt="icon">
                                    </div>
                                    <span class="font-bold">{{ formatDate(assessment.finished_at) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="pt-8 border-t border-[#EEEEEE] flex flex-col gap-6">
                            <h5 class="font-bold">Performance Summary</h5>
                            <p class="text-gray-500 leading-relaxed">
                                This assessment consisted of 50 technical questions. Your final score of <strong>{{ assessment.score }}%</strong> indicates a 
                                {{ assessment.score >= 90 ? 'superior' : (assessment.score >= 70 ? 'strong' : 'developing') }} 
                                understanding of the subject matter.
                            </p>
                            
                            <div class="flex items-center gap-4">
                                <div class="flex-1 h-3 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full transition-all duration-1000" :class="assessment.score >= 70 ? 'bg-[#06BC65]' : 'bg-[#FD445E]'" :style="{ width: assessment.score + '%' }"></div>
                                </div>
                                <span class="font-bold text-lg">{{ assessment.score }}%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </StudentLayout>
</template>
