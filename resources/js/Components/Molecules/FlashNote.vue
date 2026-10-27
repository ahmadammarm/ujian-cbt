<script setup>
import { computed, onUnmounted, ref, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import Icon from '@/Components/Atoms/Icon.vue';

const VISIBLE_MS = 4500;

const page = usePage();
const isVisible = ref(false);
let hideTimer = null;

const message = computed(() => page.props.flash?.error || page.props.flash?.success || '');
const isError = computed(() => Boolean(page.props.flash?.error));

const dismiss = () => {
    isVisible.value = false;
    clearTimeout(hideTimer);
};

watch(
    () => page.props.flash,
    () => {
        if (!message.value) return;
        isVisible.value = true;
        clearTimeout(hideTimer);
        hideTimer = setTimeout(dismiss, VISIBLE_MS);
    },
    { immediate: true, deep: true }
);

onUnmounted(() => clearTimeout(hideTimer));
</script>

<template>
    <Transition
        enter-active-class="transition duration-200 ease-out motion-reduce:transition-none"
        enter-from-class="translate-y-3 opacity-0"
        leave-active-class="transition duration-150 ease-in motion-reduce:transition-none"
        leave-to-class="translate-y-3 opacity-0"
    >
        <div
            v-if="isVisible && message"
            :role="isError ? 'alert' : 'status'"
            :class="[
                'fixed bottom-4 right-4 z-[200] flex max-w-[calc(100vw-2rem)] items-start gap-3 px-5 py-4 font-legible text-sm leading-6 shadow-[0_18px_36px_-18px_rgba(27,42,107,0.55)] sm:max-w-sm sm:-rotate-1',
                isError ? 'border-l-4 border-pen bg-paper text-pen' : 'bg-sticky text-graphite',
            ]"
        >
            <Icon :name="isError ? 'alert' : 'check'" class="mt-0.5 size-5 shrink-0" />
            <p class="flex-1 font-bold">{{ message }}</p>
            <button
                type="button"
                class="-mr-1 rounded p-1 opacity-70 hover:opacity-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pen"
                aria-label="Tutup pesan"
                @click="dismiss"
            >
                <Icon name="close" class="size-4" />
            </button>
        </div>
    </Transition>
</template>
