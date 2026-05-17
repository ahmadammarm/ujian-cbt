<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import Dropdown from '@/Components/Organisms/Dropdown.vue';
import DropdownLink from '@/Components/Molecules/DropdownLink.vue';

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
    <div class="font-poppins text-[#0A090B] bg-white min-h-screen">
        <!-- Mobile Sidebar Overlay -->
        <div
            v-if="isSidebarOpen"
            class="fixed inset-0 bg-black/20 backdrop-blur-sm z-[60] lg:hidden"
            @click="isSidebarOpen = false"
        ></div>

        <section class="flex flex-col lg:flex-row relative">
            <!-- Sidebar -->
            <aside
                id="sidebar"
                :class="[
                    'fixed lg:sticky top-0 left-0 z-[70] w-[280px] h-screen bg-[#FBFBFB] border-r border-[#EEEEEE] p-8 flex flex-col justify-between transition-transform duration-300 ease-in-out',
                    isSidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'
                ]"
            >
                <div class="flex flex-col gap-10">
                    <Link :href="route('dashboard')" class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-[#D95300] rounded-xl flex items-center justify-center shadow-lg shadow-[#D95300]/20">
                            <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <span class="text-xl font-bold tracking-tight">Ujian CBT</span>
                    </Link>

                    <div class="flex flex-col gap-8">
                        <div>
                            <h3 class="font-bold text-[11px] text-[#A5ABB2] uppercase tracking-[0.1em] mb-4">Daily Use</h3>
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
                                        <span>Courses</span>
                                    </Link>
                                </li>
                                <li>
                                    <Link :href="route('dashboard.students.index')" class="nav-link" :class="{'active': route().current('dashboard.students.*')}">
                                        <img src="/assets/images/icons/profile-2user.svg" class="w-5 h-5 icon" alt="icon">
                                        <span>Students</span>
                                    </Link>
                                </li>
                                <li>
                                    <Link :href="route('dashboard.analytics')" class="nav-link" :class="{'active': route().current('dashboard.analytics')}">
                                        <img src="/assets/images/icons/chart-2.svg" class="w-5 h-5 icon" alt="icon">
                                        <span>Analytics</span>
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
                <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-[#EEEEEE] h-20 flex items-center justify-between px-6 lg:px-10">
                    <!-- Hamburger -->
                    <button
                        id="hamburger-button"
                        @click="toggleSidebar"
                        class="p-2 -ml-2 rounded-xl text-gray-500 hover:bg-gray-100 lg:hidden transition-colors"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path v-if="!isSidebarOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <!-- Spacer for mobile, nothing for desktop -->
                    <div class="lg:hidden font-bold text-lg">Ujian Online</div>
                    <div class="hidden lg:block"></div>

                    <div class="flex items-center gap-6">
                        <!-- Notifications/Actions -->
                        <div class="hidden sm:flex items-center gap-3">
                            <button class="w-11 h-11 flex items-center justify-center rounded-full border border-[#EEEEEE] hover:bg-gray-50 transition-colors">
                                <img src="/assets/images/icons/receipt-text.svg" class="w-5 h-5" alt="icon">
                            </button>
                            <button class="w-11 h-11 flex items-center justify-center rounded-full border border-[#EEEEEE] hover:bg-gray-50 transition-colors">
                                <img src="/assets/images/icons/notification.svg" class="w-5 h-5" alt="icon">
                            </button>
                        </div>

                        <div class="h-8 w-[1px] bg-[#EEEEEE] hidden sm:block"></div>

                        <!-- User Dropdown -->
                        <Dropdown align="right" width="56">
                            <template #trigger>
                                <button class="flex items-center gap-3 p-1.5 rounded-2xl hover:bg-gray-50 transition-all group">
                                    <div class="flex flex-col text-right hidden sm:flex">
                                        <p class="text-[12px] font-medium text-gray-400">Howdy</p>
                                        <p class="text-[14px] font-bold text-[#0A090B] group-hover:text-[#D95300] transition-colors">{{ props.auth.user.name }}</p>
                                    </div>
                                    <div class="w-11 h-11 rounded-xl overflow-hidden border-2 border-transparent group-hover:border-[#D95300] transition-all shadow-sm">
                                        <img src="/assets/images/photos/default-photo.svg" alt="photo" class="w-full h-full object-cover">
                                    </div>
                                </button>
                            </template>

                            <template #content>
                                <div class="px-4 py-3 border-b border-gray-50 lg:hidden">
                                    <p class="text-sm font-bold text-gray-900">{{ props.auth.user.name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ props.auth.user.email }}</p>
                                </div>
                                <div class="p-1">
                                    <DropdownLink :href="route('profile.edit')" class="rounded-lg">
                                        <div class="flex items-center gap-3">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                            </svg>
                                            My Profile
                                        </div>
                                    </DropdownLink>
                                    <DropdownLink :href="route('logout')" method="post" as="button" class="rounded-lg text-[#FD445E] hover:bg-red-50">
                                        <div class="flex items-center gap-3">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                            </svg>
                                            Sign Out
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
    @apply flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all duration-300 text-gray-500 hover:bg-gray-100 hover:text-[#0A090B];
}

.nav-link.active {
    @apply bg-[#2B82FE] text-white shadow-lg shadow-blue-100 hover:bg-[#2B82FE];
}

.nav-link .icon {
    @apply transition-all duration-300 opacity-60;
}

.nav-link.active .icon {
    @apply brightness-0 invert opacity-100;
}

.nav-link span {
    @apply font-bold text-[14px];
}
</style>

