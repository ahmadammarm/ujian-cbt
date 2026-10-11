<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    value: {
        type: [String, Number],
        required: true,
    },
    sublabel: {
        type: String,
        default: '',
    },
    href: {
        type: String,
        default: null,
    },
    linkText: {
        type: String,
        default: '',
    },
    footerText: {
        type: String,
        default: '',
    },
    theme: {
        type: String,
        default: 'teacher', // 'teacher' (#D95300), 'student' (#2B82FE), 'emerald' (#10B981), 'amber' (#F59E0B)
    },
});

const themeClasses = computed(() => {
    switch (props.theme) {
        case 'student':
            return {
                cardHover: 'hover:border-[#2B82FE]/30 dark:hover:border-[#2B82FE]/40',
                iconBox: 'bg-[#2B82FE]/10 dark:bg-[#2B82FE]/20 text-[#2B82FE]',
                link: 'text-[#2B82FE]',
            };
        case 'emerald':
            return {
                cardHover: 'hover:border-emerald-500/30 dark:hover:border-emerald-500/40',
                iconBox: 'bg-emerald-500/10 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400',
                link: 'text-emerald-600 dark:text-emerald-400',
            };
        case 'amber':
            return {
                cardHover: 'hover:border-amber-500/30 dark:hover:border-amber-500/40',
                iconBox: 'bg-amber-500/10 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400',
                link: 'text-amber-600 dark:text-amber-400',
            };
        case 'teacher':
        default:
            return {
                cardHover: 'hover:border-[#D95300]/30 dark:hover:border-[#D95300]/40',
                iconBox: 'bg-[#D95300]/10 dark:bg-[#D95300]/20 text-[#D95300]',
                link: 'text-[#D95300]',
            };
    }
});
</script>

<template>
    <div
        :class="[
            'p-7 bg-white dark:bg-[#111116] border border-slate-200/80 dark:border-slate-800 rounded-3xl flex flex-col justify-between gap-6 shadow-xs transition-all duration-300 group',
            themeClasses.cardHover,
        ]"
    >
        <div class="flex items-center justify-between">
            <div
                :class="[
                    'w-14 h-14 rounded-2xl flex items-center justify-center group-hover:scale-105 transition-transform',
                    themeClasses.iconBox,
                ]"
            >
                <slot name="icon">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </slot>
            </div>
            <span v-if="sublabel" class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">
                {{ sublabel }}
            </span>
        </div>

        <div>
            <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">
                {{ title }}
            </p>
            <p class="text-4xl font-extrabold text-[#0A090B] dark:text-white tracking-tight">
                {{ value }}
            </p>
        </div>

        <div v-if="(href && linkText) || footerText || $slots.footer" class="pt-4 border-t border-slate-100 dark:border-slate-800/80 flex items-center justify-between">
            <slot name="footer">
                <Link
                    v-if="href && linkText"
                    :href="href"
                    :class="['text-xs font-bold hover:underline flex items-center gap-1 transition-colors', themeClasses.link]"
                >
                    <span>{{ linkText }}</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </Link>
                <span v-else-if="footerText" class="text-xs font-semibold text-slate-500 dark:text-slate-400">
                    {{ footerText }}
                </span>
            </slot>
        </div>
    </div>
</template>
