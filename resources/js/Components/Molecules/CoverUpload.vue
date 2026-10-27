<script setup>
import { computed, onUnmounted, ref } from 'vue';
import CourseThumbnail from '@/Components/Atoms/CourseThumbnail.vue';
import Icon from '@/Components/Atoms/Icon.vue';

// Must match the `mimes` rule in StoreCourseRequest / UpdateCourseRequest
const ACCEPTED_TYPES = 'image/png,image/jpeg,image/gif,image/svg+xml';
const BYTES_PER_MB = 1024 * 1024;

// Holds the selected File, or null when nothing new was picked
const model = defineModel({
    default: null,
});

const props = defineProps({
    id: {
        type: String,
        default: 'cover',
    },
    label: {
        type: String,
        default: 'Gambar sampul',
    },
    // Stored path of the current cover (edit form)
    existingCover: {
        type: String,
        default: null,
    },
    courseName: {
        type: String,
        default: '',
    },
    error: {
        type: String,
        default: '',
    },
});

const fileInput = ref(null);
const isDragging = ref(false);
const previewUrl = ref(null);

const fileDetails = computed(() => {
    if (!model.value) return null;
    return {
        name: model.value.name,
        size: `${(model.value.size / BYTES_PER_MB).toFixed(2)} MB`,
    };
});

const shownCover = computed(() => previewUrl.value || props.existingCover);

const processFile = (file) => {
    if (!file) return;
    if (previewUrl.value) URL.revokeObjectURL(previewUrl.value);
    model.value = file;
    previewUrl.value = URL.createObjectURL(file);
};

const onFileChange = (event) => {
    processFile(event.target.files[0]);
};

const onDrop = (event) => {
    isDragging.value = false;
    const file = event.dataTransfer.files[0];
    if (file && file.type.startsWith('image/')) {
        processFile(file);
    }
};

const removeFile = () => {
    if (previewUrl.value) URL.revokeObjectURL(previewUrl.value);
    model.value = null;
    previewUrl.value = null;
    if (fileInput.value) {
        fileInput.value.value = '';
    }
};

onUnmounted(() => {
    if (previewUrl.value) URL.revokeObjectURL(previewUrl.value);
});
</script>

<template>
    <div>
        <p :id="`${id}-label`" class="font-form text-[11px] font-semibold uppercase tracking-[0.16em] text-pen">{{ label }}</p>

        <div class="mt-2 grid gap-4 sm:grid-cols-[minmax(0,14rem)_1fr] sm:items-stretch">
            <div class="aspect-video overflow-hidden rounded-md border border-rule">
                <CourseThumbnail :src="shownCover" :name="courseName || 'Kursus'" monogram-class="text-3xl" />
            </div>

            <label
                :for="id"
                :class="[
                    'flex cursor-pointer flex-col items-center justify-center gap-2 rounded-md border-2 border-dashed px-4 py-6 text-center transition-colors focus-within:ring-2 focus-within:ring-pen motion-reduce:transition-none',
                    isDragging ? 'border-ink bg-stabilo/30' : error ? 'border-pen bg-pen/5' : 'border-rule bg-paper hover:border-ink-soft',
                ]"
                @dragover.prevent="isDragging = true"
                @dragleave.prevent="isDragging = false"
                @drop.prevent="onDrop"
            >
                <input
                    :id="id"
                    ref="fileInput"
                    type="file"
                    class="sr-only"
                    :accept="ACCEPTED_TYPES"
                    :aria-labelledby="`${id}-label`"
                    :aria-describedby="error ? `${id}-error` : `${id}-hint`"
                    @change="onFileChange"
                />
                <Icon name="upload" class="size-6 text-ink" />
                <span class="font-bold text-ink">{{ shownCover ? 'Ganti gambar' : 'Pilih gambar' }}</span>
                <span :id="`${id}-hint`" class="text-sm text-ink-soft">Tarik ke sini atau klik. PNG, JPG, GIF, atau SVG, maks 2 MB.</span>
            </label>
        </div>

        <div v-if="fileDetails" class="mt-3 flex flex-wrap items-center justify-between gap-2 text-sm">
            <span class="min-w-0 truncate text-ink-soft"><span class="font-bold text-ink">{{ fileDetails.name }}</span> · {{ fileDetails.size }}</span>
            <button
                type="button"
                class="rounded-sm font-bold text-pen underline decoration-2 underline-offset-4 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pen"
                @click="removeFile"
            >
                Batalkan pilihan
            </button>
        </div>

        <p v-if="error" :id="`${id}-error`" class="mt-2 font-hand text-base font-semibold leading-snug text-pen">{{ error }}</p>
    </div>
</template>
