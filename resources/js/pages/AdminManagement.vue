<script setup lang="ts">
import { ref, watch } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import debounce from 'lodash/debounce';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import Button from '@/components/ui/button/Button.vue';
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select";

interface Admin {
    adminLevel: number;
}

interface User {
    id: number;
    name: string;
    email: string;
    admin?: Admin;
}

// Fix the type for ADMIN_LEVELS
const ADMIN_LEVELS = {
    NORMAL_USER: 0,
    MODERATOR: 1,
    ADMIN: 2,  
} as const;

type AdminLevel = typeof ADMIN_LEVELS[keyof typeof ADMIN_LEVELS];

const ADMIN_LEVEL_LABELS: Record<AdminLevel, string> = {
    [ADMIN_LEVELS.NORMAL_USER]: 'Felhasználó',
    [ADMIN_LEVELS.MODERATOR]: 'Moderátor', 
    [ADMIN_LEVELS.ADMIN]: 'Admin',
};

// Make props optional with default values
const props = withDefaults(defineProps<{
    links?: any;
    users?: {
        data: User[];
        from: number;
        to: number;
        total: number;
        links: any[];
    };
    filters?: {
        search: string;
    };
}>(), {
    links: () => ({}),
    users: () => ({
        data: [],
        from: 0,
        to: 0,
        total: 0,
        links: []
    }),
    filters: () => ({
        search: ''
    })
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Jogkezelő',  
        href: '/management',
    },
    {
        title: 'Adminisztrátorkezelés',
        href: '/management/admins',
    },
];

const search = ref(props.filters?.search ?? '');

// Fix the search watch handler
watch(search, debounce((value) => {
    router.get(route('management.admin-levels'), { 
        search: value 
    }, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
        only: ['users', 'filters']
    });
}, 300));

// Fix the selectedLevels type
const selectedLevels = ref<Record<number, string>>({});

// Fix the type error in updateAdminLevel
const updateAdminLevel = (userId: number, level: string) => {
    const numLevel = parseInt(level) as AdminLevel;
    if (!(numLevel in ADMIN_LEVEL_LABELS)) return;

    selectedLevels.value[userId] = level;
    router.post(`/users/${userId}/update-admin-level`, 
        { level: numLevel }, 
        {
            preserveScroll: true,
            onError: (errors) => {
                console.error('Failed to update admin level:', errors);
                const currentUser = props.users?.data.find(u => u.id === userId);
                selectedLevels.value[userId] = String(currentUser?.admin?.adminLevel ?? 0);
            }
        }
    );
};

// Initialize selected levels when users data changes
watch(() => props.users?.data, (newUsers) => {
    if (newUsers) {
        newUsers.forEach(user => {
            selectedLevels.value[user.id] = String(user.admin?.adminLevel ?? '0');
        });
    }
}, { immediate: true });

const getAdminLevelClass = (level: number) => {
    switch (level) {
        case ADMIN_LEVELS.ADMIN:
            return 'text-red-600';
        case ADMIN_LEVELS.MODERATOR:
            return 'text-blue-600';
        default:
            return 'text-gray-600';
    }
};

const goToPage = (url: string) => {
    if (url) {
        router.get(url, {}, {
            preserveState: true,
            preserveScroll: true
        });
    }
};

// Fix the template type error with proper type casting
const getSelectPlaceholder = (userId: number): string => {
    const level = Number(selectedLevels.value[userId]) as AdminLevel;
    return ADMIN_LEVEL_LABELS[level] || ADMIN_LEVEL_LABELS[0];
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
                                    <th class="px-6 py-3 text-left">Jogosultság</th>
                                    <th class="px-6 py-3 text-left">Műveletek</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-black dark:divide-gray-200">
                                <tr v-for="user in users?.data || []" :key="user.id">
                                    <td class="px-6 py-4">{{ user.name }}</td>
                                    <td class="px-6 py-4">{{ user.email }}</td>
                                    <td class="px-6 py-4">
                                        <span :class="getAdminLevelClass(user.admin?.adminLevel ?? 0)">
                                            {{ ADMIN_LEVEL_LABELS[user.admin?.adminLevel as keyof typeof ADMIN_LEVEL_LABELS ?? 0] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <Select
                                            :model-value="selectedLevels[user.id]"
                                            @update:model-value="(level) => level !== null && updateAdminLevel(user.id, String(level))"
                                        >
                                            <SelectTrigger class="w-[180px]">
                                                <SelectValue :placeholder="getSelectPlaceholder(user.id)" />
                                            </SelectTrigger>
                                            <SelectContent>
                                                <SelectItem
                                                    v-for="(label, level) in ADMIN_LEVEL_LABELS"
                                                    :key="level"
                                                    :value="String(level)"
                                                >
                                                    {{ label }}
                                                </SelectItem>
                                            </SelectContent>
                                        </Select>
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