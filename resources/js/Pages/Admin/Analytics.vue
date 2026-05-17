<script setup>
import AdminLayout from '@/Components/Templates/AdminLayout.vue';
import Breadcrumbs from '@/Components/Molecules/Breadcrumbs.vue';
import { Head } from '@inertiajs/vue3';
import { Line, Bar, Doughnut } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, LineElement, CategoryScale, LinearScale, PointElement, BarElement, ArcElement } from 'chart.js';

ChartJS.register(Title, Tooltip, Legend, LineElement, CategoryScale, LinearScale, PointElement, BarElement, ArcElement);

const props = defineProps({
    enrollmentTrends: Array,
    coursePerformance: Array,
    passFailRatio: Object,
});

const enrollmentData = {
    labels: props.enrollmentTrends.map(t => t.month),
    datasets: [{
        label: 'New Students',
        data: props.enrollmentTrends.map(t => t.count),
        borderColor: '#6436F1',
        backgroundColor: 'rgba(100, 54, 241, 0.1)',
        fill: true,
        tension: 0.4
    }]
};

const performanceData = {
    labels: props.coursePerformance.map((c, index) => `#${index + 1} ${c.name}`),
    datasets: [{
        label: 'Average Score (%)',
        data: props.coursePerformance.map(c => c.avg_score),
        backgroundColor: props.coursePerformance.map((_, index) => index === 0 ? '#6436F1' : '#2B82FE'),
        borderRadius: 8,
    }]
};

const passFailData = {
    labels: ['Passed (>=70)', 'Failed'],
    datasets: [{
        data: [props.passFailRatio.passed, props.passFailRatio.failed],
        backgroundColor: ['#28A745', '#FD445E'],
        borderWidth: 0,
    }]
};

const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            display: false
        }
    }
};
</script>

<template>
    <Head title="Analytics" />
    <AdminLayout>
        <Breadcrumbs :items="[
            { label: 'Dashboard', href: route('dashboard.overview') },
            { label: 'Analytics' }
        ]" />
        
        <div class="flex flex-col gap-2 animate-slide-up">
            <h1 class="font-black text-[32px] tracking-tight text-[#0A090B]">Analytics</h1>
            <p class="text-[#7F8190] font-medium text-lg">Real-time data insights and platform performance.</p>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-12 pb-20">
                <!-- Enrollment Trend -->
                <div class="bg-white p-8 rounded-[40px] border border-gray-100 shadow-sm">
                    <h3 class="text-xl font-black mb-6">Enrollment Trend</h3>
                    <div class="h-64">
                        <Line :data="enrollmentData" :options="chartOptions" />
                    </div>
                </div>

                <!-- Pass/Fail Ratio -->
                <div class="bg-white p-8 rounded-[40px] border border-gray-100 shadow-sm">
                    <h3 class="text-xl font-black mb-6">Pass/Fail Ratio</h3>
                    <div class="h-64 relative">
                        <Doughnut :data="passFailData" :options="{ ...chartOptions, plugins: { legend: { display: true, position: 'bottom' } } }" />
                    </div>
                </div>

                <!-- Course Performance -->
                <div class="lg:col-span-2 bg-white p-8 rounded-[40px] border border-gray-100 shadow-sm">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-black">Performance of Top Enrolled Courses</h3>
                        <span class="px-4 py-1.5 bg-gray-50 rounded-full text-[10px] font-black uppercase tracking-widest text-[#7F8190]">Avg Score of Top 5 by Enrollment</span>
                    </div>
                    <div class="h-80">
                        <Bar :data="performanceData" :options="chartOptions" />
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<style scoped>
@keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
.animate-slide-up { animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
</style>
