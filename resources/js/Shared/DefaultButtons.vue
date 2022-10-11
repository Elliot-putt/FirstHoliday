<template>
    <Link href="/" class=" my-auto mx-2 btn btn-grey"><i class="fa-solid fa-house me-2 "></i>Dashboard</Link>
    <Link @click.prevent="back()" class=" my-auto mx-2 fs-6 btn btn-red"><i class="fa-solid fa-circle-chevron-left me-2"></i>Previous Page</Link>
</template>

<script setup>
let back = function()
{
    window.history.back();
}
</script>

