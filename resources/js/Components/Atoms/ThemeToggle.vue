<script setup>
import { ref, onMounted } from 'vue';

const isDark = ref(false);

const updateThemeState = () => {
    isDark.value = document.documentElement.classList.contains('dark');
};

onMounted(() => {
    updateThemeState();

    // Listen to OS theme changes if user has no explicit preference in localStorage
    const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
    const handleMediaChange = (e) => {
        if (!localStorage.getItem('theme')) {
            if (e.matches) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
            updateThemeState();
        }
    };
    mediaQuery.addEventListener('change', handleMediaChange);
});

const toggleTheme = (event) => {
    const targetState = !isDark.value;

    // Check for reduced motion preference or missing View Transition API
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (!document.startViewTransition || prefersReducedMotion) {
        applyTheme(targetState);
        return;
    }

    // Determine the origin coordinate (x, y) for the circular ripple reveal
    let x = event.clientX;
    let y = event.clientY;

    if (x === undefined || y === undefined || (x === 0 && y === 0)) {
        // Fallback for keyboard activation (Enter / Space)
        const target = event.currentTarget || event.target;
        if (target && target.getBoundingClientRect) {
            const rect = target.getBoundingClientRect();
            x = rect.left + rect.width / 2;
            y = rect.top + rect.height / 2;
        } else {
            x = window.innerWidth / 2;
            y = window.innerHeight / 2;
        }
    }

    // Calculate maximum radius to the furthest corner of the viewport
    const endRadius = Math.hypot(
        Math.max(x, window.innerWidth - x),
        Math.max(y, window.innerHeight - y)
    );

    const transition = document.startViewTransition(() => {
        applyTheme(targetState);
    });

    transition.ready.then(() => {
        const clipPath = [
            `circle(0px at ${x}px ${y}px)`,
            `circle(${endRadius}px at ${x}px ${y}px)`
        ];

        document.documentElement.animate(
            {
                clipPath: clipPath,
            },
            {
                duration: 480,
                easing: 'cubic-bezier(0.4, 0, 0.2, 1)',
                pseudoElement: '::view-transition-new(root)',
            }
        );
    });
};

const applyTheme = (dark) => {
    isDark.value = dark;
    if (dark) {
        document.documentElement.classList.add('dark');
        localStorage.setItem('theme', 'dark');
    } else {
        document.documentElement.classList.remove('dark');
        localStorage.setItem('theme', 'light');
    }
};
</script>

<template>
    <button
        type="button"
        @click="toggleTheme"
        class="w-10 h-10 rounded-xl flex items-center justify-center border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 hover:text-[#D95300] dark:hover:text-[#D95300] hover:border-slate-300 dark:hover:border-slate-700 transition-colors shadow-xs focus:outline-hidden focus:ring-2 focus:ring-[#D95300]/40"
        :title="isDark ? 'Beralih ke mode terang' : 'Beralih ke mode gelap'"
        aria-label="Alihkan tema tampilan"
    >
        <!-- Sun icon (shown when dark mode is active to toggle back to light) -->
        <svg
            v-if="isDark"
            class="w-4 h-4 text-amber-400"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <circle cx="12" cy="12" r="5"></circle>
            <line x1="12" y1="1" x2="12" y2="3"></line>
            <line x1="12" y1="21" x2="12" y2="23"></line>
            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
            <line x1="1" y1="12" x2="3" y2="12"></line>
            <line x1="21" y1="12" x2="23" y2="12"></line>
            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
        </svg>

        <!-- Moon icon (shown when light mode is active to toggle to dark) -->
        <svg
            v-else
            class="w-4 h-4 text-slate-700"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
        </svg>
    </button>
</template>
