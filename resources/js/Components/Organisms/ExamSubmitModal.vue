<script setup>
import { computed, watch, onMounted, onUnmounted } from 'vue';
import GhostButton from '@/Components/Atoms/GhostButton.vue';
import InkButton from '@/Components/Atoms/InkButton.vue';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    totalQuestions: {
        type: Number,
        required: true,
    },
    totalAnswered: {
        type: Number,
        required: true,
    },
    courseName: {
        type: String,
        default: 'Kursus',
    },
    isSubmitting: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['close', 'confirm']);

const totalUnanswered = computed(() => {
    return Math.max(0, props.totalQuestions - props.totalAnswered);
});

const answeredPercentage = computed(() => {
    if (props.totalQuestions <= 0) return 0;
    return Math.round((props.totalAnswered / props.totalQuestions) * 100);
});

const isAllAnswered = computed(() => {
    return totalUnanswered.value === 0;
});

// Manage body scroll locking
watch(
    () => props.show,
    (val) => {
        if (val) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = null;
        }
    }
);

const handleClose = () => {
    if (!props.isSubmitting) {
        emit('close');
    }
};

const handleConfirm = () => {
    emit('confirm');
};

const handleKeydown = (e) => {
    if (e.key === 'Escape' && props.show && !props.isSubmitting) {
        handleClose();
    }
};

onMounted(() => {
    document.addEventListener('keydown', handleKeydown);
});

onUnmounted(() => {
    document.removeEventListener('keydown', handleKeydown);
    document.body.style.overflow = null;
});
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
            <div v-if="show" class="fixed inset-0 z-[140] flex items-center justify-center overflow-y-auto px-4 py-6">
                <div class="fixed inset-0 bg-graphite/60" @click="handleClose"></div>

                <div
                    role="dialog"
                    aria-modal="true"
                    aria-labelledby="submit-title"
                    class="relative z-10 w-full max-w-md rounded-md border border-pen/25 bg-paper p-6 font-legible text-ink shadow-[0_24px_48px_-20px_rgba(27,42,107,0.55)] sm:p-8"
                >
                    <p class="border-b-2 border-pen pb-2 font-form text-[11px] font-semibold uppercase tracking-[0.16em] text-pen">Kumpulkan jawaban</p>

                    <h2 id="submit-title" class="mt-6 font-hand text-3xl font-extrabold leading-tight">
                        {{ isAllAnswered ? 'Semua soal sudah terisi.' : `Masih ada ${totalUnanswered} soal kosong.` }}
                    </h2>
                    <p class="mt-1 text-sm text-ink-soft">{{ courseName }}</p>

                    <dl class="mt-6 grid grid-cols-3 divide-x divide-rule rounded-md border border-rule text-center">
                        <div class="px-2 py-3">
                            <dt class="font-form text-[10px] font-semibold uppercase tracking-[0.14em] text-ink-soft">Terisi</dt>
                            <dd class="mt-1 text-2xl font-bold">{{ totalAnswered }}</dd>
                        </div>
                        <div class="px-2 py-3">
                            <dt class="font-form text-[10px] font-semibold uppercase tracking-[0.14em] text-ink-soft">Kosong</dt>
                            <dd :class="['mt-1 text-2xl font-bold', totalUnanswered > 0 ? 'text-pen' : '']">{{ totalUnanswered }}</dd>
                        </div>
                        <div class="px-2 py-3">
                            <dt class="font-form text-[10px] font-semibold uppercase tracking-[0.14em] text-ink-soft">Selesai</dt>
                            <dd class="mt-1 text-2xl font-bold">{{ answeredPercentage }}%</dd>
                        </div>
                    </dl>

                    <p
                        :class="[
                            'mt-6 border-l-4 px-4 py-3 text-sm leading-6',
                            isAllAnswered ? 'border-ink bg-rule/40 text-ink' : 'border-ink bg-stabilo/50 text-graphite',
                        ]"
                    >
                        <template v-if="isAllAnswered">Setelah dikirim, jawaban tidak bisa diubah lagi.</template>
                        <template v-else>Soal yang kosong dihitung salah. Kamu masih bisa kembali dan mengisinya.</template>
                    </p>

                    <div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                        <GhostButton size="sm" :disabled="isSubmitting" @click="handleClose">Periksa lagi</GhostButton>
                        <InkButton type="button" size="sm" :disabled="isSubmitting" @click="handleConfirm">
                            {{ isSubmitting ? 'Mengirim…' : 'Kirim jawaban' }}
                        </InkButton>
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>
