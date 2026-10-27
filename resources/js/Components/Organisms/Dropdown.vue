<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const props = defineProps({
    align: {
        default: 'right',
    },
    width: {
        default: '48',
    },
    contentClasses: {
        default: 'py-1.5 bg-paper',
    },
});

const open = ref(false);

const closeOnEscape = (e) => {
    if (open.value && e.key === 'Escape') {
        open.value = false;
    }
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));
onUnmounted(() => document.removeEventListener('keydown', closeOnEscape));

const alignmentClasses = {
    left: 'ltr:origin-top-left rtl:origin-top-right start-0',
    top: 'origin-top',
    right: 'ltr:origin-top-right rtl:origin-top-left end-0',
}[props.align];

const widthClass = {
    48: 'w-48',
    56: 'w-56',
}[props.width] || props.width;
</script>

<template>
    <div class="relative">
        <div @click="open = !open">
            <slot name="trigger" />
        </div>

        <!-- Full Screen Dropdown Overlay -->
        <div v-show="open" class="fixed inset-0 z-40" @click="open = false"></div>

        <Transition
            enter-active-class="transition ease-out duration-150 motion-reduce:transition-none"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75 motion-reduce:transition-none"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-95"
        >
            <div
                v-show="open"
                class="absolute z-50 mt-2"
                :class="[alignmentClasses, widthClass]"
                @click="open = false"
            >
                <div class="overflow-hidden rounded-md border border-rule shadow-[0_16px_32px_-18px_rgba(27,42,107,0.45)]" :class="contentClasses">
                    <slot name="content" />
                </div>
            </div>
        </Transition>
    </div>
</template>
