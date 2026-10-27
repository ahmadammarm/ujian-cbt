<script setup>
import { Link } from '@inertiajs/vue3';
import Icon from '@/Components/Atoms/Icon.vue';

defineProps({
    href: {
        type: String,
        required: true,
    },
    icon: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <Link
        :href="href"
        :aria-current="active ? 'page' : undefined"
        :class="[
            'flex items-center gap-3 rounded-md px-3 py-2.5 font-legible text-[15px] transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pen motion-reduce:transition-none',
            active ? 'bg-stabilo/70 font-bold text-ink' : 'text-ink-soft hover:bg-rule/40 hover:text-ink',
        ]"
    >
        <Icon :name="icon" class="size-5 shrink-0" />
        <span class="truncate"><slot /></span>
    </Link>
</template>
