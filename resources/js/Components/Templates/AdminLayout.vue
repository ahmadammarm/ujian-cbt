<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import Dropdown from '@/Components/Organisms/Dropdown.vue';
import DropdownLink from '@/Components/Molecules/DropdownLink.vue';
import ThemeToggle from '@/Components/Atoms/ThemeToggle.vue';

const { props } = usePage();
const isSidebarOpen = ref(false);

const toggleSidebar = () => {
    isSidebarOpen.value = !isSidebarOpen.value;
};

// Close sidebar when clicking outside on mobile
const closeSidebarOnMobile = (e) => {
    if (isSidebarOpen.value && window.innerWidth < 1024) {
        const sidebar = document.getElementById('sidebar');
        const hamburger = document.getElementById('hamburger-button');
        if (sidebar && !sidebar.contains(e.target) && hamburger && !hamburger.contains(e.target)) {
            isSidebarOpen.value = false;
        }
    }
};

onMounted(() => {
    document.addEventListener('click', closeSidebarOnMobile);
});

onUnmounted(() => {
    document.removeEventListener('click', closeSidebarOnMobile);
});
</script>

<template>
    <div class="font-poppins text-[#0A090B] dark:text-slate-100 bg-white dark:bg-[#0A090B] min-h-screen transition-colors">
        <!-- Mobile Sidebar Overlay -->
        <div
            v-if="isSidebarOpen"
            class="fixed inset-0 bg-black/40 backdrop-blur-sm z-[60] lg:hidden"
            @click="isSidebarOpen = false"
        ></div>

        <section class="flex flex-col lg:flex-row relative">
            <!-- Sidebar -->
            <aside
                id="sidebar"
                :class="[
                    'fixed lg:sticky top-0 left-0 z-[70] w-[280px] h-screen bg-[#FBFBFB] dark:bg-[#0E0E12] border-r border-[#EEEEEE] dark:border-slate-800 p-8 flex flex-col justify-between transition-transform duration-300 ease-in-out',
                    isSidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'
                ]"
            >
                <div class="flex flex-col gap-10">
                    <Link :href="route('dashboard.overview')" class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-[#D95300] rounded-xl flex items-center justify-center text-white shrink-0">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                <path d="M4 3.5H8.2L15.8 15.3V3.5H20V20.5H15.8L8.2 8.7V20.5H4V3.5Z" />
                            </svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xl font-extrabold tracking-tight text-[#0A090B] dark:text-white">Naiju</span>
                            <span class="text-[10px] font-bold text-[#D95300] uppercase tracking-wider -mt-0.5">Studio · Pengajar</span>
                        </div>
                    </Link>

                    <div class="flex flex-col gap-8">
                        <div>
                            <h3 class="font-bold text-[11px] text-[#A5ABB2] dark:text-slate-500 uppercase tracking-[0.1em] mb-4">Navigasi Utama</h3>
                            <ul class="flex flex-col gap-2">
                                <li>
                                    <Link :href="route('dashboard.overview')" class="nav-link" :class="{'active': route().current('dashboard.overview')}">
                                        <img src="/assets/images/icons/home-hashtag.svg" class="w-5 h-5 icon" alt="icon">
                                        <span>Overview</span>
                                    </Link>
                                </li>
                                <li>
                                    <Link :href="route('dashboard.courses.index')" class="nav-link" :class="{'active': route().current('dashboard.courses.*')}">
                                        <img src="/assets/images/icons/note-favorite.svg" class="w-5 h-5 icon" alt="icon">
                                        <span>Daftar Kursus</span>
                                    </Link>
                                </li>
                                <li>
                                    <Link :href="route('dashboard.students.index')" class="nav-link" :class="{'active': route().current('dashboard.students.*')}">
                                        <img src="/assets/images/icons/profile-2user.svg" class="w-5 h-5 icon" alt="icon">
                                        <span>Daftar Siswa</span>
                                    </Link>
                                </li>
                                <li>
                                    <Link :href="route('dashboard.analytics')" class="nav-link" :class="{'active': route().current('dashboard.analytics')}">
                                        <img src="/assets/images/icons/chart-2.svg" class="w-5 h-5 icon" alt="icon">
                                        <span>Analitik Nilai</span>
                                    </Link>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 min-w-0 flex flex-col">
                <!-- Top Navigation -->
                <nav class="sticky top-0 z-50 bg-white/80 dark:bg-[#0E0E12]/80 backdrop-blur-md border-b border-[#EEEEEE] dark:border-slate-800 h-20 flex items-center justify-between px-6 lg:px-10 transition-colors">
                    <!-- Hamburger -->
                    <button
                        id="hamburger-button"
                        @click="toggleSidebar"
                        class="p-2 -ml-2 rounded-xl text-gray-500 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-slate-800 lg:hidden transition-colors"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path v-if="!isSidebarOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <!-- Spacer for mobile, title for desktop -->
                    <div class="lg:hidden font-bold text-lg text-[#D95300]">Naiju Studio</div>
                    <div class="hidden lg:block text-xs font-semibold text-slate-500 dark:text-slate-400">
                        Ruang Kerja Pengajar · Manajemen Asesmen
                    </div>

                    <div class="flex items-center gap-4 sm:gap-6">
                        <!-- Theme Toggle Button -->
                        <ThemeToggle />

                        <div class="h-8 w-[1px] bg-[#EEEEEE] dark:bg-slate-800 hidden sm:block"></div>

                        <!-- User Dropdown -->
                        <Dropdown align="right" width="56">
                            <template #trigger>
                                <button class="flex items-center gap-3 p-1.5 rounded-2xl hover:bg-gray-50 dark:hover:bg-slate-800/60 transition-all group">
                                    <div class="flex flex-col text-right hidden sm:flex">
                                        <p class="text-[11px] font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Pengajar</p>
                                        <p class="text-[14px] font-bold text-[#0A090B] dark:text-white group-hover:text-[#D95300] dark:group-hover:text-[#D95300] transition-colors">{{ props.auth.user.name }}</p>
                                    </div>
                                    <div class="w-10 h-10 rounded-xl overflow-hidden border-2 border-slate-200 dark:border-slate-700 group-hover:border-[#D95300] transition-all shadow-xs flex items-center justify-center bg-slate-100 dark:bg-slate-800 font-bold text-sm text-[#D95300]">
                                        {{ props.auth.user.name ? props.auth.user.name.charAt(0).toUpperCase() : 'G' }}
                                    </div>
                                </button>
                            </template>

                            <template #content>
                                <div class="px-4 py-3 border-b border-gray-100 dark:border-slate-800 lg:hidden">
                                    <p class="text-sm font-bold text-gray-900 dark:text-white">{{ props.auth.user.name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-slate-400 truncate">{{ props.auth.user.email }}</p>
                                </div>
                                <div class="p-1 space-y-0.5">
                                    <DropdownLink :href="route('profile.edit')" class="rounded-lg">
                                        <div class="flex items-center gap-3">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                            </svg>
                                            Profil Saya
                                        </div>
                                    </DropdownLink>
                                    <DropdownLink :href="route('logout')" method="post" as="button" class="rounded-lg text-[#FD445E] dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/40">
                                        <div class="flex items-center gap-3">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                            </svg>
                                            Keluar
                                        </div>
                                    </DropdownLink>
                                </div>
                            </template>
                        </Dropdown>
                    </div>
                </nav>

                <!-- Dynamic Page Content -->
                <div class="p-6 lg:p-10">
                    <slot />
                </div>
            </main>
        </section>
    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap');

.font-poppins {
    font-family: 'Poppins', sans-serif;
}

.nav-link {
    @apply flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all duration-300 text-gray-500 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-slate-800/80 hover:text-[#0A090B] dark:hover:text-white;
}

.nav-link.active {
    @apply bg-[#D95300] text-white hover:bg-[#D95300] dark:bg-[#D95300] dark:text-white;
}

.nav-link .icon {
    @apply transition-all duration-300 opacity-60 dark:invert;
}

.nav-link.active .icon {
    @apply brightness-0 invert opacity-100 dark:invert-0 dark:brightness-0 dark:invert;
}

.nav-link span {
    @apply font-bold text-[14px];
}
</style>

