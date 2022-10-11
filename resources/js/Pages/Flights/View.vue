<template>
    <Head>
        <title>Flights</title>
        <meta type="description" content="Information about my flights" head-key="description">
    </Head>

    <TitleLayout title="Flights"
                 description="This page allows you to search Flights. If you Believe you should have more access please contact firstholiday@gmail.com"/>
    <div class="d-flex justify-content-end m-4">
        <DefaultButtons/>
    </div>
    <div class="card shadow mb-4 mx-2">
        <div class=" card-body">
            <div class="d-flex mx-2">
                <label class="me-2 my-auto">Flight Filter:</label>
                <input type="text" class="border rounded p-2" v-model="search" placeholder="Search.....">
            </div>
            <div v-for="flight in flights.data"
                 class="bg-light card-css-shadow rounded-hard-blue card-md cursor-click card-shadow col-11 col-md-7 col-xl-10 bg-light mx-auto my-4">
                <div class="row m-2">
                    <div class=" col-10 d-flex flex-column mt-4">
                        <p class=" fw-bold fs-4 my-0" v-text="'Flight Number:  '+flight.ref"></p>
                        <div class="d-flex">
                            <p class="text-secondary fs-6 mt-0 mx-2"><i class="fa-solid fa-plane"></i> Departure
                                Airport: {{ flight.departureAirport }}</p>
                            <p class="text-secondary fs-6 mt-0 mx-2"><i class="fa-solid fa-plane"></i> Departure
                                Airport: {{ flight.arrivalAirport }}</p>
                        </div>
                        <div class="d-flex my-3">
                            <img class="img-text-size "
                                 :src="imageSmall"
                                 alt="Company img">
                            <p class="my-auto left-divider mx-2 px-2" v-text="'created: ' + flight.date"></p>
                        </div>
                        <div class="d-flex">
                            <p class="text-secondary fs-6 mt-0 mx-2"><i class="fa-solid fa-earth-oceania"></i> Departure Country:
                                {{ flight.departureCountry }}</p>
                            <p class="text-secondary fs-6 mt-0 mx-2"><i class="fa-solid fa-earth-oceania"></i> Arrival Country:
                                {{ flight.ArrivalCountry }}</p>
                        </div>

                    </div>
                    <div
                        class="col-3 col-md-2 me-2 me-md-0 d-none d-lg-flex flex-column text-center my-auto left-divider ">
                        <p class="fs-6 m-0" ><i class="fa-solid fa-plane-departure"></i> Departure Date: {{ flight.departureDate }}</p>
                        <p class="fs-6 m-0" ><i class="fa-solid fa-plane-arrival"></i> Arrival Date: {{ flight.arrivalDate }}</p>
                        <p class="fs-6 m-0" ><i class="fa-solid fa-chair"></i> Seats: {{flight.seats}}</p>
                    </div>
                </div>
            </div>
            <Pagination :links="flights.links"/>
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
    flights: Object,
    filters: Object,
});

let search = ref(props.filters.search);

watch(search, throttle(function (value) {
    Inertia.get('/flights', {search: value}, {
        preserveState: true,
        replace: true
    });
}, 500));


</script>
