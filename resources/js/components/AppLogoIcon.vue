<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

interface Props {
    className?: HTMLAttributes['class'];
}

defineProps<Props>();
</script>

<template>

<img :src="'/images/logo_darkmode.svg'" class="hidden dark:block" :class="className" alt="Ertekeld.hu" />
<img :src="'/images/logo_lightmode.svg'" class="block dark:hidden" :class="className" alt="Ertekeld.hu" />
    
</template>
