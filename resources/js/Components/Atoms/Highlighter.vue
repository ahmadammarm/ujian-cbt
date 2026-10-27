<template>
    <span class="relative inline-block whitespace-nowrap">
        <span
            aria-hidden="true"
            class="absolute -inset-x-[0.12em] bottom-[0.06em] h-[0.5em] origin-left rounded-[3px] bg-stabilo motion-safe:animate-highlight"
        ></span>
        <span class="relative">
            <slot />
        </span>
    </span>
</template>
