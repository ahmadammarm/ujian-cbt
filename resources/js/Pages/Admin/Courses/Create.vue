<script setup>
import AdminLayout from '@/Components/Templates/AdminLayout.vue';
import Breadcrumbs from '@/Components/Molecules/Breadcrumbs.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import InputError from '@/Components/Atoms/InputError.vue';
import InputLabel from '@/Components/Atoms/InputLabel.vue';

defineProps({
    categories: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    name: '',
    category_id: '',
    cover: null,
    action: 'add_questions',
    course_type: 'Onboarding',
    publish_date: 'Active Now',
    access: 'Invitation Only',
    tnc: true,
});

const previewUrl = ref(null);
const fileInput = ref(null);
const fileDetails = ref(null);
const isDragging = ref(false);

const processFile = (file) => {
    if (!file) return;
    form.cover = file;
    fileDetails.value = {
        name: file.name,
        size: (file.size / (1024 * 1024)).toFixed(2) + ' MB',
        type: file.type.split('/')[1]?.toUpperCase() || 'IMG'
    };
    previewUrl.value = URL.createObjectURL(file);
};

const onFileChange = (e) => {
    const file = e.target.files[0];
    processFile(file);
};

const onDrop = (e) => {
    isDragging.value = false;
    const file = e.dataTransfer.files[0];
    if (file && file.type.startsWith('image/')) {
        processFile(file);
    }
};

const removeFile = () => {
    form.cover = null;
    previewUrl.value = null;
    fileDetails.value = null;
    if (fileInput.value) {
        fileInput.value.value = '';
    }
};

const submitWithAction = (actionType) => {
    form.action = actionType;
    form.post(route('dashboard.courses.store'), {
        forceFormData: true,
    });
};
</script>

<template>
    <Head title="Buat Kursus Baru · Naiju Studio" />

    <AdminLayout>
        <div class="max-w-4xl mx-auto pb-20">
            <Breadcrumbs :items="[
                { label: 'Naiju Studio', href: route('dashboard.overview') },
                { label: 'Daftar Kursus', href: route('dashboard.courses.index') },
                { label: 'Buat Kursus Baru' }
            ]" />

            <div class="flex flex-col lg:flex-row gap-10 items-start animate-slide-up mt-2">
                <!-- Left: Header Info -->
                <div class="lg:w-1/3 flex flex-col gap-4">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-[#D95300]/10 text-[#D95300] rounded-full border border-[#D95300]/20 w-fit">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#D95300] animate-pulse"></span>
                        <span class="text-[10px] font-extrabold uppercase tracking-widest">Modul Baru</span>
                    </div>

                    <h1 class="text-3xl lg:text-4xl font-black text-[#0A090B] dark:text-white tracking-tight leading-tight">
                        Buat Kursus &amp; <span class="text-[#D95300]">Asesmen</span>
                    </h1>
                    <p class="text-slate-500 dark:text-slate-400 text-sm font-medium leading-relaxed">
                        Siapkan modul evaluasi digital baru untuk siswa. Setelah informasi tersimpan, Anda dapat langsung menambahkan bank soal pilihan ganda.
                    </p>

                    <div class="p-5 rounded-2xl bg-slate-50 dark:bg-[#141419] border border-slate-200/80 dark:border-slate-800 flex flex-col gap-3 mt-2">
                        <p class="text-xs font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider">Tahapan Pembuatan</p>
                        <div class="space-y-2 text-xs">
                            <div class="flex items-center gap-2.5 text-[#D95300] font-bold">
                                <span class="w-5 h-5 rounded-full bg-[#D95300] text-white flex items-center justify-center text-[10px]">1</span>
                                <span>Informasi &amp; Sampul Kursus</span>
                            </div>
                            <div class="flex items-center gap-2.5 text-slate-400 dark:text-slate-500 font-medium">
                                <span class="w-5 h-5 rounded-full bg-slate-200 dark:bg-slate-700 text-slate-500 dark:text-slate-400 flex items-center justify-center text-[10px]">2</span>
                                <span>Penyusunan Bank Soal &amp; Kunci</span>
                            </div>
                            <div class="flex items-center gap-2.5 text-slate-400 dark:text-slate-500 font-medium">
                                <span class="w-5 h-5 rounded-full bg-slate-200 dark:bg-slate-700 text-slate-500 dark:text-slate-400 flex items-center justify-center text-[10px]">3</span>
                                <span>Penerbitan ke Peserta Didik</span>
                            </div>
                        </div>
                    </div>

                    <!-- Error Alert -->
                    <div v-if="Object.keys(form.errors).length > 0" class="p-5 bg-rose-500/10 border border-rose-500/20 rounded-2xl">
                        <div class="flex items-center gap-2.5 text-rose-600 dark:text-rose-400 font-bold mb-2 text-xs">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            <span>Periksa Kembali Data Formulir:</span>
                        </div>
                        <ul class="text-[11px] text-rose-600 dark:text-rose-400 space-y-1 ml-6 list-disc font-semibold">
                            <li v-for="error in form.errors" :key="error">{{ error }}</li>
                        </ul>
                    </div>
                </div>

                <!-- Right: Form Card -->
                <div class="flex-1 w-full bg-white dark:bg-[#111116] p-7 lg:p-10 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-xs">
                    <form @submit.prevent="submitWithAction('add_questions')" class="space-y-7">
                        <!-- Cover Upload with Drag and Drop -->
                        <div class="space-y-2">
                            <InputLabel value="Gambar Sampul Kursus (Thumbnail)" class="text-xs uppercase tracking-wider text-slate-600 dark:text-slate-300 font-bold" />

                            <div
                                @dragover.prevent="isDragging = true"
                                @dragleave.prevent="isDragging = false"
                                @drop.prevent="onDrop"
                                :class="[
                                    'relative flex flex-col items-center justify-center p-8 rounded-2xl border-2 border-dashed transition-all duration-300',
                                    isDragging
                                        ? 'border-[#D95300] bg-[#D95300]/5 dark:bg-[#D95300]/10 scale-[1.01]'
                                        : 'border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-[#141419]/50 hover:border-slate-300 dark:hover:border-slate-700'
                                ]"
                            >
                                <input
                                    type="file"
                                    ref="fileInput"
                                    @change="onFileChange"
                                    class="hidden"
                                    accept="image/png,image/jpeg,image/jpg,image/webp"
                                >

                                <!-- Preview Active -->
                                <div v-if="previewUrl" class="w-full flex flex-col sm:flex-row items-center gap-5">
                                    <div class="w-28 h-28 shrink-0 rounded-xl overflow-hidden border border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-800 relative shadow-sm">
                                        <img :src="previewUrl" class="w-full h-full object-cover" alt="Preview Sampul">
                                    </div>
                                    <div class="flex-1 text-center sm:text-left min-w-0">
                                        <div class="flex items-center justify-center sm:justify-start gap-2 mb-1">
                                            <span class="px-2 py-0.5 rounded bg-[#D95300]/10 text-[#D95300] font-bold text-[10px] uppercase tracking-wider">
                                                {{ fileDetails?.type || 'GAMBAR' }}
                                            </span>
                                            <span class="text-xs text-slate-400 dark:text-slate-500 font-medium">
                                                {{ fileDetails?.size }}
                                            </span>
                                        </div>
                                        <p class="font-bold text-sm text-[#0A090B] dark:text-white truncate max-w-xs">
                                            {{ fileDetails?.name || 'Berkas Terpilih' }}
                                        </p>
                                        <p class="text-xs text-emerald-600 dark:text-emerald-400 font-medium mt-1">
                                            Berkas siap diunggah
                                        </p>
                                        <div class="flex items-center justify-center sm:justify-start gap-2.5 mt-3">
                                            <button
                                                type="button"
                                                @click="fileInput.click()"
                                                class="px-3.5 py-1.5 rounded-lg bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 text-xs font-bold transition-colors"
                                            >
                                                Ganti Gambar
                                            </button>
                                            <button
                                                type="button"
                                                @click="removeFile"
                                                class="px-3.5 py-1.5 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 text-rose-600 dark:text-rose-400 text-xs font-bold transition-colors"
                                            >
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Empty / Upload Dropzone -->
                                <div v-else class="flex flex-col items-center text-center">
                                    <div class="w-16 h-16 mb-3 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-400 dark:text-slate-500 group-hover:text-[#D95300] transition-colors shadow-xs">
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <p class="font-bold text-sm text-[#0A090B] dark:text-white mb-1">
                                        Tarik &amp; lepas gambar ke sini, atau klik tombol di bawah
                                    </p>
                                    <p class="text-[11px] font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-4">
                                        PNG, JPG, JPEG, atau WebP (Maksimum 2MB)
                                    </p>
                                    <button
                                        type="button"
                                        @click="fileInput.click()"
                                        class="px-5 py-2.5 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 text-xs font-bold rounded-xl transition-all active:scale-95 border border-slate-200 dark:border-slate-700"
                                    >
                                        Pilih Berkas dari Komputer
                                    </button>
                                </div>
                            </div>
                            <InputError :message="form.errors.cover" />
                        </div>

                        <!-- Course Name -->
                        <div class="space-y-2">
                            <InputLabel for="name" value="Nama Kursus / Judul Asesmen" class="text-xs uppercase tracking-wider text-slate-600 dark:text-slate-300 font-bold" />
                            <input
                                id="name"
                                type="text"
                                v-model="form.name"
                                placeholder="Contoh: Pemrograman Web &amp; Laravel Tingkat Lanjut"
                                required
                                autofocus
                                class="w-full px-4 py-3.5 bg-slate-50 dark:bg-[#141419] border border-slate-200 dark:border-slate-800 rounded-2xl text-slate-800 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-600 focus:outline-none focus:border-[#D95300] focus:ring-1 focus:ring-[#D95300] font-bold text-sm transition-all"
                            />
                            <InputError :message="form.errors.name" />
                        </div>

                        <!-- Category -->
                        <div class="space-y-2">
                            <InputLabel for="category" value="Kategori Bidang Materi" class="text-xs uppercase tracking-wider text-slate-600 dark:text-slate-300 font-bold" />
                            <div class="relative">
                                <select
                                    v-model="form.category_id"
                                    id="category"
                                    required
                                    class="w-full px-4 py-3.5 bg-slate-50 dark:bg-[#141419] border border-slate-200 dark:border-slate-800 rounded-2xl text-slate-800 dark:text-slate-100 focus:outline-none focus:border-[#D95300] focus:ring-1 focus:ring-[#D95300] font-bold text-sm appearance-none transition-all cursor-pointer"
                                >
                                    <option value="" disabled hidden>Pilih salah satu kategori materi</option>
                                    <option v-for="category in categories" :key="category.id" :value="category.id">
                                        {{ category.name }}
                                    </option>
                                </select>
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            <InputError :message="form.errors.category_id" />
                        </div>

                        <!-- Action Buttons Flow: Dual Action Buttons -->
                        <div class="pt-6 border-t border-slate-200/80 dark:border-slate-800 flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-3.5">
                            <Link
                                :href="route('dashboard.courses.index')"
                                class="px-5 py-3 text-center bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold rounded-xl text-xs uppercase tracking-wider transition-all active:scale-95"
                            >
                                Batal
                            </Link>

                            <button
                                type="button"
                                @click="submitWithAction('manage')"
                                :disabled="form.processing"
                                class="px-5 py-3 bg-white dark:bg-[#141419] border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-200 font-bold rounded-xl text-xs uppercase tracking-wider transition-all active:scale-95 disabled:opacity-50"
                            >
                                Simpan Saja
                            </button>

                            <button
                                type="button"
                                @click="submitWithAction('add_questions')"
                                :disabled="form.processing"
                                class="px-6 py-3 bg-[#D95300] hover:bg-[#b84600] text-white font-bold rounded-xl text-xs uppercase tracking-wider transition-all shadow-md shadow-[#D95300]/20 hover:shadow-lg hover:shadow-[#D95300]/30 active:scale-95 flex items-center justify-center gap-2 disabled:opacity-50"
                            >
                                <span>Simpan &amp; Lanjut Tambah Soal</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<style scoped>
@keyframes slideUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
.animate-slide-up { animation: slideUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
</style>
