<script setup>
import { computed, onMounted, onUnmounted, watch } from 'vue';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    title: {
        type: String,
        default: 'Are you sure?',
    },
    message: {
        type: String,
        default: 'This action cannot be undone.',
    },
    confirmText: {
        type: String,
        default: 'Confirm',
    },
    cancelText: {
        type: String,
        default: 'Cancel',
    },
    type: {
        type: String,
        default: 'danger', // danger, info, success
    },
});

const emit = defineEmits(['close', 'confirm']);

watch(
    () => props.show,
    () => {
        if (props.show) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = null;
        }
    }
);

const close = () => {
    emit('close');
};

const confirm = () => {
    emit('confirm');
};

const closeOnEscape = (e) => {
    if (e.key === 'Escape' && props.show) {
        close();
    }
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));

onUnmounted(() => {
    document.removeEventListener('keydown', closeOnEscape);
    document.body.style.overflow = null;
});

const iconClass = computed(() => {
    return {
        danger: 'bg-red-100 text-red-600',
        info: 'bg-blue-100 text-blue-600',
        success: 'bg-green-100 text-green-600',
    }[props.type];
});

const buttonClass = computed(() => {
    return {
        danger: 'bg-red-600 hover:bg-red-700 shadow-red-200',
        info: 'bg-blue-600 hover:bg-blue-700 shadow-blue-200',
        success: 'bg-green-600 hover:bg-green-700 shadow-green-200',
    }[props.type];
});
</script>

<template>
    <Teleport to="body">
        <Transition
            enter-active-class="ease-out duration-300"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="ease-in duration-200"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div v-show="show" class="fixed inset-0 z-[100] overflow-y-auto px-4 py-6 sm:px-0 flex items-center justify-center">
                <!-- Backdrop -->
                <div class="fixed inset-0 transform transition-all" @click="close">
                    <div class="absolute inset-0 bg-[#0A090B]/40 backdrop-blur-sm" />
                </div>

                <!-- Dialog Card -->
                <Transition
                    enter-active-class="ease-out duration-300"
                    enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    enter-to-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-active-class="ease-in duration-200"
                    leave-from-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                >
                    <div
                        v-show="show"
                        class="relative bg-white rounded-[32px] overflow-hidden shadow-2xl transform transition-all sm:w-full sm:max-w-md p-8 text-center"
                    >
                        <!-- Icon -->
                        <div :class="[iconClass, 'mx-auto w-20 h-24 flex items-center justify-center rounded-3xl mb-6 transition-colors duration-300']">
                            <svg v-if="type === 'danger'" class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            <svg v-else-if="type === 'success'" class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <svg v-else class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>

                        <!-- Content -->
                        <h3 class="text-2xl font-bold text-[#0A090B] mb-2 font-poppins">{{ title }}</h3>
                        <p class="text-[#7F8190] leading-relaxed mb-8 font-poppins">
                            {{ message }}
                        </p>

                        <!-- Actions -->
                        <div class="flex flex-col sm:flex-row gap-3">
                            <button
                                @click="close"
                                class="flex-1 px-6 py-4 bg-gray-100 hover:bg-gray-200 text-[#0A090B] font-bold rounded-2xl transition-all duration-200 active:scale-95 font-poppins"
                            >
                                {{ cancelText }}
                            </button>
                            <button
                                @click="confirm"
                                :class="[buttonClass, 'flex-1 px-6 py-4 text-white font-bold rounded-2xl shadow-lg transition-all duration-200 active:scale-95 font-poppins']"
                            >
                                {{ confirmText }}
                            </button>
                        </div>
                    </div>
                </Transition>
            </div>
        </Transition>
    </Teleport>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap');
.font-poppins {
    font-family: 'Poppins', sans-serif;
}
</style>
