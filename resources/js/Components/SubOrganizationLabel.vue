<script setup>
defineProps({
    value: {
        type: String,
    },
});
</script>

<template>
    <q-chip color="amber-9" text-color="white">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </q-chip>
</template>
