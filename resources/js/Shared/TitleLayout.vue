<template>
<div class="m-3">
    <h3 v-text="title"></h3>
    <p class="mt-2" v-text="description"></p>
</div>
</template>


<script setup>

defineProps({
    title:String,
    description:String,
})
</script>
