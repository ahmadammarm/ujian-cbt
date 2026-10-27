<script setup>
import { computed, onMounted, onUnmounted, watch } from 'vue';
import Icon from '@/Components/Atoms/Icon.vue';
import InkButton from '@/Components/Atoms/InkButton.vue';
import GhostButton from '@/Components/Atoms/GhostButton.vue';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    title: {
        type: String,
        default: 'Yakin?',
    },
    message: {
        type: String,
        default: 'Tindakan ini tidak bisa dibatalkan.',
    },
    confirmText: {
        type: String,
        default: 'Lanjutkan',
    },
    cancelText: {
        type: String,
        default: 'Batal',
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

const isDanger = computed(() => props.type === 'danger');
const iconName = computed(() => ({ danger: 'alert', success: 'check' }[props.type] || 'alert'));
</script>

<template>
    <Teleport to="body">
        <Transition
            enter-active-class="ease-out duration-200 motion-reduce:transition-none"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="ease-in duration-150 motion-reduce:transition-none"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div v-show="show" class="fixed inset-0 z-[140] flex items-center justify-center overflow-y-auto px-4 py-6">
                <div class="fixed inset-0 bg-graphite/50" @click="close"></div>

                <div
                    role="alertdialog"
                    aria-modal="true"
                    aria-labelledby="alert-dialog-title"
                    aria-describedby="alert-dialog-message"
                    class="relative w-full max-w-md rounded-md border border-rule bg-paper p-6 font-legible text-ink shadow-[0_24px_48px_-20px_rgba(27,42,107,0.5)] sm:p-8"
                >
                    <span
                        :class="[
                            'flex size-11 items-center justify-center rounded-md',
                            isDanger ? 'bg-pen/10 text-pen' : 'bg-rule/60 text-ink',
                        ]"
                    >
                        <Icon :name="iconName" class="size-6" />
                    </span>

                    <h3 id="alert-dialog-title" class="mt-5 font-hand text-2xl font-extrabold leading-tight">{{ title }}</h3>
                    <p id="alert-dialog-message" class="mt-2 text-[15px] leading-7 text-ink-soft">{{ message }}</p>

                    <div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                        <GhostButton size="sm" @click="close">{{ cancelText }}</GhostButton>
                        <InkButton type="button" size="sm" :variant="isDanger ? 'danger' : 'ink'" @click="confirm">
                            {{ confirmText }}
                        </InkButton>
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>
