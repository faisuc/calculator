<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button
        :type="type"
        v-bind="$attrs"
        class="w-full items-center px-6 py-3 border border-transparent text-base text-center font-bold rounded-md text-gray-700 bg-gray-200 hover:bg-gray-100 focus:outline-none">
        <slot />
    </button>
</template>