<template>
    <Head>
        <title>Packages</title>
        <meta type="description" content="Information about my flights" head-key="description">
    </Head>

    <TitleLayout title="Packages"
                 description="This page allows you to search Packages. If you Believe you should have more access please contact firstholiday@gmail.com"/>
    <div class="d-flex justify-content-end m-4">
        <DefaultButtons/>
    </div>
    <div class=" mb-4 mx-2">
        <div class=" card-body">
            <div class="d-flex mx-2">
                <label class="me-2 my-auto">Packages Filter:</label>
                <input type="text" class="border rounded p-2" v-model="search" placeholder="Search.....">
            </div>
            <div class='row justify-content-center m-4 card-package col-10 mx-auto' v-for="pack in packages.data">
                <h3 class="text-center text-secondary" v-text="pack.hotel +  ' Hotel'"></h3>
                <div class="d-flex justify-content-center">
                    <div class="d-flex my-3 justify-content-center">

                        <img class="img-package img-thumbnail" src="https://loremflickr.com/g/190/140/paris" alt="Hotel img">
                    </div>
                    <div class="text-center my-auto">
                        <p class="text-secondary fs-6 mt-0 mx-2"><i class="fa-solid fa-plane-departure"></i> Departure
                            Date:
                            {{ pack.departureDate }}</p>
                        <p class="text-secondary fs-6 mt-0 mx-2"><i class="fa-solid fa-plane-arrival"></i> Arrival Date:
                            {{ pack.arrivalDate }}</p>
                        <p class="text-secondary fs-6 mt-0 mx-2"><i class="fa-solid fa-earth-oceania"></i> Departure
                            Country:
                            {{ pack.departureCountry }}</p>
                        <p class="text-secondary fs-6 mt-0 mx-2"><i class="fa-solid fa-earth-oceania"></i> Arrival
                            Country:
                            {{ pack.ArrivalCountry }}</p>


                        <p class="text-secondary fs-6 mt-0 mx-2"><i class="fa-solid fa-plane"></i> Departure
                            Airport: {{ pack.departureAirport }}</p>
                        <p class="text-secondary fs-6 mt-0 mx-2"><i class="fa-solid fa-plane"></i> Arrival
                            Airport: {{ pack.arrivalAirport }}</p>
                    </div>
                </div>

                <div class="col-12 col-sm-8 col-lg-4 mb-4 mb-lg-0 order-3 order-lg-1">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-lilac text-uppercase mb-1">
                                        Previous Package Total
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        £<span
                                        class="countup">{{ pack.originalPrice }}</span><br>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-pound-sign fa-2x text-gray-300 d-md-none d-lg-inline-block"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-8 col-lg-4 mb-4 mb-lg-0 order-3 order-lg-1">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-lilac text-uppercase mb-1">
                                        Discounted Package Total
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        £<span
                                        class="countup" v-text="pack.discountedPrice"></span><br>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-pound-sign fa-2x text-gray-300 d-md-none d-lg-inline-block"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <Link as="a" :href="'/packages/' + pack.id" class="btn btn-purple"><i class="fa-solid fa-hotel"></i> View Package</Link>
                </div>
            </div>
            <Pagination :links="packages.links"/>
        </div>
    </div>
</template>
<script setup>
import Pagination from "../../Shared/Pagination"
import {ref, watch} from "vue";
import {Inertia} from "@inertiajs/inertia";
import throttle from "lodash/throttle"
import TitleLayout from "../../Shared/TitleLayout";
import imageSmall from "../../../../public/images/logo-white - orange.png"
import Swal from "sweetalert2";
import DefaultButtons from "../../Shared/DefaultButtons";


let props = defineProps({
    packages: Object,
    filters: Object,
});

let search = ref(props.filters.search);

watch(search, throttle(function (value) {
    Inertia.get('/packages', {search: value}, {
        preserveState: true,
        replace: true
    });
}, 500));


</script>
