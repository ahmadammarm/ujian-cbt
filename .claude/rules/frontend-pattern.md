# Frontend Development Standards

## 1. Introduction
This document establishes the mandatory architectural, structural, and coding standards for all frontend development within the Ujian CBT project. Utilizing Vue 3, Inertia.js, and Tailwind CSS, these standards ensure a consistent, high-performance, and visually premium user experience. AI agents must strictly adhere to these guidelines.

## 2. Core Architectural Principles: Atomic Design

All UI components must be categorized according to the Atomic Design hierarchy to ensure modularity and extreme reusability.

### 2.1 Atoms (Stateless Building Blocks)
Atoms are the basic building blocks of the UI. They are typically stateless and perform a single function.
*   **Examples:** Buttons, Input fields, Badges, Icons, Labels.
*   **Location:** `resources/js/Components/Atoms`.
*   **Rule:** If a style or basic UI element is used in more than two places, it must be an Atom.

### 2.2 Molecules (Functional Groups)
Molecules are groups of atoms bonded together that function as a single unit.
*   **Examples:** A Search input (Input atom + Icon atom), a Form field (Label atom + Input atom + Error atom).
*   **Location:** `resources/js/Components/Molecules`.

### 2.3 Organisms (Complex UI Sections)
Organisms are complex UI components composed of molecules and/or atoms. They are typically self-contained and represent a distinct section of the interface.
*   **Examples:** Data tables, Navigation bars, Chart cards, Sidebar.
*   **Location:** `resources/js/Components/Organisms`.

### 2.4 Templates (Structural Context)
Templates are page-level objects that place components into a layout and articulate the design's underlying content structure.
*   **Examples:** `AdminLayout`, `StudentLayout`, `GuestLayout`.
*   **Location:** `resources/js/Components/Templates`.

### 2.5 Pages (Specific View Instances)
Pages are specific instances of templates that represent a route in the application.
*   **Location:** `resources/js/Pages`.
*   **Rule:** Pages should focus on data orchestration and high-level layout, delegating all UI rendering to Organisms and Molecules.

## 3. Directory and Naming Conventions

### 3.1 Naming Standards
*   **Component Files:** PascalCase (e.g., `InkButton.vue`).
*   **Page Files:** PascalCase, organized by role (e.g., `Admin/Courses/Index.vue`).
*   **Props:** camelCase.
*   **Emits:** kebab-case.

### 3.2 Script Standards
*   **Composition API:** Always use the `<script setup>` syntax.
*   **Reactivity:** Prefer `ref` for primitive values and `reactive` for complex objects where appropriate.
*   **Props Definition:** Use `defineProps` with explicit types and required status.

## 4. State Management and Data Flow

### 4.1 Inertia.js Integration
*   **Primary Data Source:** Always use Inertia props passed from the server for initial page data.
*   **Forms:** Always use the `useForm` hook for handling form state and submissions. This provides built-in processing, error handling, and progress indicators.
*   **Navigation:** Use the `<Link>` component for all internal navigation to maintain the SPA experience. Use `router` for manual navigation.

### 4.2 Local State vs. Server State
*   **Server State:** Data that originates from the database (e.g., student list, course details) must be handled by Inertia.
*   **Local State:** Only transient UI state (e.g., modal visibility, search query before submission) should be handled via Vue `ref`.

### 4.3 Debouncing
*   **Mandate:** Implement server-side searching using debouncing for all search/filter inputs.
*   **Pattern:** Use a `watch` on the input ref with a `setTimeout` of at least 500ms before triggering a `router.get` request.

## 5. Styling and UX Polish

### 5.1 Tailwind CSS Standards
*   **Utility-First:** Use Tailwind utility classes for all styling.
*   **Prohibition:** Custom `<style>` blocks and inline styles are strictly prohibited unless dealing with dynamic data-driven styles (e.g., progress bar width, animation delay per item).
*   **Design Tokens Only:** Use the "study desk" tokens from `tailwind.config.js` — `desk`, `paper`, `rule`, `ink`, `ink-soft`, `ink-mark`, `pen`, `graphite`, `stabilo`, `sticky` (meanings in `.claude/CLAUDE.md`). Never write raw hex colors (`bg-[#...]`) in templates; add a token instead.
    *   Primary action: `InkButton` (`bg-ink`). Secondary: `GhostButton`. Destructive: `variant="danger"` (`pen`).
    *   Selected / active / focused field: `stabilo` highlight. Errors and violations: `pen`.
*   **Typography:** `font-hand` only for page titles (via `PageHeader`) and handwritten accents; `font-legible` (default `sans`) for body, tables, and forms; `font-form` for small uppercase labels, numbers, and timers.
*   **Light Mode Only:** The app has no dark mode. Do not add `dark:` variants or a theme toggle.
*   **Tailwind v3:** The project runs Tailwind 3.4. Do not use v4-only class names (e.g., `shadow-xs`, `shadow-2xs`, `backdrop-blur-xs`, `outline-hidden`); they generate no CSS.
*   **Icons:** Use the `Icon` atom (`<Icon name="..." />`). Add new paths to its map instead of inlining SVGs or using image files.

### 5.2 Animations and Transitions
*   **Restraint:** Motion is reserved for meaning — the pencil fill (`animate-pencil`), highlighter stroke (`animate-highlight`), and entering elements (`animate-slide-up`, `animate-fade-in`).
*   **Reduced Motion:** Prefix decorative animation with `motion-safe:` and add `motion-reduce:transition-none` to transitions.
*   **Interactive Feedback:** Every interactive element needs a hover state and a visible keyboard focus ring (`focus-visible:ring-2 focus-visible:ring-pen`).

### 5.3 Shared Constants
*   **Exam rules:** Import `PASSING_SCORE`, `isPassing`, and date formatters from `@/Utils/exam`; never hardcode `70` or re-implement date formatting.
*   **Charts:** Import colors and base options from `@/Utils/chartTheme`.

## 6. Implementation Example: Atomic DRY Pattern

### 6.1 Reusable Status Badge (Atom)
```vue
<!-- resources/js/Components/Atoms/StatusBadge.vue (simplified) -->
<script setup>
defineProps({
    active: {
        type: Boolean,
        default: true
    }
});
</script>

<template>
    <span :class="[
        'inline-flex items-center rounded-full px-3 py-1 font-form text-[10px] font-semibold uppercase tracking-[0.14em]',
        active ? 'bg-ink/10 text-ink' : 'bg-pen/10 text-pen'
    ]">
        <slot />
    </span>
</template>
```

### 6.2 Implementation in an Organism
```vue
<!-- resources/js/Components/Organisms/StudentRow.vue (simplified) -->
<script setup>
import GhostButton from '@/Components/Atoms/GhostButton.vue';
import ScoreMark from '@/Components/Atoms/ScoreMark.vue';
import StatusBadge from '@/Components/Atoms/StatusBadge.vue';

defineProps({ student: { type: Object, required: true } });
defineEmits(['toggle-suspension']);
</script>

<template>
    <div class="flex items-center gap-4 px-5 py-4">
        <p class="min-w-0 flex-1 truncate font-bold text-ink">{{ student.name }}</p>
        <ScoreMark :score="student.assessments_avg_score" size="sm" />
        <StatusBadge :active="student.is_active">
            {{ student.is_active ? 'Aktif' : 'Nonaktif' }}
        </StatusBadge>
        <GhostButton size="sm" variant="danger" @click="$emit('toggle-suspension', student)">
            Nonaktifkan
        </GhostButton>
    </div>
</template>
```

### 6.3 Page Composition
Pages compose a Template, a `PageHeader`, and organisms/molecules; they hold data orchestration only:
```vue
<StudentLayout>
    <div class="flex flex-col gap-8">
        <PageHeader eyebrow="Ujian saya" title="Pilih ujian yang mau dikerjakan." />
        <ul v-if="courses.length" class="divide-y divide-rule rounded-md border border-rule bg-paper">…</ul>
        <EmptyState v-else title="Belum ada ujian untukmu." description="…" />
    </div>
</StudentLayout>
```

## 7. Performance Optimization

### 7.1 Debounced Searching Example
```javascript
const search = ref('');
watch(search, (value) => {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
        router.get(route('dashboard.students.index'), { search: value }, {
            preserveState: true,
            replace: true,
        });
    }, 500);
});
```

## 8. Prohibitions and Anti-patterns

### 8.1 What NOT to do
*   **Monolithic Page Components:** Never build a page without breaking it down into at least one template and several organisms/molecules.
*   **Direct API Calls:** Never use `axios` or `fetch` for data that should be passed as Inertia props or handled via `useForm`.
*   **Manual DOM Manipulation:** Never use `document.getElementById`, `id` attributes for styling, or manual class manipulation.
*   **Hardcoded Styles:** Never use the `style` attribute for layout or static styling. Use Tailwind.
*   **Off-palette Colors & Old Fonts:** Never reintroduce Poppins/Nunito, the old terracotta/cobalt palette (`#D95300`, `#2B82FE`, `#0A090B`), Tailwind's default grays (`slate-*`, `gray-*`), or `dark:` variants.
*   **Duplicated Components:** Before writing a button, field, badge, empty state, or page header, reuse the existing atom/molecule (`InkButton`, `GhostButton`, `NotebookField`, `StatusBadge`, `EmptyState`, `PageHeader`, …).
*   **Logic in Templates:** Keep logic in the `<script>` section. Templates should be as declarative as possible.
*   **Hardcoded UI Strings:** Reusable components should accept labels as props rather than hardcoding text.
*   **Ignoring Accessibility:** Ensure all interactive elements have appropriate focus states and semantic tags.

## 9. Conclusion
Consistency is the foundation of a premium application. By adhering to these Atomic Design and Inertia.js standards, we ensure that the Ujian CBT frontend remains clean, scalable, and delightful for the user. Any component that violates these rules must be refactored.
