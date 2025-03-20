<script setup lang="ts">
import { ref, watch } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import debounce from 'lodash/debounce';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import Button from '@/components/ui/button/Button.vue';

const props = defineProps({
    links: Object,
    users: Object,
    filters: {
        type: Object,
        default: () => ({ search: '' })
    }
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Jogkezelő',
        href: '/management',
    },
    {
        title: 'Értékelési jog kezelése',
        href: '/management/users',
    },
];

const search = ref(props.filters.search);

watch(search, debounce((value) => {
    router.get('/management/users', { search: value }, {
        preserveState: true,
        preserveScroll: true
    });
}, 300));

const toggleUserRating = (userId: number) => {
    router.post(`/users/${userId}/toggle-rating`);
};

const goToPage = (url: string) => {
    if (url) {
        router.get(url, {}, {
            preserveState: true,
            preserveScroll: true
        });
    }
};

</script>

<template>

    <Head title="Jogkezelő"></Head>

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-black overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="mb-4">
                        <input v-model="search" type="text" placeholder="Felhasználó keresése"
                            class="w-full sm:w-1/3 rounded-md p-2 shadow-lg border border-gray-300 placeholder:text-gray-400 shadow-gray-700 dark:text-black">
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left">Név</th>
                                    <th class="px-6 py-3 text-left">Email</th>
                                    <th class="px-6 py-3 text-left">Szavazhat</th>
                                    <th class="px-6 py-3 text-left">Műveletek</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-black dark:divide-gray-200">
                                <tr v-for="user in users?.data || []" :key="user.id">
                                    <td class="px-6 py-4">{{ user.name }}</td>
                                    <td class="px-6 py-4">{{ user.email }}</td>
                                    <td class="px-6 py-4">
                                        <span :class="(user.rater?.canRate ?? false) ? 'text-green-600' : 'text-red-600'">
                                            {{ (user.rater?.canRate ?? false) ? 'Igen' : 'Nem' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <Button @click="toggleUserRating(user.id)">
                                            Megváltoztatás
                                        </Button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="flex justify-end my-4 mr-4">
                        <span class="text-sm text-gray-700 dark:text-gray-300">
                            {{ users ? `${users.from || 0} - ${users.to || 0} / ${users.total || 0}` : 'N/A' }}
                        </span>
                    </div>

                    <div class="flex justify-center">
                        <nav v-if="users?.links?.length" class="pagination">
                            <Button v-for="(link, index) in users.links" :key="index"
                                :disabled="link.active || !link.url" @click="goToPage(link.url)"
                                class="px-3 py-1 mx-1 rounded-md border-2" :class="{
                                    'bg-white text-black dark:bg-black dark:text-white': link.active,
                                }">
                                {{ link.label }}
                            </Button>
                        </nav>
                    </div>

                </div>
            </div>
        </div>
    </AppLayout>
</template>