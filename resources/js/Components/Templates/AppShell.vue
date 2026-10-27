<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/Atoms/ApplicationLogo.vue';
import Icon from '@/Components/Atoms/Icon.vue';
import NavItem from '@/Components/Atoms/NavItem.vue';
import FlashNote from '@/Components/Molecules/FlashNote.vue';

defineProps({
    spaceLabel: {
        type: String,
        required: true,
    },
    spaceTag: {
        type: String,
        required: true,
    },
    // [{ label, href, icon, active }]
    navItems: {
        type: Array,
        required: true,
    },
});

const page = usePage();
const user = computed(() => page.props.auth.user);
const initial = computed(() => user.value?.name?.charAt(0).toUpperCase() || 'N');
const isProfileActive = computed(() => route().current('profile.edit'));

const isDrawerOpen = ref(false);
const closeDrawer = () => {
    isDrawerOpen.value = false;
};

const handleKeydown = (event) => {
    if (event.key === 'Escape') closeDrawer();
};

let removeNavigateListener = null;

onMounted(() => {
    window.addEventListener('keydown', handleKeydown);
    removeNavigateListener = router.on('navigate', closeDrawer);
});

onUnmounted(() => {
    window.removeEventListener('keydown', handleKeydown);
    removeNavigateListener?.();
});
</script>

<template>
    <div class="min-h-screen bg-desk font-legible text-ink antialiased selection:bg-stabilo selection:text-ink lg:flex">
        <!-- Mobile top bar -->
        <header class="sticky top-0 z-30 flex h-16 items-center justify-between border-b border-rule bg-paper/95 px-4 backdrop-blur sm:px-6 lg:hidden">
            <Link href="/" class="flex items-center gap-2.5 rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pen">
                <span class="flex size-9 items-center justify-center rounded-lg bg-ink text-paper">
                    <ApplicationLogo class="size-5" />
                </span>
                <span class="font-hand text-xl font-extrabold">{{ spaceLabel }}</span>
            </Link>
            <button
                type="button"
                class="flex size-10 items-center justify-center rounded-lg text-ink hover:bg-rule/50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pen active:scale-95"
                :aria-expanded="isDrawerOpen"
                aria-controls="app-sidebar"
                aria-label="Buka menu"
                @click="isDrawerOpen = true"
            >
                <Icon name="menu" class="size-6" />
            </button>
        </header>

        <!-- Drawer overlay (mobile) -->
        <Transition
            enter-active-class="transition-opacity duration-200 motion-reduce:transition-none"
            enter-from-class="opacity-0"
            leave-active-class="transition-opacity duration-150 motion-reduce:transition-none"
            leave-to-class="opacity-0"
        >
            <div v-if="isDrawerOpen" class="fixed inset-0 z-40 bg-graphite/40 lg:hidden" aria-hidden="true" @click="closeDrawer"></div>
        </Transition>

        <!-- Sidebar: the notebook margin -->
        <aside
            id="app-sidebar"
            :class="[
                'fixed inset-y-0 left-0 z-50 flex w-72 max-w-[85vw] flex-col border-r border-pen/40 bg-paper transition-transform duration-200 motion-reduce:transition-none lg:sticky lg:top-0 lg:z-auto lg:h-screen lg:w-64 lg:translate-x-0',
                isDrawerOpen ? 'translate-x-0' : '-translate-x-full',
            ]"
        >
            <div class="flex items-center justify-between gap-3 px-5 pb-6 pt-6">
                <Link href="/" class="flex items-center gap-3 rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pen">
                    <span class="flex size-10 items-center justify-center rounded-lg bg-ink text-paper">
                        <ApplicationLogo class="size-5" />
                    </span>
                    <span class="flex flex-col">
                        <span class="font-hand text-xl font-extrabold leading-tight">{{ spaceLabel }}</span>
                        <span class="font-form text-[10px] font-semibold uppercase tracking-[0.16em] text-pen">{{ spaceTag }}</span>
                    </span>
                </Link>
                <button
                    type="button"
                    class="flex size-9 items-center justify-center rounded-lg text-ink-soft hover:bg-rule/50 hover:text-ink focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pen lg:hidden"
                    aria-label="Tutup menu"
                    @click="closeDrawer"
                >
                    <Icon name="close" class="size-5" />
                </button>
            </div>

            <nav aria-label="Menu utama" class="flex-1 overflow-y-auto px-3">
                <ul class="space-y-1">
                    <li v-for="item in navItems" :key="item.href">
                        <NavItem :href="item.href" :icon="item.icon" :active="item.active">{{ item.label }}</NavItem>
                    </li>
                </ul>
            </nav>

            <div class="border-t border-rule px-3 pb-4 pt-4">
                <div class="flex items-center gap-3 px-3 pb-3">
                    <span class="flex size-10 shrink-0 items-center justify-center rounded-full bg-ink font-hand text-lg font-bold text-paper">{{ initial }}</span>
                    <span class="min-w-0">
                        <span class="block truncate text-sm font-bold text-ink">{{ user?.name }}</span>
                        <span class="block truncate text-xs text-ink-soft">{{ user?.email }}</span>
                    </span>
                </div>
                <NavItem :href="route('profile.edit')" icon="user" :active="isProfileActive">Profil saya</NavItem>
                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="flex w-full items-center gap-3 rounded-md px-3 py-2.5 font-legible text-[15px] text-pen transition-colors hover:bg-pen/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pen motion-reduce:transition-none"
                >
                    <Icon name="logout" class="size-5 shrink-0" />
                    Keluar
                </Link>
            </div>
        </aside>

        <main class="min-w-0 flex-1">
            <div class="mx-auto w-full max-w-6xl px-4 py-8 sm:px-6 lg:px-10 lg:py-10">
                <slot />
            </div>
        </main>

        <FlashNote />
    </div>
</template>
