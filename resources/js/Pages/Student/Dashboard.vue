<script setup>
import StudentLayout from '@/Components/Templates/StudentLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    courses: Array,
    assessments: Array
});

const getLatestScore = (courseId) => {
    const assessment = props.assessments.find(a => a.course_id === courseId);
    return assessment ? assessment.score : null;
};
</script>

<template>
    <Head title="Student Dashboard" />

    <StudentLayout>
        <div class="flex flex-col gap-10">
            <!-- Welcome Header -->
            <div class="flex flex-col gap-2">
                <h2 class="font-extrabold text-[32px] leading-[48px]">Welcome back, {{ $page.props.auth.user.name }}! 👋</h2>
                <p class="text-gray-500">Here's an overview of your learning progress and recent activities.</p>
            </div>

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-8 bg-white border border-[#EEEEEE] rounded-[32px] flex flex-col gap-4 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-[#EAE8FE] rounded-2xl flex items-center justify-center">
                        <img src="/assets/images/icons/note-favorite.svg" class="w-6 h-6" alt="icon">
                    </div>
                    <div>
                        <p class="text-[#7F8190] font-bold text-sm uppercase tracking-wider">Enrolled Courses</p>
                        <p class="text-3xl font-black mt-1">{{ courses.length }}</p>
                    </div>
                </div>

                <div class="p-8 bg-white border border-[#EEEEEE] rounded-[32px] flex flex-col gap-4 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-[#E6F9E6] rounded-2xl flex items-center justify-center">
                        <img src="/assets/images/icons/chart-2.svg" class="w-6 h-6" alt="icon">
                    </div>
                    <div>
                        <p class="text-[#7F8190] font-bold text-sm uppercase tracking-wider">Completed Tests</p>
                        <p class="text-3xl font-black mt-1">{{ assessments.filter(a => a.finished_at).length }}</p>
                    </div>
                </div>

                <div class="p-8 bg-white border border-[#EEEEEE] rounded-[32px] flex flex-col gap-4 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-[#FDEBEA] rounded-2xl flex items-center justify-center">
                        <img src="/assets/images/icons/receipt-text.svg" class="w-6 h-6" alt="icon">
                    </div>
                    <div>
                        <p class="text-[#7F8190] font-bold text-sm uppercase tracking-wider">Average Score</p>
                        <p class="text-3xl font-black mt-1">
                            {{ assessments.length > 0 ? Math.round(assessments.reduce((acc, a) => acc + (a.score || 0), 0) / assessments.length) : 0 }}%
                        </p>
                    </div>
                </div>
            </div>

            <!-- Recent Assessments -->
            <div class="flex flex-col gap-6">
                <div class="flex items-center justify-between">
                    <h3 class="font-bold text-2xl">Recent Activities</h3>
                    <Link :href="route('dashboard.learning.index')" class="text-[#2B82FE] font-bold text-sm hover:underline">View All Courses</Link>
                </div>

                <div v-if="assessments.length > 0" class="flex flex-col gap-4">
                    <div v-for="assessment in assessments.slice(0, 5)" :key="assessment.id" class="bg-white border border-[#EEEEEE] p-6 rounded-[24px] flex items-center justify-between hover:border-[#2B82FE] transition-colors group">
                        <div class="flex items-center gap-5">
                            <div class="w-14 h-14 rounded-2xl bg-gray-50 flex items-center justify-center overflow-hidden">
                                <img v-if="assessment.course.cover" :src="'/storage/' + assessment.course.cover" class="w-full h-full object-cover">
                                <div v-else class="text-[#2B82FE] font-bold">{{ assessment.course.name.substring(0, 2) }}</div>
                            </div>
                            <div class="flex flex-col">
                                <p class="font-bold text-lg group-hover:text-[#2B82FE] transition-colors">{{ assessment.course.name }}</p>
                                <p class="text-sm text-gray-400 font-medium">Taken on {{ new Date(assessment.created_at).toLocaleDateString() }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-8">
                            <div class="flex flex-col text-right">
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Score</p>
                                <p class="text-xl font-black" :class="assessment.score >= 70 ? 'text-[#06BC65]' : 'text-[#FD445E]'">
                                    {{ assessment.score }}%
                                </p>
                            </div>
                            <Link :href="route('dashboard.learning.report', assessment.id)" class="w-12 h-12 rounded-xl border border-[#EEEEEE] flex items-center justify-center hover:bg-gray-50 transition-all">
                                <img src="/assets/images/icons/receipt-text.svg" class="w-5 h-5 opacity-40">
                            </Link>
                        </div>
                    </div>
                </div>

                <div v-else class="p-20 bg-gray-50 rounded-[40px] border-2 border-dashed border-gray-100 text-center">
                    <div class="w-20 h-20 bg-white rounded-3xl shadow-sm flex items-center justify-center mx-auto mb-6">
                        <img src="/assets/images/icons/note-favorite.svg" class="w-10 h-10 opacity-10" alt="icon">
                    </div>
                    <p class="text-[#7F8190] font-black text-xl">No activities yet.</p>
                    <p class="text-gray-400 font-medium mt-2">Start your first course to see your progress here.</p>
                    <Link :href="route('dashboard.learning.index')" class="mt-8 inline-flex px-8 py-4 bg-[#2B82FE] text-white rounded-2xl font-bold hover:bg-blue-600 transition-all shadow-lg shadow-blue-100">
                        Browse Courses
                    </Link>
                </div>
            </div>
        </div>
    </StudentLayout>
</template>
