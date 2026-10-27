<script setup>
import { computed } from 'vue';
import NotebookField from '@/Components/Molecules/NotebookField.vue';
import NotebookSelect from '@/Components/Molecules/NotebookSelect.vue';
import CoverUpload from '@/Components/Molecules/CoverUpload.vue';

// `form` is the page's useForm() instance; fields are bound in place
const props = defineProps({
    form: {
        type: Object,
        required: true,
    },
    categories: {
        type: Array,
        required: true,
    },
    existingCover: {
        type: String,
        default: null,
    },
});

const emit = defineEmits(['submit']);

const categoryOptions = computed(() => props.categories.map((category) => ({ value: category.id, label: category.name })));
</script>

<template>
    <form class="rounded-md border border-rule bg-paper p-5 sm:p-8" @submit.prevent="emit('submit')">
        <div class="space-y-8">
            <NotebookField
                id="name"
                v-model="form.name"
                label="Nama kursus"
                placeholder="mis. Biologi Kelas XI — Sel"
                :error="form.errors.name"
                required
                autofocus
            />

            <NotebookSelect
                id="category_id"
                v-model="form.category_id"
                label="Kategori"
                placeholder="Pilih kategori"
                :options="categoryOptions"
                :error="form.errors.category_id"
                required
            />

            <CoverUpload
                v-model="form.cover"
                :existing-cover="existingCover"
                :course-name="form.name"
                :error="form.errors.cover"
            />
        </div>

        <div class="mt-10 flex flex-col-reverse gap-3 border-t border-dashed border-rule pt-6 sm:flex-row sm:justify-end">
            <slot name="actions" />
        </div>
    </form>
</template>
