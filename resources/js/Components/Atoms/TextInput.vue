<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        class="w-full px-5 py-3.5 bg-white border border-gray-300 focus:border-[#D95300] focus:ring-1 focus:ring-[#D95300] rounded-xl transition-all duration-200 placeholder:text-gray-400 text-gray-700 font-medium"
        v-model="model"
        ref="input"
    />
</template>

