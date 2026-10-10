<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
    question: Object,
    index: Number,
    selectedAnswer: String,
    saving: Boolean
});

const emit = defineEmits(['save']);

const localSelected = ref(props.selectedAnswer);

watch(() => props.selectedAnswer, (newVal) => {
    localSelected.value = newVal;
});

const handleSelect = (answer) => {
    localSelected.value = answer;
    emit('save', answer);
};

const optionLetters = ['A', 'B', 'C', 'D', 'E', 'F'];
</script>

<template>
    <div class="bg-white dark:bg-[#111116] p-6 lg:p-8 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-xs transition-colors">
        <!-- Question Header & Statement -->
        <div class="flex items-start gap-5">
            <div class="w-10 h-10 rounded-2xl bg-[#2B82FE] text-white flex items-center justify-center shrink-0 font-extrabold text-sm">
                {{ index + 1 }}
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">
                        Soal Nomor {{ index + 1 }}
                    </span>
                    <span v-if="localSelected" class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/10 text-emerald-500 border border-emerald-500/20">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        Terjawab
                    </span>
                    <span v-else class="text-[11px] font-semibold text-slate-400 dark:text-slate-500">
                        Pilih satu jawaban
                    </span>
                </div>

                <h3 class="text-lg lg:text-xl font-bold text-[#0A090B] dark:text-white leading-relaxed mb-8">
                    {{ question.question }}
                </h3>

                <!-- Answer Options with Keycap Letters -->
                <div class="space-y-3">
                    <label
                        v-for="(answer, optIdx) in question.answers"
                        :key="answer.id"
                        class="flex items-center gap-4 p-4 lg:p-5 rounded-2xl border cursor-pointer transition-all duration-200 group"
                        :class="[
                            localSelected === answer.answer
                            ? 'border-[#2B82FE] bg-[#2B82FE]/5 dark:bg-[#2B82FE]/15 ring-2 ring-[#2B82FE]/30 dark:ring-[#2B82FE]/50'
                            : 'border-slate-200/80 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-800/40 hover:border-slate-300 dark:hover:border-slate-700 hover:bg-slate-100/60 dark:hover:bg-slate-800/70'
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

                        <!-- Keycap [A], [B], [C], [D] Badge -->
                        <div
                            class="w-10 h-10 rounded-xl flex items-center justify-center font-extrabold text-sm shrink-0 border transition-all duration-200"
                            :class="[
                                localSelected === answer.answer
                                ? 'bg-[#2B82FE] text-white border-[#2B82FE] scale-105'
                                : 'bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 group-hover:border-slate-300 dark:group-hover:border-slate-600'
                            ]"
                        >
                            {{ optionLetters[optIdx] || (optIdx + 1) }}
                        </div>

                        <!-- Answer Text -->
                        <span
                            class="flex-1 text-sm lg:text-base font-semibold leading-relaxed transition-colors"
                            :class="[
                                localSelected === answer.answer
                                ? 'text-[#2B82FE] dark:text-blue-400 font-bold'
                                : 'text-slate-800 dark:text-slate-200'
                            ]"
                        >
                            {{ answer.answer }}
                        </span>

                        <!-- Indicator Radio Circle -->
                        <div
                            class="w-5 h-5 rounded-full border-2 flex items-center justify-center shrink-0 transition-all duration-200"
                            :class="[
                                localSelected === answer.answer
                                ? 'border-[#2B82FE] bg-[#2B82FE]'
                                : 'border-slate-300 dark:border-slate-600'
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