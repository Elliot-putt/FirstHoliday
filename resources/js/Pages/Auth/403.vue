<template>
    <link href="https://fonts.googleapis.com/css?family=Raleway:500,800" rel="stylesheet">
    <body style="height: 100vh">
    <use>
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
             viewBox="0 0 1000 1000" enable-background="new 0 0 1000 1000" xml:space="preserve" class="whistle">
            <g>
        <g transform="translate(500.000000,511.000000) scale(0.100000,-0.100000)">
            <path
                d="M500,10C229.5,10,10,229.3,10,500c0,270.5,219.5,490,490,490c270.7,0,490-219.5,490-490C990,229.3,770.7,10,500,10z M424,213.2h146.5v146.5H424V213.2z M638.7,773h-68.1H424h-68.1v-70.4H424V426.8h146.5v275.8h68.1V773z"/>
        </g>
        </g>
</svg>
    </use>
    <h1>{{ status }} - access forbidden!</h1>

    <h2 v-text="message">

    </h2>
    <div class="container text-center mt-4 mx-auto">
        <Link as="a" :href="link" class="btn btn-main p-2 text-center">Return Back</Link>
    </div>
    </body>

</template>

<script setup>
import {usePage} from "@inertiajs/inertia-vue3";

defineProps({
    message: String,
    link: String,
    status: Number,
});

</script>
<script>
import GuestLayout from "../../Shared/Guest-Layout";
import {Link} from "@inertiajs/inertia-vue3";

export default {
    layout: GuestLayout,
    props: {
        status: Number,
    },
    computed: {
        title() {
            return {
                503: '503: Service Unavailable',
                500: '500: Server Error',
                404: '404: Page Not Found',
                403: '403: Forbidden',
            }[this.status]
        },
        description() {
            return {
                503: 'Sorry, we are doing some maintenance. Please check back soon.',
                500: 'Whoops, something went wrong on our servers.',
                404: 'Sorry, the page you are looking for could not be found.',
                403: 'Sorry, you are forbidden from accessing this page.',
            }[this.status]
        },
    },
}


</script>
<style scoped>
* {
    margin: 0;
    padding: 0;
}

body {
    background: #332d71;
    font-family: JetBrains Mono, sans-serif;

}

.whistle {
    width: 20%;
    fill: #6768AB;
    margin: 100px 40%;
    text-align: left;
    transform: translate(-50%, -50%);
    transform: rotate(0);
    transform-origin: 80% 30%;
    animation: wiggle .2s infinite;
}

@keyframes wiggle {
    0% {
        transform: rotate(3deg);
    }
    50% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(3deg);
    }
}

h1 {
    margin-top: -100px;
    margin-bottom: 20px;
    color: #eeeeee;
    text-align: center;
    font-family: 'Raleway';
    font-size: 90px;
    font-weight: 800;
}

h2 {
    color: #eeeeee;
    text-align: center;
    font-family: 'Raleway';
    font-size: 30px;
    text-transform: uppercase;
}

.btn-main {
    margin: auto;
    text-align: center;
    background-color: #ADABC6;
    font-size: 20px;
    margin-top: 30px;
    font-family: 'Raleway';
    text-transform: capitalize;
}
</style>
