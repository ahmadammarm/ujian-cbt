<script setup>
import { computed } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Components/Templates/AdminLayout.vue';
import Icon from '@/Components/Atoms/Icon.vue';
import InkButton from '@/Components/Atoms/InkButton.vue';
import MetricCard from '@/Components/Molecules/MetricCard.vue';
import PageHeader from '@/Components/Molecules/PageHeader.vue';
import { formatDate } from '@/Utils/exam';

defineProps({
    metrics: {
        type: Object,
        required: true,
    },
});

const page = usePage();
const firstName = computed(() => page.props.auth.user.name.split(' ')[0]);
const today = formatDate(new Date(), { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });

const shortcuts = [
    {
        title: 'Susun kursus & soal',
        description: 'Buat kursus baru, tambah soal pilihan ganda, dan atur sampulnya.',
        routeName: 'dashboard.courses.index',
        icon: 'book',
    },
    {
        title: 'Kelola siswa',
        description: 'Cari siswa, lihat rata-rata nilai, dan nonaktifkan akun bila perlu.',
        routeName: 'dashboard.students.index',
        icon: 'users',
    },
    {
        title: 'Baca analitik',
        description: 'Tren pendaftaran, kursus dengan nilai terbaik, dan rasio kelulusan.',
        routeName: 'dashboard.analytics',
        icon: 'chart',
    },
];
</script>

<template>
    <Head title="Ringkasan" />

    <AdminLayout>
        <div class="flex flex-col gap-10">
            <PageHeader
                :eyebrow="today"
                :title="`Selamat datang, ${firstName}.`"
                description="Ringkasan ujian di seluruh platform Naiju."
            >
                <template #actions>
                    <InkButton :href="route('dashboard.courses.create')" size="sm">
                        <Icon name="plus" class="size-4" />
                        Buat kursus
                    </InkButton>
                </template>
            </PageHeader>

            <div class="grid gap-4 sm:grid-cols-3">
                <MetricCard
                    title="Kursus"
                    :value="metrics.totalCourses"
                    :href="route('dashboard.courses.index')"
                    link-text="Kelola kursus"
                >
                    <template #icon><Icon name="book" class="size-5" /></template>
                </MetricCard>
                <MetricCard
                    title="Siswa terdaftar"
                    :value="metrics.totalStudents"
                    :href="route('dashboard.students.index')"
                    link-text="Lihat siswa"
                >
                    <template #icon><Icon name="users" class="size-5" /></template>
                </MetricCard>
                <MetricCard
                    title="Ujian dikerjakan"
                    :value="metrics.assessmentsTaken"
                    :href="route('dashboard.analytics')"
                    link-text="Buka analitik"
                >
                    <template #icon><Icon name="clipboard" class="size-5" /></template>
                </MetricCard>
            </div>

            <section aria-labelledby="pintasan-heading">
                <h2 id="pintasan-heading" class="text-xl font-bold text-ink">Mau mengerjakan apa?</h2>
                <ul class="mt-4 grid gap-4 md:grid-cols-3">
                    <li v-for="shortcut in shortcuts" :key="shortcut.routeName">
                        <Link
                            :href="route(shortcut.routeName)"
                            class="group flex h-full flex-col gap-3 rounded-md border border-rule bg-paper p-5 transition-colors hover:border-ink-soft focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pen motion-reduce:transition-none"
                        >
                            <span class="flex size-9 items-center justify-center rounded-md bg-rule/50 text-ink">
                                <Icon :name="shortcut.icon" class="size-5" />
                            </span>
                            <span class="flex items-center gap-1 font-bold text-ink">
                                {{ shortcut.title }}
                                <Icon name="arrow-right" class="size-4 transition-transform group-hover:translate-x-0.5 motion-reduce:transition-none" />
                            </span>
                            <span class="text-sm leading-6 text-ink-soft">{{ shortcut.description }}</span>
                        </Link>
                    </li>
                </ul>
            </section>
        </div>
    </AdminLayout>
</template>
