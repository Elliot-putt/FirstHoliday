<template>
    <Link :class="active ? 'fw-bold text-white fs-5' : 'text-white'" class="text-decoration-none btn" ><slot/></Link>
</template>

<script setup>

defineProps({
    active:Boolean,
})
</script>

