<template>
    <Head>
        <title>Home</title>
        <meta type="description" content="Information about my app" head-key="description">
    </Head>
    <div class="col-md-12">
        <Nav/>
    </div>
    <div class="col-md-11 my-2 mx-auto " style="min-height: 85vh">
        <slot/>
    </div>
    <div class="position-relative bottom-0 h-100 w-100 mt-5">
            <Footer  ></Footer>

    </div>
</template>

<script setup>
import Nav from "./Nav";
import Footer from "./Footer";


</script>

