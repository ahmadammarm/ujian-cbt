<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import GhostButton from '@/Components/Atoms/GhostButton.vue';
import InkButton from '@/Components/Atoms/InkButton.vue';
import NotebookField from '@/Components/Molecules/NotebookField.vue';
import Modal from '@/Components/Organisms/Modal.vue';

// ProfileController::destroy validates into this named error bag
const ERROR_BAG = 'userDeletion';
const FOCUS_DELAY_MS = 250;

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    setTimeout(() => passwordInput.value.focus(), FOCUS_DELAY_MS);
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        errorBag: ERROR_BAG,
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.reset();
};
</script>

<template>
    <div>
        <header>
            <h2 class="text-xl font-bold text-pen">Hapus akun</h2>
            <p class="mt-1 text-[15px] leading-7 text-ink-soft">
                Akun, nilai, dan riwayat ujianmu terhapus permanen. Simpan dulu data yang masih kamu perlukan.
            </p>
        </header>

        <GhostButton size="sm" variant="danger" class="mt-6" @click="confirmUserDeletion">Hapus akun</GhostButton>

        <Modal :show="confirmingUserDeletion" max-width="md" @close="closeModal">
            <form class="p-6 sm:p-8" @submit.prevent="deleteUser">
                <h2 class="font-hand text-2xl font-extrabold text-ink">Yakin mau menghapus akunmu?</h2>
                <p class="mt-2 text-[15px] leading-7 text-ink-soft">
                    Tindakan ini tidak bisa dibatalkan. Masukkan password untuk melanjutkan.
                </p>

                <NotebookField
                    id="delete_password"
                    ref="passwordInput"
                    v-model="form.password"
                    type="password"
                    label="Password"
                    autocomplete="current-password"
                    :error="form.errors.password"
                    class="mt-6"
                />

                <div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                    <GhostButton size="sm" @click="closeModal">Batal</GhostButton>
                    <InkButton size="sm" variant="danger" :disabled="form.processing">Hapus akun</InkButton>
                </div>
            </form>
        </Modal>
    </div>
</template>
