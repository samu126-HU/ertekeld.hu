<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';

interface Review {
    id: number;
    user: {
        name: string;
    };
    website: {
        name: string;
        url: string;
    };
    rating: number;
    created_at: string;
}

interface Props {
    totalWebsites?: number;
    totalRatings?: number;
    averageRating?: number;
    latestReviews?: Review[];
}

const props = defineProps<Props>();

const formatNumber = (num: number): string => {
    return new Intl.NumberFormat('hu-HU').format(num);
};

const averageRatingFormatted = computed(() => {
    return props.averageRating?.toFixed(1) || '0.0';
});

const formatDate = (date: string): string => {
    return new Date(date).toLocaleDateString('hu-HU', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Főoldal',
        href: '/dashboard',
    },
];
</script>

<template>
    <Head title="Főoldal" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <!-- Websites Counter -->
                <div class="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                    <div class="flex flex-col">
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Értékelhető weboldalak</span>
                        <span class="text-3xl font-bold mt-2">{{ formatNumber(totalWebsites || 0) }}</span>
                        <div class="absolute right-6 top-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                            </svg>
                        </div>
                    </div>
                </div>
                
                <!-- Total Ratings -->
                <div class="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                    <div class="flex flex-col">
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Értékelések száma</span>
                        <span class="text-3xl font-bold mt-2">{{ formatNumber(totalRatings || 0) }}</span>
                        <div class="absolute right-6 top-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Average Rating -->
                <div class="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                    <div class="flex flex-col">
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Értékelések átlaga</span>
                        <span class="text-3xl font-bold mt-2">{{ averageRatingFormatted }}</span>
                        <div class="absolute right-6 top-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min p-6">
                <h2 class="text-xl font-semibold mb-4">Legutóbbi értékelések</h2>
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    <div v-for="review in latestReviews" :key="review.id" class="py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-medium">
                                    {{ review.user.name }} értékelte:
                                    <a :href="review.website.url" target="_blank" class="text-blue-600 hover:underline dark:text-blue-400">
                                        {{ review.website.name }}
                                    </a>
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ formatDate(review.created_at) }}
                                </p>
                            </div>
                            <div class="flex items-center">
                                <span class="text-lg font-bold">{{ review.rating }}/5</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div v-if="!latestReviews?.length" class="py-4 text-center text-gray-500 dark:text-gray-400">
                        Még nincsenek értékelések
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
