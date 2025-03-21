<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import Heading from '@/components/Heading.vue';
import Button from '@/components/ui/button/Button.vue';
import { BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Jogosultságok kezelése',
        href: '/management',
    },
];

const handleAdminClick = () => {
    window.location.href = route('management.admin-levels');
};

const handleRaterClick = () => {
    window.location.href = route('management.users');
};


</script>

<template>

    <Head title="Jogkezelés"></Head>

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-5 text-center">
            <Heading title="Jogosultságkezelés"
                description="Válasszon az alábbi jogosultságkezelési lehetőségek közül:"></Heading>
            <ul class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-4  gap-4 mt-8">
                <span class="hidden xl:grid"></span>
                <li class="grid">
                    <Button @click="handleAdminClick" class="w-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path
                                d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                        </svg>
                        Adminok kezelése
                    </Button>
                    <Heading title="" class="mt-2 text-xs md:text-sm"
                        description="Az adminisztrátorok jogosultságainak kezelése. Itt tudja hozzáadni, eltávolítani vagy módosítani az adminisztrátorok jogosultságait a rendszerben. Adminisztrátorként hozzéférhet a különböző jogkezelő rendszerekhez.">
                    </Heading>
                </li>
                <li class="grid">
                    <Button @click="handleRaterClick" class="w-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                            <path fill-rule="evenodd"
                                d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                                clip-rule="evenodd" />
                        </svg>
                        Értékelők kezelése
                    </Button>
                    <Heading title="" class="mt-2 text-xs md:text-sm" description="Az értékelők jogosultságainak kezelése. Ezen a felületen tudja kezelni az értékelők
                        jogosultságait a rendszerben. Alapértelmezetten egy fióknak nincs értékeléshez joga, ezt
                        manuálisan kell hozzáadni."> 
                    </Heading>
                </li>
                <span class="hidden xl:grid"></span>
            </ul>
        </div>
    </AppLayout>
</template>

<style scoped>
.grid {
    min-height: 60px;
}
</style>