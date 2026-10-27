<script setup>
import { Link } from '@inertiajs/vue3';
import Icon from '@/Components/Atoms/Icon.vue';

defineProps({
    items: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <nav aria-label="Lokasi halaman" class="mb-6 font-legible text-sm">
        <ol class="flex flex-wrap items-center gap-1.5">
            <li v-for="(item, index) in items" :key="index" class="flex items-center gap-1.5">
                <Link
                    v-if="item.href && index < items.length - 1"
                    :href="item.href"
                    class="rounded-sm text-ink-soft underline-offset-4 hover:text-ink hover:underline focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pen"
                >
                    {{ item.label }}
                </Link>
                <span v-else aria-current="page" class="font-bold text-ink">{{ item.label }}</span>
                <Icon v-if="index < items.length - 1" name="chevron-right" class="size-4 text-ink-soft/60" />
            </li>
        </ol>
    </nav>
</template>
