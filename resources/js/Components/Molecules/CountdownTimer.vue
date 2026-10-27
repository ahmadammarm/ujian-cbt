<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue';
import Icon from '@/Components/Atoms/Icon.vue';

const LOW_TIME_MS = 5 * 60 * 1000;

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

const isLow = computed(() => timeLeft.value < LOW_TIME_MS);

onMounted(() => {
    calculateTimeLeft();
    timer = setInterval(calculateTimeLeft, 1000);
});

onUnmounted(() => {
    clearInterval(timer);
});
</script>

<template>
    <div
        role="timer"
        :class="[
            'flex shrink-0 items-center gap-2 rounded-md border px-2.5 py-1.5 font-form text-sm font-semibold tabular-nums sm:px-3 sm:text-base',
            isLow ? 'border-pen/40 bg-pen/10 text-pen' : 'border-rule bg-paper text-ink',
        ]"
    >
        <Icon name="clock" class="size-4 shrink-0" />
        <span class="sr-only">Sisa waktu</span>
        <span>{{ formattedTime }}</span>
    </div>
</template>
