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
        <div class="flex flex-wrap gap-3 items-center justify-center lg:justify-start">
            <template v-for="(link, key) in links" :key="key">
                <div v-if="link.url === null" 
                    class="px-6 py-4 text-[#A5ABB2] font-black text-[13px] uppercase tracking-widest bg-gray-50 rounded-2xl border border-gray-100 opacity-50 cursor-not-allowed" 
                    v-html="link.label" 
                />
                <Link v-else 
                    class="px-6 py-4 font-black text-[13px] uppercase tracking-widest rounded-2xl transition-all duration-300 active:scale-95 border" 
                    :class="[
                        link.active 
                            ? 'bg-[#0A090B] text-white border-[#0A090B] shadow-xl shadow-gray-200' 
                            : 'bg-white text-[#0A090B] border-gray-100 hover:bg-gray-50 hover:border-gray-200'
                    ]" 
                    :href="link.url" 
                    v-html="link.label" 
                />
            </template>
        </div>
    </div>
</template>
