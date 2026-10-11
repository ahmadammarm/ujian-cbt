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
        default: 'danger', // danger, info, success, primary
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
        danger: 'bg-rose-500/10 text-rose-600 dark:text-rose-400 border border-rose-500/20',
        info: 'bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-500/20',
        success: 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20',
        primary: 'bg-[#2B82FE]/10 text-[#2B82FE] border border-[#2B82FE]/20',
    }[props.type] || 'bg-slate-500/10 text-slate-600 dark:text-slate-400 border border-slate-500/20';
});

const buttonClass = computed(() => {
    return {
        danger: 'bg-rose-600 hover:bg-rose-700 shadow-rose-500/20',
        info: 'bg-blue-600 hover:bg-blue-700 shadow-blue-500/20',
        success: 'bg-emerald-600 hover:bg-emerald-700 shadow-emerald-500/20',
        primary: 'bg-[#2B82FE] hover:bg-blue-600 shadow-[#2B82FE]/25',
    }[props.type] || 'bg-slate-800 text-white';
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
            <div v-show="show" class="fixed inset-0 z-[140] overflow-y-auto px-4 py-6 sm:px-0 flex items-center justify-center">
                <!-- Backdrop -->
                <div class="fixed inset-0 transform transition-all" @click="close">
                    <div class="absolute inset-0 bg-[#0A090B]/60 backdrop-blur-md" />
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
                        class="relative bg-white dark:bg-[#111116] border border-slate-200/90 dark:border-slate-800 rounded-3xl overflow-hidden shadow-2xl shadow-slate-900/15 dark:shadow-black/60 transform transition-all sm:w-full sm:max-w-md p-6 sm:p-8 text-center font-poppins"
                    >
                        <!-- Icon -->
                        <div :class="[iconClass, 'mx-auto w-16 h-16 sm:w-20 sm:h-20 flex items-center justify-center rounded-2xl sm:rounded-3xl mb-6 transition-colors duration-300']">
                            <svg v-if="type === 'danger'" class="w-8 h-8 sm:w-10 sm:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            <svg v-else-if="type === 'success'" class="w-8 h-8 sm:w-10 sm:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <svg v-else-if="type === 'primary'" class="w-8 h-8 sm:w-10 sm:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <svg v-else class="w-8 h-8 sm:w-10 sm:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>

                        <!-- Content -->
                        <h3 class="text-xl sm:text-2xl font-bold text-[#0A090B] dark:text-white mb-2 leading-tight">{{ title }}</h3>
                        <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 leading-relaxed mb-8">
                            {{ message }}
                        </p>

                        <!-- Actions -->
                        <div class="flex flex-col sm:flex-row gap-3">
                            <button
                                @click="close"
                                class="flex-1 px-5 py-3.5 bg-slate-100 dark:bg-slate-800/80 hover:bg-slate-200 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs uppercase tracking-wider rounded-2xl border border-transparent dark:border-slate-700/60 transition-all duration-200 active:scale-95 cursor-pointer"
                            >
                                {{ cancelText }}
                            </button>
                            <button
                                @click="confirm"
                                :class="[buttonClass, 'flex-1 px-5 py-3.5 text-white font-bold text-xs uppercase tracking-wider rounded-2xl shadow-lg transition-all duration-200 active:scale-95 cursor-pointer']"
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
