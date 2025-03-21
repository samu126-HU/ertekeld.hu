<script setup lang="ts">
import { ref, watch } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import debounce from 'lodash/debounce';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import Button from '@/components/ui/button/Button.vue';
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger,
} from "@/components/ui/alert-dialog";

interface Website {
    id: number;
    name: string;
    url: string;
    created_at: string;
}

const props = defineProps<{
    websites: {
        data: Website[];
        links: any[];
        from: number;
        to: number;
        total: number;
    };
    filters: {
        search: string;
    };
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Weboldalkezelő',
        href: '/management/websites',
    },
];

const search = ref(props.filters.search);
const newWebsite = ref({
    name: '',
    url: ''
});
const showAddForm = ref(false);
const showSuccessAlert = ref(false);
const successMessage = ref('');

watch(search, debounce((value) => {
    router.get('/management/websites', { search: value }, {
        preserveState: true,
        preserveScroll: true
    });
}, 300));

const deleteWebsite = (websiteId: number) => {
    router.delete(`/management/websites/delete/${websiteId}`, {
        onSuccess: () => {
            showSuccessAlert.value = true;
            setTimeout(() => {
                showSuccessAlert.value = false;
            }, 1000);
        },
    });
    router.delete(`/management/websites/delete/${websiteId}`);
}


const errors = ref<Record<string, string[]>>({});
const addWebsite = () => {
    errors.value = {};
    router.post('/management/websites/add', newWebsite.value, {
        onSuccess: () => {
            newWebsite.value = { name: '', url: '' };
            showAddForm.value = false;
            showSuccessAlert.value = true;
            setTimeout(() => {
                showSuccessAlert.value = false;
            }, 1000);
        },
        onError: (formErrors) => {
            errors.value = Object.fromEntries(
                Object.entries(formErrors).map(([key, value]) => [key, Array.isArray(value) ? value : [value]])
            );
        }
    });
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

    <Head title="Weboldalkezelő"></Head>

    <AppLayout :breadcrumbs="breadcrumbs">

        <div class="py-12">
            <div class="max-w-7xl mx-1 md:mx-auto  sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-black overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="flex justify-between mb-4">
                        <input v-model="search" type="text" placeholder="Weboldal keresése"
                            class="w-full sm:w-1/3 rounded-md p-2 shadow-lg border border-gray-300 placeholder:text-gray-400 shadow-gray-700 dark:text-black">
                        <Button @click="showAddForm = !showAddForm">
                            {{ showAddForm ? 'Bezárás' : 'Új weboldal' }}
                        </Button>
                    </div>

                    <!-- Add Website Form -->
                    <div v-if="showAddForm" class="mb-6 p-4 border rounded-lg">
                        <div class="grid gap-4">
                            <div>
                                <label class="block mb-1">Név:</label>
                                <input v-model="newWebsite.name" type="text"
                                    class="w-full rounded-md p-2 border dark:text-black"
                                    :class="{ 'border-red-500': errors.name }">
                                <div v-if="errors.name" class="text-red-500 text-sm mt-1">
                                    {{ errors.name[0] }}
                                </div>
                            </div>
                            <div>
                                <label class="block mb-1">URL:</label>
                                <input v-model="newWebsite.url" type="url"
                                    class="w-full rounded-md p-2 border dark:text-black"
                                    :class="{ 'border-red-500': errors.url }">
                                <div v-if="errors.url" class="text-red-500 text-sm mt-1">
                                    {{ errors.url[0] }}
                                </div>
                            </div>
                            <Button @click="addWebsite" class="mt-2">
                                Hozzáadás
                            </Button>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left">Név</th>
                                    <th class="px-6 py-3 text-left">URL</th>
                                    <th class="px-6 py-3 text-left">Létrehozva</th>
                                    <th class="px-6 py-3 text-left">Műveletek</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-black dark:divide-gray-200">
                                <tr v-for="website in websites?.data" :key="website.id">
                                    <td class="px-6 py-4">{{ website.name }}</td>
                                    <td class="px-6 py-4">
                                        <a :href="website.url" target="_blank"
                                            class="text-blue-600 hover:underline block w-full">
                                            <span class="hidden sm:hidden md:inline lg:inline">{{ website.url }}</span>
                                            <span class="inline sm:inline md:hidden lg:hidden">
                                                {{ website.url.length > 30 ? website.url.substring(0, 30) + '...' :
                                                website.url }}
                                            </span>
                                        </a>
                                    </td>
                                    <td class="px-6 py-4">{{ new Date(website.created_at).toLocaleDateString() }}</td>
                                    <td class="px-6 py-4">
                                        <Button @click="deleteWebsite(website.id)" class="bg-red-600 hover:bg-red-700">
                                            Törlés
                                        </Button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="flex justify-end my-4 mr-4">
                        <span class="text-sm text-gray-700 dark:text-gray-300">
                            {{ websites ? `${websites.from || 0} - ${websites.to || 0} / ${websites.total || 0}` : 'N/A'
                            }}
                        </span>
                    </div>

                    <div class="flex justify-center">
                        <nav v-if="websites?.links?.length" class="pagination">
                            <Button v-for="(link, index) in websites.links" :key="index"
                                :disabled="link.active || !link.url" @click="goToPage(link.url)"
                                class="px-3 py-1 mx-1 rounded-md border-2" :class="{
                                    'bg-white text-black dark:bg-black dark:text-white': link.active,
                                }">
                                {{ link.label }}
                            </Button>
                        </nav>
                    </div>
                    {{ successMessage }}
                </div>
            </div>
        </div>

        <AlertDialog :open="showSuccessAlert">
            <AlertDialogContent>
                <AlertDialogHeader>
                    <AlertDialogTitle>Sikeres művelet</AlertDialogTitle>
                    <AlertDialogDescription>
                        A weboldal sikeresen hozzáadva!
                    </AlertDialogDescription>
                </AlertDialogHeader>
            </AlertDialogContent>
        </AlertDialog>

    </AppLayout>
</template>