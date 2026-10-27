<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import InkButton from '@/Components/Atoms/InkButton.vue';
import NotebookField from '@/Components/Molecules/NotebookField.vue';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <div>
        <header>
            <h2 class="text-xl font-bold text-ink">Ganti password</h2>
            <p class="mt-1 text-[15px] text-ink-soft">Pakai password yang mudah kamu ingat, tapi sulit ditebak teman.</p>
        </header>

        <form class="mt-6 space-y-7" @submit.prevent="updatePassword">
            <NotebookField
                id="current_password"
                ref="currentPasswordInput"
                v-model="form.current_password"
                type="password"
                label="Password sekarang"
                autocomplete="current-password"
                :error="form.errors.current_password"
            />

            <NotebookField
                id="password"
                ref="passwordInput"
                v-model="form.password"
                type="password"
                label="Password baru"
                hint="Minimal 8 karakter."
                autocomplete="new-password"
                :error="form.errors.password"
            />

            <NotebookField
                id="password_confirmation"
                v-model="form.password_confirmation"
                type="password"
                label="Ulangi password baru"
                autocomplete="new-password"
                :error="form.errors.password_confirmation"
            />

            <div class="flex items-center gap-4">
                <InkButton size="sm" :disabled="form.processing">Simpan password</InkButton>
                <Transition
                    enter-active-class="transition ease-in-out motion-reduce:transition-none"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out motion-reduce:transition-none"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" role="status" class="font-hand text-lg font-bold text-ink">Tersimpan.</p>
                </Transition>
            </div>
        </form>
    </div>
</template>
