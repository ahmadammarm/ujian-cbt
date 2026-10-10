<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue';

const props = defineProps({
    startTime: String, // ISO string from server
    durationHours: {
        type: Number,
        default: 90
    }
});

const emit = defineEmits(['timeout']);

const timeLeft = ref(0);
let timer = null;

const calculateTimeLeft = () => {
    const start = new Date(props.startTime).getTime();
    const end = start + (props.durationHours * 60 * 60 * 1000);
    const now = new Date().getTime();
    const diff = end - now;
    
    if (diff <= 0) {
        timeLeft.value = 0;
        emit('timeout');
        clearInterval(timer);
    } else {
        timeLeft.value = diff;
    }
};

const formattedTime = computed(() => {
    const totalSeconds = Math.floor(timeLeft.value / 1000);
    const hours = Math.floor(totalSeconds / 3600);
    const minutes = Math.floor((totalSeconds % 3600) / 60);
    const seconds = totalSeconds % 60;
    
    return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
});

onMounted(() => {
    calculateTimeLeft();
    timer = setInterval(calculateTimeLeft, 1000);
});

onUnmounted(() => {
    clearInterval(timer);
});
</script>

<template>
    <div class="flex items-center space-x-2 font-mono text-lg font-bold text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-950/40 px-3.5 py-1.5 rounded-xl border border-rose-200 dark:border-rose-900/60 shadow-xs">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>{{ formattedTime }}</span>
    </div>
</template>
