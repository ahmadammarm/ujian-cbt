<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    links: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap gap-2 items-center justify-center lg:justify-start">
            <template v-for="(link, key) in links" :key="key">
                <div
                    v-if="link.url === null"
                    class="px-4 py-2.5 text-slate-400 dark:text-slate-600 font-bold text-xs uppercase tracking-wider bg-slate-100 dark:bg-[#141419] rounded-xl border border-slate-200/80 dark:border-slate-800 opacity-50 cursor-not-allowed select-none"
                    v-html="link.label"
                />
                <Link
                    v-else
                    class="px-4 py-2.5 text-xs font-bold uppercase tracking-wider rounded-xl transition-colors active:scale-95 border"
                    :class="[
                        link.active
                            ? 'bg-[#0A090B] dark:bg-white text-white dark:text-[#0A090B] border-[#0A090B] dark:border-white font-black'
                            : 'bg-white dark:bg-[#141419] text-slate-700 dark:text-slate-300 border-slate-200/80 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-[#1a1a22] hover:border-slate-300 dark:hover:border-slate-700'
                    ]"
                    :href="link.url"
                    v-html="link.label"
                />
            </template>
        </div>
    </div>
</template>
