<template>
    <div class="mt-4" >
        <Component :is="link.url ? 'Link' : 'span'" v-for="link in links"
                   class="mx-2 text-decoration-none"
                   :class="{'text-secondary' : ! link.url , 'btn btn-purple' : link.active}"
                   :href="link.url"
                   v-html="link.label"/>
    </div>
</template>

<script setup>
 defineProps({
     links:Array
 })
</script>

