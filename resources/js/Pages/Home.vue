<template>
    <Head>
        <title>Home</title>
        <meta type="description" content="Information about my homepage" head-key="description">
    </Head>
    <!--    if you have a company or are assigned one show company stats -->
    <div class="container-fluid ">
        <div class="row justify-content-center full">
            <div class="col-md-5 col-10 d-flex mx-auto my-auto ">
                <div class="mx-auto">
                    <h1 class="text-purple">
                        Online Package Holidays<br> <span style="color: #db5461" class="text-red">for all holiday based users</span>
                    </h1>
                    <p class="text-secondary">
                        Simply define your dates and destination, then book your
                        holiday. </p>
                    <div class="d-block d-md-flex ">
                        <div class="me-2 my-3 my-md-0" id="bot" @click="openBot">
                            <button class="fancy" type="submit">
                                <span class="top-key"></span>
                                <span class="text">Ask Our Bot</span>
                                <span class="bottom-key-1"></span>
                                <span class="bottom-key-2"></span>
                            </button>
                        </div>
                        <div class="me-2 my-3 my-md-0" @click="openBot">
                            <button class="fancy" type="submit">
                                <span class="top-key"></span>
                                <span class="text">View our Deals</span>
                                <span class="bottom-key-1"></span>
                                <span class="bottom-key-2"></span>
                            </button>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end my-4">
                        <Link as="button" href="/" class="cssbuttons-io-button btn-purple"> Book Your Holiday Here
                            <div class="icon">
                                <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0 0h24v24H0z" fill="none"></path>
                                    <path
                                        d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"
                                        fill="currentColor"></path>
                                </svg>
                            </div>
                        </Link>
                    </div>
                </div>
            </div>
            <Link as="div" :href="`/hotels/`+ featured.id +'/'" class="col-md-5 col-10 justify-content-end my-auto d-flex ">
                <div class="mx-auto">
                    <p class="text-center" style="color: #db5461">Hover To Preview <i class="fa-solid fa-star me-2"></i>
                    </p>
                    <div class="card-box-hidden cursor-click">
                        <div class="imgbox">
                            <div class="img-home"></div>
                        </div>
                        <div class="details">
                            <h2 class="title fs-6">Featured Break</h2>
                            <span class="caption">This December</span>
                        </div>
                    </div>
                </div>
            </Link>
            <div class="text-center scroll d-none d-md-block" v-show="scrolled" @click="scrolled.value = !scrolled ">
                <section id="section07" class="demo">
                    <a href="#card"><span></span><span></span><span></span>Scroll</a>
                </section>
            </div>
        </div>
        <div class="row justify-content-center" id="card">
            <div class="col-12 my-auto justify-content-center row">
                <div class="col-md-4 col-10 my-4 my-md-0  justify-content-center d-flex">
                    <div class="card-box shadow">
                        <div class="body-bottom">
                            <div class="card-details">
                                <i class="fa-solid fa-magnifying-glass text-center fs-2 text-grey"></i>
                                <p class="fs-3 text-purple">Find a holiday</p>
                            </div>
                            <div>
                                <p class="text-muted">Click below to find out more.</p>
                            </div>
                        </div>
                        <Link as="a" class="card-button text-center btn" href="/">More info</Link>
                    </div>
                </div>
                <div class="col-md-4 col-10 my-4 my-md-0 justify-content-center d-flex">
                    <div class="card-box shadow">
                        <div class="body-bottom">
                            <div class="card-details">
                                <i class="fa-solid fa-building text-center fs-2 text-grey"></i>
                                <p class="fs-3 text-purple">Ask out Bot</p>
                            </div>
                            <div>
                                <p class="text-muted">Click below to find out more.</p>

                            </div>
                        </div>
                        <Link as="a" class="card-button text-center btn" href="/">More info</Link>
                    </div>
                </div>
                <div class="col-md-4 col-10 my-4 my-md-0  justify-content-center d-flex">
                    <div class="card-box shadow">
                        <div class="body-bottom">
                            <div class="card-details">
                                <i class="fa-solid fa-building text-center fs-2 text-grey"></i>
                                <p class="fs-3 text-purple">Find out more</p>
                            </div>
                            <div>
                                <p class="text-muted">Click below to find out more.</p>


                            </div>
                        </div>
                        <Link as="a" class="card-button text-center btn" href="/">More info</Link>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
<script setup>
import imageSmall from "../../../public/images/logo-white - orange.png"
import {computed, ref} from "vue";
import {usePage} from "@inertiajs/inertia-vue3";
import Swal from "sweetalert2";
import {Inertia} from "@inertiajs/inertia";

defineProps({
    featured: Object,
});

const username = computed(() => {
    return usePage().props.value.auth.user.username
});
let scrolled = ref(true);
let openBot = async () => {

}


</script>

