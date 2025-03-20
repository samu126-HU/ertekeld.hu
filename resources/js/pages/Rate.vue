<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { router } from '@inertiajs/vue3';
import { type BreadcrumbItem } from '@/types';


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Értékelés',
        href: '/websites',
    },
];

defineProps({
    websites: Array,
    userRatings: Object,
    canRate: Boolean,
});

// @ts-expect-error Correct handling > no error.
const submitRating = (websiteId, rating) => {
    router.post(route('websites.rate'), {
        website_id: websiteId,
        rating: rating
    }, {
        preserveScroll: true
    });
};
</script>

<template>


    <Head title="Weboldal értékelés" />

    <AppLayout :breadcrumbs="breadcrumbs">

        <h1 class="text-2xl font-bold text-center pt-5">Weboldalak értékelése</h1>
        <!-- @vue-skip Annoying errors skip it  -->
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-2 lg:p-6">
                        <div v-for="website in websites" :key="website.id" class="mb-6 p-4 border rounded">
                            <h3 class="text-lg font-bold">{{ website.name }}</h3>
                            <a :href="website.url" target="_blank" class="text-blue-600 hover:underline block w-full">
                                <span class="hidden sm:hidden md:inline lg:inline">{{ website.url }}</span>
                                <span class="inline sm:inline md:hidden lg:hidden">
                                    {{ website.url.length > 30 ? website.url.substring(0, 30) + '...' : website.url }}
                                </span>
                            </a>
                            <div class="mt-2">
                                <p>Értékelés: {{ website.average_rating }} ({{ website.total_ratings }} szavazat)</p>
                                <div class="flex gap-2 mt-2">
                                    <button v-for="rating in 5" :key="rating"
                                        @click="canRate ? submitRating(website.id, rating) : null" :disabled="!canRate"
                                        :class="[
                                            'px-3 py-1 rounded',
                                            userRatings[website.id] === rating
                                                ? 'border bg-gray-400 text-white dark:bg-gray-300 dark:text-black'
                                                : 'border dark:bg-slate-700 hover:bg-gray-300',
                                            !canRate && 'opacity-50 cursor-not-allowed'
                                        ]">
                                        {{ rating }}
                                    </button>
                                    <p v-if="!canRate">Nincs lehetőséged jelenleg szavazni!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>