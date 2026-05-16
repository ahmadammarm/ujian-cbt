<script setup>
import { ref } from 'vue';
import PrimaryButton from '@/Components/Atoms/PrimaryButton.vue';

const props = defineProps({
    question: Object,
    index: Number,
    selectedAnswer: String,
    saving: Boolean
});

const emit = defineEmits(['save']);

const localSelected = ref(props.selectedAnswer);

const handleSelect = (answer) => {
    localSelected.value = answer;
    emit('save', answer);
};
</script>

<template>
    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 mb-6">
        <div class="flex items-start space-x-4">
            <div class="bg-indigo-600 text-white w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 font-bold">
                {{ index + 1 }}
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">{{ question.question }}</h3>
                
                <div class="space-y-3">
                    <label 
                        v-for="answer in question.answers" 
                        :key="answer.id"
                        class="flex items-center p-4 rounded-lg border cursor-pointer transition-all"
                        :class="[
                            localSelected === answer.answer 
                            ? 'border-indigo-600 bg-indigo-50 ring-1 ring-indigo-600' 
                            : 'border-slate-200 hover:bg-slate-50'
                        ]"
                    >
                        <input 
                            type="radio" 
                            :name="'question-' + question.id" 
                            :value="answer.answer"
                            v-model="localSelected"
                            class="hidden"
                            @change="handleSelect(answer.answer)"
                        >
                        <span class="flex-1 text-slate-700">{{ answer.answer }}</span>
                        <div 
                            class="w-5 h-5 rounded-full border flex items-center justify-center"
                            :class="[
                                localSelected === answer.answer 
                                ? 'border-indigo-600 bg-indigo-600' 
                                : 'border-slate-300'
                            ]"
                        >
                            <div v-if="localSelected === answer.answer" class="w-2 h-2 bg-white rounded-full"></div>
                        </div>
                    </label>
                </div>
            </div>
        </div>
    </div>
</template>
