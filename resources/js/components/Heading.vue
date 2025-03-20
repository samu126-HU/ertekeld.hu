<script setup lang="ts">
import { computed } from 'vue';

interface Props {
    title: string;
    description?: string;
    titleSize?: string;
}

const props = defineProps<Props>();

const titleClass = computed(() => {
    return `font-semibold tracking-tight ${props.titleSize || 'text-xl'}`;
});

</script>

<template>
    <div class="mb-8 space-y-0.5">
        <h2 :class="titleClass">{{ title }}</h2>
        <p v-if="description" class="text-sm text-muted-foreground">
            {{ description }}
        </p>
    </div>
</template>
