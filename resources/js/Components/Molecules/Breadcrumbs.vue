<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    items: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <nav class="flex mb-8 text-sm font-medium text-gray-500 animate-fade-in font-poppins">
        <ol class="flex items-center gap-2">
            <li v-for="(item, index) in items" :key="index" class="flex items-center gap-2">
                <Link 
                    v-if="item.href" 
                    :href="item.href" 
                    class="hover:text-[#D95300] transition-colors"
                    :class="{'text-[#D95300]': index === items.length - 1}"
                >
                    {{ item.label }}
                </Link>
                <span v-else class="text-gray-900 font-bold">
                    {{ item.label }}
                </span>
                
                <svg 
                    v-if="index < items.length - 1" 
                    class="w-4 h-4 text-gray-300" 
                    fill="none" 
                    stroke="currentColor" 
                    viewBox="0 0 24 24"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                </svg>
            </li>
        </ol>
    </nav>
</template>

<style scoped>
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}
.animate-fade-in {
    animation: fadeIn 0.8s ease-out forwards;
}
</style>

