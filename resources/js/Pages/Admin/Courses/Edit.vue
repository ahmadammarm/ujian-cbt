<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    course: {
        type: Object,
        required: true,
    },
    categories: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    name: props.course.name,
    category_id: props.course.category_id,
    cover: null,
    // Keep hidden defaults
    course_type: 'Onboarding',
    publish_date: 'Active Now',
    access: 'Invitation Only',
    tnc: true,
    _method: 'PUT',
});

const previewUrl = ref('/storage/' + props.course.cover);
const fileInput = ref(null);

const onFileChange = (e) => {
    const file = e.target.files[0];
    form.cover = file;
    if (file) {
        previewUrl.value = URL.createObjectURL(file);
    }
};

const submit = () => {
    form.post(route('dashboard.courses.update', props.course.id), {
        forceFormData: true,
    });
};
</script>

<template>
    <Head title="Edit Course" />

    <AdminLayout>
        <div class="max-w-4xl mx-auto">
            <!-- Breadcrumbs -->
            <nav class="flex mb-8 text-sm font-medium text-gray-500 animate-fade-in">
                <Link :href="route('dashboard.overview')" class="hover:text-[#D95300] transition-colors">Dashboard</Link>
                <span class="mx-3 text-gray-300">/</span>
                <Link :href="route('dashboard.courses.index')" class="hover:text-[#D95300] transition-colors">Courses</Link>
                <span class="mx-3 text-gray-300">/</span>
                <span class="text-gray-900 font-bold">Edit Course</span>
            </nav>

            <div class="flex flex-col lg:flex-row gap-12 items-start animate-slide-up">
                <!-- Left: Header Info -->
                <div class="lg:w-1/3">
                    <h1 class="text-4xl font-extrabold text-[#0A090B] tracking-tight leading-tight mb-4">
                        Edit <span class="text-[#D95300]">Course</span>
                    </h1>
                    <p class="text-gray-500 text-lg leading-relaxed">
                        Update the course details, category, or thumbnail image.
                    </p>
                    
                    <!-- Form Status/Errors -->
                    <div v-if="Object.keys(form.errors).length > 0" class="mt-8 p-5 bg-red-50 border border-red-100 rounded-[24px]">
                        <div class="flex items-center gap-3 text-red-600 font-bold mb-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <span>Whoops!</span>
                        </div>
                        <ul class="text-sm text-red-500 space-y-1 ml-8 list-disc font-medium">
                            <li v-for="error in form.errors" :key="error">{{ error }}</li>
                        </ul>
                    </div>
                </div>

                <!-- Right: Form Card -->
                <div class="flex-1 w-full bg-white p-10 rounded-[32px] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100">
                    <form @submit.prevent="submit" class="space-y-8">
                        <!-- Cover Upload -->
                        <div class="flex flex-col items-center justify-center p-8 bg-gray-50/50 border-2 border-dashed border-gray-200 rounded-[24px] group hover:border-[#D95300] transition-colors duration-300 relative overflow-hidden">
                            <input type="file" ref="fileInput" @change="onFileChange" class="hidden" accept="image/*">
                            
                            <div class="absolute inset-0 z-0">
                                <img :src="previewUrl" class="w-full h-full object-cover opacity-20" alt="Preview Background">
                            </div>

                            <div class="relative z-10 flex flex-col items-center text-center">
                                <div class="w-24 h-24 mb-4 rounded-3xl bg-white shadow-sm flex items-center justify-center border border-gray-100 group-hover:scale-110 transition-transform duration-500 overflow-hidden text-poppins">
                                    <img :src="previewUrl" class="w-full h-full object-cover" />
                                </div>
                                <p class="font-bold text-[#0A090B] mb-1">Course Thumbnail</p>
                                <p class="text-sm text-gray-400 mb-4">PNG, JPG up to 2MB</p>
                                <button type="button" @click="fileInput.click()" 
                                    class="px-6 py-2.5 bg-[#0A090B] text-white text-xs font-bold rounded-full hover:bg-gray-800 transition-all active:scale-95 shadow-lg shadow-gray-200">
                                    Change Image
                                </button>
                            </div>
                        </div>

                        <!-- Name -->
                        <div class="space-y-2">
                            <InputLabel for="name" value="Course Name" />
                            <TextInput
                                id="name"
                                type="text"
                                v-model="form.name"
                                placeholder="Enter a compelling course name..."
                                required
                            />
                            <InputError :message="form.errors.name" />
                        </div>

                        <!-- Category -->
                        <div class="space-y-2 font-poppins">
                            <InputLabel for="category" value="Category" />
                            <div class="relative text-poppins">
                                <select 
                                    v-model="form.category_id" 
                                    id="category"
                                    class="w-full px-5 py-3.5 bg-gray-50/50 border-none ring-1 ring-gray-200 focus:ring-2 focus:ring-[#D95300] rounded-xl transition-all duration-200 appearance-none font-medium text-gray-700"
                                    required
                                >
                                    <option value="" disabled hidden>Select a category</option>
                                    <option v-for="category in categories" :key="category.id" :value="category.id">
                                        {{ category.name }}
                                    </option>
                                </select>
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400 font-poppins">
                                    <svg class="w-5 h-5 font-poppins" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            <InputError :message="form.errors.category_id" />
                        </div>

                        <div class="pt-6 flex items-center gap-4">
                            <Link :href="route('dashboard.courses.index')" 
                                class="flex-1 text-center py-4 bg-gray-100 hover:bg-gray-200 text-[#0A090B] font-bold rounded-2xl transition-all active:scale-95 font-poppins">
                                Cancel
                            </Link>
                            <PrimaryButton class="flex-[2] py-4" :disabled="form.processing">
                                <span v-if="form.processing">Updating...</span>
                                <span v-else>Update Course</span>
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap');
.font-poppins {
    font-family: 'Poppins', sans-serif;
}
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
@keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
.animate-fade-in { animation: fadeIn 0.8s ease-out forwards; }
.animate-slide-up { animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
</style>
